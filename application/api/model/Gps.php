<?php
/**
 * 饭巢GPS位置.
 * User: mwhp
 * Date: 2018/10/29
 * Time: 16:43
 */

namespace app\api\model;


use think\Model;

class Gps extends Model
{
protected  $table=  'sf_maps';
    /* *参数说明：
     * @param   $lng 经度
     * @param   $lat 纬度
     * @param   $distance 周边半径 默认是500米（0.5Km）
     * */
    public function returnSquarePoint($lng, $lat, $distance = 3)
    {
        $dlng = 2 * asin(sin($distance / (2 * 6371)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
        $dlat = $distance / 6371;
        $dlat = rad2deg($dlat);
        return array(
            'left-top' => array('lat' => $lat + $dlat, 'lng' => $lng - $dlng),
            'right-top' => array('lat' => $lat + $dlat, 'lng' => $lng + $dlng),
            'left-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng - $dlng),
            'right-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng + $dlng));
    }
    //接收起点经纬度
    // $longitude,
    // $latitude
    public function Distance($longitude, $latitude)
    {
        $array = $this->returnSquarePoint($longitude, $latitude);

        $map = array(
            'lat' => array(
                array('egt', $array['right-bottom']['lat']),
                array('elt', $array['left-top']['lat']), 'and'),
            'lng' => array(
                array('egt', $array['left-top']['lng']),
                array('elt', $array['right-bottom']['lng']), 'and'),
            );
        /*echo "<pre>";
        var_dump($map);
        die;*/
        $data = $this->where($map)->select();
        $this->getLastSql();
        //return $data;
    }


}