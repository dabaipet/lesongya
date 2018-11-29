<?php
namespace app\common\model;
/**
 * 派送人员 模型.
 * User: whp
 * Date: 2018/10/19
 * Time: 17:48
 */
use think\facade\Config;
use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;//开启自动时间戳
    protected $pk = 'uid';

}