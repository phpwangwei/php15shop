<?php 
 namespace app\admin\Controller;  
 use think\Controller; 
 use app\admin\model\User;
 use app\admin\model\Role; 
 class UserController extends CommonController {
      public function add(){
    	if(request()->isPost()){
    	 	$postData = input('post.');
    	 	$result = $this->validate($postData,'User.add',[],true);
    	 	if($result !== true){
    	 		$this->error(implode(',',$result));
    	 	}
    	 	$userModel = new User();
    	 	if($userModel->allowField(true)->save($postData)){
    	 		//入库成功
    	 		$this->success("入库成功",url("admin/user/index"));
    	 	}else{
    	 		//入库失败
    	 		$this->error("入库失败");
    	 	}
    	}
        $roles = Role::select();
    	return $this->fetch('',['roles'=>$roles]);
    }
    public function index(){
    	$lists = User::paginate(3);
        $roleData=Role::select();
        $roles=[];
        foreach ($roleData as $role) {
            $roles[$role['role_id']]=$role;
        }
    	return $this->fetch('',['lists'=>$lists,'roles'=>$roles]);
    }
    public function upd(){
      if(request()->isPost()){
            $postData = input('post.');
            $result = $this->validate($postData,'User.upd',[],true);
            if($result !== true){
                $this->error(implode(',',$result));
            }
            $userModel = new User();
            if($userModel->allowField(true)->isUpdate(true)->save($postData)!==false){
            
                $this->success("编辑成功",url("admin/user/index"));
            }else{
                
                $this->error("编辑失败");
            }
            
        }
        $user_id=input('user_id');
            $data=User::find($user_id);
            return $this->fetch('',['data'=>$data]);  
    }
    public function ajaxChangeActive(){
        if (request()->isAjax()){
           $is_active = input('is_active');
            $user_id = input('user_id');
            $update_active =  $is_active?0:1;
            $data = [
                'is_active'=>$update_active,
                'user_id' => $user_id
            ];
            $userModel = new User();
            if($userModel->update($data)!==false){
                return json(['status' => 200,'is_active'=>$update_active]);
            }else{
                return json(['status' => -1,'is_active'=>$update_active]);
            }
        }
    }
     public function ajaxDel(){
          if (request()->isAjax()){
          $user_id=input('user_id');
          }
          if (User::destroy($user_id)){
          return json(['code'=>'200','message'=>'删除成功']);
          }else{
           return json(['code'=>'-3','message'=>'删除失败']); 
          }
     }
 
  

}

 