<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/11
 * Time: 14:49
 */

namespace app\admin\controller;


use think\Controller;

class User extends Controller
{
    public function adminList(){

        return $this->fetch('admin-list');
    }
    public function adminAdd(){

        return $this->fetch('admin-add');
    }
    public function role(){
        return $this->fetch('admin-role');
    }
    public function addRole(){
        return $this->fetch('admin-role-add');
    }
}