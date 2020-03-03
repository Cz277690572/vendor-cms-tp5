<?php
namespace app\api\controller\v1;

use app\api\validate\Count;

use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;
use app\api\validate\IDMustBePostiveInt;
class Product
{
	public function  getRecent($count=15){
		(new count())->goCheck();
		$products = ProductModel::getMostRecent($count);
		if($products->isEmpty()){
		    throw new ProductException();
		}
		// 返回数据对象(数据集)，临时隐藏summary
		$products = $products->hidden(['summary']);
		return $products;
	}

	public function getAllInCategory($id){
		(new IDMustBePostiveInt())->goCheck();
		$products = ProductModel::getProductsByCategoryID($id);
		if($products->isEmpty()){
			throw new ProductException();
		}
		$products = $products->hidden(['summary']);
		return $products;
	}

	public function getOne($id){
		(new IDMustBePostiveInt())->goCheck();
		$product = ProductModel::getProductDetail($id);

		if(!$product){
			throw new ProductException();
		}
		return $product;
	}
}