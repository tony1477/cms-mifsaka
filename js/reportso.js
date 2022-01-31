if("undefined"==typeof jQuery)throw new Error("Sales Order's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'soheaderid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'salesname':$("input[name='dlg_search_salesname']").val(),
		'pocustno':$("input[name='dlg_search_pocustno']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'soheaderid='+$id
	+ '&fullname='+$("input[name='dlg_search_fullname']").val()
	+ '&companyname='+$("input[name='dlg_search_companyname']").val()
	+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	window.open('reportso/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'soheaderid='+$id
	+ '&fullname='+$("input[name='dlg_search_fullname']").val()
	+ '&companyname='+$("input[name='dlg_search_companyname']").val()
	+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	window.open('reportso/downxls?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'soheaderid='+$id;
	$.fn.yiiGridView.update("DetailSodetailList",{data:array});
	$.fn.yiiGridView.update("DetailSodiscList",{data:array});
} 