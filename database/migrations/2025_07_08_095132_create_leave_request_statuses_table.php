<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_request_statuses', function (Blueprint $table) {
            $table->comment('请假审批状态日志表');

            $table->id()->comment('审批状态自增主键');
            $table->foreignId('leave_request_id')
                ->constrained('leave_requests')
                ->onDelete('cascade')
                ->comment('关联请假申请ID');
            $table->string('handler_name')->comment('处理者名称，如 Supervisor');
            $table->string('status')->comment('审批结果：approved、pending、rejected');
            $table->string('comment')->nullable()->comment('审批备注');
            $table->timestamp('handled_at')->comment('处理时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_request_statuses');
    }
};
