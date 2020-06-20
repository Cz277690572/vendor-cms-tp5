<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;


use think\facade\Log;

require __DIR__ . '/../thinkphp/base.php';

$wxData = file_get_contents("php://input");
Log::record('微信支付回调参数POST'.json_encode($wxData),'error');

// 执行应用并响应
Container::get('app')->run()->send();
