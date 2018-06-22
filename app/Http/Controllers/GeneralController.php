<?php

namespace App\Http\Controllers;

use App\Http\Components\Scope;
use Illuminate\Http\Request;
use Route;

class GeneralController extends Controller
{
    public $scope;

    protected $scopeClass = Scope::class;

    protected $params;

    public function __construct()
    {
        $this->setScope();
    }


    // 设置 scope 参数
    protected function setScopeParams()
    {
        return Route::getCurrentRequest()->get('scope', []);
    }

    // 设置 scope 实例对象
    protected function setScope()
    {
        $this->params = $this->setScopeParams();
        $this->scope = new $this->scopeClass($this->params);
    }


    public function success($message ='success')
    {
        return response()->json([
            'success'  => true,
            'message'    => $message,
        ]);
    }

    public function fail($message ='fail')
    {
        return response()->json([
            'success'  => false,
            'message'    => $message,
        ]);
    }

}
