<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaDeliver extends Model
{

    protected $table = 'adaDeliver';


    public $deliverPrice = 3;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'shopId',
        'date',
        'number',
    ];

}
