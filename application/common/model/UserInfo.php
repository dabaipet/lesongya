<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/12/4
 * Time: 21:16
 */

namespace app\common\model;


use think\Model;

class UserInfo extends Model
{
    private $table  =   'ls_user_info';
    private $pk  =   'uid';

    public function getRiderInfo($uid){
        return $this->where('uid','=',$uid)
            ->field('')
            ->find();
    }


}