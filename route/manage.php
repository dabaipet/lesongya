<?php
/**
 * 后台路由.
 * User: max
 * Date: 2018/11/8
 * Time: 17:21
 */
use think\facade\Route;

/*
 * 后台路由设置
 * */

Route::domain('manage', function () {
    Route::rule('/', 'index');
    Route::rule('read', 'index/read');
});