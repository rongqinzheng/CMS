<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function apply(Request $request)
    {
        // 验证输入数据，trigger_at 可选
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'days'        => 'required|integer|min:1',
            'reason'      => 'nullable|string',
            'trigger_at'  => 'nullable|date|after_or_equal:now',
        ]);

        // 创建请假申请，默认 pending
        $leave = LeaveRequest::create($data + ['status' => 'pending']);

        // 若未设置延迟触发，立即执行审批链
        if (empty($data['trigger_at'])) {
            app('leave.chain')->handle($leave);
        }

        // 返回申请及状态日志
        return response()->json(['leave_request' => $leave->load('statuses')]);

    }
}