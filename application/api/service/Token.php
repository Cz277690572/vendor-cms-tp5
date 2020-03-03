<?php
namespace app\api\service;

use think\facade\Cache;
use think\facade\Request;
use think\Exception;
use app\lib\exception\ForbiddenException;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
class Token
{
	public static function generateToken()
	{
		// 32个字符组成一组随机字符串
		$randChars = getRandChar(32);
		// 用三组字符串，进行MD5加密
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		// salt 盐
		$salt = config('secure.token_salt');

		return md5($randChars.$timestamp.$salt);

	}

    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

	public static function getCurrentTokenVar($key)
	{
		$token = Request::instance()
			->header('token');
		$vars = Cache::get($token);
		if(!$vars){
			throw new TokenException();
		}
		else{
			if(!is_array($vars))
			{
				$vars = json_decode($vars, true);
			}
			if (array_key_exists($key, $vars)) {
				return $vars[$key];
			}
			else{
				throw new Exception('尝试获取的Token变量不存在!');
			}
		}
	}

	public static function getCurrentUid()
	{
		// token
		$uid = self::getCurrentTokenVar('uid');
		return $uid;
	}

	// 需要管理员权限
	public static function needPrimaryScope()
	{
		$scope = self::getCurrentTokenVar('scope');
		if ($scope)
		{
			if ($scope >= ScopeEnum::User)
			{
				return true;
			}
			else
			{
				throw new ForbiddenException();
			}
		}
		else
		{
			throw new TokenException();
		}
	}

	// 只有普通用户才能访问的接口权限
	public static function needExclusiveScope()
	{
		$scope = self::getCurrentTokenVar('scope');
		if ($scope)
		{
            if ($scope == ScopeEnum::User)
            {
                return true;
            }
            else
            {
                throw new ForbiddenException();
            }
		}
		else
		{
			throw new TokenException();
		}
	}

	public static function isValidOperate($checkedID)
	{
		if (!$checkedID) {
			throw new Exception('检查UID时必须传入一个被检查的UID');
		}
		$currentOperateUID = self::getCurrentUid();
		if ($currentOperateUID == $checkedID) {
			return true;
		}
		return false;
	}

	public static function verifyToken($token)
	{
		$exist = Cache::get($token);
		if($exist){
			return true;
		}
		else{
			return false;
		}
	}

}