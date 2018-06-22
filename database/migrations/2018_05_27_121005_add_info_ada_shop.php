<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoAdaShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adaShop', function(Blueprint $table) {
            $table->decimal('artificial',10,4)->nullable()->default(0)->comment = '人工分摊比例 0.1 表示百分之 0.1';
            $table->decimal('public',10,4)->nullable()->default(0)->comment = '公共分摊比例 0.1 表示百分之 0.1';
        });


        Schema::create('adaSpread', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date')->comment = '时间';
            $table->unsignedInteger('shopId')->default(0)->comment = '店铺ID';

            $table->decimal('ztc',18,4)->nullable()->default(0)->comment = '直通车费用';
            $table->decimal('zhzh',18,4)->nullable()->default(0)->comment = '钻展费用';
            $table->decimal('tk',18,4)->nullable()->default(0)->comment = '淘客';
            $table->decimal('wxb',18,4)->nullable()->default(0)->comment = '网销宝';

            $table->decimal('jtk',18,4)->nullable()->default(0)->comment = '京挑客';
            $table->decimal('jdkc',18,4)->nullable()->default(0)->comment = '京东快车';
            $table->decimal('rjf',18,4)->nullable()->default(0)->comment = '软件费';

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adaShop', function(Blueprint $table) {
            $table->dropColumn('artificial');
            $table->dropColumn('public');
        });

        Schema::drop('adaSpread');
    }
}
