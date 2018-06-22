<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    protected $tableName = 'schedules';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32)->unique()->comment = '任务类型';
            $table->boolean('status')->default(0)->comment = '状态 0 待执行，1 执行中，2 失败';
            $table->string('last_value')->nullable()->comment = '最后执行参数值';
            $table->text('message')->nullable()->comment = '信息';
            $table->timestamp('op_time')->nullable()->comment = '最后执行时间';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tableName);
    }
}
