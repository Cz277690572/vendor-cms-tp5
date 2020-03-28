<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:05
 */

namespace app\admin\controller;


use library\Controller;
use think\facade\Request;

/**
 * 用户登录管理
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 登出
     */
    public function out()
    {
        $token = Request::instance()
            ->header('token');
        cache($token,null);
        $this->success('退出登录成功!', url('@admin/login'));
    }
}