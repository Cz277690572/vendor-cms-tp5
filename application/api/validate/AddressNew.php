<?php
namespace app\api\validate;

class AddressNew extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'mobile' => 'require|isMobile',
		'province' => 'require|isNotEmpty',
		'city' => 'require|isNotEmpty',
		'country' => 'require|isNotEmpty',
		'detail' => 'require|isNotEmpty',
	];

    protected $message  =   [
        'name.isNotEmpty' => '收件人必须填写！',
        'mobile.isMobile' => '手机号码格式错误！',
        'province.isNotEmpty' => '省份不能为空！',
        'city.isNotEmpty'     => '市不能为空！',
        'country.isNotEmpty'  => '区不能为空！',
        'detail.isNotEmpty'  => '详情地址不能为空！',
    ];
}