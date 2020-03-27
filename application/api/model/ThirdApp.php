<?php
namespace app\api\model;

class ThirdApp extends BaseModel
{
	public static function check($ac, $se)
	{
        $se = md5($se);
		$app = self::where('app_id','=',$ac)
			->where('app_secret','=',$se)
			->find();
		return $app;
	}
}