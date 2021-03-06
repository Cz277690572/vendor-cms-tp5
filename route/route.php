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

//Route::get('think', function () {
//    return 'hello,ThinkPHP5!';
//});
//
//Route::get('hello/:name', 'index/hello');
//
//return [
//
//];

    /*小程序接口开始*/
    // 获取轮播图信息
    Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
    // 获取专栏信息
    Route::get('api/:version/theme/by/ids','api/:version.Theme/getSimpleList');
    // 获取专栏里的商品
    Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');
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
    // 第三方应用获取令牌
    Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');
    // 创建或更新用户的地址
    Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');
    Route::get('api/:version/address', 'api/:version.Address/getUserAddress');
    // 提交预支付订单
    Route::post('api/:version/order/create', 'api/:version.Order/placeOrder');
    // 获取订单详情
    Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[],['id'=>'\d+']);
    // 获取用户订单简要信息
    Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');
    // 微信支付预订单
    Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
    // 微信回调api的地址--无效,微信支付回调通知不会进入该接口;无解
    Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');

    // 定时签收订单
    Route::get('api/:version/order/complete', 'api/:version.Order/complete');
    // 定时关闭订单
    Route::get('api/:version/order/close', 'api/:version.Order/close');
    // 获取快递服务信息
    Route::get('api/:version/express/service_info', 'api/:version.Express/getServiceInfo');
    // 获取快递物流信息
    Route::get('api/:version/express/logistics_info', 'api/:version.Express/getLogisticsInfo');
    // 获取关于我们信息
    Route::get('api/:version/config/about_us/type', 'api/:version.Config/getAboutUs');
    /*小程序接口结束*/

    /*cms内容管理开始*/
    // 登录
    // Route::get('admin/login', 'admin/Login/index');
    // 发货
    // Route::post('api/:version/order/delivery', 'api/:version.Order/delivery');
    // 获取订单分页
    // Route::get('api/:version/order/paginate', 'api/:version.Order/getSummary');
    /*cms内容管理结束*/
