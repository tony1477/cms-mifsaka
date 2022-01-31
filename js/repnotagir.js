if("undefined"==typeof jQuery)throw new Error("Nota GIR Report's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'notagirid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'notagirno':$("input[name='dlg_search_notagirno']").val(),
		'gireturno':$("input[name='dlg_search_gireturno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'notagirid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagirno='+$("input[name='dlg_search_notagirno']").val()
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val();
	window.open('repnotagir/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'notagirid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagirno='+$("input[name='dlg_search_notagirno']").val()
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val();
	window.open('repnotagir/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'notagirid='+$id
$.fn.yiiGridView.update("DetailnotagirproList",{data:array});
$.fn.yiiGridView.update("DetailnotagiraccList",{data:array});
} 