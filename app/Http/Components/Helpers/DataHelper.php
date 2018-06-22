<?php

namespace App\Http\Components\Helpers;

class DataHelper
{
    public static function asPercent($num, $denominator, $decimals = 4)
    {
        $percent = $denominator != 0 ? round($num / $denominator, $decimals) : 0;
        return $percent * 100 . '%';
    }

    public static function asCNY($rmb)
    {
        return '￥' . number_format($rmb, 2);
    }

    public static function asDate($time = null, $default = '从未更新')
    {
        is_null($time) && $time = time();
        return $time == 0 ? $default : date('Y-m-d', $time);
    }

    public static function asMonth($time = null)
    {
        is_null($time) && $time = time();
        return date('Y-m', $time);
    }

    public static function asDateTime($time = null, $default = '从未更新')
    {
        is_null($time) && $time = time();
        return $time == 0 ? $default : date('Y-m-d H:i:s', $time);
    }

    public static function numberFormat($number)
    {
        return number_format($number, 2);
    }

    public static function assemblyResult($error = 1, $message = '', $content = '')
    {
        return compact('error', 'message', 'content');
    }

    /**
     * 生成tab
     * @param array $conf tab配置
     * @param  string $routeName 路由名称
     * @return array
     */
    public static function createTab(array $conf, string $routeName)
    {
        $tabs = [];
        foreach ($conf as $k => $v) {
            $tabs[$k]['id'] = $k;
            $tabs[$k]['text'] = $v;
            $tabs[$k]['url'] = route($routeName, array_merge(\Request::all(), ['type' => $k]));
        }

        return $tabs;
    }


    public static function week($date)
    {
        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        return $weekarray[date("w", strtotime($date))];
    }


}