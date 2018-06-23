<?php

namespace App\Http\Controllers;

use App\Models\AdaData;
use App\Http\Components\AdaData as ScopeAdaData;
use App\Models\AdaDeliver;
use App\Models\AdaUnitPrice;
use App\Models\AdaShop;
use App\Models\Schedule;
use \DB;


class DataController extends GeneralController
{
    protected $redirectTo = '/ada/data';
    public $scopeClass = ScopeAdaData::class;

    public function index()
    {
        $scope = $this->scope;
        $scope->block = 'ada.data.scope';
        $shops = AdaShop::all()->keyBy('id');
        $message = '';

        $title = '导入数据整理';
        $res = $this->getData($scope, $shops);
        $data = $res['data'];
        $nonePriceArr = $res['nonePriceArr'];

        if ($nonePriceArr) {
            $message = implode(',', array_unique($nonePriceArr)) . ',商品单价还未录入';
        }

        return view('ada.data.index', compact('title', 'data', 'shops', 'scope', 'message', 'spreadData'));
    }


    public function getData($scope, $shops)
    {
        $price = AdaUnitPrice::all()->keyBy('productId');
        $adaData = AdaData::whereRaw($scope->getWhere() . ' AND ' . $scope->getDateWhere(null, 'date'))->orderBy('shopId')->get();
        $deliverData = $this->getDeliverDate($scope);
        $spreadData = $this->getSpreadData($scope);

        $data = [];
        $nonePriceArr = [];
        foreach ($adaData as $v) {
            if (!isset($price[$v->productId])) {
                $nonePriceArr[] = '【' . $v->productId . ':' . $v->productName . '】';
                continue;
            }
            isset($data[$v->shopId]['materialSum']) ? $data[$v->shopId]['materialSum'] += ($v->productNumber * $price[$v->productId]->material) : $data[$v->shopId]['materialSum'] = ($v->productNumber * $price[$v->productId]->material);
            isset($data[$v->shopId]['makeSum']) ? $data[$v->shopId]['makeSum'] += ($v->productNumber * $price[$v->productId]->make) : $data[$v->shopId]['makeSum'] = ($v->productNumber * $price[$v->productId]->make);
            isset($data[$v->shopId]['produceSum']) ? $data[$v->shopId]['produceSum'] += ($v->productNumber * $price[$v->productId]->produce) : $data[$v->shopId]['produceSum'] = ($v->productNumber * $price[$v->productId]->produce);
            isset($data[$v->shopId]['manageSum']) ? $data[$v->shopId]['manageSum'] += ($v->productNumber * $price[$v->productId]->manage) : $data[$v->shopId]['manageSum'] = ($v->productNumber * $price[$v->productId]->manage);

            isset($data[$v->shopId]['amount']) ? ($data[$v->shopId]['amount'] += $v->amount) : ($data[$v->shopId]['amount'] = $v->amount);
            isset($data[$v->shopId]['cost']) ? ($data[$v->shopId]['cost'] += $v->cost) : ($data[$v->shopId]['cost'] = $v->cost);
            isset($data[$v->shopId]['profit']) ? $data[$v->shopId]['profit'] += $v->profit : $data[$v->shopId]['profit'] = $v->profit;
            isset($data[$v->shopId]['shopName']) ? '' : ($data[$v->shopId]['shopName'] = $shops[$v->shopId]->shopName);
            isset($data[$v->shopId]['spread']) ? '' : ($data[$v->shopId]['spread'] = $spreadData[$v->shopId] ?? 0);
            isset($data[$v->shopId]['deliver']) ? '' : ($data[$v->shopId]['deliver'] = $deliverData[$v->shopId] ?? 0);
            isset($data[$v->shopId]['deliverSum0']) ? '' : ($data[$v->shopId]['deliverSum'] = $deliverData[$v->shopId] ?? 0) * AdaDeliver::PRICE0;
            isset($data[$v->shopId]['deliverSum']) ? '' : ($data[$v->shopId]['deliverSum'] = $deliverData[$v->shopId] ?? 0) * AdaDeliver::PRICE;
        }
        ksort($data);

        return ['data' => $data, 'nonePriceArr' => $nonePriceArr];

    }


    public function loadStatus()
    {
        $title = '自动导入数据状态';
        $status = Schedule::where(['name' => 'load-data'])->first();
        return view('ada.data.load-status', compact('title', 'status'));
    }


