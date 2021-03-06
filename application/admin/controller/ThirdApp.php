<?php
/**
 * 第三方账户管理
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/26
 * Time: 16:41
 */

namespace app\admin\controller;


use app\api\service\Token as TokenService;
use think\Db;

class ThirdApp extends BaseController
{
    /**
     * 指定当前数据表
     * @var string
     */
    protected $table = 'third_app';
    public function index()
    {
        $this->title = '应用账号管理';
        $query = $this->_query($this->table)->where(['delete_time' => null])->like('app_id');
        $query->timeBetween('update_time')->order('id desc')->page();
    }

    public function add()
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
            $data['app_secret'] = md5($data['app_secret']);
            // 登录账号重复检查
            if (isset($data['id'])) unset($data['app_id']);
            elseif (Db::name($this->table)->where(['app_id' => $data['app_id'], 'delete_time' => null])->count() > 0) {
                $this->error("账号{$data['app_id']}已经存在，请使用其它账号！");
            }
        }
    }

    public function remove()
    {
        if (in_array('1', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止删除！');
        }
        // 自己不能删除自己
        $id = TokenService::getCurrentUid();
        if($id == $this->request->post('id')){
            $this->error('不能删除自己！');
        }
        $this->_save($this->table, ['delete_time' => time()]);
    }
}