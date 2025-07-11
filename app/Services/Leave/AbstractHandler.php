<?php

namespace App\Services\Leave;

use App\Models\LeaveRequest;

abstract class AbstractHandler implements Handler
{
    // 下一个处理者
    protected ?Handler $next = null;

    /**
     * 设置并返回下一个处理者
     *
     * @param \App\Services\Leave\Handler $handler
     * @return \App\Services\Leave\Handler
     * @author qinzheng.rong
     * @date 2025-07-08
     */
    public function setNext(Handler $handler): Handler
    {
        $this->next = $handler;
        return $handler;
    }

    /**
     * 若无处理者则处理，否则将请求传递给下一个处理者
     *
     * @param \App\Models\LeaveRequest $leaveRequest
     * @author qinzheng.rong
     * @date 2025-07-08
     */
    public function handle(LeaveRequest $leaveRequest): void
    {
        if($this->next){
            $this->next->handle($leaveRequest);
        }
    }
}