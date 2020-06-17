<?php
namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;

use think\Db;
use think\Exception;
use think\facade\Env;
use think\facade\Log;
require_once(Env::get('root_path').'extend/WxPay/WxPayNotify.php');
class WxNotify extends \WxPay\WxPayNotify
{
//	public function NotifyProcess($data, &$msg)
	public function NotifyProcess($dataObj, $config, &$msg)
	{
        $data = $dataObj->GetValues();
        Log::record(date('Y-m-d H:i:s').'微信支付回调处理过程data'.json_encode($data),'wxpay');
		if ($data['result_code'] == 'SUCCESS')
		{
			$orderNo = $data['out_trade_no'];
			Db::startTrans();
			try
			{
				$order = OrderModel::where('order_no','=',$orderNo)
					->find();
				if ($order->status == 1)
				{
					$service = new OrderService();
					$stockStatus = $service->checkOrderStock($order->id);
					// 已支付，库存足
					if ($stockStatus['pass']) 
					{
						$this->updateOrderStatus($order->id, true);
						$this->reduceStock($stockStatus);
					}
					// 已支付，库存不足
					else
					{
						$this->updateOrderStatus($order->id, false);
					}
				}else{
                    Log::record(date('Y-m-d H:i:s').'已支付,但是订单状态不是未支付状态','wxpay');
                }
				Db::commit();
				return true;
			}
			catch (Exception $ex)
			{
				Db::rollback();
                Log::record(date('Y-m-d H:i:s').'微信支付回调处理过程order处理异常','wxpay');
				return false;
			}
		}
		else
		{
			return true;
		}
	}

	private function reduceStock($stockStatus)
	{
		foreach ($stockStatus['pStatusArray'] as $singlePStatus) 
		{
			Product::where('id','=',$singlePStatus['id'])
				->setDec('stock',$singlePStatus['counts']);
		}
	}

	private function updateOrderStatus($orderID, $success)
	{
		$status = $success?
			OrderStatusEnum::PAID :
			OrderStatusEnum::PAID_BUT_OUT_OF;
		OrderModel::where('id','=',$orderID)
			->update(['status' => $status]);
	}
}