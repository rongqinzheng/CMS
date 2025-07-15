<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use Notifiable, HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department_id',
    ];

    /**
     * 一个员工可以有多条请假申请
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}