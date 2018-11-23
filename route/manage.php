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
    //骑手
    Route::rule('rider', 'rider/index');
    Route::rule('rider-set', 'rider/set');
    Route::rule('rider-coupon', 'rider/coupon');
    Route::rule('rider-payment', 'rider/payment');
    //物业
    Route::rule('property', 'property/index');

});