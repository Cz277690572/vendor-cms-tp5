<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/4/30
 * Time: 15:13
 */

namespace app\api\validate;


class AboutUsGet extends BaseValidate
{
    protected $rule = [
        'type' => 'require|isNotEmpty'
    ];
}