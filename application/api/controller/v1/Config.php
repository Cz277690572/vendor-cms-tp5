<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/4/29
 * Time: 19:02
 */

namespace app\api\controller\v1;

use app\api\model\SystemConfig as SystemConfigModel;
use app\api\validate\AboutUsGet;
use app\lib\exception\SystemConfigException;

class Config
{
    public function getAboutUs($type='')
    {
        (new AboutUsGet())->goCheck();
        $about = SystemConfigModel::getSystemConfigByType($type);
        if(!$about){
            throw new SystemConfigException();
        }
        $data = [];
        foreach ($about as $vo){
            $data[$vo['name']] = $vo['value'];
        }
        return $data;
    }
}