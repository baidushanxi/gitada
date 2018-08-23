<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaDataNew extends Model
{
    protected $table = 'adaDataNew';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'date',
        'shopId',
        'shopName',
        'cost',
        'sale',
    ];

}
