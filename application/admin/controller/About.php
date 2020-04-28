<?php
/**
 * 关于我们参数配置
 * User: Armin
 * Date: 2020/4/28
 * Time: 15:32
 */

namespace app\admin\controller;


use think\Db;

class About extends BaseController
{
    protected $table = 'system_config';
    public function index()
    {
        $data = Db::name($this->table)->where(['type' => 'base'])->select();
        return $this->fetch('index',['title'=>'关于我们','data'=>$data]);
    }

    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 表单保存前置回调处理
     * 表单数据处理
     * @param $data
     */
    protected function _form_filter(&$data)
    {
        if ($this->request->isPost()) {
        }
    }
}