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

    public function edit()
    {
        $this->isAddMode = '0';
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _form_filter(&$data)
    {
    }

    public function remove()
    {

    }
}