<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\lang;
class Test extends Controller
{
    public function index()
    {
       header("location:admin/index/index");
        $this->assign('a','test');
        $name=Lang::get('name');
        $this->assign('name',$name);
        return $this->fetch();
        
    }
}
