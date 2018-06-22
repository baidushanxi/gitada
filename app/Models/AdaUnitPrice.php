<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaUnitPrice extends Model
{
    protected $table = 'adaUnitPrice';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'productId',
        'productName',
        'material',
        'produce',
        'manage',
        'make',
    ];


}
