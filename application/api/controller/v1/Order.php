<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
class Order extends BaseController
{
	// 用户在选择商品后，向api提交包含它所选择商品的相关信息
	// 1.1api在接收到信息后，需要检查订单相关商品的库存量
	// 1.2有库存，把订单数据存入数据库中=下单成功，返回客户端信息，告诉客户端可以支付
	// 2.调用我们的支付接口，进行支付
	// 2.1还需要再次进行库存量检测
	// 2.2服务器这边就可以调用微信的支付接口进行支付
	// 2.3微信会返回给我们一个支付的结果（异步）
	// 2.4成功：也需要进行库存量的检查
	// 2.5成功：进行库存量的扣除

	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'placeOrder'],
		'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
        'checkSuperScope' => ['only' => 'delivery,getSummary']
	];

	public function getSummaryByUser($page=1, $size=10)
	{
		(new PagingParameter())->goCheck();
		$uid = TokenService::getCurrentUid();
		$pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
		if ($pagingOrders->isEmpty()) 
		{
			return [
				'data' => [],
				'current_page' => $pagingOrders->getCurrentPage()
			];
		}
		$data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
		return [
			'data' => $data,
			'current_page' => $pagingOrders->getCurrentPage()
		];
	}

	public function getDetail($id)
	{
		(new IDMustBePostiveInt())->goCheck();
		$orderDetail = OrderModel::get($id);
		if (!$orderDetail) 
		{
			throw new OrderException();
		}
        $orderDetail['express_send_time'] = date('Y-m-d H:i:s',$orderDetail['express_send_time']);
		return $orderDetail
			->hidden(['prepay_id']);
	}

	public function placeOrder()
	{
		(new OrderPlace())->gocheck();
		$oProducts = input('post.products/a');
		$uid = TokenService::getCurrentUid();
		$order = new OrderService();
		$status = $order->place($uid, $oProducts);
		return $status;
	}

	/**
	 * 获取全部订单简要信息 (分页)
	 * @param int $page
	 * @param int size
	 * @return array
	 * @throws \app\lib\exception\ParameterException
	 */
	public function getSummary($page=1, $size=20){
		(new PagingParameter())->goCheck();
		$pagingOrders = OrderModel::getSummaryByPage($page, $size);
		if($pagingOrders->isEmpty())
		{
			return [
				'current_type' => $pagingOrders->currentPage(),
				'data' => []
			];
		}
		$data = $pagingOrders->hidden(['snap_items', 'snap_address'])
			->toArray();
		return [
			'current_page' => $pagingOrders->currentPage(),
			'data' => $data
		];
	}

	public function delivery($id='')
	{
		(new IDMustBePostiveInt())->goCheck();
		$order = new OrderService();
		$success = $order->delivery($id);
		if($success){
			return new SuccessMessage();
		}
	}

    /**
     * 定时签收订单
     * 凌晨1点时, 将已发货七天未签收的订单更新为已完成
     */
    public function complete()
    {
        $sTime = strtotime(date('Y-m-d 00:00:00', time() - 8*24*60*60));
        $eTime = strtotime(date('Y-m-d 00:00:00', time() - 7*24*60*60));
        OrderModel::where('express_send_time','<', $eTime)
            ->where('express_send_time','>=',$sTime)
            ->where('status','=',3)
            ->update(['status' => 5]);
    }

    /**
     * 定时关闭订单
     * 凌晨1点时, 将昨天未支付的订单更新为已取消
     */
    public function close()
    {
        $sTime = strtotime(date('Y-m-d 00:00:00', time() - 24*60*60));
        $eTime = strtotime(date('Y-m-d 23:59:59', time() - 24*60*60));
        OrderModel::where('create_time','<', $eTime)
            ->where('create_time','>=',$sTime)
            ->where('status','=',1)
            ->update(['status' => 6]);
    }

}