<?php

namespace App\Http\Controllers;

use App\Http\Components\AdaData as ScopeAdaData;
use App\Models\AdaDeliver;
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


        $fileContent = file_get_contents(public_path('ada/Deliver/617.csv'));
        $arr = explode("\n" ,$fileContent);

        foreach ($arr as $v){
            $data = explode(',',$v);

            dump($data);
            echo mb_convert_encoding($data[1],'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

        }

        exit;



        $query = "
            SELECT
                shopId,
                SUM(number) as number
             FROM adaDeliver
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY shopId
        ";
        $data = DB::select($query);
        $sum = collect($data)->sum('number');
        $title = '快递列表';
        return view('ada.deliver.index', compact('title', 'data', 'scope','shops','sum'));
    }

}