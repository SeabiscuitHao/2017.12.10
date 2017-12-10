<?php
namespace app\index\controller;
use think\Controller;
class Artlist extends Controller
{
    public function artlist()
    {
        return $this -> fetch();
    }
}
