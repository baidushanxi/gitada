<?php

namespace App\Http\Components;

use App\Http\Components\Helpers\DataHelper;

class ScopeDateRange extends Scope
{
    public $dateRange = 7;

    public $startDate;
    public $endDate;

    public $startTime;
    public $endTime;
    public $dimension;
    public $dimensionName;


    //时间插件开关
    public $displayDates = true;
    public $displayMouth = false;

    public function __construct(array $params)
    {
        if (isset($params['dateRange'])) $this->dateRange = $params['dateRange'];
        $this->dimension =  $params['dimension'] ?? '';

        $this->setDateTime();
        parent::__construct($params);
    }

    public function setDateTime()
    {
        $this->endDate = \Request::get('scope')['endDate'] ?? DataHelper::asDate();
        $defaultStartDate = DataHelper::asDate(strtotime($this->endDate) - $this->dateRange * 86400);
        $this->startDate = \Request::get('scope')['startDate'] ?? $defaultStartDate;
        $this->startTime = strtotime($this->startDate);
        $this->endTime = strtotime($this->endDate) + 86400 - 1;
    }

    public function getStartDateTime($interval = 0)
    {
        $time = $this->startTime + $interval * 86400;
        return DataHelper::asDateTime($time);
    }

    public function getEndDateTime($interval = 0)
    {
        $time = $this->endTime + $interval * 86400;
        return DataHelper::asDateTime($time);
    }

    public function enableDates()
    {
        $this->displayDates = true;
    }

    public function disableDates()
    {
        $this->displayDates = false;
    }

    /**
     * 获取时间相关查询条件
     * @param null $tableAlias
     * @param string $field
     * @param string $dateType
     * @return string
     */
    public function getDateWhere($tableAlias = null, $field = 'created_at', $dateType = 'date')
    {
        if (!$this->displayDates) return ' 1 = 1';

        if ($tableAlias !== null && substr($tableAlias, -1) != '.') {
            $tableAlias = $tableAlias . '.';
        }

        if ($dateType == 'int') {
            $st = $this->startTime;
            $et = $this->endTime;
        } else {
            $st = $this->getStartDateTime();
            $et = $this->getEndDateTime();
        }

        return sprintf("%s%s BETWEEN '%s' AND '%s'", $tableAlias, $field, $st, $et);
    }

}