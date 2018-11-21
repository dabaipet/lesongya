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
    protected $apptoken =   '';//全局接受token
    protected $uid  =   '';//全局uid

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        //token uid获取
        $this->apptoken =   $this->request->param('token');
        $this->uid  =   Session::get('uid');

    }
    //Check does't login
    public function isLogin(){
        if (Session::has('apptoken') == false && Session::has('apptoken') != $this->apptoken) {
            return json(['code' => 202,'turl' => '/reglogin', 'msg' => "showReturnCode('2002')"]);
        }
    }


}