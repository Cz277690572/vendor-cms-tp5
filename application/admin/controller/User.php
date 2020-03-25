<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/25
 * Time: 15:37
 */

namespace app\admin\controller;


class User extends BaseController
{
    protected $dbQuery = 'user';
    public function index()
    {
        $this->title = 'C端用户列表';
        $this->_page($this->dbQuery);
    }
}