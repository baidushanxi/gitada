<?php

namespace App\Http\Controllers;

use App\Http\Components\AdaData as ScopeAdaData;
use App\Models\AdaShop;
use App\Models\AdaSpread;
use DB;
use Illuminate\Http\Request;

class SpreadController extends GeneralController
{
    protected $redirectTo = '/ada/spread/index';
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
        $sum['rjf'] = $data->sum('rjf');
        $sum['qita'] = $data->sum('qita');

        $sum['all'] = 0;
        foreach ($sum as $v) {
            $sum['all'] += $v;
        }

        $title = '推广消耗列表';
        return view('ada.spread.index', compact('title', 'data', 'scope','shops','sum'));
    }


    public function create()
    {
        $title = '上传推广消耗';
        return view('ada.spread.edit', compact('title'));
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->_validateRule);
        $shops = AdaShop::all()->pluck('id','shopName');


        if ($request->hasFile('spread_file') && $request->file('spread_file')->isValid()) {
            $path = $request->file('spread_file')->getRealPath();
            $data = $this->getDataFromExcel($path);

            if (!$data) {
                flash('添加失败：数据为空', 'danger');
                return redirect($this->redirectTo);
            }
            foreach ($data as $k => $v){
                if(in_array($k ,[0,1])) continue;
                if(empty($v[0]) || empty($v[1])) continue;

                list($date, $shopId, $wxb,$yxt,$cxt, $ztc,$zhzh,$jdkc,$jtk,$taobaofuwu,$shuadan,$rjf,$qita)
                    = [ '2018-'. str_replace('/', '-',$v[0]), $shops[trim($v[1])] ?? 0, (float) $v[2], (float) $v[3],(float) $v[4],(float) $v[5],(float) $v[6],(float) $v[7],(float) $v[8],(float) $v[9],(float) $v[10],(float) $v[11],(float) $v[12]];

                if(empty($shopId)){
                    flash('添加失败：【'.trim($v[1]) .'】店铺不存在', 'danger');
                    return redirect($this->redirectTo);
                }

                $spread = AdaSpread::firstOrnew(
                    [   'date' => $date,
                        'shopId' => $shopId,
                    ]);

                $spread->date = $date;
                $spread->shopId = $shopId;

                $spread->wxb = $wxb;
                $spread->yxt = $yxt;
                $spread->cxt = $cxt;
                $spread->ztc = $ztc;
                $spread->zhzh = $zhzh;
                $spread->jdkc = $jdkc;
                $spread->jtk = $jtk;
                $spread->taobaofuwu = $taobaofuwu;
                $spread->shuadan = $shuadan;
                $spread->qita = $qita;
                $spread->rjf = $rjf;

//                $spread->tk = $tk;
//                $spread->rjf = $rjf;
//                $spread->jishufuwu = $jishufuwu;
//                $spread->shikelianmeng = $shikelianmeng;
//                $spread->pingtaishiyong = $pingtaishiyong;
//                $spread->jtkyj = $jtkyj;
                $spread->save();
            }
        }
        flash(trans('app.添加成功', ['value' => '推广消耗']), 'success');
        return redirect($this->redirectTo);
    }


    public function getDataFromExcel($fileName, $sheet = 0)
    {
        $data = [];
        \Excel::load($fileName, function ($reader) use ($sheet, &$data) {
            $reader = $reader->getSheet($sheet);
            $reader = $reader->toarray();
            $data = $reader;
        });
        return $data;
    }


}
