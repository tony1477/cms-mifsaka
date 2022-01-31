if("undefined"==typeof jQuery)throw new Error("Product Stock's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'productstockid':$id,
		'productname':$("input[name='dlg_search_productname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'storagebindesc':$("input[name='dlg_search_storagebindesc']").val(),
		'materialgroupcode':$("input[name='dlg_search_materialgroupcode']").val(),
		'materialgroupname':$("input[name='dlg_search_materialgroupname']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&storagebindesc='+$("input[name='dlg_search_storagebindesc']").val()
+ '&materialgroupcode='+$("input[name='dlg_search_materialgroupcode']").val()
+ '&materialgroupname='+$("input[name='dlg_search_materialgroupname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('productstock/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&storagebindesc='+$("input[name='dlg_search_storagebindesc']").val()
+ '&materialgroupcode='+$("input[name='dlg_search_materialgroupcode']").val()
+ '&materialgroupname='+$("input[name='dlg_search_materialgroupname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('productstock/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productstockid='+$id
$.fn.yiiGridView.update("DetailproductstockdetList",{data:array});
} 