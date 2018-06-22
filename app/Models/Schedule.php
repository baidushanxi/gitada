<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    const STATUS_NONE = 0;  // 待执行
    const STATUS_DOING = 1;  // 执行中
    const STATUS_FAILED = 2; // 失败

    public static $status = [
        self::STATUS_NONE => '成功',
        self::STATUS_DOING => '执行中',
        self::STATUS_FAILED => '失败',
    ];

    protected $table = 'schedules';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'status',
        'interval',
        'last_value',
        'message',
        'op_time',
    ];

    // active log 使用
    public static $logAttributes = [
        'name',
        'status',
        'interval',
        'last_value',
        'message',
        'op_time',
    ];

}
