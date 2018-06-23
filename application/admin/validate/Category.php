<?php 
namespace app\admin\validate;
use think\Validate;  
class Category extends Validate {
   	protected $rule = [
		'cat_name' => 'require|unique:Category',
		'pid' => 'require',
	];
	protected $message = [
		'cat_name.require' => '栏目名必填',
		'cat_name.unique' => '栏目名名称重复',
		'pid.require' => '必须选择父分类',
		
	];
	protected $scene = [
		'add' => ['cat_name','pid'],
		'upd' => ['cat_name','pid'],
		
	]; 

}