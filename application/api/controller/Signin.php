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
     * 前置操作
     * */
    protected $middleware = [
        //'Auth' 	=> ['except' 	=> ['hello'] ],
       // 'Hello' => ['only' 		=> ['index'] ],
    ];
    /*
     * 注册账号：手机号码 验证码
     * */
    public function index()
    {
        $type = $this->request->param('type');
        $phone = $this->request->param('phone');
        $code = $this->request->param('code');
        $result = $this->validate(['phone' => $phone, 'code' => $code,'type' => $type], 'app\api\validate\User');
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
                'type' => $type,
                'phone' => $phone,
                'token' => $token,
            ]);
            Session::set('uid', $user->uid);
            Session::set('token', $user->token);
            return json(['code' => '200', 'uid' => $user->uid, 'token' => $user->token, 'turl' => url('/location'), 'msg' => showReturnCode('5000')]);
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
        $user->where('uid',$userResult->uid)->setInc('inc');
        Session::set('uid', $userResult->uid);
        Session::set('token', $userResult->token);
        return json(['code' => '200', 'uid' => $userResult->uid, 'token' => $userResult->token, 'turl' => '/', 'msg' => showReturnCode('5000')]);
    }
}