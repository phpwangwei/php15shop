<?php 
 namespace app\admin\Controller;  
 use app\admin\model\Role;
 use app\admin\model\Auth;
 use think\Db;
 class RoleController extends CommonController {
     public function add(){
          if(request()->isPost()){
               $postData=input('post.');
               $result=$this->validate($postData,'Role.add',[],true);
               if ($result !==true){
                    $this->error(implode(',',$result));
               }
                $roleModel=new Role();
               if($roleModel->save($postData)){
                    $this->success("添加成功",url("admin/role/index"));
               }else{
                    $this->error('添加失败');
               }

          }
     	$authModel=new Auth();
     	$authData=$authModel->select()->toArray();
     	$auths=[];
     	foreach ($authData as $auth){
     		$auths[$auth['auth_id']]=$auth;
     	}
     	$children=[];
     	foreach ($authData as $auth){
     		$children[$auth['pid']][]=$auth['auth_id'];
     	}
     	return $this->fetch('',[
     		'auths'=>$auths,
     		'children'=>$children,
     	]);
     }
     public function index(){
        $sql="SELECT t1.* ,GROUP_CONCAT(t2.auth_name SEPARATOR '|')all_auth from sh_role t1 LEFT JOIN sh_auth t2 on FIND_IN_SET(t2.auth_id,t1.auth_id_list)GROUP BY t1.role_id";
         $lists=Db::query($sql);
         return $this->fetch('',['lists'=>$lists]);    
     }
     public function upd(){
            if(request()->isPost()){
               $postData=input('post.');
               $result=$this->validate($postData,'Role.add',[],true);
               if ($result !==true){
                    $this->error(implode(',',$result));
               }
                $roleModel=new Role();
               if($roleModel->isUpdate(true)->save($postData)){
                    $this->success("编辑成功",url("admin/role/index"));
               }else{
                    $this->error('编辑失败');
               }
            }
            $roleModel=new Role();
        $authModel=new Auth();
        $role_id=input('role_id');
        $authsData=$authModel->select()->toArray();
        $auths=[];
        foreach ($authsData as $auth){
           $auths[$auth['auth_id']]=$auth;
        }
        $children=[];
        foreach ($authsData as $auth){
            $children[$auth['pid']][]=$auth['auth_id'];
        }
        $data=$roleModel->find($role_id);
        return $this->fetch('',[
          'data'=>$data,
          'auths'=>$auths,
          'children'=>$children
        ]);
    }
     public function ajaxDel(){
          if (request()->isAjax()){
          $role_id=input('role_id');
          }
          if (Role::destroy($role_id)){
          return json(['code'=>'200','message'=>'删除成功']);
          }else{
           return json(['code'=>'-3','message'=>'删除失败']); 
          }
     }

       
     
 
 }