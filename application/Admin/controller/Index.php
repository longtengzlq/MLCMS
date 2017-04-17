<?php
namespace app\admin\controller;
use think\Controller;
use think\view;
class Index extends controller
{
    public function index()
    {     
        return $this->fetch();
    }
     public function welcome()
    {     
        return $this->fetch();
    }
     public function questionlist()
    {     
        return $this->fetch();
    }
    public function login()
    {     
        return $this->fetch();
    }
}
