<?php 
namespace app\home\controller;  //定义控制器的命名空间
use think\Controller;  // 引入命名空间类
use think\Db;
class CartController extends Controller {
  public function ajaxaddcart(){
		if (request()->isAjax()){
			if(!session('member_id')){
				return json(['code'=>'-1','message'=>'请先登录']);
			}	
            $goods_id=input('goods_id');

            $goods_attr_ids=input('goods_attr_ids');
            $goods_number=input('goods_number');
            $cart=new \cart\Cart();
            $cart->addCart($goods_id,$goods_attr_ids,$goods_number);
        	return json(['code'=>'200','message'=>'添加购物成功']); 
       
     	}
     	     	
  }
  public function cartList(){
      if(!session('member_id')){
        $this->error("请先登录",url("home/public/login"));
      }
      $cart=new \cart\Cart();
      $cartInfo=$cart->getCart();
   
      $cartData=[];
      foreach ($cartInfo as $key=>$goods_number){
        $arr=explode('_',$key);
        $cartData[]=[
          'goods_id'=>$arr[0],
          'goods_attr_ids'=>$arr[1]?:'',
          'goods_number'=>$goods_number
        ];
        foreach ($cartData as $k=>$data){
           $cartData[$k]['goodsInfo']=Db::name('goods')->find($data['goods_id']);
          
           $cartData[$k]['attrInfo']=Db::name("goods_attr")
                    ->field("sum(t1.attr_price) attr_total_price ,group_concat(t2.attr_name,':',t1.attr_value,'￥',t1.attr_price separator '<br />') as singleAttr")
                    ->alias('t1')
                    ->join('sh_attribute t2','t1.attr_id = t2.attr_id','left')
                    ->where("t1.goods_attr_id",'in',$data['goods_attr_ids'])
                    ->find();
        }
      }
		  return $this->fetch('',['cartData'=>$cartData]);
	}
	public function test(){
      $cart=new \cart\Cart();
      dump($cart->getCart());
     
  } 
  public function ajaxDelGoods(){
    if (request()->isAjax()){
        $cart=new \cart\Cart();
        $status=$cart->delCart(input('goods_id'),input('goods_attr_ids'));
      if($status){
          return json(['code'=>'200','message'=>'删除成功']);
      }else{
           return json(['code'=>'-3','message'=>'删除失败']); 
      }
    }
  }
  public function clearCart(){
    if (request()->isAjax()){
        $cart=new \cart\Cart();
      if($cart->clearCart()){
          return json(['code'=>'200','message'=>'删除成功']);
      }else{
           return json(['code'=>'-3','message'=>'删除失败']); 
      }
    }
  }
  public function changeCartNum(){
    $goods_id=input('goods_id');
    $goods_attr_ids=input('goods_attr_ids');
    $goods_number=input('goods_number');
    $cart=new \cart\Cart();
     if($cart->changeCartNum($goods_id,$goods_attr_ids,$goods_number)){
          return json(['code'=>'200','message'=>'更新成功']);
      }else{
           return json(['code'=>'-3','message'=>'更新失败']); 
      }
  }
       
}