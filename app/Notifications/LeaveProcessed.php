<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * 审批通知：邮件与数据库消息两种通道
 */
class LeaveProcessed extends Notification
{
    use Queueable;

    protected $leaveRequest;
    protected $handler;
    protected $status;

    /**
     * 通知渠道
     *
     * @param $notifiable
     * @return string[]
     * @author qinzheng.rong
     * @date 2025-07-08
     */
    public function via($notifiable){
        return ['mail', 'database'];
    }

    /**
     * 邮件内容
     *
     * @param $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * @author qinzheng.rong
     * @date 2025-07-08
     */
    public function toMail($notifiable){
        return (new MailMessage)
            ->subject("请假审批更新：{$this->handler}")
            ->greeting("你好 {$notifiable->name}")
            ->line("你的请假申请已由 {$this->handler} 处理，状态：{$this->status}。")
            ->action('查看详情', url("/leave/{$this->request->id}"));
    }

    public function toDatabase($notifiable){
        return [
            'leave_request_id' => $this->leaveRequest->id,
            'handler'          => $this->handler,
            'status'           => $this->status,
        ];
    }
}