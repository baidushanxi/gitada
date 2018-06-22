<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaData extends Model
{
    protected $table = 'adaData';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'date',
        'productId',
        'productName',
        'productSize',
        'productNumber',
        'shopId',
        'amount',
        'cost',
        'profit',
        'summary',
    ];

}
