<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->comment('请假申请表');

            $table->id()->comment('请假申请自增主键');
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade')
                ->comment('申请员工ID，外键');
            $table->integer('days')->comment('请假天数');
            $table->text('reason')->nullable()->comment('请假原因');
            $table->string('status')->default('pending')->comment('整体审批状态：pending、approved、rejected');
            $table->timestamp('trigger_at')->nullable()->comment('延迟触发审批时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
