<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 16:38
 */

namespace app\app_extend\controller\weixin;


use think\Controller;

class Index extends Controller
{
 public function index(){
     return $this->fetch();
 }
}