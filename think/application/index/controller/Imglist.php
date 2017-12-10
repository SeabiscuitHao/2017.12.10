<?php
namespace app\index\controller;
use think\Controller;
class Imglist extends controller
{
  public function imglist()
  {
    return $this -> fetch();
  }
}
