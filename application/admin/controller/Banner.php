<?php


namespace app\admin\controller;


class Banner extends BaseController
{
    protected $table = 'banner';
    public function index()
    {
        $this->title = 'Banner列表';
        $this->_page($this->table);
    }

    public function detail()
    {

    }

    public function remove()
    {
        $this->error('首页Banner轮播图禁止删除！');
    }
}