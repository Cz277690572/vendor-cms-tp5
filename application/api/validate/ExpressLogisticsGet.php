<?php


namespace app\api\validate;


class ExpressLogisticsGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty',
        'no' => 'require|isNotEmpty'
    ];
}