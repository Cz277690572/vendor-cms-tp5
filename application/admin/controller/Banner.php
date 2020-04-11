<?php


namespace app\admin\controller;


use library\tools\Data;
use think\Db;

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
            $data['update_time'] = $time;
        }
        if ($this->request->isGet())
        {
            // Banner-Item列表
            $id = $this->request->get('id');
            $this->bannerItem = Db::name('banner_item')->alias('bi')
                ->field('bi.*,i.url')
                ->join('image i','i.id = bi.img_id')
                ->where(['bi.delete_time' => null, 'bi.banner_id' => $id])
                ->order('bi.sort desc, bi.id desc')
                ->select();
            if(!empty($this->bannerItem)){
                foreach ($this->bannerItem as $bk => $bv){
                    $this->bannerItem[$bk]['img_url'] = isset($bv['url']) ? config('setting.img_prefix').$bv['url'] : '';
                }
            }
        }
        elseif ($this->request->isPost())
        {
            $this->_input([
                'name' => $this->request->post('name')
            ], [
                'name' => 'require'
            ], [
                'name.require' => 'Banner名称必须填写！'
            ]);
            $data['update_time'] = time();
        }
    }

    public function remove()
    {
        $this->error('首页Banner轮播图禁止删除！');
    }

    public function addBannerItem()
    {
        if($this->request->isGet())
        {
            $bannerId = $this->request->get('banner_id');
            $id = Data::uniqidNumberCode();
            $this->bannerItem = ['id'=>$id,'banner_id' => $bannerId];
            $this->types = [['value'=>0,'name'=>'无导向'],['value'=>1,'name'=>'导向商品'],['value'=>2,'name'=>'导向专题']];
            return $this->fetch('banner_item_form');
        }
        elseif ($this->request->isPost())
        {
            $this->_input([
                'key_word' => $this->request->post('key_word'),
                'type'     => $this->request->post('type'),
                'status'   => $this->request->post('status'),
                'img_url'  => $this->request->post('img_url'),
                'banner_id'  => $this->request->post('banner_id'),
            ], [
                'key_word' => 'require',
                'type' => 'require',
                'status' => 'require',
                'img_url' => 'require',
                'banner_id' => 'require'
            ], [
                'key_word.require' => '关键字必须填写！',
                'type.require' => '类型必须选择！',
                'status.require' => '是否上线必须选择！',
                'img_url.require' => '图片必须上传！',
                'banner_id.require' => 'banner_id参数错误！',
            ]);
            $data = $this->request->post();
            if($data['type'] == 1 && !is_numeric($data['key_word'])){
                $this->error('类型导向商品,关键字必须是商品id！');
            }

            $time = time();
            $imageData['url']  = substr($data['img_url'], strpos($data['img_url'],config('setting.upload_path'))+7);
            $imageData['from'] = config('setting.img_form_local');
            $imageData['update_time'] = $time;
            $imageId = Db::name('image')->insertGetId($imageData);

            unset($data['img_url']);
            $data['img_id'] = $imageId;
            $data['update_time'] = $time;
            $res = Db::name('banner_item')->insert($data);
            if($res){
                $this->success('保存成功！');
            }else{
                $this->error('保存失败！');
            }
        }
    }

    public function editBannerItem()
    {
        if ($this->request->isGet())
        {
            $id = $this->request->get('id');
            $this->bannerItem = Db::name('banner_item')->alias('bi')
                ->field('bi.*,i.url')
                ->join('image i', 'bi.img_id = i.id')
                ->where(['bi.id' => $id])
                ->find();
            $this->bannerItem['img_url'] = isset($this->bannerItem['url']) ? config('setting.img_prefix').$this->bannerItem['url'] : '';
            $this->types = [['value'=>0,'name'=>'无导向'],['value'=>1,'name'=>'导向商品'],['value'=>2,'name'=>'导向专题']];
            return $this->fetch('banner_item_form');
        }
        elseif ($this->request->isPost())
        {
            $this->_input([
                'key_word'  => $this->request->post('key_word'),
                'type'      => $this->request->post('type'),
                'status'    => $this->request->post('status'),
                'img_url'   => $this->request->post('img_url'),
                'banner_id' => $this->request->post('banner_id'),
                'img_id'  => $this->request->post('img_id'),
                'id'  => $this->request->post('id'),
            ], [
                'key_word' => 'require',
                'type' => 'require',
                'status' => 'require',
                'img_url' => 'require',
                'banner_id' => 'require',
                'img_id' => 'require',
                'id' => 'require'
            ], [
                'key_word.require' => '关键字必须填写！',
                'type.require' => '类型必须选择！',
                'status.require' => '是否上线必须选择！',
                'img_url.require' => '图片必须上传！',
                'banner_id.require' => 'banner_id参数错误！',
                'img_id.require' => 'img_id参数错误！',
                'id.require' => 'id参数错误！'
            ]);
            $data = $this->request->post();
            if($data['type'] == 1 && !is_numeric($data['key_word'])){
                $this->error('类型导向商品,关键字必须是商品id！');
            }

            $time = time();
            $imageData['id']   = $data['img_id'];
            $imageData['url']  = substr($data['img_url'], strpos($data['img_url'],config('setting.upload_path'))+7);
            $imageData['from'] = config('setting.img_form_local');
            $imageData['update_time'] = $time;
            Db::name('image')->where('id',$imageData['id'])->update($imageData);
            unset($data['img_url']);
            $data['update_time'] = $time;
            $res = Db::name('banner_item')->where('id',$data['id'])->update($data);
            if($res){
                $this->success('保存成功！');
            }else{
                $this->error('保存失败！');
            }
        }
    }

    public function delBannerItem()
    {
        $banner_item_id = $this->request->post('banner_item_id');
        $banner_id = $this->request->post('banner_id');
        $time = time();
        $res = Db::name('banner_item')->alias('bi')
            ->join('image i','bi.img_id = i.id')
            ->where(['bi.banner_id' => $banner_id, 'bi.id' => $banner_item_id])
            ->update(['bi.delete_time'=>$time,'bi.status'=>0,'bi.update_time'=>$time,'i.delete_time'=>$time,'i.update_time'=>$time]);
        if($res){
            $this->success('移除Item成功');
        }else{
            $this->error('移除Item失败');
        }
    }
}