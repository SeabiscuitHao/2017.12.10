<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
use app\admin\controller\Common;
class Article extends Common
{
    public function lst()
    {
      $artres = Db::name('article') -> field('a.*,b.catename') -> alias('a') -> join('cate b','a.cateid = b.id') -> paginate(2);
      $this -> assign('artres',$artres);
      return view();
    }

    public function add()
    {
      if (request() -> isPOst()) {
        $data = input('post.');
        $validate = \think\Loader::validate('Article');
        if (!$validate -> check($data)) {
          $this -> error($validate -> getError());
        }
        $article = new ArticleModel();
        if ($article -> save($data)) {
          $this -> success('添加文章成功！','lst');
        }else{
          $this -> error('添加文章失败！');
        }
        return;
      }
      $cate = new CateModel();
      $cateres = $cate -> catetree();
      $this -> assign('cateres',$cateres);
      return view();
    }

    public function edit()
    {
      if (request() -> isPost()) {
        $article = new ArticleModel();
        $validate = \think\Loader::validate('Article');
        if (!$validate -> check(input('post.'))) {
          $this -> error($validate -> getError());
        }
        $save = $article -> save(input('post.'),['id',input('id')]);
        if ($save !== false) {
          $this -> success('修改文章成功！','lst');
        }else{
          $this -> error('修改文章失败!');
        }
        return;
      }
      $cate = new CateModel();
      $articles = Db::name('article') -> where(array('id'=>input('id'))) -> find();
      $cateres = $cate -> catetree();
      $this -> assign(array(
        'articles' => $articles,
        'cateres' => $cateres,
      ));
      return view();
    }
    public function del()
    {
      if (ArticleModel::destroy(input('id'))) {
        $this -> success('删除文章成功！','lst');
      }else{
        $this -> error('删除文章失败！');
      }
    }
}
