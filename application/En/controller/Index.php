<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author ZLQ
 */
namespace app\en\controller;
use think\Controller;
use think\Lang;


class Index extends Controller {
    //put your code here
    public function index(){
        global  $web_lang;
        Lang::set('lang','zh-cn');
        $lang='zh-cn';
         $name=Lang::get('name');
        $this->assign('name',$name);
        $this->assign('wlang',$web_lang);
        return $this->fetch();
    }
     public function second(){
        return $this->fetch();
    }
}
