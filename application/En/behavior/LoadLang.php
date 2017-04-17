<?php
namespace app\en\behavior;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadLang
 *
 * @author ZLQ
 */
use think\Lang;
use think\Request;

class LoadLang {
    //put your code here
    public function run(){      
        $request= Request::instance();      
        switch ($request->module()){
            case 'en':
               Lang::load(APP_PATH.'lang\en-us.php');
               break;;
            case 'index':
                Lang::load(APP_PATH.'lang\zh-cn.php');
                break;
            default :
                break;;
        }        
    }   
}
