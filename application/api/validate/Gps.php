<?php
/**
 * 经纬度验证
 * User: whp
 * Date: 2018/11/29
 * Time: 16:38
 */

namespace app\api\Validate;


use think\Validate;

class Gps extends Validate
{
    //GPS正则验证
    protected $regex = [
        'gpslong' => '/^[\-\+]?(0?\d{1,2}|0?\d{1,2}\.\d{1,15}|1[0-7]?\d{1}|1[0-7]?\d{1}\.\d{1,15}|180|180\.0{0,6})$/',
        'gpslat' => '/^[\-\+]?([0-8]?\d{1}|[0-8]?\d{1}\.\d{1,15}|90|90\.0{0,6})$/'
    ];
    protected $rule =   [
        'long'  => 'require|float',
        'lat'  => 'require|float'
    ];
    protected $message  =   [
        'long.require' => '请打开手机定位',
        'lat.require' => '请打开手机定位',
        'long.float'     => '请打开手机定位',
        'lat.float'     => '请打开手机定位',
    ];

}