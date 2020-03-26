<?php
/**
 * 第三方账户管理
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/26
 * Time: 16:41
 */

namespace app\admin\controller;


class ThirdApp extends BaseController
{
    protected $dbQuery = 'third_app';
    public function index()
    {
        $this->title = '第三方账户管理';
        $this->_page($this->dbQuery);
    }
}