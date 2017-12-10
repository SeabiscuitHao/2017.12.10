<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
  public function add_admin($data)
  {
    if (empty($data) || !is_array($data)) {
      return false;
    }else{
      if ($this -> save($data)) {
        return true;
      }else{
        return false;
      }
    }
  }

  public function paginater()
  {
    return  $this::paginate(3);
  }

  public function save_admin($data,$admins)
  {
    if (!$data['username']) {
      return 2;//管理员不存在
    }
    if(!$data['password']) {
      $data['password'] = $admins['password'];
    }else{
      $data['password'] = md5($data['password']);
    }
    return $this -> update(['username' => $data['username'],'password' => $data['password']],['id' => $data['id']]);
  }

  public function del_admin($id)
  {
    if ($this -> destroy($id)) {
      return 1;
    }else{
      return 2;
    }
  }

  public function login($data)
  {
    $admin = Admin::getByUsername($data['username']);
    if ($admin) {
          if ($admin['password'] == $data['password']) {
              session('username',$admin['username']);
              session('id',$admin['id']);
              return 2;
            }else{
              return 3;
            }
        }else{
          return 1;
        }
    }
  }
