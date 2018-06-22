<?php

namespace App\Http\Controllers;

use App\Http\Components\AdaData as ScopeAdaData;
use App\Models\AdaUnitPrice;
use DB;

class UnitPriceController extends GeneralController
{
    protected $redirectTo = '/ada/unitPrice';
    public $scopeClass = ScopeAdaData::class;


    public function index()
    {

        ini_set('memory_limit','1024M');
        $scope = $this->scope;
        $scope->disableDateRange = true;
        $scope->block = 'ada.unit-price.scope';


        $data = AdaUnitPrice::whereRaw($scope->getWhere())->get()->keyBy('productId');


        $title = '单价列表';
        return view('ada.unit-price.index', compact('title', 'data', 'scope', 'price'));
    }

}
