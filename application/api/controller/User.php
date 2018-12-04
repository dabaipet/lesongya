<?php
/**
 * 用户中心.
 * User: whp
 * Date: 2018/10/24
 * Time: 16:12
 */

namespace app\api\controller;


use think\facade\Session;
use app\common\model\User as UserM;
use app\common\model\UserInfo;

class User extends Apibase
{
    /*
     * 基本信息
     * @return  头像 手机号 分数 金额 我的订单数
     * */
    public function index(){
      $user = new UserM();
      $userResult = $user->getRiderToken($this->token);

    }
    /*
     * 个人信息
     * @param   uid
     * @return  头像  昵称  姓名  是否实名认证 手机号  性别  （微信 QQ） 是否绑定
     * */
    public function info(){

    }
    /*
     * 物业设置存放点信息
     * */
    public function setDeposit(){

    }
    /*
     * 获取GPS 返回 方圆3公里所有站点
     * */
    public function getGps(){
        $lng    =   $this->request->param('lng');
        $lat    =   $this->request->param('lat');
    }
}