if("undefined"==typeof jQuery)throw new Error("TTNT Report's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'docdate':$("input[name='dlg_search_docdate']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'description':$("input[name='dlg_search_description']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'ttntid='+$id
	+ '&docdate='+$("input[name='dlg_search_docdate']").val()
	+ '&companyname='+$("input[name='dlg_search_companyname']").val()
	+ '&description='+$("input[name='dlg_search_description']").val()
	+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('repttnt/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'ttntid='+$id
	+ '&fullname='+$("input[name='dlg_search_fullname']").val()
	+ '&companyname='+$("input[name='dlg_search_companyname']").val()
	+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('repttnt/downxls?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'ttntid='+$id;
	$.fn.yiiGridView.update("DetailTtntdetailList",{data:array});
} 