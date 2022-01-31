if("undefined"==typeof jQuery)throw new Error("AR Cut Report's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'cutarid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'cutarno':$("input[name='dlg_search_cutarno']").val(),
		'docno':$("input[name='dlg_search_docno']").val(),
		'cbinno':$("input[name='dlg_search_cbinno']").val(),
		'headernote':$("input[name='dlg_search_headernote']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cutarid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cutarno='+$("input[name='dlg_search_cutarno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('repcutar/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cutarid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cutarno='+$("input[name='dlg_search_cutarno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('repcutar/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cutarid='+$id
$.fn.yiiGridView.update("DetailcutarinvList",{data:array});
}