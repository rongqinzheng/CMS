<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LeaveRequestStatus extends Model
{
    // 不使用 Eloquent 自动时间戳
    public $timestamps = false;
    protected $fillable = ['leave_request_id', 'handler_name', 'status', 'comment', 'handled_at'];
    protected $dates = ['handled_at'];

    const APPROVED = 'approved';
    const PENDING = 'pending';

    const REJECTED = 'rejected';

    /**
     * 关联回请假申请
     */
    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

}