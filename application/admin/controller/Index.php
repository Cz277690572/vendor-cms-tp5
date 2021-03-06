<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:44
 */

namespace app\admin\controller;


use app\api\service\Token as TokenService;
use library\tools\Data;
use think\Db;

class Index extends BaseController
{
    public function index(){
        $siteData   = Db::name('system_config')->where('type','in','1,2,3,5')->select();
        foreach ($siteData as $k => $v){
            switch ($v['name']){
                case 'site_name':
                    $siteName = $v['value'];
                    break;
                case 'app_name':
                    $appName = $v['value'];
                    break;
                case 'app_version':
                    $appVersion = $v['value'];
                    break;
                case 'site_icon':
                    $siteIcon = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                    break;
                default:
                    break;
            }
        }
        $this->fetch('index',['title'=>$siteName,'appName'=>$appName,'appVersion'=>$appVersion,'siteIcon'=>$siteIcon,'username'=>'管理员']);
    }

    public function home(){
        //商品总量
        //用户总量
        //已付款订单总数量
        //已付款,待发货订单总数量
        $productTotal       = Db::name('product')->where(['delete_time' => null])->count();
        $userTotal          = Db::name('user')->where(['delete_time' => null])->count();
        $paidOrderTotal     = Db::name('order')->where('status','in','2,3,4,5')->count();
        $deliveryOrderTotal = Db::name('order')->where('status','in','2,4')->count();
        $data['product_total']        = $productTotal;
        $data['user_total']           = $userTotal;
        $data['paid_order_total']     = $paidOrderTotal;
        $data['delivery_order_total'] = $deliveryOrderTotal;

        //月销售总额,昨日销售额(不含运费)
        //月支付订单总数,昨日支付订单数
        //月新增用户总数,昨日新增用户数
        //月下单用户数,昨日下单用户数
        $month          = date('m',time());
        $monthStartTime = strtotime(date('Y-m-01 00:00:00',time()));
        $monthEndTime   = strtotime(date('Y-m-t 23:59:59', time()));
        $ydayStartTime  = strtotime(date('Y-m-d 00:00:00',strtotime('-1 day')));
        $ydayEndTime    = strtotime(date('Y-m-d 23:59:59',strtotime('-1 day')));
        $monthSalesVolumeTotal = Db::name('order')->whereBetween('create_time',"{$monthStartTime},{$monthEndTime}")
            ->where(['delete_time' => null])->where('status','in','2,3,4,5')->sum('pay_price');
        $ydaySalesVolumeTotal = Db::name('order')->whereBetween('create_time',"{$ydayStartTime},{$ydayEndTime}")
            ->where(['delete_time' => null])->where('status','in','2,3,4,5')->sum('pay_price');

        $monthPaidOrderTotal   = Db::name('order')->whereBetween('create_time',"{$monthStartTime},{$monthEndTime}")
            ->where(['delete_time' => null])->where('status','in','2,3,4,5')->count();
        $ydayPaidOrderTotal   = Db::name('order')->whereBetween('create_time',"{$ydayStartTime},{$ydayEndTime}")
            ->where(['delete_time' => null])->where('status','in','2,3,4,5')->count();

        $monthNewUserTotal    = Db::name('user')->whereBetween('create_time',"{$monthStartTime},{$monthEndTime}")
            ->where(['delete_time' => null])->count();
        $ydayNewUserTotal     = Db::name('user')->whereBetween('create_time',"{$ydayStartTime},{$ydayEndTime}")
            ->where(['delete_time' => null])->count();

        $monthPaidUserTotal   = Db::name('order')->whereBetween('create_time',"{$monthStartTime},{$monthEndTime}")
            ->where(['delete_time' => null])->group('user_id')->count();
        $ydayPaidUserTotal    = Db::name('order')->whereBetween('create_time',"{$ydayStartTime},{$ydayEndTime}")
            ->where(['delete_time' => null])->group('user_id')->count();

        $data['month'] = $month;
        $data['month_sales_volume_total'] = number_format($monthSalesVolumeTotal,2);
        $data['yday_sales_volume_total']  = number_format($ydaySalesVolumeTotal,2);
        $data['month_paid_order_total']   = $monthPaidOrderTotal;
        $data['yday_paid_order_total']    = $ydayPaidOrderTotal;
        $data['month_new_user_total']     = $monthNewUserTotal;
        $data['yday_new_user_total']      = $ydayNewUserTotal;
        $data['month_paid_user_total']    = $monthPaidUserTotal;
        $data['yday_paid_user_total']     = $ydayPaidUserTotal;

        return $this->fetch('home',['title'=>'后台首页','data'=>$data]);
    }

    /**
     * 修改密码
     */
    public function pass()
    {
        $id = TokenService::getCurrentUid();
        if ($this->request->isGet()) {
            $this->verify = true;
            $this->_form('third_app', 'admin@third_app/pass', 'id', [], ['id' => $id]);
        } else {
            $data = $this->_input([
                'app_secret'    => $this->request->post('app_secret'),
                're_app_secret'  => $this->request->post('re_app_secret'),
                'old_app_secret' => $this->request->post('old_app_secret'),
            ], [
                'old_app_secret' => 'require',
                'app_secret'    => 'require|min:4',
                're_app_secret'  => 'require|confirm:app_secret',
            ], [
                'old_app_secret.require' => '旧密码不能为空！',
                'app_secret.require'    => '登录密码不能为空！',
                'app_secret.min'        => '登录密码长度不能少于4位有效字符！',
                're_app_secret.require'  => '重复密码不能为空！',
                're_app_secret.confirm'  => '重复密码与新的登录密码不匹配，请重新输入！',
            ]);
            $thirdApp = Db::name('third_app')->where(['id' => $id])->find();
            if (md5($data['old_app_secret']) !== $thirdApp['app_secret']) {
                $this->error('旧密码验证失败，请重新输入！');
            }

            if (Data::save('third_app', ['id' => $thirdApp['id'], 'app_secret' => md5($data['app_secret'])])) {
                $this->success('密码修改成功，下次请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }
}