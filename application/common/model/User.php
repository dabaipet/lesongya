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
     * 注册查询状态信息
     * */
    public function getRider($phone){
        return $this->where('phone', '=', $phone)
            ->field('create_time,inc',true)
            ->find();
    }
    /*
     * 骑手信息
     * */
    public function getRiderInfo($token){
        return $this->where('token', '=', $token)
            ->field('uid,phone,token,status,identity,sex,head_pic,birthday')
            ->find();
    }
    public function userinfo()
    {
        return $this->hasOne('user_info','uid');
    }
}