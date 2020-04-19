<?php
namespace app\api\service;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\api\model\OrderProduct;
use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\api\service\DeliveryMessage;
use app\lib\exception\UserException;
use think\exception;
use think\Db;
class Order
{
	// 订单的商品列表，也就是客户端传递过来的products参数
	protected $oProducts;

	// 真实的商品信息（包括库存量）
	protected $products;

	protected $uid;

	public function place($uid, $oProducts)
	{
		// oProducts和products 作对比
		// products从数据库中查询出来
		$this->oProducts = $oProducts;
		$this->products = $this->getProductsByOrder($oProducts);
		$this->uid = $uid;
		$status = $this->getOrderStatus();
		if (!$status['pass'])
		{
			$status['order_id'] = -1;
			return $status;
		}
		// 开始创建订单
		$orderSnap = $this->snapOrder($status);
		$order = $this->createOrder($orderSnap);
		$order['pass'] = true;
		return $order;
	}

	private function createOrder($snap)
	{
		Db::startTrans();
		try{

			$orderNo = $this->makeOrderNo();
			$order = new \app\api\model\Order();
			$order->user_id = $this->uid;
			$order->order_no = $orderNo;
			$order->total_price = $snap['orderPrice'];
			$order->express_price = $snap['expressPrice'];
			$order->pay_price = $snap['payPrice'];
			$order->total_count = $snap['totalCount'];
			$order->snap_img = $snap['snapImg'];
			$order->snap_name = $snap['snapName'];
			$order->snap_address = $snap['snapAddress'];
			$order->snap_items = json_encode($snap['pStatus']); 

			$order->save();
			$orderId = $order->id;
			$create_time = $order->create_time;

			foreach ($this->oProducts as &$p) {
				$p['order_id'] = $orderId;
			}
			$orderProduct = new orderProduct();
			$orderProduct->saveAll($this->oProducts);
			Db::commit();
			return [
				'order_no' => $orderNo,
				'order_id' => $orderId,
				'create_time' => $create_time
			];
		}catch(exception $e){
			Db::rollback();
			throw $e;
		}
	}

	// 制作订单编号
	public static function makeOrderNo()
	{
		$yCode = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','U','V');
		$OrderSn = 
			$yCode[intval(date('Y')) - 2017]. strtoupper(dechex(date('m'))) . date('d') .
					substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
		return $OrderSn;
	}

	private function snapOrder($status)
	{
		$snap = [
			'orderPrice' => 0,
			'totalCount' => 0,
			'pStatus' => [],
			'snapAddress' => null,
			'snapName' => '',
			'snapImg' => ''
		];

        $snap['expressPrice'] = config('setting.express_full_price') - $status['orderPrice'] > 0 ? config('setting.express_price') : 0;
        $snap['payPrice']     = $status['orderPrice'] + $snap['expressPrice'];
		$snap['orderPrice']  = $status['orderPrice'];
		$snap['totalCount']  = $status['totalCount'];
		$snap['pStatus']     = $status['pStatusArray'];
		$snap['snapAddress'] = json_encode($this->getUserAddress());
		$snap['snapName']    = $this->products[0]['name'];
		$snap['snapImg']     = $this->products[0]['main_img_url'];

		if (count($this->products) > 1) {
			$snap['snapName'] .= '等';
		}
		return $snap;
	}

	private function getUserAddress()
	{
		$userAddress = UserAddress::where('user_id','=',$this->uid)
			->find();
		if (!$userAddress) {
			throw new UserException([
				'msg' => '用户收货地址不存在，下单失败',
				'errorCode' => 60001,
			]);
		}
		return $userAddress;
	}

	public function checkOrderStock($orderID)
	{
		$oProducts = OrderProduct::where('order_id','=',$orderID)
			->select();
		$this->oProducts = $oProducts;

		$this->products = $this->getProductsByOrder($oProducts);
		$status = $this->getOrderStatus();
		return $status;
	}

