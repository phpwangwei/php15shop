<?php 
namespace app\home\validate;  //定义控制器的命名空间
use think\Validate;  // 引入命名空间类
class Order extends validate {
   protected $rule = [
		'receiver' => 'require',
		'address' => 'require',
		'tel'=>'require',
		'zcode'=>'require'
		
	];

	protected $message = [
		'receiver.require' => '收货人必填',
		'address.unique' => '收货地址必填',
		'tel.require' => '手机号必填',
		'zcode.require' => '邮编必填'

	];
}