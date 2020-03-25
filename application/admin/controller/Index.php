<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:44
 */

namespace app\admin\controller;


class Index extends BaseController
{
    public function index(){
        return $this->fetch('index',['title'=>'vendor系统管理后台']);
    }

    public function home(){
        return $this->fetch('home',['title'=>'后台首页']);
    }
}