	private function getOrderStatus()
	{
		$status = [
			'pass' => true,
			'orderPrice' => 0,
            'expressPrice' => 0,
            'payPrice' => 0,
			'totalCount' => 0,
			'pStatusArray' => []
		];

		foreach ($this->oProducts as $oProduct) {
			$pStatus = $this->getProductStatus(
				$oProduct['product_id'],$oProduct['count'],$this->products
			);
			if (!$pStatus['haveStock'])
			{
				$status['pass'] = false;
			}
			$status['orderPrice'] += $pStatus['totalPrice'];
			$status['totalCount'] += $pStatus['counts'];
			array_push($status['pStatusArray'], $pStatus);
		}
        $status['expressPrice'] = config('setting.express_full_price') - $status['orderPrice'] > 0 ? config('setting.express_price') : 0;
        $status['payPrice']     = $status['orderPrice'] + $status['expressPrice'];
		return $status;
	}

	private function getProductStatus($oPID, $oCount, $products)
	{
		$pIndex   = -1;
        $isDelete = true;
        $isStatus = false;
		$pStatus = [
			'id' => null,
			'haveStock' => false,
			'counts' => 0,
			'price' => 0,
			'name' => '',
			'totalPrice' => 0,
			'main_img_url' => null,
            'delete_time' => null,
            'status' => 0
		];

		for ($i=0; $i < count($products); $i++) 
		{
		    // 判断商品是否存在
			if($oPID == $products[$i]['id'])
			{
                $pIndex = $i;
                // 判断商品是否被删除
                if(is_null($products[$i]['delete_time'])){
                    $isDelete = false;
                }
			    // 判断商品是否下架
                if($products[$i]['status'] == 1){
                    $isStatus = true;
                }
			}
		}

		if($pIndex == -1)
		{
			// 客户端传递的product_id有可能根本不存在
			throw new OrderException([
				'msg' => 'id为'.$oPID.'的商品不存在！'
			]);
		}
		elseif ($isDelete === true || $isStatus === false)
        {
            // 客户端传递的product_id有可能已经删除或者下架
            throw new OrderException([
                'msg' => '商品名为'.$products[$pIndex]['name'].'的商品已下架！'
            ]);
        }
		else
		{
			$product = $products[$pIndex];
			$pStatus['id'] = $product['id'];
			$pStatus['name'] = $product['name'];
			$pStatus['counts'] = $oCount;
			$pStatus['price'] = $product['price'];
			$pStatus['main_img_url'] = $product['main_img_url'];
			$pStatus['totalPrice']  = $product['price'] * $oCount;
            $pStatus['delete_time'] = $product['delete_time'];
			$pStatus['status'] = $product['status'];
			if ($product['stock'] - $oCount >= 0)
			{
				$pStatus['haveStock'] = true;
			}
		}
		return $pStatus;
	}

	// 根据订单商品信息查找真实的商品信息
	private function getProductsByOrder($oProducts)
	{
		$oPIDs = [];
		foreach ($oProducts as $item) {
			array_push($oPIDs, $item['product_id']);
		}
		$products = Product::all($oPIDs)
			->visible(['id', 'price', 'stock', 'name', 'main_img_url','status','delete_time'])
			->toArray();
		return $products;
	}

	public function delivery($orderID, $jumpPage='')
	{
		$order = OrderModel::where('id', '=', $orderID)
			->find();
		if(!$order) {
			throw new OrderException();
		}
		if($order->status != OrderStatusEnum::PAID) {
			throw new OrderException([
				'msg' => '还没付款呢，想干嘛？ 或者你已经更新过订单了，不要再刷了',
				'errorCode' => 80002,
				'code' => 403	
			]);
		}

		$order->status = OrderStatusEnum::DELIVERED;
		$order->save();
		$message = new DeliveryMessage();
		return $message->sendDeliveryMessage($order, $jumpPage);
	}
}