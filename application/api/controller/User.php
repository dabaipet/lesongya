<?php
/**
 *-------------LeSongya--------------
 * Explain: 用户控制器
 * File name: User.php
 * Date: 2018/12/5
 * Author: 王海鹏
 * Project name: 乐送呀
 *------------------------------------
 */
namespace app\api\controller;

use app\common\model\User as UserM;

class User extends Apibase
{
    /*
     * 基本信息
     * @params  user表    头像 手机号 分数 金额 我的订单数
     * @params  wallet表  钱包余额
     * @params  order表  订单数
     * */
    public function index(){
        $user = new UserM();

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
    /*
     * 头像设置
     * */
    public function setHeadpic(){

    }
}