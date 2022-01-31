if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'invoiceapid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'invoiceno':$("input[name='dlg_search_invoiceno']").val(),
		'pono':$("input[name='dlg_search_pono']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'taxcode':$("input[name='dlg_search_taxcode']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&currencyrate='+$("input[name='dlg_search_currencyrate']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	window.open('repinvap/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&currencyrate='+$("input[name='dlg_search_currencyrate']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	window.open('repinvap/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'invoiceapid='+$id
$.fn.yiiGridView.update("DetailinvoiceapmatList",{data:array});
$.fn.yiiGridView.update("DetailinvoiceapjurnalList",{data:array});
} 