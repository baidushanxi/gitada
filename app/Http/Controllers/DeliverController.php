<?php

namespace App\Http\Controllers;

use App\Http\Components\AdaData as ScopeAdaData;
use App\Models\AdaShop;
use App\Models\AdaSpread;
use DB;
use Illuminate\Http\Request;

class DeliverController extends GeneralController
{
    protected $redirectTo = '/ada/deliver/index';
    public $scopeClass = ScopeAdaData::class;

    private $_validateRule = [
        'spread_file' => 'required',
    ];


    public function index()
    {
        $scope = $this->scope;
        $scope->block = 'ada.spread.scope';
        $shops = AdaShop::all()->pluck('shopName', 'id');

        $data = AdaSpread::whereRaw($scope->getWhere() . ' AND ' .  $scope->getDateWhere(null, 'date'))->get();

        $sum = [];
        $sum['wxb'] = $data->sum('wxb');
        $sum['yxt'] = $data->sum('yxt');
        $sum['cxt'] = $data->sum('cxt');
        $sum['ztc'] = $data->sum('ztc');
        $sum['zhzh'] = $data->sum('zhzh');
        $sum['jdkc'] = $data->sum('jdkc');
        $sum['jtk'] = $data->sum('jtk');
        $sum['taobaofuwu'] = $data->sum('taobaofuwu');
        $sum['shuadan'] = $data->sum('shuadan');
        $sum['qita'] = $data->sum('qita');

        $sum['all'] = 0;
        foreach ($sum as $v) {
            $sum['all'] += $v;
        }

        $title = '推广消耗列表';
        return view('ada.spread.index', compact('title', 'data', 'scope','shops','sum'));
    }

}