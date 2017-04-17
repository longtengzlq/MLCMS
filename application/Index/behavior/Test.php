<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author ZLQ
 */
namespace app\index\behavior;
use think\Request;
use think\Config;
use think\Cookie;


class Test {
    //put your code here
    /* 2017.01.18 ZLQ用于测试标签行为
    public function appInit(&$params){
        //header('location:admin/index/index');
        $request= Request::instance();
        //echo $request->baseUrl();
        //echo $request->url();
       // echo $request->module();
       // echo $request->server();
        //print_r($request->get());
        //echo $request->get('lang');
        //echo 'behavior second';
        
    }
    public function appEnd(&$params)
    {
        echo 'behavior end';
    }
     * 
     */
    // 在应用程序执行之前检测语言环境，如果是默认语言则不变，若是其它语言
    public function run(){
        $request= Request::instance();
        $lang=$request->get('lang');
       switch ($lang){
           case 'en-us':
              // Config::set('default_lang', $lang);
               header('location:/en/');
               exit;
               break;;
           case 'zh-cn':
               header('location:/index/');
               exit;
               break;;
           default :
               break;
       }
    }
        
        
}
