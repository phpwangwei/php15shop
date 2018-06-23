<?php 
namespace app\home\model;  //定义模型的命名空间  
use think\Model;  // 引入核心模型命名空间
class Category extends Model {
    protected $pk='cat_id';
  	protected $autoWriteTimestamp = true;
  	public function getFamilyCats($cat_id){
  		$cats=$this->select()->toArray();
  		return $this->_getFamilyCats($cats,$cat_id);
  			
  	}
  	private function _getFamilyCats($cats,$cat_id){
  		static $result=[];
  		foreach ($cats as $k=>$cat){
  			if ($cat['cat_id'] ==$cat_id){
  				$result[]=$cat;
  				unset($cats[$k]);
  				$this->_getFamilyCats($cats,$cat['pid']);
  			}
  		}
  		return array_reverse($result);
  	}
    public function getSonsCatId($cat_id){
    $cats = $this->select()->toArray();
    return $this->_getSonsCatId($cats,$cat_id);
    }

  private function _getSonsCatId($cats,$cat_id){
    static $sonids = []; //存储子孙分类的cat_id即可
    foreach($cats as $k=>$cat){
      if($cat['pid'] == $cat_id){
        $sonids[] = $cat['cat_id'];
        //移除遍历过的元素
        unset($cats[$k]);
        $this->_getSonsCatId($cats,$cat['cat_id']);
      }
    }
    return $sonids;
  }
}