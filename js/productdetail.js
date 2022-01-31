if("undefined"==typeof jQuery)throw new Error("Product Detail's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'productdetailid':$id,
		'materialcode':$("input[name='dlg_search_materialcode']").val(),
		'productname':$("input[name='dlg_search_productname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'storagedesc':$("input[name='dlg_search_storagedesc']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val(),
		'location':$("input[name='dlg_search_location']").val(),
		'referenceno':$("input[name='dlg_search_referenceno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productdetailid='+$id
+ '&materialcode='+$("input[name='dlg_search_materialcode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&storagedesc='+$("input[name='dlg_search_storagedesc']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&location='+$("input[name='dlg_search_location']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('productdetail/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productdetailid='+$id
+ '&materialcode='+$("input[name='dlg_search_materialcode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&storagedesc='+$("input[name='dlg_search_storagedesc']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&location='+$("input[name='dlg_search_location']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('productdetail/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productdetailid='+$id
$.fn.yiiGridView.update("DetailproductdetailhistList",{data:array});
} 