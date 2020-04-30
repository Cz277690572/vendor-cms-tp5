<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/4/29
 * Time: 19:20
 */

namespace app\lib\exception;


class SystemConfigException extends BaseException
{
    public $code = 404;
    public $msg = '请求的关于信息不存在';
    public $errorCode = 40000;
}