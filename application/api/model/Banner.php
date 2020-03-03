<?php
/**
 * @author anson
 */
namespace app\api\model;

use think\Db;
use think\Exception;
class Banner extends BaseModel
{
	protected $hidden = ['delete_time','update_time'];

	public function items(){
		return $this->hasMany('BannerItem','banner_id','id');
	}

	public static function getBannerByID($id){
		$banner = self::with(['items','items.img'])
			->find($id);
		return $banner;
		// sql语句写法
		// $result = Db::query('select * from banner_item where img_id=?',[1]);
		// 表达式写法
		// $result = Db::table('banner_item')->where('banner_id','=',$id)->select();
		// 闭包写法
		// $result = Db::table('banner_item')->where(function ($query) use ($id){
		// 	$query->where('banner_id','=',$id);
		// })
		// ->select();
		// return $result;
	} 
}