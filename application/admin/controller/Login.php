<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:05
 */

namespace app\admin\controller;

/**
 * 用户登录管理
 * Class Login
 * @package app\admin\controller
 */
class Login extends BaseController
{
    public function index()
    {
        // 不带任何参数 自动定位当前操作的模板文件
        return $this->fetch();
    }
}