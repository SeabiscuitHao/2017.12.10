<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{
  public function catetree()
  {
    $cateres = $this -> order('id desc') -> select();
    return $this -> sort($cateres);
  }

  public function sort($data,$pid = 0,$level = 0)
  {
    static $arr = array();
    foreach ($data as $key => $value) {
      if ($value['pid'] == $pid) {
        $value['level'] = $level;
        $arr[] = $value;
        $this -> sort($data,$value['id'],$level+1);
      }
    }
    return $arr;
  }
//遍历进行删除功能
  public function getchildrenid($cateid)
  {
    $cateres = $this -> select();
    return $this -> _getchildrenid($cateid,$cateres);
  }

  public function _getchildrenid($cateid,$cateres)
  {
    static $arr = array();
    foreach ($cateres as $key => $value) {
      if ($value['pid'] == $cateid) {
        $arr[] = $value['id'];
        $this -> _getchildrenid($cateres,$value['id']);
      }
    }
    return $arr;
  }
}
