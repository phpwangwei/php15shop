<?php 
namespace app\home\controller;   
use think\Controller;  
use app\home\model\Category;
use app\home\model\Goods;
class IndexController extends Controller {
    public function index(){
    	$navCats=Category::where(['is_show'=>1,'pid'=>0])->select();
    	$catsData=Category::select()->toArray();
    	$cats=[];
    	foreach($catsData as $cat){
    		$cats[$cat['cat_id']]=$cat;
    	}
    	$children=[];
    	foreach ($catsData as $cat){
    		$children[$cat['pid']][]=$cat['cat_id'];
    	}
        $goodsModel=new Goods();
        $crazyGoods=$goodsModel->getTypeGoods('is_crazy');
        $hotGoods=$goodsModel->getTypeGoods('is_hot');
        $bestGoods=$goodsModel->getTypeGoods('is_best');
        $newGoods=$goodsModel->getTypeGoods('is_new');
        $guessGoods=$goodsModel->getTypeGoods('is_guess');
    	return $this->fetch('',[
    		'navCats'=>$navCats, 'cats'=>$cats,'children'=>$children,
            'hotGoods'=>$hotGoods,'newGoods'=>$newGoods,'bestGoods'=>$bestGoods,'crazyGoods'=>$crazyGoods,'guessGoods'=>$guessGoods,
    	]);

    }

}