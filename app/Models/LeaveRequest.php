<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveRequest extends Model
{
    // 可批量填充字段
    protected $fillable = ['employee_id', 'days', 'reason', 'status', 'trigger_at'];
    // trigger_at 自动转换为 Carbon 对象
    protected $dates = ['trigger_at'];

    /**
     * 关联到发起请假的员工
     */
    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * 关联到本条申请的审批日志
     */

    public function statuses(): HasMany
    {
        return $this->hasMany(LeaveRequestStatus::class);
    }
}