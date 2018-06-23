<?php 
namespace app\home\validate;
use think\Validate;
class Member extends Validate{
	protected $rule = [
		'username' => 'require|unique:member',
		'password' => 'require',
		'email'=>'require|email',
		'captcha'=>'require|captcha:2',
		'repassword' => 'require|confirm:password',
		'phone' => 'require|unique:member',
	];

	protected $message = [
		'username.require' => '用户名必填',
		'username.unique' => '用户名重复',
		'email.require' => '邮箱必填',
		'email.email' => '邮箱格式不正确',
		'password.require' => '密码必填',
		'captcha.require' => '验证码必填',
		'captcha.captcha' => '验证码错误',
		'repassword.require' => '确认密码必填',
		'repassword.confirm' => '两次密码不一致',
		'phone.require' => '手机号必填',
		'phone.unique' => '手机号占用',

	];
	protected $scene = [
		'register' => ['username','password','repassword','email'],
		'sms'=>['phone'],
		'login' => ['username'=>"require",'password','captcha'],
		'email'=>['email']
	];
}
