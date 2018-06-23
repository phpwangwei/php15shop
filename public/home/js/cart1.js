/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/

$(function(){
	function changeCartNum(goods_id,goods_attr_ids,goods_number,callback){
		var param={"goods_id":goods_id,"goods_attr_ids":goods_attr_ids,"goods_number":goods_number};
		$.get("/home/cart/changeCartNum",param,callback,'json');

	}
	//减少
	$(".reduce_num").click(function(){
		var _self=$(this);
		var goods_id=_self.parent().attr('goods_id');
        var goods_attr_ids=_self.parent().attr('goods_attr_ids');
        var amountEle = _self.parent().find(".amount");
		var amount =parseInt( _self.parent().find(".amount").val());
		if (amount<= 1){
			alert("商品数量最少为1");
			return false;
		}
		var reduce=amount-1; 
		var param={"goods_id":goods_id,"goods_attr_ids":goods_attr_ids,"goods_number":reduce};
		changeCartNum(goods_id,goods_attr_ids,reduce,function(json){
			if(json.code==200){
				amountEle.val(reduce);
				var subtotal = parseFloat(_self.parent().parent().find(".col3 span").text()) * parseInt(reduce);
				_self.parent().parent().find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}

		});
			
	});

	//增加
	$(".add_num").click(function(){
		var _self=$(this);
		var goods_id=$(this).parent().attr('goods_id');
        var goods_attr_ids=$(this).parent().attr('goods_attr_ids');
        var amountEle = $(this).parent().find(".amount");
		var amount = parseInt($(this).parent().find(".amount").val());
		var add=amount+1;
		var param={"goods_id":goods_id,"goods_attr_ids":goods_attr_ids,"goods_number":add};
		changeCartNum(goods_id,goods_attr_ids,add,function(json){
			if(json.code==200){
				amountEle.val(add);
				var subtotal = parseFloat(_self.parent().parent().find(".col3 span").text()) * parseInt(add);
				_self.parent().parent().find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}
		}); 
	});

	//直接输入
	$(".amount").blur(function(){
		var _self=$(this);
		var goods_id=$(this).parent().attr('goods_id');
        var goods_attr_ids=$(this).parent().attr('goods_attr_ids');
        var amountEle = $(this).parent().find(".amount");
		var amount = amountEle.val();
		var reg=/^\d+$/;
		if(!reg.test(amount)){
			alert('数量格式不合法');
			_self.val(_self.attr('ori_amount'));
			return false;
		}
		if (amount < 1){
			alert("商品数量最少为1");
			amountEle.val(1);
		}
		var param={"goods_id":goods_id,"goods_attr_ids":goods_attr_ids,"goods_number":amount};
		changeCartNum(goods_id,goods_attr_ids,amount,function(json){
			if(json.code==200){
				var subtotal = parseFloat(_self.parent().parent().find(".col3 span").text()) * parseInt(amount);
				_self.parent().parent().find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}
		});
		
	});
	$(".amount").focus(function(){
		$(this).attr('ori_amount',$(this).val());
	});
});