<?php


namespace app\admin\controller;


class Category extends BaseController
{

    protected $table = 'category';

    public function index()
    {
        $this->title = '分类列表';
        $query = $this->_query($this->table)->alias('c')->join('image i','c.topic_img_id = i.id','LEFT')->like('c.name');
        $query->dateBetween('c.update_time')->order('c.id desc')->page();
    }

    public function edit()
    {

    }

    public function add()
    {

    }

    public function remove()
    {

    }
}