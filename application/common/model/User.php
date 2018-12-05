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
    protected $pk = 'uid';
    protected $insert = ['create_time'];
    protected $update = ['update_time'];

    /*
     * 自动完成字段
     * */
    protected function setIpAttr()
    {
        return request()->ip();
    }
    /*
     * 查询单个骑手用户
     * */
    public function getRider($phone){
        return $this->where('phone', '=', $phone)
            ->field('uid,token,status')
            ->find();
    }
    /*
     * 骑手信息
     * */
    public function getRiderToken($token){
        return $this->where('token', '=', $token)
            ->field('uid,token')
            ->find();
    }
    public function userinfo()
    {
        return $this->hasOne('user_info','uid');
    }
}