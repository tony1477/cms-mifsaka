if("undefined"==typeof jQuery)throw new Error("Nota Retur Penjualan Report's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'notagrreturid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'notagrreturno':$("input[name='dlg_search_notagrreturno']").val(),
		'grreturno':$("input[name='dlg_search_grreturno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'notagrreturid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagrreturno='+$("input[name='dlg_search_notagrreturno']").val()
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val();
	window.open('repnotagrr/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'notagrreturid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagrreturno='+$("input[name='dlg_search_notagrreturno']").val()
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val();
	window.open('repnotagrr/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'notagrreturid='+$id
$.fn.yiiGridView.update("DetailnotagrrproList",{data:array});
$.fn.yiiGridView.update("DetailnotagrraccList",{data:array});
} 