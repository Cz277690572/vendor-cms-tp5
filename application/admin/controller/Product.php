<?php


namespace app\admin\controller;


class Product extends BaseController
{
    protected $table = 'product';
    public function index()
    {
        $this->title = '商品列表';
        $query = $this->_query($this->table)->alias('p')->join('category c','p.category_id = c.id','LEFT')
            ->field('p.*,c.name as category_name')->like('p.name');
        $query->dateBetween('p.create_time')->order('p.sort desc, p.id desc')->page();
    }

    public function add()
    {
        $this->isAddMode = '1';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑商品信息
     * @return mixed
     */
    public function edit()
    {
        $this->title = '编辑商品信息';
        $this->isAddMode = '0';
        return $this->_form($this->table, 'form');
    }

    public function remove()
    {

    }
}