    public function getSpreadData($scope)
    {
        $query = "
            SELECT
                shopId,
                SUM(wxb) AS wxb,
                SUM(yxt) AS yxt,
                SUM(cxt) AS cxt,
                SUM(ztc) AS ztc,
                SUM(zhzh) AS zhzh,
                SUM(jdkc) AS jdkc,
                SUM(jtk) AS jtk,
                SUM(taobaofuwu) AS taobaofuwu,
                SUM(shuadan) AS shuadan,
                SUM(qita) AS qita,
                SUM(rjf) AS rjf
             FROM adaSpread
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY shopId
        ";
        $data = DB::select($query);
        $sum = [];
        foreach ($data as $v) {
            $sum[$v->shopId] = $v->wxb + $v->yxt +$v->cxt +$v->ztc +$v->zhzh +$v->jdkc +$v->jtk +$v->taobaofuwu +$v->shuadan +$v->qita +$v->rjf;
        }
        return $sum;

    }


    public function getSpreadDateData($scope)
    {
        $query = "
            SELECT
                shopId,
                date,
                SUM(wxb) AS wxb,
                SUM(yxt) AS yxt,
                SUM(cxt) AS cxt,
                SUM(ztc) AS ztc,
                SUM(zhzh) AS zhzh,
                SUM(jdkc) AS jdkc,
                SUM(jtk) AS jtk,
                SUM(taobaofuwu) AS taobaofuwu,
                SUM(shuadan) AS shuadan,
                SUM(qita) AS qita,
                SUM(rjf) AS rjf
             FROM adaSpread
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY shopId,date
        ";
        $data = DB::select($query);
        $sum = [];
        foreach ($data as $v) {
            $sum[$v->date . '_' . $v->shopId] = $v->wxb + $v->yxt +$v->cxt +$v->ztc +$v->zhzh +$v->jdkc +$v->jtk +$v->taobaofuwu +$v->shuadan +$v->qita +$v->rjf;
        }
        return $sum;

    }


    public function getDeliverDate($scope)
    {
        $query = "
            SELECT
                shopId,
                SUM(number) as number
             FROM adaDeliver
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY shopId
        ";
        $data = DB::select($query);
        return collect($data)->pluck('number','shopId')->toArray();
    }


    public function getDeliverDateData($scope)
    {
        $query = "
            SELECT
                shopId,
                MAX(number) as number,
                date
             FROM adaDeliver
             WHERE {$scope->getWhere()}  AND {$scope->getDateWhere(null, 'date')}
             GROUP BY shopId,date
        ";
        $data = DB::select($query);
        $res = [];
        foreach ($data as $v){
            $res[$v->date .'_'. $v->shopId] = $v->number;
        }
        return $res;
    }



