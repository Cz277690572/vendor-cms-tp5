<?php
namespace app\api\model;

class User extends BaseModel
{

	public function address()
	{
		return $this->hasOne('UserAddress','user_id','id');
	}

	// public static function get($id)
	// {
	// 	$user = self::where('id','=',$id)
	// 		->get();
	// 	return $user;
	// }

	public static function getByOpenID($openid){
		$user = self::where('openid','=',$openid)
			->find();
		return $user;
	}
}