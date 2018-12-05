<?php
/**
 * 注册登录控制器.
 * User: whp
 * Date: 2018/10/19
 * Time: 14:12
 */

namespace app\api\controller;

use think\facade\Session;
use app\common\model\User;
use app\common\model\UserInfo;

class Signin extends Apibase
{
    /*
     * 前置操作
     * */
    protected $middleware = [
        //'Auth' 	=> ['except' 	=> ['hello'] ],
       // 'Hello' => ['only' 		=> ['index'] ],
    ];
    /*
     * 注册账号：
     * @param   phone   手机号码
     * @param   code    验证码
     * */
    public function index()
    {
        $phone = $this->request->param('phone');
        $code = $this->request->param('code');
        $result = $this->validate(['phone' => $phone, 'code' => $code], 'app\api\validate\User.signin');
        if (true !== $result) {
            return json(['code' => '202', 'msg' => $result]);
        }
        if (Session::get($phone . 'sms') != $code) {
            return json(['code' => '202', 'msg' => showReturnCode('3003')]);
        }
        $user = new User();
        $userResult = $user->getRider($phone);
        if (empty($userResult)) {
            $token = $this->request->token('token', 'sha1');
            //过滤非数据表字段
            $user->allowField(true)->save([
                'phone' => $phone,
                'token' => $token,
            ]);
            Session::set('uid', $user->uid);
            Session::set('token', $user->token);
            return json(['code' => '200', 'uid' => $user->uid, 'token' => $user->token, 'turl' => url('/signin-choice'), 'msg' => showReturnCode('5000')]);
        }
        //账户状态
        switch ($userResult->status){
            case 2:
                return json(['code' => '202', 'msg' => showReturnCode('4000')]);
                break;
            case 3:
                return json(['code' => '202', 'msg' => showReturnCode('4002')]);
                break;
        }
        $user->isUpdate(true,['uid' => $userResult->uid])->save(['inc' =>['inc',1]]);
        Session::set('uid', $userResult->uid);
        Session::set('token', $userResult->token);
        return json(['code' => '200', 'uid' => $userResult->uid, 'token' => $userResult->token, 'turl' => url('/signin-choice'), 'msg' => showReturnCode('5000')]);
    }
    /*
     * 用户选择身份
     * @param   identity    身份标识 1骑手 2快递 3物业 4个人
     * */
    public function choice(){
        $identity  =   $this->request->param('identity');
        $result = $this->validate(['identity' => $identity], 'app\api\validate\User.choice');
        if (true !== $result) {
            return json(['code' => '202', 'msg' => $result]);
        }
        $UserInfo = new User();
        $UserInfoResult = $UserInfo->allowField('identity')->save(['identity' => $identity],['uid' => $this->uid]);
        if ($UserInfoResult == true){
            return json(['code' => '200', 'turl' => url('/location'),'msg' => showReturnCode('1020')]);
        }
    }
    /*
     * 第三方登录(微信)
     * */
    public function thirdParty(){

    }
}
