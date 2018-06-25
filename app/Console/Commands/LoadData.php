<?php

namespace App\Console\Commands;

use App\Models\AdaDeliver;
use App\Models\Schedule;
use Illuminate\Console\Command;
use App\Models\AdaShop;
use App\Models\AdaData;
use App\Models\AdaUnitPrice;
use Symfony\Component\Console\Output\ConsoleOutput;

class loadData extends Command
{

    public static $type = 'load-data';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将数据导入到数据库';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', "-1");

        parent::__construct();

        $schedule = Schedule::firstOrCreate(['name' => $this->signature]);
        $this->output = new ConsoleOutput;
        if ($schedule->status == Schedule::STATUS_DOING) {
            $this->info('任务正在执行中,退出...');
            \Log::info('任务正在执行中,退出...');
            exit;
        }

        try {
            $schedule = Schedule::firstOrCreate(['name' => $this->signature]);
            $lastFiles = $this->getLastExcelFiles('ada/Excel/', $schedule->op_time);
            $priceFile = $this->getLastExcelFiles('ada/UnitPrice/', $schedule->op_time);
            $deliverFile = $this->getLastExcelFiles('ada/Deliver/', $schedule->op_time);
            if ($priceFile) {
                $this->loadUnitPrice();
            }

            if (!$lastFiles && !$deliverFile) {
                $this->info("未扫描到新文件");
                \Log::info('未扫描到新文件');
                exit;
            }

            $op_time = date('Y-m-d H:i:s', time());
            $status = Schedule::STATUS_DOING;

            //获取最近上传的 EXCEL
            //$files = scandir(public_path('ada/Excel/'));
            $shops = AdaShop::all()->keyBy('shopName')->toArray();
            if ($deliverFile) {
                $message = "正在导入快递文件，小可爱稍微等等 ^.^";
                $schedule->update(compact('status', 'op_time', 'message'));
            }

            foreach ($deliverFile as $file) {
                $this->info("开始导入快递文件" . $file);
                if (strpos($file, '.csv')) {
                    //使用csv读取文件
                    $res = $this->loadDeliver($file, $shops);
                } else {
                    //使用传统EXCEL读取文件
                    $data = $this->getDataFromExcel($file);
                    $res = $this->detailDeliver($data, $shops);
                }

                foreach ($res as $k => $v) {
                    $key = explode('_', $k);
                    $deliver = AdaDeliver::firstOrnew([
                        'date' => $key[1],
                        'shopId' => $key[0],
                    ]);
                    $deliver->number = $v;
                    $deliver->save();
                }
                $this->info("导入快递结束");
            }

            //AdaData::truncate();
            if ($lastFiles) {
                $message = "正在导入销量，小可爱稍微等等 ^.^";
                $schedule->update(compact('status', 'op_time', 'message'));
            }
            $files = $lastFiles;
            foreach ($files as $file) {
                if ($file == '.' and $file == '..') continue;
                //将文件转换为数组
                $data = $this->dealData($file);
                $this->info("开始导入数据");
                if (!empty($data['shopName'])) {
                    foreach ($data['shopName'] as $shop) {
                        if (!in_array($shop, array_keys($shops))) {
                            $shopInfo = AdaShop::create([
                                'shopName' => $shop,
                            ]);
                        }
                    }
                }

                if (!empty($data['sumData'])) {
                    foreach ($data['sumData'] as $v) {
                        $adaExcel = AdaData::firstOrnew([
                            'date' => $v['date'],
                            'productId' => $v['productId'],
                            'shopId' => $shops[$v['shopName']]['id'],
                        ]);
                        $adaExcel->productName = $v['productName'];
                        $adaExcel->productSize = $v['productSize'];
                        $adaExcel->shopId = $shops[$v['shopName']]['id'];
                        $adaExcel->productNumber = $v['productNumber'];
                        $adaExcel->amount = $v['amount'];
                        $adaExcel->cost = $v['cost'];
                        $adaExcel->profit = $v['profit'];
                        $adaExcel->summary = $v['summary'];
                        $adaExcel->save();
                    }
                }
                $this->info("导入数据结束");
            }
            $status = Schedule::STATUS_NONE;
            $message = "执行成功啦！去看看吧。☺️";
            $schedule->update(compact('status', 'message'));
        } catch (\Exception $e) {
            \Log::info("导入失败了：" . $e->getMessage());
            $this->info("导入失败了：" . $e->getMessage());
            $status = Schedule::STATUS_FAILED;
            $message = "导入失败了：" . $e->getMessage();
            $schedule->update(compact('status', 'message'));
        }
    }




    public function loadDeliver($file, $shops)
    {
        $shops = $shops ?: AdaShop::all()->keyBy('shopName')->toArray();
        $shop = [];
        foreach ($shops as $k => $v){
            $shop[mb_substr($k, 0, 8)] = $v;
        }

        $shopData = [];
        if (($handle = fopen(base_path($file), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $shopName = mb_convert_encoding($data[5], 'utf-8', array('GBK'));
                if(empty($shopName) || $shopName == '店铺名称' || !strstr($shopName,'DS10')){
                    continue;
                }
                $date = date('Y-m-d', strtotime(str_replace('/', '-', $data[1])));
                $subShopName = mb_substr($shopName, 0, 8);
                $shopId = !empty($shop[$subShopName]) ? $shop[$subShopName]['id'] : ($createShops[$subShopName] ?? 0);
                if ($shopId == 0) {
                    $shopInfo = AdaShop::create([
                        'shopName' => $shopName,
                    ]);
                    $createShops[mb_substr($shopName, 0, 8)] = $shopInfo->id;
                    $shopId = $shopInfo->id;
                }

                $shopData[$shopId .'_' . $date]['data'][] = $data[3];
                $shopData[$shopId .'_' . $date]['name'] = $data[3];
            }
            fclose($handle);
        }

        $res = [];
        foreach ($shopData as $k => &$v){
            $res[$k] = count(array_unique($v['data']));
        }

        return $res;
    }

    public function loadUnitPrice()
    {

        $price = $this->getDataFromExcel('public/ada/UnitPrice/price.xlsx', 0);

        foreach ($price as $k => $v) {
            if ($k == 0) continue;
            $productId = trim($v[0]);
            $productName = trim($v[1]);

            $material = (float)$v[2];
            $produce = (float)$v[3];
            $manage = (float)$v[4];
            $make = (float)$v[5];

            $priceModel = AdaUnitPrice::firstOrnew([
                'productId' => $productId,
            ]);

            $priceModel->productName = $productName;
            $priceModel->material = $material;
            $priceModel->produce = $produce;
            $priceModel->manage = $manage;
            $priceModel->make = $make;
            $priceModel->save();
        }
    }


    public function detailDeliver($data, $shops = [])
    {
        $shops = $shops ?: AdaShop::all()->keyBy('shopName')->toArray();
        $shop = [];
        foreach ($shops as $v) {
            $shop[mb_substr($v['shopName'], 0, 8)] = $v;
        }

        $res = [];
        $createShops = [];
        foreach ($data as $k => $v) {
            if ($k == 0 || empty($v[5])) continue;
            $date = $this->dealWithDate($v[1]);
//            $date = '2018-'. substr(str_replace('/', '-',$v[1]),0,5);
            $shopName = mb_substr($v[5], 0, 8);
            $shopId = !empty($shop[$shopName]) ? $shop[$shopName]['id'] : ($createShops[$shopName] ?? 0);
            if ($shopId == 0) {
                $shopInfo = AdaShop::create([
                    'shopName' => $v[5],
                ]);
                $createShops[$shopName] = $shopInfo->id;
                $shopId = $shopInfo->id;
            }
            $key = $shopId . '_' . $date;
            $res[$key] = !isset($res[$key]) ? 1 : ($res[$key] + 1);
        }

        return $res;
    }


    /**
     * 获取Excel中的数据 并处理
     * @param $fileName
     * @return array
     */
    public function dealData($fileName)
    {
//        $data = $this->getDataFromExcel($fileName, 0);
        $handle = fopen(base_path($fileName), "r");
        while (($res = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $res;
        }
        fclose($handle);

        $sumData = [];
        $shopNames = [];
        foreach ($data as $k => $v) {
            if (in_array($k, [0, 1, 2])) continue;
            $v[1] = $this->iconvs($v[1]);
            $v[2] = $this->iconvs($v[2]);
            if (empty($v[1]) || trim($v[1] == '小计') || trim($v[1]) == '合计') continue;
            if (!empty($v[1]) && empty($v[2])) {
                $shopNames[] = trim($v[1]);
                $shopname = trim($v[1]);
            }

            list($date, $productId, $productName, $productSize, $productNumber, $amount, $cost, $profit, $summary) = [str_replace('/','-',$this->iconvs($v[2])), $this->iconvs($v[7]), $this->iconvs($v[8]), $this->iconvs($v[9]), $this->iconvs($v[14]), (float)$v[17], (float)$v[22], (float)$v[23], $this->iconvs($v[24]),];
            if (empty($date) || empty($productId)) continue;
            if (isset($sumData[$date . '_' . $productId . '_' . $shopname])) {
                $sumData[$date . '_' . $productId . '_' . $shopname]['productNumber'] = $sumData[$date . '_' . $productId . '_' . $shopname]['productNumber'] + $productNumber;
                $sumData[$date . '_' . $productId . '_' . $shopname]['amount'] = $sumData[$date . '_' . $productId . '_' . $shopname]['amount'] + $amount;
                $sumData[$date . '_' . $productId . '_' . $shopname]['cost'] = $sumData[$date . '_' . $productId . '_' . $shopname]['cost'] + $cost;
                $sumData[$date . '_' . $productId . '_' . $shopname]['profit'] = $sumData[$date . '_' . $productId . '_' . $shopname]['profit'] + $profit;
                continue;
            }

            $sumData[$date . '_' . $productId . '_' . $shopname]['date'] = $date;                            //日期
            $sumData[$date . '_' . $productId . '_' . $shopname]['productId'] = $productId;                  //商品编码
            $sumData[$date . '_' . $productId . '_' . $shopname]['productName'] = $productName;              //商品名称
            $sumData[$date . '_' . $productId . '_' . $shopname]['productSize'] = $productSize;              //商品规格
            $sumData[$date . '_' . $productId . '_' . $shopname]['productNumber'] = $productNumber;          //商品规格
            $sumData[$date . '_' . $productId . '_' . $shopname]['amount'] = $amount;                        //商品总价
            $sumData[$date . '_' . $productId . '_' . $shopname]['cost'] = $cost;                            //商品成本
            $sumData[$date . '_' . $productId . '_' . $shopname]['profit'] = $profit;                        //商品获利
            $sumData[$date . '_' . $productId . '_' . $shopname]['summary'] = $summary;                      //商品备注
            $sumData[$date . '_' . $productId . '_' . $shopname]['shopName'] = $shopname;                    //商品备注
        }

        return ['shopName' => $shopNames, 'sumData' => $sumData];
    }

    public function iconvs($str)
    {
        return mb_convert_encoding($str, 'utf-8', array('GBK'));
    }

    /**
     * 获取近期修改过的Excel
     * @param $dir
     * @return array
     */
    public function getLastExcelFiles($dir, $op_time)
    {
        $dirr = public_path($dir);
        $dh = @opendir($dirr); // 打开目录，返回一个目录流
        $return = array();
        $i = 0;
        while ($file = @readdir($dh)) { // 循环读取目录下的文件
            if ($file != '.' and $file != '..') {
                $path = $dirr . '/' . $file; // 设置目录，用于含有子目录的情况
                if (is_dir($path)) {
                    continue;
                } elseif (is_file($path)) {
                    if (strtotime($op_time) > filectime($path)) continue;
                    $filetime [] = date("Y-m-d H:i:s", filectime($path)); // 获取文件最近修改日期
                    $return [] = 'public/' . $dir . $file;
                }
            }
        }
        @closedir($dh); // 关闭目录流
        if (empty($return)) return [];
        array_multisort($filetime, SORT_DESC, SORT_STRING, $return);//按时间排序
        return $return; // 返回文件
    }


    public function dealWithDate($date)
    {
        if (empty($date)) {
            return false;
        };
        $dateArray = explode('-', $date);
        return '20' . $dateArray[2] . '-' . $dateArray[0] . '-' . $dateArray[1];
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


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
