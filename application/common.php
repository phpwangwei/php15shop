<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
error_reporting(E_ERROR | E_WARNING | E_PARSE);

function sendSms($to,$datas,$tempId){
	include_once("../extend/sendSms/CCPRestSmsSDK.php");	
	$accountSid= '8a216da863cde6f90163f29d507d0ff7';
	//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
	$accountToken= '0dc3d6180798466da1834d684addd7a8';
	//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
	//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
	$appId='8a216da863cde6f90163f29d50df0ffe';
	//请求地址
	//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
	//生产环境（用户应用上线使用）：app.cloopen.com
	$serverIP='app.cloopen.com';
	//请求端口，生产环境和沙盒环境一致
	$serverPort='8883';
	//REST版本号，在官网文档REST介绍中获得。
	$softVersion='2013-12-26';
	$rest = new REST($serverIP,$serverPort,$softVersion);
	$rest->setAccount($accountSid,$accountToken);
	$rest->setAppId($appId);
	$result = $rest->sendTemplateSMS($to,$datas,$tempId);
	return json($result);	
}

function sendEmail($to,$title,$content){
	include "../extend/sendEmail/class.phpmailer.php";
	$pm = new PHPMailer();

	// 服务器相关信息
	$pm->Host = 'smtp.163.com'; // SMTP服务器 从163邮箱网站中获取
	$pm->IsSMTP(); // 设置使用SMTP服务器发送邮件
	$pm->SMTPAuth = true; // 需要SMTP身份认证
	$pm->Username = '16621072096'; // （邮箱@前面的一部分）登录SMTP服务器的用户名
	$pm->Password = 'ww123456'; //授权码 登录SMTP服务器的密码

	// 发件人信息
	$pm->From = '16621072096@163.com';   //注册时候的邮箱
	$pm->FromName = 'GOD伟';  //当前邮箱用户的别名

	// 收件人信息
	$pm->AddAddress($to); // 添加一个收件人 别名为玮哥222
	//$pm->AddAddress('wangwei2@itcast.cn', 'wangwei2'); // 添加另一个收件人

	$pm->IsHTML(true); //支持富文本html
	$pm->CharSet = 'utf-8'; // 内容编码
	$pm->Subject = $title; // 邮件标题
	$pm->MsgHTML($content); // 邮件内容
	// halt($pm->send());
	// 发送邮件
	if($pm->Send()){
	   return true;
	}else {
	   return false;
	}
}

