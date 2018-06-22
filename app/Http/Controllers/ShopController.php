<?php

namespace App\Http\Controllers;

use App\Http\Components\AdaShop as ScopeAdaShop;
use App\Models\AdaShop;
use DB;
use Illuminate\Http\Request;

class ShopController extends GeneralController
{
    protected $redirectTo = '/ada/shop';
    public $scopeClass = ScopeAdaShop::class;


    public function index()
    {
        $scope = $this->scope;
        $scope->disableDateRange = true;
        $scope->block = 'ada.shop.scope';
        $data = AdaShop::whereRaw($scope->getWhere())->orderBy('id')->get();
        $title = '店铺列表';
        return view('ada.shop.index', compact('title', 'data', 'scope'));
    }


    public function edit($id)
    {
        $data = AdaShop::findOrFail($id);
        $title = '修改店铺列表';
        return view('ada.shop.edit', compact('title', 'data'));
    }


    public function update(Request $request, $id)
    {
        $shop = AdaShop::findOrFail($id);
        $shop->update($request->all());
        return redirect($this->redirectTo);
    }



}
