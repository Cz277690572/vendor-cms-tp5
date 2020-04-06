<?php


namespace app\admin\controller;

use think\Db;

class Order extends BaseController
{
    protected $table = 'order';
    public function index()
    {
        $query = $this->_query($this->table)->like('order_no,user_id');
        $query->dateBetween('create_time,update_time')->where('delete_time', null)->order('id desc')->page();
    }

    public function detail() {
        $id = $this->request->request('id');
        $this->_query('order_product')->where('order_id', $id)->order('product_id desc')->page();
    }

    public function edit() {
        $id = $this->request->request('id');
        if ($this->request->isGet()){
            $this->info = Db::name($this->table)->field('id,status')->where('id', $id)->find();
            $this->status = [1 => '未支付', '已支付', '已发货', '已支付,库存不足'];
        } else {
            $status = $this->request->request('status');
            Db::name($this->table)->where('id', $id)->update(['status' => $status]);
        }
        return $this->_form($this->table, 'form');
    }

    public function remove()
    {
        $time  = time();
        $id    = $this->request->post('id');
        Db::name('order_product')->where('order_id', $id)->update(['delete_time' => $time]);
        $this->_save($this->table, ['delete_time' => $time]);
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _index_page_filter(&$data)
    {
        foreach ($data as &$v) {
            switch ($v['status']) {
                case '1':
                    $v['status'] = '未支付';
                    break;
                case '2':
                    $v['status'] = '已支付';
                    break;
                case '3':
                    $v['status'] = '已发货';
                    break;
                case '4':
                    $v['status'] = '已支付,库存不足';
                    break;
            }
        }
    }
}