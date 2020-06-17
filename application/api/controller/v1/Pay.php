<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;
use app\api\service\WxNotify;
use think\facade\Env;
use think\facade\Log;
require_once(Env::get('root_path').'extend/WxPay/WxPayConfig.php');
class Pay extends BaseController
{
	// 只能由基本用户访问的权限
	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'getPreOrder']
	];

	public function getPreOrder($id='')
	{
		(new IDMustBePostiveInt())->goCheck();
		$pay = new PayService($id);
		return $pay->pay();
	}

	// 接受微信回调通知
	public function receiveNotify()
	{
		//通知频率为15/15/30/180/1800/1800/1800/1800/3600 单位秒
		//1. 检查库存量， 超卖
		//2. 更新这个订单的status状态
		//3. 减库存
		// 如果成功处理，我们返回微信成功处理的信息。否则，我们需要返回没有成功处理
		// 特点：post：xml格式：不会携带参数
        $wxData = file_get_contents("php://input");
        Log::record('微信支付回调参数POST'.json_encode($wxData),'wxpay');
//        Log::record('微信支付回调参数HTTP_RAW_POST_DATA:xml'.json_encode($GLOBALS['HTTP_RAW_POST_DATA']),'wxpay');
		try{
            $notify = new WxNotify();
            $config = new \WxPay\WxPayConfig();
            $notify->Handle($config, false);
		}catch(Exception $e){
            Log::record('微信支付回调响应异常'.$e->getMessage(),'wxpay');
		}
	}
}
