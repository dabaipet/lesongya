<?php
/*
 * 错误控制器
 * */

namespace app\api\controller;

use think\facade\Request;

class Error
{
    public function index(Request $request)
    {

        return ['code' => '202','msg' => showReturnCodeMsg('2003')];
    }
}