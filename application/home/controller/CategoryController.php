<?php 
 namespace app\home\controller;  //定义控制器的命名空间
 use think\Controller;  // 引入命名空间类
 use app\home\model\Category; 
 use app\home\model\Goods; 
 class CategoryController extends Controller {
 	public function index(){
 		$cat_id=input('cat_id');
     	$catModel=new Category();
     	$familyCats=$catModel->getFamilyCats($cat_id);

     	$catsData=Category::select()->toArray();
     	$cats=[];
     	foreach ($catsData as $cat){
     		$cats[$cat['cat_id']]=$cat;
     	}
     	$children=[];
     	foreach ($catsData as $cat) {
     		$children[$cat['pid']][]=$cat['cat_id'];
     	}
          $sonsCatsId = $catModel->getSonsCatId($cat_id);
          //加上当前的分类cat_id
          $sonsCatsId[]=intVal($cat_id); // [1,3,5]
          //取出所有子孙分类sonsCatsId中的所有的商品
          $condition = [
               'is_sale' => ['eq',1],
               'is_delete' => 0,
               'cat_id' => ['in',$sonsCatsId]  //等价于 'cat_id' => ['in',implode(',',$sonsCatsId)]
          ];
          $catsGoods = Goods::where($condition)->select();
     	return $this->fetch('',[
     	'familyCats'=>$familyCats,
     	'cats'=>$cats,
     	'children'=>$children,
          'catsGoods'=>$catsGoods
     	]);	
 	}
     
 
 }