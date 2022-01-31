if("undefined"==typeof jQuery)throw new Error("Purchase Order Report's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'poheaderid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'pono':$("input[name='dlg_search_pono']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'paycode':$("input[name='dlg_search_paycode']").val(),
		'taxcode':$("input[name='dlg_search_taxcode']").val(),
		'headernote':$("input[name='dlg_search_headernote']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'poheaderid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('reportpurchaseorder/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'poheaderid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('reportpurchaseorder/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'poheaderid='+$id
$.fn.yiiGridView.update("DetailpodetailList",{data:array});
} 