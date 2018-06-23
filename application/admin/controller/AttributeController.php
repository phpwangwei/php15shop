<?php   
namespace app\admin\Controller;  //定义控制器的命名空间
use think\Controller;  // 引入命名空间类
use app\admin\model\Attribute;
use app\admin\model\Type;
class AttributeController extends Controller {
  	public function add(){
  		$typeModel=new Type();
		if(request()->isPost()){
			$postData = input('post.');
			// halt($postData);
			$postData['attr_values']=trim($postData['attr_values']);
			if($postData['attr_input_type']=='0'){
				$result = $this->validate($postData,'Attribute.add',[],true);
			}else{
				$result = $this->validate($postData,'Attribute.listselect',[],true);
			}
			// halt(2);
			if($result !== true){
			$this->error(implode(',',$result));
			}
			
			$attributeModel = new Attribute();

			if($attributeModel->allowField(true)->save($postData)){
			$this->success("入库成功",url("admin/attribute/index"));
			}else{
			$this->error("入库失败");
			}
		}
		$types=$typeModel->select();
		return $this->fetch('',['types'=>$types]);
   	}
   	public function index(){
   		$lists=Attribute::select();
 		$typeData=Type::select()->toArray();
 		$types=[];
 		foreach ($typeData as $type){
 			$types[$type['type_id']]=$type;
 		}
 		 	return $this->fetch('',['lists'=>$lists,'types'=>$types]);
 	}
 	public function upd(){
 		$attributeModel=new Attribute();
		if(request()->isPost()){
			$postData = input('post.');
			// halt($postData);
			$postData['attr_values']=trim($postData['attr_values']);
			if($postData['attr_input_type']=='0'){
				$result = $this->validate($postData,'Attribute.add',[],true);
			}else{
				$result = $this->validate($postData,'Attribute.listselect',[],true);
			}
			if($result !== true){
			$this->error(implode(',',$result));
			}
			
			$attributeModel = new Attribute();

			if($attributeModel->allowField(true)->isUpdate(true)->save($postData)){
			$this->success("编辑成功",url("admin/attribute/index"));
			}else{
			$this->error("编辑失败");
			}
		}
		$attr_id=input('attr_id');
		$data=$attributeModel->find($attr_id);
		$types=Type::select();
			return $this->fetch('',['data'=>$data,'types'=>$types]);
 	}
 	public function ajaxDel(){
 		if(request()->isAjax()){
          $attr_id=input('attr_id');
          if (Attribute::destroy($attr_id)){
          return json(['code'=>'200','message'=>'删除成功']);
          }else{
           return json(['code'=>'-3','message'=>'删除失败']); 
          }
      	}
 	}
 		

 	

}