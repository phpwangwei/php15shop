<?php 
namespace app\admin\validate;  //定义控制器的命名空间
use think\Validate;  // 引入命名空间类
class Order extends validate {
    protected $rule = [
		'company' => 'require',
		'number' => 'require',		
	];
	protected $message = [
		'company.require' => '请选择物流公司必填',
		'number.unique' => '运单号重复',
	];
	protected $scene = [
		'wuliu' => ['company','number']
	];

}