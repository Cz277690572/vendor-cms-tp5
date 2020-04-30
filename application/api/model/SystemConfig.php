<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/4/29
 * Time: 19:04
 */

namespace app\api\model;


class SystemConfig extends BaseModel
{
    // 获取器
    public function getValueAttr($value,$data)
    {
        $names = ['site_icon','site_logo','site_logo_bg','contact_way_a_img','contact_way_b_img'];
        if(in_array($data['name'],$names)){
            $value = config('setting.img_prefix').$value;
        }
        return $value;
    }

    public static function getSystemConfigByType($type)
    {
        $systemConfig = self::where('type','in',$type)->select();
        return $systemConfig;
    }
}