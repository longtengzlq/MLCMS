<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
/*
//测试路由章节中的动态注册功能放到此处能正常使用
use think\Route;
Route::rule('index/:id','index/index/read');
 * 
 */

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    
    
    /*
    '__domain__'=>[
            'admin' => 'admin',
            
    ],
     * 
     */
  
    
];
/*
//测试路由章节中的动态注册功能放到此处不能正常使用
use think\Route;
Route::rule('index/:id','index/index/read');
/* * 
 */