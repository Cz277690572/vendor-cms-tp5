<?php


namespace app\api\controller\v1;


use app\api\validate\ExpressLogisticsGet;

class Express
{
    /**
     * 获取物流运费服务信息
     * @return array
     */
    public function getServiceInfo()
    {
        $express = ['express_full_price'=>config('setting.express_full_price'),'express_price' => config('setting.express_price')];
        return $express;
    }

    /**
     * 获取物流动态信息
     * @param $code
     * @param $no
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getLogisticsInfo($code,$no)
    {
        (new ExpressLogisticsGet())->goCheck();
        $this->result = \library\tools\Express::query($code, $no);
        return $this->result;
    }
}