    public function export()
    {
        ini_set('memory_limit',"-1");
        $scope = $this->scope;
        $adaData = AdaData::whereRaw($scope->getWhere() . ' AND ' . $scope->getDateWhere(null, 'date'))->orderBy('date', 'asc')->get();
        $price = AdaUnitPrice::all()->keyBy('productId');
        $shops = AdaShop::all()->keyBy('id');
        $data = $tmp = $tmp1 = [];
        $spreadDateData = $this->getSpreadDateData($scope);
        $deliverData = $this->getDeliverDateData($scope);

        foreach ($adaData as $v) {
            if (!isset($price[$v->productId])) {
                continue;
            }
            $key = $v->date . '_' . $v->shopId;
            isset($tmp[$key]['date']) ? '' : ($tmp[$key]['date'] = $v->date);
            isset($tmp[$key]['shopId']) ? '' : ($tmp[$key]['shopId'] = $v->shopId);
            isset($tmp[$key]['shopName']) ? '' : ($tmp[$key]['shopName'] = $shops[$v->shopId]->shopName);
            isset($tmp[$key]['amount']) ? ($tmp[$key]['amount'] += $v->amount) : ($tmp[$key]['amount'] = $v->amount);
            isset($tmp[$key]['cost']) ? ($tmp[$key]['cost'] += $v->cost) : ($tmp[$key]['cost'] = $v->cost);
            isset($tmp[$key]['materialSum']) ? $tmp[$key]['materialSum'] += ($v->productNumber * $price[$v->productId]->material) : $tmp[$key]['materialSum'] = ($v->productNumber * $price[$v->productId]->material);
            isset($tmp[$key]['makeSum']) ? $tmp[$key]['makeSum'] += ($v->productNumber * $price[$v->productId]->make) : $tmp[$key]['makeSum'] = ($v->productNumber * $price[$v->productId]->make);
            isset($tmp[$key]['produceSum']) ? $tmp[$key]['produceSum'] += ($v->productNumber * $price[$v->productId]->produce) : $tmp[$key]['produceSum'] = ($v->productNumber * $price[$v->productId]->produce);
            isset($tmp[$key]['manageSum']) ? $tmp[$key]['manageSum'] += ($v->productNumber * $price[$v->productId]->manage) : $tmp[$key]['manageSum'] = ($v->productNumber * $price[$v->productId]->manage);
            isset($tmp[$key]['spread']) ? '' : ($tmp[$key]['spread'] = $spreadDateData[$key] ?? 0);
            isset($tmp[$key]['deliver']) ? '' : ($tmp[$key]['deliver'] = $deliverData[$key] ?? 0);
            isset($tmp[$key]['deliverSum0']) ? '' : ($tmp[$key]['deliverSum'] = $deliverData[$key] ?? 0) * AdaDeliver::PRICE0;
            isset($tmp[$key]['deliverSum']) ? '' : ($tmp[$key]['deliverSum'] = $deliverData[$key] ?? 0) * AdaDeliver::PRICE;
        }
        foreach ($tmp as $v) {
            $v['artificial'] = round(($shops[$v['shopId']]->artificial * $v['amount'] / 100), 2);
            $v['public'] = round(($shops[$v['shopId']]->public * $v['amount'] / 100), 2);
            unset($v['shopId']);
            $tmp1[$v['shopName']][] = $v;
        }

        foreach ($tmp1 as $k => $v) {
            $data[$k]['data'] = $v;
            $sum['date'] = '';
            $sum['shop'] = '总计';
            $sum['amount'] = collect($v)->sum('amount');
            $sum['cost'] = collect($v)->sum('cost');
            $sum['materialSum'] = collect($v)->sum('materialSum');
            $sum['makeSum'] = collect($v)->sum('makeSum');
            $sum['produceSum'] = collect($v)->sum('produceSum');
            $sum['manageSum'] = collect($v)->sum('manageSum');
            $sum['spread'] = collect($v)->sum('spread');
            $sum['deliver'] = collect($v)->sum('deliver');
            $sum['deliverSum0'] = (collect($v)->sum('deliver')) * AdaDeliver::PRICE0;
            $sum['deliverSum'] = (collect($v)->sum('deliver')) * AdaDeliver::PRICE;
            $sum['artificial'] = collect($v)->sum('artificial');
            $sum['public'] = collect($v)->sum('public');
            $data[$k]['sum'] = [$sum];
        }

        $headers[] = ['时间', '店铺', '价税合计', '销售成本', '资材费用', '制料费用', '生产费用', '管理费用', '推广费用', '快递数量','快递费用1','快递费用2','人工分摊', '公共分摊',];
        \Excel::create(date('Y-m-d', strtotime($scope->getStartDateTime())) . '-' . date('Y-m-d', strtotime($scope->getEndDateTime())). '利润预估', function ($excel) use ($data, $headers) {
            $sum = [];
            foreach ($data as $k => $v) {
                $sum[] = $v['sum'][0];
                $cellData = array_merge($headers, $v['data']);
                $cellData = array_merge($cellData, $v['sum']);
                $excel->sheet($k, function ($sheet) use ($cellData) {
                    $sheet->rows($cellData);
                });
            }

            unset($headers);
            $s['total'] = '';
            $s['amount'] = collect($sum)->sum('amount');
            $s['cost'] = collect($sum)->sum('cost');
            $s['materialSum'] = collect($sum)->sum('materialSum');
            $s['makeSum'] = collect($sum)->sum('makeSum');
            $s['produceSum'] = collect($sum)->sum('produceSum');
            $s['manageSum'] = collect($sum)->sum('manageSum');
            $s['spread'] = collect($sum)->sum('spread');
            $s['deliver'] = collect($sum)->sum('deliver');
            $s['deliverSum0'] = collect($sum)->sum('deliver') * AdaDeliver::PRICE0;
            $s['deliverSum'] = collect($sum)->sum('deliver') * AdaDeliver::PRICE;
            $s['artificial'] = collect($sum)->sum('artificial');
            $s['public'] = collect($sum)->sum('public');
            $headers[] = [];
            $headers[] = [];
            $headers[] = ['总计','价税合计', '销售成本', '资材费用', '制料费用', '生产费用', '管理费用', '推广费用','快递数量','快递费用','人工分摊', '公共分摊',];
            $cellData = array_merge($headers, [$s]);
            $excel->sheet('总计', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
