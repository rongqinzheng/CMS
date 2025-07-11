<?php

namespace App\Services\Leave;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestStatus;

class SupervisorHandler extends AbstractHandler
{
    public function handle(LeaveRequest $request): void
    {
        $name = 'Supervisor';
        if ($request->days <= 2) {
            // 记录审批日志
            $this->log($request, $name, 'approved');
            // 通知员工
            $this->notify($request->employee, $request, $name, 'approved');
            // 更新整体状态
            $request->update(['status' => 'approved']);
            return; // 不继续
        }
        // 超过权限范围，标记待定
        $this->log($request, $name, 'pending');
        $this->notify($request->employee, $request, $name, 'pending');
        parent::handle($request); // 传递给下一级
    }

    public function log(LeaveRequest $leaveRequest, string $handler, string $status)
    {
        $leaveRequest->statuses()->create([
            'handler_name' => $handler,
            'status'       => $status,
            'comment'      => '',
            'handled_at'   => now(),
        ]);
    }

    public function notify(Employee $employee,LeaveRequest $leaveRequest,string $handler, string $status)
    {
        // 发送通知
        $employee->notify(new LeaveProcessed($leaveRequest, $handler, $status));
    }
}