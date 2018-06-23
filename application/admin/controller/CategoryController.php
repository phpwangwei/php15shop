<?php 
namespace app\admin\Controller;  //定义控制器的命名空间
use app\admin\model\Category; 
class CategoryController extends CommonController {
    public function add(){
    	$catModel=new Category();
    	if(request()->isPost()){	
    		$postData = input('post.');
    		$result = $this->validate($postData,'Category.add',[],true);
    		if($result !== true){
    			$this->error(implode(',',$result));
    		}
    		//入库
    		if($catModel->allowField(true)->save($postData)){
    			$this->success("入库成功",url("admin/category/index"));
    		}else{
    			$this->error("入库失败");
    		}
    	}
    	$cats=$catModel->getSonsCat();
    	return $this->fetch('',['cats'=>$cats]);
    }
    public function index(){
 		$catModel=new Category();
 		$lists=$catModel->getSonsCat();
 		return $this->fetch('',[
 			'lists'=>$lists
 		]);
 	}
    public function upd(){
        $catsModel=new Category();
        if(request()->isPost()){
            $postData = input('post.');
            $result = $this->validate($postData,'Category.upd',[],true);
            if($result !== true){
            $this->error(implode(',',$result));
            }
            //入库
            if($catsModel->allowField(true)->isUpdate(true)->save($postData)){
            $this->success("入库成功",url("admin/Category/index"));
            }else{
            $this->error("入库失败");
            }
        } 
        $cat_id=input('cat_id');
        $data=$catsModel->find($cat_id);
        $cats=$catsModel->getSonsCat();
        return $this->fetch('',[
            'data'=>$data,
            'cats'=>$cats
        ]);
    }
    public function ajaxDel(){
        if (request()->isAjax()){
            $cat_id=input('cat_id');
            $soncat=Category::where('pid','eq',$cat_id)->find();
            if ($soncat){
                $result=[
                    'code'=>'-1',
                    'message'=>'含有子类标签无法删除',
                ];
                return json($result);
            }
        }
        if (Category::destroy($cat_id)){
            return json(['code'=>'200','message'=>'删除成功']);
        }else{
             return json(['code'=>'-3','message'=>'删除失败']); 
        }
     }

}