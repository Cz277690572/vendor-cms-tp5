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
        $this->title = 'vendor系统管理后台';
        $this->fetch();
    }
}