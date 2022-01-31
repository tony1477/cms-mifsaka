if("undefined"==typeof jQuery)throw new Error("Cash/Bank In Report's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'cbinid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'cbinno':$("input[name='dlg_search_cbinno']").val(),
		'docno':$("input[name='dlg_search_docno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cbinid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	window.open('repcbin/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cbinid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	window.open('repcbin/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cbinid='+$id
$.fn.yiiGridView.update("DetailcbinjournalList",{data:array});
} 