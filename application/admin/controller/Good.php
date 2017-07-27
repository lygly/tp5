<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 10:06
 */

namespace app\admin\controller;


use app\admin\model\Goods;
use app\admin\model\GoodsType;
use think\Controller;
use think\Request;

class Good extends Controller
{
    //分类
   public function Category(){

       return $this->fetch('product-category');
   }
   //获取分类数据
    public function getCategory(){
       $GoodType = new GoodsType();
       $Category = $GoodType->field('id,pid,name')->select();
       echo json_encode($Category);
       $this->assign('category',$Category);
    }
    //删除分类数据
    public function CateDel(){
        $GoodType = new GoodsType();
        $id =input('id');
       // var_dump($id);
       // exit();
        $result = $GoodType->where('pid',$id)->find();
        if($result){
            /*return {code:0,msg:'存在子分类，不允许删除'}*/
            $str = '存在子分类，不允许删除';
            return $str;
        }else{
            $data = $GoodType->get($id);
            $re = $data->delete();
            if($re){
                return 1;
            }else{
                return 0;
            }
        }

    }
   //添加分类
    public function AddCategory(){
       $GoodsType = new GoodsType;
       $Cate = $GoodsType->order('path')->select();
      // $Cate = $GoodsType->field(['*','concat(path,",",id) as paths'])->order('paths')->select();
        foreach ($Cate as $k=>$v){
            $Cate[$k]['name']=str_repeat("|--",$v['level']).$v['name'];
        }
        //var_dump($Cate);
        $this->assign('cate',$Cate);//传值到视图
       return $this->fetch('product-category-add');
    }
    //添加分类信息到数据库
    public function CateTypeUpdate(){
       // var_dump(input());
        $data['name'] = input('name');
        $data['pid'] = input('pid');

        $GoodType = new GoodsType;
        $pid = input('pid');
        //如果不是顶级分类pid=0;
        if($pid){
            //查询服Id的路径
            $path = $GoodType->where('id',input('pid'))->value('path');
            $level = substr_count($path,',');
            $data['level'] = $level + 1;
            $data['path'] = $path;
        }else{
            $path = '0';
            $level = 1;
            $data['path'] = $path;
            $data['level'] = $level;

        }
        $GoodType->save($data);
        $id = $GoodType->id;
        $path = $GoodType->where('id',$id)->value('path');
        $GoodType->path  = $path.','.$id;
        $re = $GoodType->save();
        if($re){
            $this->success("新增成功",'Goods/addCategory',"",2);
            /*$data=['code'=>1,'msg'=>'新增成功'];
            return json_encode($data);*/
        }else{
           $this->error('新增失败','Goods/addCategory',"",2);
            // $data=['code'=>0,'msg'=>'新增失败'];
           // return json_encode($data);
        }
    }
    //产品列表
    public function goods(){
        $data = Goods::all();
        $this->assign('data',$data);
      return $this->fetch('product-list');
    }
    //添加产品
    public function addGood(){
        //产品类别
        $GoodsType = new GoodsType();
        $Cate = $GoodsType->order('path')->select();
        foreach ($Cate as $k=>$v){
            $Cate[$k]['name']=str_repeat("|--",$v['level']).$v['name'];
        }
        $this->assign('cate',$Cate);
       return $this->fetch('product-add');
    }
    //保存在数据库
    public function addGoods(){
      //var_dump(input());
      $data['goodsname'] = input('goodsname');
      $data['attributes'] = input('attributes');
      $data['number'] = input('number');
      $data['barcode'] = input('barcode');
      $data['unit'] = input('unit');
      $data['curprice'] = input('curprice');
      $data['oriprice'] = input('oriprice');
      $data['cosprice'] = input('cosprice');
      $data['inventory'] = input('inventory');
      $data['already'] = input('already');
      $data['freight'] = input('freight');
      $data['status'] = input('status');
      $data['reorder'] = input('reorder');
      //$data['imagepath'] = input('file');
      $data['text'] = input('editorValue');
      $tid = explode(',', input('tid'));
      $data['tid'] = $tid[0];
      $data['tpid'] = $tid[1];
      //var_dump($data);
      $Goods = new Goods();
      $re = $Goods->save($data);
      if($re){
          $this->success('成功','Good/goods');
      }else{
          $this->error('失败');
      }
    }
}