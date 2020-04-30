<?php
/**
 * 关于我们参数配置
 * User: Armin
 * Date: 2020/4/28
 * Time: 15:32
 */

namespace app\admin\controller;


use think\Db;

class Config extends BaseController
{
    protected $table = 'system_config';
    public function index()
    {
        $data = Db::name($this->table)->where('type','in','1,2,3,5,74,75,76,77,78,79,80')->select();
        $siteData = [];
        foreach ($data as $vo) {
            switch ($vo['name']){
                case 'site_logo':
                    $siteData['site_logo'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                    break;
                case 'site_logo_bg':
                    $siteData['site_logo_bg'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                    break;
                case 'site_icon':
                    $siteData['site_icon'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                    break;
                case 'contact_way_a_img':
                    $siteData['contact_way_a_img'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                    break;
                case 'contact_way_b_img':
                    $siteData['contact_way_b_img'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                    break;
                default:
                    $siteData[$vo['name']] = $vo['value'];
                    break;
            }
        }
        return $this->fetch('index',['title'=>'关于我们','siteData'=>$siteData]);
    }

    public function edit()
    {
        $this->title = '编辑网站信息';
        $this->isAddMode = 0;
        return $this->_form($this->table, 'form');
    }

    /**
     * 表单保存前置回调处理
     * 表单数据处理
     * @param $data
     */
    protected function _form_filter(&$data)
    {
        if($this->request->isGet())
        {
            $data = Db::name($this->table)->where('type','in','1,2,3,5,74,75,76,77,78,79,80')->select();
            $siteData = [];
            foreach ($data as $vo) {
                switch ($vo['name']){
                    case 'site_logo':
                        $siteData['site_logo'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                        break;
                    case 'site_logo_bg':
                        $siteData['site_logo_bg'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                        break;
                    case 'site_icon':
                        $siteData['site_icon'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                        break;
                    case 'contact_way_a_img':
                        $siteData['contact_way_a_img'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                        break;
                    case 'contact_way_b_img':
                        $siteData['contact_way_b_img'] = !empty($vo['value']) ? config('setting.img_prefix').$vo['value'] : '';
                        break;
                    default:
                        $siteData[$vo['name']] = $vo['value'];
                        break;
                }
            }
            $this->siteData = $siteData;
        }
        elseif ($this->request->isPost())
        {
            $this->_input([
                'site_name'    => $this->request->post('site_name'),
                'app_name'  => $this->request->post('app_name'),
                'app_version' => $this->request->post('app_version'),
                'site_icon' => $this->request->post('site_icon'),
                'site_logo' => $this->request->post('site_logo'),
                'site_logo_bg' => $this->request->post('site_logo_bg'),
                'site_intro' => $this->request->post('site_intro')

            ], [
                'site_name'     => 'require',
                'app_name'      => 'require',
                'app_version'   => 'require',
                'site_icon'     => 'require',
                'site_logo'     => 'require',
                'site_logo_bg'  => 'require',
                'site_intro'    => 'require',
            ], [
                'site_name.require'     => '网站名称不能为空！',
                'app_name.require'      => '管理程序名称不能为空！',
                'app_version.require'   => '管理程序版本不能为空！',
                'site_icon.require'     => '网站图标不能为空！',
                'site_logo.require'     => '网站Logo不能为空！',
                'site_logo_bg.require'  => '网站Logo背景图不能为空！',
                'site_intro.require'    => '网站简介不能为空！',
            ]);

            $data['site_icon']         = !empty($data['site_icon']) ? substr($data['site_icon'], strpos($data['site_icon'], config('setting.upload_path')) + 7) : '';
            $data['site_logo']         = !empty($data['site_logo']) ? substr($data['site_logo'], strpos($data['site_logo'], config('setting.upload_path')) + 7) : '';
            $data['site_logo_bg']      = !empty($data['site_logo_bg']) ? substr($data['site_logo_bg'], strpos($data['site_logo_bg'], config('setting.upload_path')) + 7) : '';
            $data['contact_way_a_img'] = !empty($data['contact_way_a_img']) ? substr($data['contact_way_a_img'], strpos($data['contact_way_a_img'], config('setting.upload_path')) + 7) : '';
            $data['contact_way_b_img'] = !empty($data['contact_way_b_img']) ? substr($data['contact_way_b_img'], strpos($data['contact_way_b_img'], config('setting.upload_path')) + 7) : '';

            foreach ($data as $key => $value) sysconf($key, $value);
            $this->success('保存成功！', 'javascript:history.back()');
        }
    }
}