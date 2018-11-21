<?php
/*
 * 乐送首页
 *-----------------------
 * @display 当前3公里所有可存放的地点
 * */
namespace app\api\controller;

use app\api\model\Gps;
use think\facade\Session;
use think\facade\Cache;
use app\api\model\User;
class Index extends Apibase
{
    /*
     * @param   decimal $lng
     * @param   decimal $lat
     * @return  用户信息
     * */
    public function index()
    {
        echo "11122";
    }
    public function read(){
       $lng =   116.40387397;
       $lat =   39.91488908;
       $gps =   new Gps();



    }




}
