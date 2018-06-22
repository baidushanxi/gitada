<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdaDeliverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adaDeliver', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->comment = '时间';
            $table->unsignedInteger('shopId')->comment = '店铺Id';
            $table->unsignedInteger('number')->default(0)->comment = '包裹数量';
            $table->index(['date','shopId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adaDeliver');
    }
}
