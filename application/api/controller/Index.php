<?php
/*
 * 乐送首页
 *-----------------------
 * @display 当前3公里所有可存放的地点
 * */
namespace app\api\controller;

use app\common\model\PropertyGps;
use think\facade\Session;
use think\facade\Cache;
use app\common\model\User;
class Index extends Apibase
{
    /*
     * 当前定位
     * @param   long 经度
     * @param   lat 纬度
     * */
    public function location()
    {
        //获取当前经纬度
        $long = $this->request->param('long');
        $lat = $this->request->param('lat');
        $result = $this->validate(['long' => $long, 'lat' => $lat], 'app\api\validate\Gps');
        if (true !== $result) {
            return json(['code' => '202', 'msg' => $result]);
        }
        //计算周围可以存放地点
        $gpsAround = new PropertyGps();
        $aroundAddress = $gpsAround->getDistance("$long","$lat");
        //var_dump($aroundAddress);
        return json(['ss'=>$aroundAddress]);
    }

}
