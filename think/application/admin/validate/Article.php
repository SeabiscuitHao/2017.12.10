<?php
namespace app\admin\validate;
use think\Validate;
class Article extends Validate
{
  protected $rule = [
    'title' => 'require|max:25',
    'author' => 'require|max:12',
    'keywords' => 'require|max:10',
    'desc' => 'require',
    'content' => 'require',
  ];

  protected $message = [
    'title.require' => '文章标题不能为空',
    'title.max' => '文章标题长度不能超过25',
    'author.require' => '作者名称不能为空',
    'author.max' => '作者名称长度不能超过12',
    'keywords.require' => '文章关键字不能为空',
    'keywords.max' => '文章关键字长度不能超过10',
    'desc.require' => '文章简介不能为空',
    'content.require' => '文章内容不能为空',
  ];

  protected $scene = [
    'add' => ['title','author','keywords','desc','content'],
    'edit' => ['title','author','keywords','desc','content'],
  ];
}
