<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaSpread extends Model
{
    protected $table = 'adaSpread';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'date',
        'shopId',
        'ztc',
        'zhzh',
        'tk',
        'wxb',
        'jtk',
        'jdkc',
        'rjf',

        'yxt',
        'cxt',
        'taobaofuwu',
        'jishufuwu',
        'shuadan',
        'shikelianmeng',
        'pingtaishiyong',
        'qita',
        'jtkyj',
    ];

}
