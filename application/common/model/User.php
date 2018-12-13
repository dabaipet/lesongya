<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/12/13
 * Time: 19:23
 */

namespace app\common\model;


use think\Model;

class User extends Model
{
    protected $pk = 'uid';
    protected $update = ['update_time'];

    public function getRider($phone){
        return $this->where('phone','=',$phone)
            ->field(true)
            ->find();
    }
    public function getRiderInfo(){

    }
}