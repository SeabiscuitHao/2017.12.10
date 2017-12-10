<?php
namespace app\admin\controller;
use app\admin\model\Admin;
use think\Controller;
class Login extends Controller
{
  public function login()
  {
    if (request() -> isPost()) {
      $admin = new Admin();
      $res = $admin -> login(input('post.'));
      if ($res == '1') {
        $this -> error('用户不存在');
      }
      if ($res == '2') {
        $this -> success('登陆成功','index/index');
      }
      if ($res == '3') {
        $this -> error('密码不正确');
      }
      return;
    }
    return view();
  }
}
