<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:05
 */

namespace app\admin\controller;

use library\Controller;
use think\Db;
use think\facade\Request;

/**
 * 用户登录管理
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    public function index()
    {
        $siteData   = Db::name('system_config')->where('type','in','1,2,3,5,74')->select();
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
                    $siteIcon = !empty($v['value']) ? config('setting.img_prefix').$v['value'] : '';
                    break;
                case 'site_logo':
                    $siteLogo = !empty($v['value']) ? config('setting.img_prefix').$v['value'] : '';
                    break;
                default:
                    continue;
                    break;
            }
        }
        return $this->fetch('index',['title'=>$siteName,'appName'=>$appName,'appVersion'=>$appVersion,'siteIcon'=>$siteIcon,'siteLogo'=>$siteLogo]);
    }

    /**
     * 登出
     */
    public function out()
    {
        $token = Request::instance()
            ->header('token');
        cache($token,null);
        $this->success('退出登录成功!', url('@admin/login'));
    }
}