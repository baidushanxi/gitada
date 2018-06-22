<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaShop extends Model
{

    protected $table = 'adaShop';

    public $timestamps = false;

    protected $primaryKey = 'id';


    public static $platform = [
       1=>'京东',
       2=>'天猫',
       3=>'阿里一部',
       4=>'阿里二部',
       5=>'其他',
    ];

    protected $fillable = [
        'shopName',
        'platform',
        'artificial',
        'public',
    ];

}
