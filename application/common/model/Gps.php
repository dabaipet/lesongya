<?php
/**
 * 物业存放地址信息GPS.
 * User: whp
 * Date: 2018/10/29
 * Time: 16:43
 */

namespace app\common\model;


use think\Model;

class PropertyGps extends Model
{
protected  $table=  'property_gps';
    /* *参数说明：
     * @param   $lng 经度
     * @param   $lat 纬度
     * @param   $distance 周边半径 默认是500米（0.5Km）
     * */
    public function returnSquarePoint($long, $lat, $distance = 3)
    {
        $dlong = 2 * asin(sin($distance / (2 * 6371)) / cos(deg2rad($lat)));
        $dlong = rad2deg($dlong);
        $dlat = $distance / 6371;
        $dlat = rad2deg($dlat);
        return array(
            'left-top' => array('lat' => $lat + $dlat, 'long' => $long - $dlong),
            'right-top' => array('lat' => $lat + $dlat, 'long' => $long + $dlong),
            'left-bottom' => array('lat' => $lat - $dlat, 'long' => $long - $dlong),
            'right-bottom' => array('lat' => $lat - $dlat, 'long' => $long + $dlong));
    }
    //接收起点经纬度
    // $longitude,
    // $latitude
    public function getDistance($longitude, $latitude)
    {
        $array = $this->returnSquarePoint($longitude, $latitude);
        return $this->where('long',['<=',$array['left-top']['long']],['>=',$array['right-bottom']['long']],'and')
            ->where('lat',['>=',$array['right-bottom']['lat']],['<=',$array['left-top']['lat']],'and')
            ->field('long,lat,name')
            ->order('id', 'desc')
            ->select();
        /*$
       注释代码
       map = array(
       'lat' => array(
           array('>=', $array['right-bottom']['lat']),
           array('<=', $array['left-top']['lat']), 'and'),
       'long' => array(
           array('<=', $array['left-top']['long']),
           array('>=', $array['right-bottom']['long']), 'and'),
       );
   echo "<pre>";
   var_dump($map);*/
    }

}