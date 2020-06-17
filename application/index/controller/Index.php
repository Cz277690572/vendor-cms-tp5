<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:23
 */

namespace app\index\controller;

use app\api\service\WxNotify;
use think\Controller;
use think\facade\Log;

class Index extends Controller
{
    //微信支付回调通知入口
    public function index()
    {
        $this->redirect(url('@admin/login'));
    }
}