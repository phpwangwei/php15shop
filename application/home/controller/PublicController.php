<?php 
namespace app\home\Controller;  //定义控制器的命名空间
use think\Controller;  // 引入命名空间类
use app\home\model\Member; 
class PublicController extends Controller {
   public function register(){
    	if(request()->isPost()){
        //接收参数
            $postData = input('post.');
            //验证器验证
            $result = $this->validate($postData,'Member.register',[],true);
            if($result !== true){
                $this->error(implode(',',$result));
            }
            if (md5($postData['phoneCaptcha'].config('sms_salt')) !==cookie('sms')){
               $this->error("手机验证码错误");
            }
            //入库
            $memModel = new Member();
            if($memModel->allowField(true)->save($postData)){
                $this->success("注册成功",url("home/public/login"));
            }else{
                $this->error("注册失败");
            }
        }
            return $this->fetch('');
    		
    }
    public function sendSms(){

        if(request()->isAjax()){
           $phone = input('phone');
           //echo $phone;die;
            //验证器验证
            $result = $this->validate(['phone'=>$phone],'Member.sms',[]);
            if($result !== true){
                return json(['code'=>-1,'message'=>$result]);
            }
            $rand = mt_rand(1000,9999);
            $sms=md5($rand.config('sms_salt'));
            cookie('sms',$sms,300);
            return sendSms($phone,array($rand,5),"1");
        }
    }
    public function testEmail(){
       dump(sendEmail('675545421@qq.com','大吉大利','退u的我的武器')) ;
    }
    public function findPassword(){

        if(request()->isAjax()){
           $email = input('email');
           //echo $email;die;email
            //验证器验证
            $result = $this->validate(['email'=>$email],'Member.email',[],true);
            if($result !== true){
                return json(['code'=>-1,'message'=>implode(',',$result)]);
            }
            if($userInfo=Member::where('email',$email)->find()){
                $title='修改密码';
                $time=time();
                $member_id=$userInfo['member_id'];
                $hash=md5($member_id.$time.config('email_salt'));
                $href=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/home/public/updpassword/member_id/".$userInfo['member_id'].'/time/'.$time.'/hash/'.$hash;
                $content="<a href='{$href}'>点我修改密码</a>";
                if(sendEmail($email,$title,$content)){
                    return json(['code'=>200,'message'=>'邮件发送成功']);
                }else{
                    return json(['code'=>-3,'message'=>'邮件发送失败，请联系管理员']);
                }
            }else{
                return json(['code'=>-2,'message'=>'邮箱不存在']);
            }
            
        }
        return $this->fetch('');
    }
    public function updpassword(){
        if(request()->isAjax()){
            $postData=input('post.');
            $memModel=new Member();
            if($memModel->isUpdate(true)->allowField(true)->save($postData)!==false){
                return json(['code'=>200,'message'=>'密码更新成功,转到登陆页面']);
            }else{
                return json(['code'=>-2,'message'=>'更新失败']);
            }
        }
       $member_id=input('member_id');
       $oldtime = input('time');
        $hash = input('hash');
         if( md5( $member_id.$oldtime.config('email_salt') ) !== $hash ){
            exit('无效的链接地址,你对链接地址做啥了');
        }
        //2、判断是否在有效期内(120s)
        //之前时间+有效期（120） < 当前时间戳
        if($oldtime+120<time()){
            exit('早干嘛去了，现在才来，没用了');
        }
       return $this->fetch('',['member_id'=>$member_id]); 
    }
    public function login(){
        if(request()->isPost()){
             //接收参数
             $postData = input('post.');
             //验证器验证
             $result = $this->validate($postData,'Member.login',[],true);
             if($result !== true){
                 $this->error(implode(',',$result));
             }
             //入库
             $memModel = new Member();
             $status=$memModel->checkUser($postData['username'],$postData['password']);
             if($status){
                if(input('return_url')){
                    $this->redirect('home/goods/detail?goods_id='.input('return_url'));
                }
                 $this->redirect("home/index/index");
                
             }else{
                 $this->error("用户名或密码错误");
             }
        }
        return $this->fetch('');
    } 
    public function logout(){
        session('member_id',null);
        session('home_username',null);
        $this->redirect('home/index/index');
    }

}