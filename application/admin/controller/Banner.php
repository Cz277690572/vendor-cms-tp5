<?php


namespace app\admin\controller;


class Banner extends BaseController
{
    protected $table = 'banner';
    public function index()
    {
        $this->title = 'Banner列表';
        $query = $this->_query($this->table)->where(['delete_time' => null]);
        $query->page();
    }

    public function edit()
    {
        $this->title = '更新Banner';
        $this->isAddMode = '0';
        return $this->_form($this->table,'form');
    }

    public function remove()
    {
        $this->error('首页Banner轮播图禁止删除！');
    }
}