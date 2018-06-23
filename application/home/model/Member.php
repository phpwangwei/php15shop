<?php 
namespace app\home\model;  //定义模型的命名空间  
use think\Model;  // 引入核心模型命名空间

class Member extends Model {
	protected $pk='member_id';
  	protected $autoWriteTimestamp = true;
  	protected static function init(){
  		Member::event('before_insert',function($mem){
  			if(isset($mem['password'])){
  			$mem['password']=md5($mem['password'].config('password_salt'));
  			}
  		});
  		Member::event('before_update',function($mem){
  			$mem['password']=md5($mem['password'].config('password_salt'));
  		});
  	}
  	public function checkUser($username,$password){
		$condition = [
			'username' => $username,
			'password' => md5($password.config('password_salt'))
		];
		$userInfo = $this->where($condition)->find();
		if($userInfo){
			//把用户的用户名和用户id写入到session中
			session('home_username',$userInfo['username']);
			session('member_id',$userInfo['member_id']);
			return true;
		}else{
			return false;
		}
	}
}