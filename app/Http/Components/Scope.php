<?php

namespace App\Http\Components;
use App\Models\AdaShop;

class Scope
{
    public $where = [];
    public $block; // 搜索扩展区块
    public $shopName;
    public $platform;
    public $disableDateRange = false;
    public $shopIdFiled = 'shopId';

    public function __construct(array $params)
    {
        $this->shopName = $params['shop_name'] ?? '';
        $this->platform = $params['platform'] ?? '';
        $this->init($params);
    }

    public function init(array $params)
    {

    }


    public function getWhere($tableAlias, $field = ['shopName', 'platform'])
    {

        $where =[];

        if(!empty($this->shopName) || !empty($this->platform)){

            if(!empty($this->shopName) && !empty($this->platform)){
                $shop = AdaShop::whereRaw($field[0] .'  LIKE "%' . trim($this->shopName) . '%" AND platform = ' . $this->platform)->get();
            } elseif(empty($this->shopName)) {
                $shop = AdaShop::whereRaw($field[1] . ' = ' . $this->platform)->get();
            }else {
                $shop = AdaShop::whereRaw($field[0] . ' LIKE "%' . trim($this->shopName) . '%"')->get();
            }

            if(!$shop->isEmpty()) {
                $shopStr = $shop->implode('id',',');
                $where[] =  sprintf("%s%s IN (%s)", $tableAlias, $this->shopIdFiled, $shopStr);
            } else {
                $where[] =  ' 1 = 0 ';
            }
        }

        if(!empty($this->platform)){
            $shop = AdaShop::whereRaw('shopName  LIKE "%' . trim($this->shopName) . '%"')->get();

            if(!$shop->isEmpty()) {
                $shopStr = $shop->implode('id',',');
                $where[] =  sprintf("%s%s IN (%s)", $tableAlias, $this->shopIdFiled, $shopStr);
            } else {
                $where[] =  ' 1 = 0 ';
            }
        }


       return  $where ? implode(' AND ', $where) : '1 = 1';
    }

}