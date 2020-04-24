<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:09
 */

namespace app\admin\controller;

use app\api\service\Token as TokenService;
use library\Controller;
use think\App;
use think\facade\Cache;
use think\facade\Request;

class BaseController extends Controller
{
    public function __construct(App $app)
    {
        // token登录令牌校验
        $token = Request::instance()->header('token');
        $url   = Request::instance()->url();
        if($url !== '/admin.html'){ // admin.html页面不进行令牌校验
            if(!$token){
                return $this->error('无效令牌,请重新登录!', url('@admin/login'));
            }
            $valid = TokenService::verifyToken($token);
            if(!$valid){
                return $this->error('令牌已过期,请重新登录!', url('@admin/login'));
            }
        }
        parent::__construct($app);
    }
}