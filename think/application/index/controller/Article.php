<?php
namespace app\index\controller;
use think\Controller;
class Article extends controller
{
  public function article()
  {
    return $this -> fetch();
  }
}
