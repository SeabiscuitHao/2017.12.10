<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use think\Db;
use app\admin\controller\Common;
class Admin extends Common
{
    public function add()
    {
      // $data = [
      //   'username' => input('username'),
      //   'password' => input('password'),
      // ];
      // if (request() -> isPost()) {
      //   $ins = Db::name('admin') -> insert($data);
      //   if ($ins) {
      //     $this -> success('添加管理员成功！','lst');
      //   }else{
      //     $this -> error('添加管理员失败');
      //   }
      // }
      if (request() -> isPost()) {
        $admin = new AdminModel();
        $res = $admin -> add_admin(input('post.'));
        if ($res) {
          $this -> success('添加管理员成功！','lst');
        }else{
          $this -> error('添加管理员失败！');
        }
      }
      return $this -> fetch('add');

    }

    public function lst()
    {
      // $list = Db::name('admin') -> paginate(3);
      // $this -> assign('list',$list);
      $admin = new AdminModel();
      $adminres = $admin -> paginater();
      $this -> assign('adminres',$adminres);
      return $this -> fetch('lst');
    }

    public function edit()
    {
      // $id = input('id');
      // $admins = Db::name('admin') -> find($id);
      // $data = [
      //   'id' => input('id'),
      //   'username' => input('username'),
      //   'password' => input('password'),
      // ];
      // if (request() -> isPost()) {
      //   $edit = Db::name('admin') -> update($data);
      //   if ($edit) {
      //     $this -> success('修改管理员信息成功！','lst');
      //   }else{
      //     $this -> error('修改管理员信息失败！');
      //   }
      // }
      // $this -> assign('admins',$admins);
      $id = input('id');
      $admins = Db::name('admin') -> find($id);
      if (request() -> isPost()) {
        $admin = new AdminModel();
        $data = input('post.');
        if ($admin->save_admin($data,$admins) == '2') {
          $this -> error('管理员名称不能为空');
        }
        if ($admin->save_admin($data,$admins)) {
          $this -> success('修改管理员信息成功!','lst');
        }else {
          $this -> error('修改管理员信息失败！');
        }
      }
      $this -> assign('admins',$admins);
      return $this -> fetch('edit');
    }

    public function del()
    {
      // $id = input('id');
      // $del = Db::name('admin') -> where('id','=',$id) -> delete();
      // if ($del) {
      //   $this -> success('删除管理员成功！','lst');
      // }else{
      //   $this -> error('删除管理员失败！');
      // }
      // return $this -> fetch('del');
      $id = input('id');
      $admin = new AdminModel();
      if ($admin -> del_admin($id) == 1) {
        $this -> success('删除管理员成功！','lst');
      }else{
        $this -> error('删除管理员失败！');
      }
    }

    public function logout()
    {
      session(null);
      $this -> success('退出登陆成功！');
    }
}
