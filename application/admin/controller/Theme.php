<?php


namespace app\admin\controller;


use think\Db;

class Theme extends BaseController
{
    protected $table = 'theme';
    public function index()
    {
        $this->title = '主题列表';
        $query = $this->_query($this->table)->like('name');
        $query->dateBetween('update_time')->order('sort desc, id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _index_page_filter(&$data)
    {
        $this->ilist = Db::name('image')->select();
        foreach ($data as &$vo) {
            foreach ($this->ilist as $image){
                if ($image['id'] === $vo['topic_img_id']){
                    $vo['topic_img'] = config('setting.img_prefix').$image['url'];
                }
                if ($image['id'] === $vo['head_img_id']){
                    $vo['head_img'] = config('setting.img_prefix').$image['url'];
                }
            }
        }
    }
}