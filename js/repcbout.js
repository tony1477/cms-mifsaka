if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'cashbankoutid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'cashbankoutno':$("input[name='dlg_search_cashbankoutno']").val(),
		'reqpayno':$("input[name='dlg_search_reqpayno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cashbankoutid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankoutno='+$("input[name='dlg_search_cashbankoutno']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('repcbout/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cashbankoutid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankoutno='+$("input[name='dlg_search_cashbankoutno']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('repcbout/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cashbankoutid='+$id
$.fn.yiiGridView.update("DetailcbapinvList",{data:array});
} 