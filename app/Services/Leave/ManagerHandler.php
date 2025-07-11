<?php

namespace App\Services\Leave;

use App\Models\LeaveRequest;
use App\Models\LeaveRequestStatus;

class ManagerHandler extends SupervisorHandler
{
    public function handle(LeaveRequest $request): void
    {
        $name = 'Manager';
        if ($request->days <= 5 && $request->days > 2) {
            // 记录处理结果
            $this->log($request, $name, LeaveRequestStatus::APPROVED);
            // 发送通知
            $this->notify($request->employee, $request, $name, LeaveRequestStatus::APPROVED);
            // 更新请假申请状态
            $request->update(['status' => LeaveRequestStatus::APPROVED]);
            return;
        }
        // 记录处理结果
        $this->log($request, $name, LeaveRequestStatus::PENDING);
        // 发送通知
        $this->notify($request->employee, $request, $name, LeaveRequestStatus::PENDING);
        // 继续处理下一个处理者
        parent::handle($request);

    }
}