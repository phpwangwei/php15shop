<?php 
namespace app\admin\validate;
use think\Validate;  
class Goods extends Validate {
   protected $rule = [
		'goods_name' => 'require|unique:Goods',
		'goods_price' => 'require',
		'goods_number' => 'require|regex:\d+',
		'cat_id' => 'require'
		
	];
	protected $message = [
		'goods_name.require' => '商品名称必填',
		'goods_name.unique' => '商品名称重复',
		'goods_price.require' => '价格必填',
		'goods_number.require' => '商品库存必填',
		'goods_number.regex' => '商品库存数量大于0',
		'cat_id.require' => '请选择一个商品分类'
	];
	protected $scene = [
		'add' => ['goods_name','goods_price','goods_number','cat_id'],
		
	]; 

}