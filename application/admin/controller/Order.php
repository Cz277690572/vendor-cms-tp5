<?php


namespace app\admin\controller;

use app\lib\enum\OrderStatusEnum;
use think\Db;

class Order extends BaseController
{
    protected $table = 'order';
    public function index()
    {
        $this->title = '订单列表';
        $query = $this->_query($this->table)->like('order_no,user_id');
        $query->timeBetween('create_time,update_time')
            ->where('delete_time', null)
            ->order('id desc')->page();
    }

    public function edit() {
        $this->title = '订单详情';
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
        if ($this->request->isGet())
        {
            $this->orderStatus = [
                ['value'=>1,'name'=>'未支付'],
                ['value'=>2,'name'=>'已支付,待发货'],
                ['value'=>3,'name'=>'已发货'],
                ['value'=>4,'name'=>'已支付,但库存不足']
            ];
            $data['snap_address'] = json_decode($data['snap_address'], true);
            $data['snap_items_list'] = json_decode($data['snap_items'], true);
        }
    }

    public function remove()
    {
        // 只有无效订单可以删除
        $time  = time();
        $id    = $this->request->post('id');
        Db::name('order_product')->where('order_id', $id)->update(['delete_time' => $time]);
        $this->_save($this->table, ['delete_time' => $time]);
    }

    //发货
    public function delivery()
    {
        $this->_form($this->table);
    }

    /**
     * 发货快递表单处理
     */
    protected function _delivery_form_filter(&$vo)
    {
        $time = time();
        if ($this->request->isGet())
        {
            $where = ['delete_time' => null, 'status' => '1'];
            $this->expressList = Db::name('express_company')->where($where)->order('sort asc,id desc')->select();
        }
        elseif($this->request->isPost()) {
            if(empty($vo)){
                $this->error('订单不存在，请检查ID');
            }

            if($vo['status'] != OrderStatusEnum::PAID && $vo['status'] != OrderStatusEnum::PAID_BUT_OUT_OF) {
                $this->error('还没付款呢，想干嘛？ 或者你已经更新过订单了，不要再刷了');
            }

            $this->_input([
                'snap_address_name'       => $this->request->post('snap_address_name'),
                'snap_address_mobile'     => $this->request->post('snap_address_mobile'),
                'form_province'           => $this->request->post('form_province'),
                'form_city'               => $this->request->post('form_city'),
                'form_country'            => $this->request->post('form_country'),
                'snap_address_detail'     => $this->request->post('snap_address_detail')
            ], [
                'snap_address_name' => 'require',
                'snap_address_mobile' => 'require',
                'form_province' => 'require',
                'form_city' => 'require',
                'form_country' => 'require',
                'snap_address_detail' => 'require',
            ], [
                'snap_address_name.require' => '收货姓名不能为空！',
                'snap_address_mobile.require' => '收货手机不能为空！',
                'form_province.require' => '收货省份不能为空！',
                'form_city.require' => '收货城市不能为空！',
                'form_country.require' => '收货城区不能为空！',
                'snap_address_detail.require' => '详细地址不能为空！',
            ]);

            $data = $this->request->post();
            $snap_address['name']     = $data['snap_address_name'];
            $snap_address['mobile']   = $data['snap_address_mobile'];
            $snap_address['province'] = $data['form_province'];
            $snap_address['city']     = $data['form_city'];
            $snap_address['country']  = $data['form_country'];
            $snap_address['detail']   = $data['snap_address_detail'];
            $snap_address['update_time'] = $time;

            $order['snap_address'] = json_encode($snap_address);
            $order['status']       = OrderStatusEnum::DELIVERED;
            $order['express_company_code']  = !empty($data['express_company_code']) ? $data['express_company_code'] : null;
            $order['express_company_title'] = !empty($data['express_company_title']) ? $data['express_company_title'] : null;
            $order['express_send_no']   = !empty($data['express_send_no']) ? $data['express_send_no'] : null;
            $order['express_send_time'] = $time;
            $order['update_time']       = $time;
            $res = Db::name('order')->update($order);
            if($res){
                // 发送小程序模板消息通知
                $this->success('发货成功！');
            }else{
                $this->error('发货失败！');
            }
        }
    }
}