<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 2020/3/18
 * Time: 19:44
 */

namespace app\admin\controller;


use library\tools\Data;
use think\Db;

class Index extends BaseController
{
    public function index(){
        return $this->fetch('index',['title'=>'系统管理后台 · Vendor']);
    }

    public function home(){
        return $this->fetch('home',['title'=>'后台首页']);
    }

    /**
     * 修改密码
     */
    public function pass($id)
    {
//        if (intval($id) !== intval(session('admin_user.id'))) {
//            $this->error('只能修改当前用户的密码！');
//        }
        if ($this->request->isGet()) {
            $this->verify = true;
            $this->_form('third_app', 'admin@third_app/pass', 'id', [], ['id' => $id]);
        } else {
            $data = $this->_input([
                'app_secret'    => $this->request->post('app_secret'),
                're_app_secret'  => $this->request->post('re_app_secret'),
                'old_app_secret' => $this->request->post('old_app_secret'),
            ], [
                'old_app_secret' => 'require',
                'app_secret'    => 'require|min:4',
                're_app_secret'  => 'require|confirm:app_secret',
            ], [
                'old_app_secret.require' => '旧密码不能为空！',
                'app_secret.require'    => '登录密码不能为空！',
                'app_secret.min'        => '登录密码长度不能少于4位有效字符！',
                're_app_secret.require'  => '重复密码不能为空！',
                're_app_secret.confirm'  => '重复密码与新的登录密码不匹配，请重新输入！',
            ]);
            $thirdApp = Db::name('third_app')->where(['id' => $id])->find();
            if (md5($data['old_app_secret']) !== $thirdApp['app_secret']) {
                $this->error('旧密码验证失败，请重新输入！');
            }

            if (Data::save('third_app', ['id' => $thirdApp['id'], 'app_secret' => md5($data['app_secret'])])) {
                $this->success('密码修改成功，下次请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }
}