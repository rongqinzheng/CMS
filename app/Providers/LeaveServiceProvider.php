<?php

namespace App\Providers;

use App\Services\Leave\GeneralManagerHandler;
use App\Services\Leave\ManagerHandler;
use App\Services\Leave\Middleware\CheckWorkingHours;
use App\Services\Leave\SupervisorHandler;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

/**
 * 服务提供者：注册责任链与中间件、调度
 */
class LeaveServiceProvider extends ServiceProvider
{
    public function register()
    {
        //单例模式构建审批链
        $this->app->singleton('leave.chain', function ($app) {
            $sup = new SupervisorHandler();
            $mgr = $sup->setNext(new ManagerHandler());
            $mgr->setNext(new GeneralManagerHandler());
            return $sup;
        });
    }

    public function boot()
    {
        // 注册路由中间件
        Route::aliasMiddleware('working.hours', CheckWorkingHours::class);

        // 每分钟检查到达 trigger_at 的待处理申请
        $this->app->booted(function() {
            $schedule = $this->app->make('Illuminate\Console\Scheduling\Schedule');
            $schedule->call(function() {
                \App\Models\LeaveRequest::where('status', 'pending')
                    ->whereNotNull('trigger_at')
                    ->where('trigger_at', '<=', now())
                    ->each(function($req) {
                        app('leave.chain')->handle($req);
                    });
            })->everyMinute();
        });
    }
}