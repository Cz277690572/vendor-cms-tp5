<?php


namespace app\admin\controller;


use library\tools\Data;
use think\Db;

class Product extends BaseController
{
    protected $table = 'product';
    public function index()
    {
        $this->title = '商品列表';
        $query = $this->_query($this->table)->like('name')->where(['delete_time' => null]);
        $query->dateBetween('create_time')->order('sort desc, id desc')->page();
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
        // 商品分类
        $this->cates = Db::name('category')->where(['delete_time' => null, 'status' => '1'])->order('sort asc,id desc')->select();
        foreach ($data as &$vo) {
            $vo['main_img_url'] = config('setting.img_prefix').$vo['main_img_url'];
            foreach ($this->cates as $cate){
                if ($cate['id'] === $vo['category_id']){
                    $vo['category_name'] = $cate['name'];
                }
            }
        }
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
        // 生成商品ID
        if (empty($data['id'])){
            $data['id'] = Data::uniqidNumberCode();
            $data['create_time'] = $time;
        }
        if ($this->request->isGet())
        {
            $images = Db::name('product_image')->alias('p')->join('image i','p.img_id = i.id')->field('p.*,i.url')
                ->where(['p.product_id' => $data['id'],'p.delete_time' => null])->order('p.order desc')->select();
            $data['detail_image'] = '';
            if(!empty($images)){
                foreach ($images as $img){
                    $data['detail_image'] .= config('setting.img_prefix').$img['url'].'|';
                }
                $data['detail_image'] = rtrim($data['detail_image'],'|');
            }
            $data['main_img_url'] = isset($data['main_img_url']) ? config('setting.img_prefix').$data['main_img_url'] : '';
            // 商品参数说明
            $this->properties = Db::name('product_property')->where(['delete_time' => null, 'product_id' => $data['id']])->order('id asc')->select();
            $data['product_property'] = '';
            if(!empty($this->properties))
            {
                foreach ($this->properties as $property){
                    $data['product_property'] .= $property['name'].':'.$property['detail'].';';
                }
            }
            // 商品分类
            $this->cates = Db::name('category')->where(['delete_time' => null, 'status' => '1'])->order('sort asc,id desc')->select();


        }
        elseif ($this->request->isPost())
        {

//            Array
//            (
//                [category_id] => 5
//                [name] => 商品名
//                [price] => 0.01
//                [stock] => 11
//                [status] => 1
//                [product_property] => 口味:抹茶味;保质期:18个月
//                [main_img_url] => http://vendor.cn/upload/5037bffcdf09bc7c/b5261a08189ea4be.png
//                [detail_image] => http://vendor.cn/upload/5037bffcdf09bc7c/b5261a08189ea4be.png|http://vendor.cn/upload/92e953fad71f84b6/7c463eeddd5606ee.png
//                [summary] => 描述
//                [id] => 6858331859
//            )
            // 参数校验
            $this->_input([
                'category_id'      => $this->request->post('category_id'),
                'name'             => $this->request->post('name'),
                'price'            => $this->request->post('price'),
                'stock'            => $this->request->post('stock'),
                'product_property' => $this->request->post('product_property'),
                'main_img_url'     => $this->request->post('main_img_url')
            ], [
                'category_id' => 'number',
                'name' => 'require',
                'price' => 'float|between:0.01,100000.00',
                'stock' => 'number|between:1,100000',
                'product_property' => 'require',
                'main_img_url' => 'require',
            ], [
                'category_id.number' => '商品分类必须选择！',
                'name.require' => '商品名称必须填写！',
                'price.float' => '价格值只能在0.01-100000.00之间！',
                'stock.number' => '库存值只能在1-100000之间！',
                'product_property.require' => '商品参数说明必须填写！',
                'main_img_url.require' => '商品主图必须上传！',
            ]);

            $data['update_time'] = $time;
            // 商品主图先删除后保存
            if(isset($data['img_id'])){
                Db::table('image')->where('id','=',$data['img_id'])->delete();
            }

            if(!empty($data['main_img_url'])){
                $mainImgData = array();
                $mainImgData['url']  = substr($data['main_img_url'], strpos($data['main_img_url'],'/upload')+7);
                $mainImgData['from'] = 1;
                $mainImgData['update_time'] = $time;
                $mainImgId = Db::name('image')->insertGetId($mainImgData);
                $data['main_img_url'] = $mainImgData['url'];
                $data['img_id'] = $mainImgId;
            }

            // 商品详情图片先删除后保存，硬删除不影响前端已购买的商品图片展示
            $proImglist = Db::table('product_image')->where('product_id', $data['id'])->select();
            if($proImglist){
                $delByImgIds = array_column($proImglist,'img_id');
                Db::table('image')->delete($delByImgIds);
                Db::table('product_image')->where('product_id','=',$data['id'])->delete();
                unset($delByImgIds);
                unset($proImglist);
            }
            if(!empty($data['detail_image'])) {
                $images = explode('|',$data['detail_image']);
                $productImageData = array();
                foreach ($images as $k => $img){
                    $imageData['url']         = substr($img, strpos($img,'/upload')+7);;
                    $imageData['from']        = 1;
                    $imageData['update_time'] = $time;
                    $imageId = Db::name('image')->insertGetId($imageData);

                    $productImageData[$k]['img_id']     = $imageId;
                    $productImageData[$k]['order']      = $k;
                    $productImageData[$k]['product_id'] = $data['id'];
                }
                Db::name('product_image')->insertAll($productImageData);
                unset($images);
                unset($imageData);
                unset($productImageData);
            }

            // 商品参数说明先删除后保存，硬删除不影响前端正常展示
            Db::table('product_property')->where('product_id', '=', $data['id'])->delete();
            if(!empty($data['product_property'])){
                $data['product_property'] = rtrim($data['product_property'],';');
                $properties = explode(';',$data['product_property']);
                $propertyArr = array();
                foreach ($properties as $k => $property){
                    $temp = explode(':',$property);
                    $propertyArr[$k]['name'] = $temp[0];
                    $propertyArr[$k]['detail'] = isset($temp[1]) ? $temp[1] : '';
                    $propertyArr[$k]['product_id'] = $data['id'];
                    $propertyArr[$k]['update_time'] = $time;
                }
                Db::name('product_property')->insertAll($propertyArr);
                unset($properties);
                unset($temp);
                unset($propertyArr);
            }
            unset($data['detail_image']);
            unset($data['product_property']);
        }
    }

    public function remove()
    {
        $id      = $this->request->post('id');
        $product = Db::table($this->table)->field('img_id')->where('id', $id)->find();
        $time  = time();
        Db::name('image')->where('id',$product['img_id'])->update(['delete_time' => $time]);
        Db::name('product_image')->alias('p')->join('image i','p.img_id = i.id')->where('p.product_id',$id)->update(['p.delete_time' => $time,'i.delete_time' => $time]);
        $this->_save($this->table, ['delete_time' => $time, 'status' => 0]);
    }
}