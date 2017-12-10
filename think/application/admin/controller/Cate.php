<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
use think\Db;
use app\admin\controller\Common;
class Cate extends Common
{
    protected $beforeActionList = [
      'del' => ['only' => 'delsoncate'],
    ];

    public function lst()
    {
      $cate = new CateModel();
      if (request() -> isPost()) {
        $sorts = input('post.');
        foreach ($sorts as $key => $value) {
          $cate -> update(['id'=>$key],['sort'=>$value]);
          // if () {
          //   $this -> success('更新排序成功！');
          // }else{
          //   $this -> error('更新排序失败！');
          // }

        }
        $this -> success('更新排序成功！','lst');
        return;
      }
      $cateres = $cate -> catetree();
      $this -> assign('cateres',$cateres);
      return view();
    }
    public function add()
    {
      $cate = new CateModel();
      if (request() -> isPost()) {
        $save = $cate -> save(input('post.'));
        if ($save) {
          $this -> success('添加栏目成功！','lst');
        }else{
          $this -> error('添加栏目失败！');
        }
      }
      $cateres = $cate -> catetree();
      $this -> assign('cateres',$cateres);
      return view();
    }
    public function del()
    {
      $id = input('id');
      $res = Db::name('cate') -> delete($id);
      if ($res) {
        $this -> success('删除栏目成功！','lst');
      }else{
        $this -> error('删除栏目失败！');
      }
    }

    public function delsoncate()
    {
      $cateid = input('id');
      $cate = new CateModel();
      $sonids = $cate -> getchildrenid($cateid);
      $allcateid = $sonids;
      $allcateid[] = $cateid;
      foreach ($allcateid as $key => $value) {
        $article = new ArticleModel();
        $article -> where(array('cateid' => $value)) -> delete();
      }
      if ($sonids) {
        Db::name('cate') -> delete($sonids);
      }
    }

    public function edit()
    {
      $cate = new CateModel();
      if (request() -> isPost()) {
        $save = $cate -> save(input('post.'),['id'=>input('id')]);
        if ($save !== false) {
          $this -> success('修改栏目成功！','lst');
        }else{
          $this -> error('栏目修改失败');
        }
        return;
      }
      $cates = $cate -> find(input('id'));
      $cateres = $cate -> catetree();
      $this -> assign(array(
        'cateres' => $cateres,
        'cates' => $cates,
      ));
      return view();
    }
}
