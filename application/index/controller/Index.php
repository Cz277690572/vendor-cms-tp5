<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:23
 */

namespace app\index\controller;


use app\admin\controller\BaseController;

class Index extends BaseController
{
    public function index()
    {
        $this->redirect(url('@admin/login'));
    }
}