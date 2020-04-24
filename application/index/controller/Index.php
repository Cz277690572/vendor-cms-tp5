<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:23
 */

namespace app\index\controller;

use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $this->redirect(url('@admin/login'));
    }
}