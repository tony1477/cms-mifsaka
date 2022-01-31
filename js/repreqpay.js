if("undefined"==typeof jQuery)throw new Error("Request Payment Report's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'reqpayid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'reqpayno':$("input[name='dlg_search_reqpayno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'reqpayid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('repreqpay/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'reqpayid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('repreqpay/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'reqpayid='+$id
$.fn.yiiGridView.update("DetailreqpayinvList",{data:array});
} 