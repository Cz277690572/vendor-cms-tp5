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

    public function edit()
    {
        $this->title = '更新主题';
        $this->isAddMode = '0';
        return $this->_form($this->table, 'form');
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
        $time = time();
        // 生成专题ID
        if (empty($data['id'])){
            $data['id'] = Data::uniqidNumberCode();
            $data['create_time'] = $time;
        }
        if ($this->request->isGet())
        {
            // 主题主图
            $topicImgUrl = Db::table('image')->where('id', $data['topic_img_id'])->value('url');
            $data['topic_img_url'] = isset($topicImgUrl) ? $topicImgUrl : config('setting.img_prefix').$topicImgUrl;
            // 主题列表头图
            $headImgUrl = Db::table('image')->where('id', $data['head_img_id'])->value('url');
            $data['head_img_url'] = isset($headImgUrl) ? $headImgUrl : config('setting.img_prefix').$headImgUrl;

            // 主题下的商品
            $this->products = Db::table('theme_product')->alias('t')
                ->join('product p','p.id = t.product_id')
                ->field('t.*,p.*')
                ->where(['t.theme_id' => $data['id'],'p.delete_time' => null])
                ->order('p.sort desc, p.id desc')
                ->select();;
        }
        elseif ($this->request->isPost())
        {

        }
    }

    public function remove()
    {

    }
}