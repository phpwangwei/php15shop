<?php 
namespace app\admin\controller;
use app\admin\model\Auth;
class AuthController extends CommonController{
	public function add(){
		if(request()->isPost()){
			$postData=input('post.');
			if($postData['pid']==0){
				$result=$this->validate($postData,'Auth.ding',[],true);
			}else{
				$result=$this->validate($postData,'Auth.add',[],true);
			}
			if ($result !==true){
				$this->error(implode(',',$result));
			}
			$authModel=new Auth();
			if ($authModel->save($postData)){
				$this->success("添加成功",url("admin/auth/index"));
			}else{
				$this->error('添加失败');
			}
		}
		$authModel = new Auth();
		$auths=$authModel->getAuthsSon();
		return $this->fetch('',['auths'=>$auths]);
	}
	public function index(){
		$auth=new Auth();
		$lists=$auth->getAuthsSon();
		return $this->fetch('',[
			'lists'=>$lists
		]);
	}
	public function upd(){
		$auth=new Auth();
		if(request()->isPost()){
			$postData=input('post.');
			if($postData['pid']==0){
				$result=$this->validate($postData,'Auth.ding',[],true);
			}else{
				$result=$this->validate($postData,'Auth.add',[],true);
			}
			if ($result !==true){
				$this->error(implode(',',$result));
			}
			if ($auth->isUpdate(true)->save($postData)){
				$this->success("编辑成功",url("admin/auth/index"));
			}else{
				$this->error('编辑失败');
			}
		}
		$auth_id=input('auth_id');
		$data=$auth->find($auth_id);
		$auths=$auth->getAuthsSon();
		return $this->fetch('',[
			'data'=>$data,
			'auths'=>$auths
		]);

	}
    public function ajaxDel(){
    	if (request()->isAjax()){
    		$auth_id=input('auth_id');
    		$soncat=Auth::where('pid','eq',$auth_id)->find();
    		if ($soncat){
    			$result=[
    				'code'=>'-1',
    				'message'=>'含有子权限标签无法删除',
    			];
    			return json($result);
    		}
    	}
    	if (Auth::destroy($auth_id)){
    		return json(['code'=>'200','message'=>'删除成功']);
    	}else{
    		 return json(['code'=>'-3','message'=>'删除失败']); 
    	}
     }


}