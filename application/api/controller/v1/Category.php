<?php
namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
class Category
{
	public function getAllCategories(){
		$categories = CategoryModel::all(['delete_time'=>null,'status'=>1],'img');
		if($categories->isEmpty()){
			throw new CategoryException();
		}
		return $categories;
	}
}