<?php

namespace App\Http\Controllers;

use App\Http\Components\AdaData as ScopeAdaData;
use \DB;

class DataNewController extends GeneralController
{
    protected $redirectTo = '/ada/data';
    public $scopeClass = ScopeAdaData::class;

    public function index()
    {
        $scope = $this->scope;
        $title = '导入数据整理';
        $data = $this->getData($scope);
        return view('ada.datanew.index', compact('title', 'data', 'shops', 'scope'));
    }

    public function getData($scope)
    {
        $query = "
            SELECT
                shopId,
                MAX(shopName) AS shopName,
                SUM(cost) AS cost,
                SUM(sales) AS sales
             FROM adaDataNew
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY shopId
        ";
        $data = DB::select($query);
        return $data;
    }

    public function detail()
    {
        $scope = $this->scope;
        $query = "
            SELECT
                date,
                MAX(shopName) AS shopName,
                SUM(cost) AS cost,
                SUM(sales) AS sales
             FROM adaDataNew
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY date 
             ORDER BY date ASC
        ";
        $data = DB::select($query);
        $hcData = $this->hcDetailData($data);
        return response()->json(compact('data', 'hcData'));
    }


    //分时图表
    protected function hcDetailData($data)
    {
        $yAxis = [];
        $series = [];
        foreach ($data as $v){
            $xAxis[] = $v->date;

            $series[] = [
                'name' => $v->shopName,
                'data' => $v->cost,
            ];
            $series[] = [
                'name' => $v->shopName,
                'data' => $v->sales,
            ];
        }
        return compact('xAxis', 'yAxis', 'series');
    }

}
