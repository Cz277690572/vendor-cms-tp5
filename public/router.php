<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

//if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
//    return false;
//} else {
//    require __DIR__ . "/index.php";
//}


use think\Route;
// Route::get('api/v1/banner/:id', 'api/v1.Banner/getBanner');
// 获取轮播图信息
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

// 获取专栏信息
Route::get('api/:version/theme','api/:version.Theme/getSimpleList');
// 获取专栏里的商品
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');

// 获取分类中的所有商品
// Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');
// 获取商品详情
// Route::get('api/:version/product/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']);
// 获取最新商品
// Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');

    //路由分组,方便管理路由相同的前缀
    Route::group('api/:version/product',function(){
        Route::get('/by_category','api/:version.Product/getAllInCategory');
        Route::get('/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']);
        Route::get('/recent', 'api/:version.Product/getRecent');
    });

    // 获取所有分类
    Route::get('api/:version/category/all', 'api/:version.category/getAllCategories');

    // 获取用户的token
    Route::post('api/:version/token/user', 'api/:version.Token/getToken');
    // 验证用户令牌是否过期或无效
    Route::post('api/:version/token/verify','api/:version.Token/verifyToken');
    // 获取AppToken
    Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');

    // 创建或更新用户的地址
    Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');
    Route::get('api/:version/address', 'api/:version.Address/getUserAddress');

    // 支付订单
    Route::post('api/:version/order', 'api/:version.Order/placeOrder');
    // 获取订单详情
    Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[],['id'=>'\d+']);
    // 发货
    Route::post('api/:version/order/delivery', 'api/:version.Order/delivery');
    // 获取用户订单简要信息
    Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');
    // 获取订单分页
    Route::get('api/:version/order/paginate', 'api/:version.Order/getSummary');

    // 微信支付预订单
    Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
    // 微信回调api的地址
    Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
