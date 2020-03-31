<?php


namespace app\admin\controller;


use app\admin\controller\api\Plugs;
use library\tools\Data;
use think\Db;

class Category extends BaseController
{

    protected $table = 'category';

    public function index()
    {
        $this->title = '分类列表';
        $query = $this->_query($this->table)->like('name,update_time')->where(['delete_time' => null]);
        $query->dateBetween('update_time')->order('sort desc, id desc')->page();
    }

    public function edit()
    {
        $this->isAddMode = '0';
        $this->_form($this->table, 'form');
    }

    public function add()
    {
        $this->isAddMode = '1';
        $this->_form($this->table, 'form');
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
        $imgIds = join(',',array_column($data,'topic_img_id'));
        $this->imglist = Db::name('image')->where('id','in',"$imgIds")->select();
        foreach ($data as &$vo) {
            foreach ($this->imglist as $img){
                if ($img['id'] === $vo['topic_img_id']){
                    $vo['topic_img_url'] = config('setting.img_prefix').$img['url'];
                }
            }
        }
    }

    /**
     * 表单数据处理
     * 文件保存地址为本地目录/upload
     * @param array $data
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _form_filter(&$data)
    {
        if($this->request->isGet() && !$this->isAddMode){
            $row = Db::name('image')->where(['id'=>$data['topic_img_id']])->find();
            $data['topic_img_url'] = isset($row['url']) ? config('setting.img_prefix').$row['url'] : null;
        }elseif ($this->request->isPost()){
            $this->_input([
                'topic_img_url'    => $this->request->post('topic_img_url'),
                'sort'           => $this->request->post('sort')
            ], [
                'topic_img_url' => 'require',
                'sort' => 'number',
            ], [
                'topic_img_url.require' => '分类图片必须上传！',
                'sort.number' => '排序值必须是数字！',
            ]);

            $data['update_time'] = time();
            if($this->isAddMode){
                $imageData['url']  = substr($data['topic_img_url'], strpos($data['topic_img_url'],'/upload')+7);
                $imageData['from'] = 1;
                $imageData['update_time'] = time();
                $imageId = Db::name('image')->insertGetId($imageData);
                $data['topic_img_id'] = $imageId;
                unset($data['topic_img_url']);
            }else{
                $imageData['id']   = $data['topic_img_id'];
                $imageData['url']  = substr($data['topic_img_url'], strpos($data['topic_img_url'],'/upload')+7);
                $imageData['from'] = 1;
                $imageData['update_time'] = time();
                Db::name('image')->where('id',$imageData['id'])->update($imageData);
                unset($data['topic_img_url']);
            }
        }
    }

    public function remove()
    {
        $this->_save($this->table, ['delete_time' => time()]);
    }
}