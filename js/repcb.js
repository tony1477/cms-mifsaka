if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'cbid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'cashbankno':$("input[name='dlg_search_cashbankno']").val(),
		'receiptno':$("input[name='dlg_search_receiptno']").val(),
		'headernote':$("input[name='dlg_search_headernote']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cbid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankno='+$("input[name='dlg_search_cashbankno']").val()
+ '&receiptno='+$("input[name='dlg_search_receiptno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('repcb/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cbid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankno='+$("input[name='dlg_search_cashbankno']").val()
+ '&receiptno='+$("input[name='dlg_search_receiptno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('repcb/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cbid='+$id
$.fn.yiiGridView.update("DetailcbaccList",{data:array});
$.fn.yiiGridView.update("DetailchequeList",{data:array});
$.fn.yiiGridView.update("DetailbankList",{data:array});
} 