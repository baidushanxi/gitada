<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpreadAdaSpread extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adaSpread', function (Blueprint $table) {
            $table->decimal('yxt',18,4)->nullable()->default(0)->comment = '营销通费用';
            $table->decimal('cxt',18,4)->nullable()->default(0)->comment = '诚信通费用';
            $table->decimal('taobaofuwu',18,4)->nullable()->default(0)->comment = '淘宝服务费';
            $table->decimal('jishufuwu',18,4)->nullable()->default(0)->comment = '技术服务费';
            $table->decimal('shuadan',18,4)->nullable()->default(0)->comment = '刷单服务费';
            $table->decimal('shikelianmeng',18,4)->nullable()->default(0)->comment = '试客联盟';
            $table->decimal('pingtaishiyong',18,4)->nullable()->default(0)->comment = '平台使用费';
            $table->decimal('qita',18,4)->nullable()->default(0)->comment = '其他费用';
            $table->decimal('jtkyj',18,4)->nullable()->default(0)->comment = '京挑客佣金';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adaSpread', function (Blueprint $table) {
            $table->dropColumn('yxt');
            $table->dropColumn('cxt');
            $table->dropColumn('tmtk');
            $table->dropColumn('taobaofuwu');
            $table->dropColumn('jishufuwu');
            $table->dropColumn('shuadan');
            $table->dropColumn('shikelianmeng');
            $table->dropColumn('pingtaishiyong');
            $table->dropColumn('qita');
            $table->dropColumn('jtkyj');

        });
    }
}
