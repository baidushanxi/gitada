<?php

namespace App\Console\Commands;

use App\Models\AdaDataNew;
use App\Models\AdaShop;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class LoadNewData extends Command
{

    public static $type = 'load-data-new';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-data-new';

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
            return;
        }

        try {
            $schedule = Schedule::firstOrCreate(['name' => $this->signature]);
            $dataNew = $this->getLastExcelFiles('ada/Excel/', $schedule->op_time);
            if (!$dataNew) {
                $this->info("未扫描到新文件");
                \Log::info('未扫描到新文件');
                return;
            }
            $op_time = date('Y-m-d H:i:s', time());
            $status = Schedule::STATUS_DOING;
            $schedule->save();

            //获取最近上传的 EXCEL
            if ($dataNew) {
                $message = "正在导入数据，小可爱稍微等等 ^.^";
                $schedule->update(compact('status', 'op_time', 'message'));
            }
            foreach ($dataNew as $file) {
                $this->info("开始导入数据" . $file);
                if (strpos($file, '.csv')) {
                    //使用csv读取文件
                    $data = $this->getDataFromCsv($file);
                    $this->storeData($data, 'csv');
                } else {
                    //使用传统EXCEL读取文件
                    $data = $this->getDataFromExcel($file);
                    $this->storeData($data, 'excel');
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


    public function storeData($data, $type = 'csv')
    {
        $sum = [];
        $success = true;
        foreach ($data as $k => $v) {
            if (empty($v[0])) continue;
            if ($k == 0) {
                if ($type == 'csv') {
                    $dateKey = array_search(iconv('UTF-8', 'GBK', 'WMS发货时间'), $v);
                    $shopNameKey = array_search(iconv('UTF-8', 'GBK', '店铺名称'), $v);
                    $numberKey = array_search(iconv('UTF-8', 'GBK', '数量'), $v);
                    $saleKey = array_search(iconv('UTF-8', 'GBK', '销售金额'), $v);
                    $costKey = array_search(iconv('UTF-8', 'GBK', '成本价'), $v);
                    continue;
                }
                $dateKey = array_search('WMS发货时间', $v);
                $shopNameKey = array_search('店铺名称', $v);
                $numberKey = array_search('数量', $v);
                $saleKey = array_search('销售金额', $v);
                $costKey = array_search('成本价', $v);
                continue;
            }


            if(!isset($v[$dateKey]) ||!isset($v[$shopNameKey]) ||!isset($v[$numberKey]) ||!isset($v[$saleKey]) ||!isset($v[$costKey]) ) {
                \Log::info("表格存在错误". json_encode($v));
                $this->info("表格中存在错误");
                $success = false;
                break;
            }

            if ($type == 'csv') {
                list($date, $shopId, $shopName, $number, $sale, $cost) = [date('Y-m-d', strtotime($v[$dateKey])), mb_substr($this->iconvs($v[$shopNameKey]), 2, 6), $this->iconvs($v[$shopNameKey]), intval($v[$numberKey]), $v[$saleKey], $v[$costKey]];
            } else {
                list($date, $shopId, $shopName, $number, $sale, $cost) = [date('Y-m-d', strtotime($v[$dateKey])), mb_substr($v[$shopNameKey], 2, 6), $v[$shopNameKey], intval($v[$numberKey]), $v[$saleKey], $v[$costKey]];
            }


            $key = $shopId . '_' . $date;
            if (!isset($sum[$key])) {
                $sum[$key]['date'] = $date;             #时间
                $sum[$key]['shopId'] = $shopId;         #商店ID
                $sum[$key]['shopName'] = $shopName;     #商店名称
                $sum[$key]['sales'] = $sale;           #销售额
                $sum[$key]['cost'] = $cost * $number;   #成本
                continue;
            }
            $sum[$key]['sales'] += $sale;           #销售额
            $sum[$key]['cost'] += ($cost * $number);   #成本
        }

        if($success == false) return;
        foreach ($sum as $v) {
            $adaExcel = AdaDataNew::firstOrnew([
                'date' => $v['date'],
                'shopId' => $v['shopId'],
            ]);
            $adaExcel->shopName = $v['shopName'];
            $adaExcel->sales = $v['sales'];
            $adaExcel->cost = $v['cost'];
            $adaExcel->save();
        }
    }

    public function iconvs($str)
    {
        if (empty($str)) return '';
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


    public function getDataFromCsv($fileName)
    {
        $handle = fopen(base_path($fileName), "r");
        while (($res = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $res;
        }
        fclose($handle);
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
