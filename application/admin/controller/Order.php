<?php


namespace app\admin\controller;


class Order extends BaseController
{
    protected $table = 'order';
    public function index()
    {
        $query = $this->_query($this->table)->like('order_no,user_id');
        $query->dateBetween('create_time,update_time')->order('id desc')->page();
    }
}