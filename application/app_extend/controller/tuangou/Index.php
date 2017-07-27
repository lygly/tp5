<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 16:32
 */

namespace app\app_extend\controller\tuangou;


use think\Controller;

class Index extends Controller
{
   public function index(){
       return $this->fetch();
   }
}