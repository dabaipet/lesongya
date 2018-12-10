<?php
/*
 * API全局基类
 * */

namespace app\api\controller;


use think\App;
use think\Controller;
use think\facade\Session;
use think\facade\Cache;

class Apibase extends Controller
{

    protected $phone = null;
    protected $token = null;//全局接受token
    protected $uid;//全局uid
    protected $identity; //身份标识
    protected $CacheUser;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->phone =   $this->request->param('phone');
        $this->token =   $this->request->param('token');
        $this->CacheUser = json_decode(Cache::store('redis')->get('user'.$this->phone));
        $this->uid  =   $this->CacheUser->uid;
        $this->identity  =    $this->CacheUser->identity;
        self::isLogin();
    }
    //Check does't login
    public function isLogin()
    {
        if ($this->CacheUser->token != $this->token) {
            return json(['code' => 202, 'turl' => url('/signin'), 'msg' => showReturnCode('2002')]);
        }
    }
}