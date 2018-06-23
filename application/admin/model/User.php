<?php 
namespace app\admin\Model;  
use think\Model;  // 
class User extends Model{
  	protected $pk='user_id';
  	protected $autoWriteTimestamp = true;
  	protected static function init(){
		//定义入库的前钩子（事件）
		User::event('before_insert',function($user){
			//参数$user是当前提交过来的数据对象（经过验证的合法数据）
			$user['password'] = md5($user['password'].config('password_salt'));
		});
		User::event('berore_update',function($user){
			if (isset($user['password'])) {
				if ($user['password']==''){
					unset($user['password']);
				}else{
					$user['password']=md5($user['password'].config('password_salt'));
				}
			}
		});
	}

  	public function checkUser($username,$password){
		    $condition = [
			   'username' => $username,
			   'password' => md5($password.config('password_salt'))
		    ];
		    $userInfo = $this->where($condition)->find();
		    if($userInfo){
			
			   session('username',$userInfo['username']);
			   $this->writeAuthToSession($userInfo['role_id']);
			   return true;
		     }else{
			   return false;
		    }
    }
    public function writeAuthToSession($role_id){
      	$row=Role::find($role_id);
      	$auth_id_list=$row['auth_id_list'];
      	if ($auth_id_list == '*'){
      		$oneAuth=Auth::where('pid',0)->select()->toArray();
      		foreach ($oneAuth as $k => $auth) {
      			$oneAuth[$k]['sonsAuth']=Auth::where('pid',$auth['auth_id'])->select()->toArray();
      		}
          session('visitorAuth','*');
      	}else{
            $visitorAuth=[];
            $all_auth=Auth::where('auth_id','in',$auth_id_list)->select()->toArray();
      		  $oneAuth=[];
      		  foreach ($all_auth as $k=>$auth){
      			   if ($auth['pid']==0){
      				    $oneAuth[]=$auth;
      			   }
                $visitorAuth[] = strtolower($auth['auth_c'].'/'.$auth['auth_a']);
            }
      		  foreach ($oneAuth as $k=>$auth){
      			   foreach ($all_auth as $kk=>$s_auth){
      				    if ($s_auth['pid']==$auth['auth_id']){
      					   $oneAuth[$k]['sonsAuth'][]=$s_auth;
      				    }
      			   }
       		  }
        session('visitorAuth',$visitorAuth);
      	}
      	session('menuAuth',$oneAuth);

    }  
}
