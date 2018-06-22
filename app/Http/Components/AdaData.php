<?php

namespace App\Http\Components;

use App\Models\AdaShop;

class AdaData extends ScopeDateRange
{
    public $productName;
    public $productId;

    public function __construct(array $params)
    {
        $this->productName = $params['product_name'] ?? '';
        $this->productId = $params['product_id'] ?? '';
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


        if (!empty($this->productName)) {
            $where[] = 'productName  LIKE "%' . trim($this->productName) . '%"';
        }

        if (!empty($this->productId)) {
            $where[] = 'productId  LIKE "%' . trim($this->productId) . '%"';
        }

        $this->where = empty($where) ? '1 = 1' : implode(' AND ', $where);

        return $this->where;
    }
}