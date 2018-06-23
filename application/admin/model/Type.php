<?php 
namespace app\admin\Model;  //定义模型的命名空间  
use think\Model;  // 引入核心模型命名空间
class Type extends Model {
  	protected $pk='type_id';
  	protected $autoWriteTimestamp = true;  

}