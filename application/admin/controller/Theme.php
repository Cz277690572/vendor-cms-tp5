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
        $query->dateBetween('update_time')->where(['delete_time' => null])->order('sort desc, id desc')->page();
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
            $data['topic_img_url'] = empty($topicImgUrl) ? '' : config('setting.img_prefix').$topicImgUrl;
            // 主题列表头图
            $headImgUrl = Db::table('image')->where('id', $data['head_img_id'])->value('url');
            $data['head_img_url'] = empty($headImgUrl) ? '' : config('setting.img_prefix').$headImgUrl;
            // 主题下的商品
            $this->products = Db::table('theme_product')->alias('t')
                ->join('product p','p.id = t.product_id')
                ->field('t.*,p.*')
                ->where(['t.theme_id' => $data['id'],'p.delete_time' => null])
                ->order('p.sort desc, p.id desc')
                ->select();
            if(!empty($this->products)){
                foreach ($this->products as $pk => $pv){
                    $this->products[$pk]['main_img_url'] = config('setting.img_prefix').$pv['main_img_url'];
                }
            }
            // 主题下可添加的商品
            $themeProductIds = !empty($this->products) ? array_column($this->products,'product_id') : [0];
            $themeProductIdsStr = join(',', $themeProductIds);
            $this->validAddProducts = Db::table('product')
                ->whereNotIn('id',$themeProductIdsStr)
                ->where(['delete_time' => null])
                ->order('sort desc,id desc')
                ->select();
        }
        elseif ($this->request->isPost())
        {
            $this->_input([
                'name' => $this->request->post('name'),
                'topic_img_url' => $this->request->post('topic_img_url'),
                'head_img_url' => $this->request->post('head_img_url'),
            ], [
                'name' => 'require',
                'topic_img_url' => 'require',
                'head_img_url' => 'require',
            ], [
                'name.require' => '专题名称必须填写！',
                'topic_img_url.require' => '专题主题图必须上传！',
                'head_img_url.require' => '专题列表页头图必须上传！',
            ]);

            $data['update_time'] = time();
            if($this->isAddMode == 0){
                $topicImgData['id']   = $data['topic_img_id'];
                $topicImgData['url']  = substr($data['topic_img_url'], strpos($data['topic_img_url'],config('setting.upload_path'))+7);
                $topicImgData['from'] = config('setting.img_form_local');
                $topicImgData['update_time'] = time();
                Db::name('image')->where('id',$topicImgData['id'])->update($topicImgData);

                $headImgData['id']   = $data['head_img_id'];
                $headImgData['url']  = substr($data['head_img_url'], strpos($data['head_img_url'],config('setting.upload_path'))+7);
                $headImgData['from'] = config('setting.img_form_local');
                $headImgData['update_time'] = time();
                Db::name('image')->where('id',$headImgData['id'])->update($headImgData);
                unset($data['topic_img_url']);
                unset($data['head_img_url']);
            }
        }
    }

    public function remove()
    {
        $id    = $this->request->post('id');
        $theme = Db::table($this->table)->field('topic_img_id,head_img_id')->where('id', $id)->find();
        $time  = time();
        Db::name('image')
            ->where('id', 'in',"{$theme['topic_img_id']},{$theme['head_img_id']}")
            ->update(['delete_time' => $time,'update_time' => $time]);
        $this->_save($this->table, ['delete_time' => $time, 'status' => 0]);

    }

    public function addProduct()
    {
        if($this->request->isGet())
        {
            $this->theme_id = $this->request->get('theme_id');
            // 主题下的商品
            $this->products = Db::table('theme_product')->alias('t')
                ->join('product p','p.id = t.product_id')
                ->field('t.*,p.*')
                ->where(['t.theme_id' => $this->theme_id,'p.delete_time' => null])
                ->order('p.sort desc, p.id desc')
                ->select();
            // 主题下可添加的商品
            $themeProductIds = !empty($this->products) ? array_column($this->products,'product_id') : [0];
            $themeProductIdsStr = join(',', $themeProductIds);
            $this->validAddProducts = Db::table('product')
                ->whereNotIn('id',$themeProductIdsStr)
                ->where(['delete_time' => null])
                ->order('sort desc,id desc')
                ->select();
            $this->fetch();
        }
        elseif ($this->request->isPost())
        {
            $this->_input([
                'product_id' => $this->request->post('product_id')
            ], [
                'product_id' => 'require'
            ], [
                'product_id.require' => '必须选择商品！'
            ]);
            $themeProduct['product_id'] = $this->request->post('product_id');
            $themeProduct['theme_id'] = $this->request->post('theme_id');
            $res = Db::table('theme_product')->insert($themeProduct);
            if($res){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }
    }

    public function delProduct()
    {
        $product_id = $this->request->post('product_id');
        $theme_id = $this->request->post('theme_id');
        $res = Db::table('theme_product')->delete(['product_id'=>$product_id,'theme_id'=>$theme_id]);
        if($res){
            $this->success('移除商品成功');
        }else{
            $this->error('移除商品失败');
        }
    }
}