<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateNewTable extends Migration
{
    public function up()
    {
        Schema::create('adaDataNew', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date')->comment = '时间';
            $table->string('shopId')->comment = '店铺ID';
            $table->string('shopName')->comment = '店铺名称';
            $table->decimal('cost',15,4)->default(0)->comment = '成本';
            $table->decimal('sales',15,4)->default(0)->comment = '销售额';
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
        Schema::dropIfExists('new_data');
    }
}
