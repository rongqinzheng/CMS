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
        Schema::create('employees', function (Blueprint $table) {
            // 表注释（部分数据库驱动支持）
            $table->comment('员工表');

            $table->id()->comment('员工自增主键');
            $table->string('name')->comment('员工姓名');
            $table->string('email')->unique()->comment('员工邮箱，唯一');
            $table->unsignedBigInteger('department_id')->nullable()->comment('部门ID，外键');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
