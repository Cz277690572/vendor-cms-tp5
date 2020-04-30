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
    protected $table = 'user';
    public function index()
    {
        $this->title = 'C端用户列表';
        $query = $this->_query($this->table)->where(['delete_time' => null])->like('openid,nickname');
        $query->timeBetween('update_time')->order('id desc')->page();


    }

    public function remove()
    {
        $this->_save($this->table, ['delete_time' => time()]);
    }
}