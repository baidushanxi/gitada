<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adaData', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date')->comment = '时间';
            $table->string('productId')->comment = '商品ID';
            $table->string('productName')->comment = '商品名称';
            $table->string('productSize')->nullable()->comment = '商品规格';
            $table->unsignedInteger('productNumber')->default(0)->comment = '商品数量';
            $table->unsignedInteger('shopId')->comment = '店铺Id';
            $table->decimal('amount',10,4)->default(0)->comment = '商品总价';
            $table->decimal('cost',10,4)->default(0)->comment = '商品成本';
            $table->decimal('profit',10,4)->default(0)->comment = '利润';
            $table->string('summary',255)->nullable()->default('')->comment = '商品备注';

            $table->index(['productId','date','shopId']);
        });

        Schema::create('adaUnitPrice', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('productId')->comment = '商品ID';
            $table->string('productName')->comment = '商品名称';
            $table->decimal('material',10,4)->nullable()->default(0)->comment = '材料单价';
            $table->decimal('produce',10,4)->nullable()->default(0)->comment = '生成单价';
            $table->decimal('manage',10,4)->nullable()->default(0)->comment = '管理单价';
            $table->decimal('make',10,4)->nullable()->default(0)->comment = '制作单价';
            $table->index(['productId']);
        });

        Schema::create('adaShop', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('shopName',32)->comment = '店铺名称';
            $table->unsignedTinyInteger('platform')->nullable()->default(1)->comment = '1:天猫,2:京东';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adaData');
        Schema::dropIfExists('adaUnitPrice');
        Schema::dropIfExists('adaShop');
    }
}
