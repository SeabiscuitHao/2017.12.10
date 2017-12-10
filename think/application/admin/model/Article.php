<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
  protected static function init()
  {
    Article::event('before_insert',function($data){
      if ($_FILES['thumb']['tmp_name']) {
        $file = request() -> file('thumb');
        $info = $file -> move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
          $thumb = '/Second/think/'. 'public' . DS . 'uploads'.'/'.$info -> getSaveName();
          $data['thumb'] = $thumb;
        }
      }
    });
    Article::event('before_update',function($data){
      //开始 修改一篇文章的缩略图 上次保存在文档中的原图片就会被替换掉 保存为新的图片
      if ($_FILES['thumb']['tmp_name']) {
        $arts = Article::find($data -> id);
        $thumbpath = $_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
        if (file_exists($thumbpath)) {
          @unlink($thumbpath);
        }
      //结束
        $file = request() -> file('thumb');
        $info = $file -> move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
          $thumb = '/Second/think/'. 'public' . DS . 'uploads'.'/'.$info -> getSaveName();
          $data['thumb'] = $thumb;
        }
      }
    });
    Article::event('before_delete',function($data){
      //开始 修改一篇文章的缩略图 上次保存在文档中的原图片就会被替换掉 保存为新的图片
        $arts = Article::find($data -> id);
        $thumbpath = $_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
        if (file_exists($thumbpath)) {
          @unlink($thumbpath);
        }
      //结束
    });
}
}
