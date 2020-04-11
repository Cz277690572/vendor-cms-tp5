<?php
namespace app\api\service;

use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use app\lib\enum\OrderStatusEnum; 
use think\Exception;
use think\facade\Env;
use think\facade\Log;

require_once (Env::get('root_path').'extend/WxPay/WxPayData.php');
class Pay
{
	private $orderID;
	private $orderNO;

	function __construct($orderID)
	{
		if (!$orderID)
		{
			throw new Exception("订单ID不能为空");
		}
		$this->orderID = $orderID;
	}

	// 支付的主方法
	public function pay()
	{
		//订单号可能根本就不存在
		//订单号确实是存在的，但是，订单号和当前用户是不匹配的
		//订单有可能已经被支付过了
		//进行库存量检测
		$this->checkOrderValid();
		$orderService = new OrderService();
		$status = $orderService->checkOrderStock($this->orderID);
		if (!$status['pass'])
		{
			return $status;
		}
		return $this->makeWxPreOrder($status['orderPrice']);
	}

	private function makeWxPreOrder($totalPrice)
	{
		// openid
		$openid = Token::getCurrentTokenVar('openid');
		if (!$openid) 
		{
			throw new TokenException();
		}
		$wxOrderData = new \WxPay\WxPayUnifiedOrder();
		$wxOrderData->SetOut_trade_no($this->orderNO);
		$wxOrderData->SetTrade_type('JASPI');
		$wxOrderData->SetTotal_fee($totalPrice*100);
		$wxOrderData->SetBody('李白的酒');
		$wxOrderData->SetOpenid($openid);
		$wxOrderData->SetNotify_url(config('secure.pay_back_url'));

		return $this->getPaySignature($wxOrderData);
	}

	// 发起微信预订单,获取微信服务器返回的参数
	private function getPaySignature($wxOrderData)
	{
		$wxOrder = \WxPay\WxPayApi::unifiedOrder($wxOrderData);
		if ($wxOrder['return_code'] != 'SUCCESS' ||
			$wxOrder['result_code'] != 'SUCCESS') 
		{
			Log::record($wxOrder,'error');
			Log::record('获取预支付订单失败','error');
			throw new OrderException([
				'msg' => "获取预支付订单失败",
				'code' => 200
			]);
		}

		//prepay_id 向用户推送微信模板消息时需用到
		$this->recordPreOrder($wxOrder);
		$signature = $this->sign($wxOrder);
		return $signature;
	}

	// 生成签名
	private function sign($wxOrder)
	{
		$jsApiPayData = new \WxPay\WxPayJsApiPay();
		$jsApiPayData->SetAppid(config('wx.app_id'));
		$jsApiPayData->SetTimeStamp((string)time());

		$rand = md5(time() . mt_rand(0,1000));
		$jsApiPayData->SetNonceStr($rand);

		$jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
		$jsApiPayData->SetSignType('md5');

		$sign = $jsApiPayData->MakeSign();
		$rawValues = $jsApiPayData->GetValues();
		$rawValues['paySign'] = $sign;

		unset($rawValues['appId']);
		return $rawValues;

	}

	private function recordPreOrder($wxOrder)
	{
		OrderModel::where('id','=',$this->orderID)
			->update(['prepay_id'=>$wxOrder['prepay_id']]);
	}

	private function checkOrderValid()
	{
		$order = OrderModel::where('id','=',$this->orderID)
			->find();
		if (!$order) 
		{
			throw new OrderException();
		}
		if (!Token::isValidOperate($order->user_id)) 
		{
			throw new TokenException([
				'msg' => '订单与用户不匹配',
				'errorCode' => 10003
			]);
		}
		if ($order->status != OrderStatusEnum::UNPAID) {
			throw new OrderException([
				'msg' => '订单已经支付过了',
				'errorCode' => 80003,
				'code' => 400
			]);
		}
		$this->orderNO = $order->order_no;
		return true;
	}
}