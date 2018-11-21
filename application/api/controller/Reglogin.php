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
use app\api\model\User;
use think\facade\Config;

class Reglogin extends Apibase
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
        if (Cache::store('redis')->get($phone) != $code) {
            return json(['code' => '202', 'msg' => showReturnCode('3003')]);
        }
        //Is mobile phone number registered
        $user = new User();
        $userAtr = $user->where('phone',"$phone")->field('create_time,update_time,cishu','turn')->find();
        if (empty($userAtr)) {
            //account status
            switch ($userAtr['status']){
                case 2:
                    return json(['code' => '202', 'msg' => showReturnCode('4000')]);
                    break;
                case 3:
                    return json(['code' => '202', 'msg' => showReturnCode('4002')]);
                    break;
            }
            echo token('apptoken', 'sha1');
            $token = Session::get('apptoken');
            $uid = $user->insertUser($phone, $token);
            if (!empty($uid)) {
                //write in
                Session::set('uid', $uid);
                Session::set('apptoken', $token, Config::get('sys_config.expiry_time'));
                return json(['code' => '200', 'uid' => $uid, 'token' => $token, 'turl' => '/index', 'msg' => showReturnCode('5000')]);
            }
        }
        //data exist
        Session::set('uid', $userAtr['uid']);
        Session::set('apptoken', $userAtr['uid'], Config::get('sys_config.expiry_time'));
        return json(['code' => '200', 'uid' => $userAtr['uid'], 'token' => $userAtr['token'], 'turl' => '/index', 'msg' => showReturnCode('5000')]);

        // 读写分离模式 读redis 写MySQL
        if (Session::has("$phone") == false){
            $user = new User();
            $userAtr = $user->where('phone',"$phone")->field('create_time,update_time,cishu','turn')->find();
            if (empty($userAtr)) {
                //account status
                switch ($userAtr->status){
                    case 2:
                        return json(['code' => '202', 'msg' => showReturnCode('4000')]);
                        break;
                    case 3:
                        return json(['code' => '202', 'msg' => showReturnCode('4002')]);
                        break;
                }
                $token = Session::get('apptoken');
                $uid = $user->insertUser($phone, $token);
                if (!empty($uid)) {
                    //write in
                    Session::set('uid', $uid, Config::get('sys_config.expiry_time'));
                    Session::set('apptoken', $token, Config::get('sys_config.expiry_time'));
                    return json(['code' => '200', 'uid' => $uid, 'token' => $token, 'turl' => '/index', 'msg' => showReturnCode('5000')]);
                }
            }
        }
        //data exist
        Session::set('uid', $userAtr->uid, $userAtr->expiry_time);
        Session::set('apptoken', $userAtr->token, $userAtr->expiry_time);
        return json(['code' => '200', 'uid' => $userAtr->uid, 'token' => $userAtr->token, 'turl' => '/index', 'msg' => showReturnCode('5000')]);
    }

}