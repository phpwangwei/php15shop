<?php 
namespace app\admin\validate;  //定义控制器的命名空间
use think\Validate;  // 引入命名空间类
class Type extends validate {
   protected $rule = [
		'type_name' => 'require|unique:type',
		
		
		
	];
	protected $message = [
		'type_name.require' => '商品分类名称必填',
		'type_name.unique' => '商品分类名称重复',
		
		
	];
	protected $scene = [
		'add' => ['type_name'],
		'upd' => ['type_name']
	]; 

}