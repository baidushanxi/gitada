<?php

namespace App\Http\Components;


class AdaShop extends ScopeDateRange
{
    public $productName;
    public $productId;
    public $shopIdFiled = 'id';

    public function __construct(array $params)
    {
        parent::__construct($params);
    }


    public function getWhere($tableAlias = null, $field = ['shopName', 'platform'])
    {
        if ($tableAlias !== null && substr($tableAlias, -1) != '.') {
            $tableAlias = $tableAlias . '.';
        }

        $where = [
            parent::getWhere($tableAlias, $field)
        ];


        $this->where = empty($where) ? '1 = 1' : implode(' AND ', $where);

        return $this->where;
    }
}