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

    protected $appSite = '';
    protected $token;//全局接受                                                                                 token
    protected $uid;//全局uid
    protected $identity; //身份标识

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->token =   $this->request->param('token');
        $this->uid  =   Session::get('uid');
        $this->identity  =   Session::get('identity');
        self::isLogin();
    }
    //Check does't login
    public function isLogin()
    {
        if (Session::has('token') == false && Session::get('token') != $this->token) {
            return json(['code' => 202, 'turl' => url('/signin'), 'msg' => showReturnCode('2002')]);
        }
    }
}