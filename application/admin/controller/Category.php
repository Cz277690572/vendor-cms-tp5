<?php


namespace app\admin\controller;


use think\Db;

class Category extends BaseController
{

    protected $table = 'category';

    public function index()
    {
        $this->title = '分类列表';
        $query = $this->_query($this->table)->alias('c')->join('image i','c.topic_img_id = i.id','LEFT')
            ->field('c.*, i.url as topic_img_url')->like('c.name');
        $query->dateBetween('c.update_time')->order('c.sort desc, c.id desc')->page();
    }

    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    public function add()
    {

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
        if($this->request->isGet()){
            $row = Db::name('image')->where(['id'=>$data['topic_img_id']])->find();
            $data['topic_img_url'] = isset($row['url']) ? '/static/images'.$row['url'] : null;
        }elseif ($this->request->isPost()){

        }
    }

    public function remove()
    {

    }
}