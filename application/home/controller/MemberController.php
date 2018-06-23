<?php 
namespace app\home\controller;  //定义控制器的命名空间
use think\Controller;
use app\home\model\Member;  // 引入命名空间类
class MemberController extends Controller {
   	public function qqLogin(){
    	include '../extend/qqLogin/API/qqConnectAPI.php';
    	$qc = new \QC();
    	$qc->qq_login();
    }
    public function qqCallback(){
     	include '../extend/qqLogin/API/qqConnectAPI.php';
    	$qc = new \QC();
    	$token=$qc->qq_callback();
    	$openid=$qc->get_openid();
		$qc = new \QC($token,$openid);
		$userInfo=Member::where('openid',$openid)->find();
		if($userInfo){
			session('home_username',$userInfo['username']?:$userInfo['nickname']);
			session('member_id',$userInfo['member_id']);
			$this->redirect('home/index/index');
		}else{
			$qqUserInfo=$qc->get_user_info();
			$data=['openid'=>$openid,'nickname'=>$qqUserInfo['nickname']];
			$member=Member::create($data);
			session('home_username',$member['nickname']);
			session('member_id',$member['member_id']);
			$this->redirect('home/index/index');
		}
		
		echo "<br />token:".$token;
		echo "<br />openid:".$openid;
		echo "<br/>";
		dump($qqUserInfo);
     } 

}