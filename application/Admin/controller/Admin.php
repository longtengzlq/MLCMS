<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\controller;
use think\Controller;
/**
 * Description of Admin
 *
 * @author ZLQ
 */
class Admin extends Controller{
    //put your code here
    public function  adminAdd(){
        return $this->fetch();
    }
    public function  adminList(){
        return $this->fetch();
    }
}
