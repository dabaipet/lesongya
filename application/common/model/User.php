<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/12/13
 * Time: 19:23
 */

namespace app\common\model;


use think\facade\Cache;
use think\Model;

class User extends Model
{
    protected $pk = 'uid';
    protected $update = ['update_time'];

    public function getRider($phone)
    {
        return $this->where('phone', '=', $phone)
            ->field(true)
            ->find();
    }

    /*
     * 增删改查缓存用户数据
     * @param uid
     * */
    public function curdSessionUser($uid)
    {
        $result = $this->where('uid', '=', $uid)
            ->field(true)
            ->find();
        Cache::store('redis')->set('user' . $uid, json_encode($result));
    }

    public function getRiderInfo($uid)
    {

    }
}