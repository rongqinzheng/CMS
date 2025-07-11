<?php

namespace App\Services\Leave;

use App\Models\LeaveRequest;

/**
 * 处理者接口 ：定义链式调用和处理方法
 */
interface Handler
{
 public function setNext(Handler $handler): Handler;

 public function handle(LeaveRequest $request):void;
}