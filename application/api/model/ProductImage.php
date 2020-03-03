<?php
namespace app\api\model;

class ProductImage extends BaseModel
{
	// 隐藏字段
	protected $hidden = ['img_id', 'delete_time', 'product_id'];

	// 定义productimage与image的关系
	public function imgUrl()
	{
		return $this->belongsTo('Image', 'img_id', 'id');
	}
}