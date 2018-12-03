<?php
/**
 * 注册登录控制器.
 * User: whp
 * Date: 2018/10/19
 * Time: 14:12
 */

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Session;
use think\facade\Config;
use app\common\model\User;

class Signin extends Apibase
{
    /*
     * 注册账号：手机号码 验证码
     * */
    public function index()
    {
        $phone = $this->request->param('phone');
        $code = $this->request->param('code');
        $result = $this->validate(['phone' => $phone, 'code' => $code], 'app\api\validate\User');
        if (true !== $result) {
            return json(['code' => '202', 'msg' => $result]);
        }
        //check code
        if (Session::get($phone.'sms') != $code) {
            return json(['code' => '202', 'msg' => showReturnCode('3003')]);
        }

        //Is mobile phone number registered
        $user = new User();
        $userResult = $user->getRider($phone);
        //为空添加数据
        if (empty($userResult)) {
            $apptoken = $this->request->token($phone.'apptoken', 'sha1');

            $uid = $user->insertUser($phone, $apptoken);
            if (!empty($uid)) {
                //write in
                Session::set('uid', $uid);
                Session::set('apptoken', $token, Config::get('sys_config.expiry_time'));
                return json(['code' => '200', 'uid' => $uid, 'token' => $token, 'turl' => '/index', 'msg' => showReturnCode('5000')]);
            }
        }
        //账户状态
        switch ($userResult['status']){
            case 2:
                return json(['code' => '202', 'msg' => showReturnCode('4000')]);
                break;
            case 3:
                return json(['code' => '202', 'msg' => showReturnCode('4002')]);
                break;
        }
        //data exist
        Session::set('uid', $userResult['uid']);
        Session::set('apptoken', $userResult['uid'], Config::get('sys_config.expiry_time'));
        return json(['code' => '200', 'uid' => $userResult['uid'], 'token' => $userResult['token'], 'turl' => '/index', 'msg' => showReturnCode('5000')]);

         }
}