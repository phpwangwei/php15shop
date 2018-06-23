<?php 
namespace app\admin\Controller;  //定义控制器的命名空间
use app\admin\model\Category;
use app\admin\model\Goods; 
use app\admin\model\Type;
use app\admin\model\Attribute;
 class GoodsController extends CommonController {
    public function add(){
        $goodsModel = new Goods();
    	if(request()->isPost()){
    		//接收参数
    		$postData = input('post.');
    		//验证器验证
    		$result = $this->validate($postData,'Goods.add',[],true);
    		if($result !== true){
    			$this->error(implode(',',$result));
    		}
            $goods_img=$goodsModel->uploadImg();
            if($goods_img){
                $result=$goodsModel->thumbImg($goods_img);
                $postData['goods_img']=json_encode($goods_img);
                $postData['goods_middle']=json_encode($result['middle']);
                $postData['goods_thumb']=json_encode($result['small']);
            }

    		//入库
    		if($goodsModel->allowField(true)->save($postData)){
    			$this->success("入库成功",url("admin/goods/index"));
    		}else{
    			$this->error("入库失败");
    		}
    	}
     	$catsModel=new Category();
     	$cats=$catsModel->getSonsCat();
        $types=Type::select();
     	return $this->fetch('',['cats'=>$cats,'types'=>$types]);
	}
    public function ajaxGetTypeAttr(){
        if (request()->isAjax()){
            $type_id=input('type_id');
            $attrData=Attribute::where('type_id',$type_id)->select();
            return json($attrData);
        }
    }
    public function index(){
        $lists=Goods::select();
        foreach ($lists as $k=>$v) {
            $result=json_decode($v['goods_thumb'],true);
            $lists[$k]['goods_thumb']=$result;
          }
        return $this->fetch('',['lists'=>$lists]);
    }
    public function ajaxDel(){
            if (request()->isAjax()){
                $goods_id=input('goods_id');
            }
            if (Goods::destroy($goods_id)){
                return json(['code'=>'200','message'=>'删除成功']);
            }else{
                 return json(['code'=>'-3','message'=>'删除失败']); 
            }
    }
    public function ajaxGetContent(){
       if(request()->isAjax()){
        $goods_id=input('goods_id');
        $goods=Goods::where('goods_id',$goods_id)->find();
        return json(['code'=>200,'goods'=>$goods]);
       } 
    }
     public function ajaxChangeActive(){
        if (request()->isAjax()){
           $is_hot = input('is_hot');
            $goods_id = input('goods_id');
            $update_active =  $is_hot?0:1;
            $data = [
                'is_hot'=>$update_active,
                'goods_id' => $goods_id
            ];
            $goodsrModel = new Goods();
            if($goodsrModel->update($data)!==false){
                return json(['status' => 200,'is_hot'=>$update_active]);
            }else{
                return json(['status' => -1,'is_hot'=>$update_active]);
            }
        }
    }
        
 
 }