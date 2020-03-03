<?php
namespace app\api\validate;

class TokenGet extends BaseValidate
{
	protected $rule = [
		'code'=> 'require|isNotempty'
	];

	protected $message = [
		'code'=> '必须传入code,才能获取Token！'
	];
}