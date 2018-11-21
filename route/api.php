<?php
/**
 * API 路由.
 * User: max
 * Date: 2018/11/8
 * Time: 17:21
 */
use think\facade\Route;

Route::bind('api');
Route::domain('api', function () {
    Route::rule('/', 'index');
    Route::rule('reglogin', 'reglogin/index','GET|POST');
    //Route::rule('info', 'user/info','GET|POST');
   // Route::get(':c/:a', 'api/:c/:a');
});