<?php

namespace App\Services\Leave\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWorkingHours
{
    public function handle(Request $request, Closure $next)
    {
        $hour = now()->hour;
        if ($hour < 9 || $hour > 18) {
            // 非工作时间，禁止访问
            return response()->json([
                'error' => '审批只能在工作时间内 9:00-18:00'
            ], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}