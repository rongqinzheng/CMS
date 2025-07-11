<?php

namespace App\Services\Leave;

use App\Models\LeaveRequest;
use App\Models\LeaveRequestStatus;

class GeneralManagerHandler extends SupervisorHandler
{
    /**
     *
     *
     * @param \App\Models\LeaveRequest $request
     * @author qinzheng.rong
     * @date 2025-07-08
     */
    public function handle(LeaveRequest $request): void
    {
        $name = 'GeneralManager';
        if ($request->days >= 5) {
            $this->log($request, $name, LeaveRequestStatus::APPROVED);
            $this->notify($request->employee, $request, $name, LeaveRequestStatus::APPROVED);
            $request->update(['status' => LeaveRequestStatus::APPROVED]);
        }
        $this->log($request, $name, LeaveRequestStatus::REJECTED);
        $this->notify($request->employee, $request, $name, LeaveRequestStatus::REJECTED);
        $request->update(['status' => LeaveRequestStatus::REJECTED]);

    }
}