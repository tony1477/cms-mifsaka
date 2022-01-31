if("undefined"==typeof jQuery)throw new Error("Production Output Report's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'productoutputid':$id,
		'productoutputno':$("input[name='dlg_search_productoutputno']").val(),
		'companyname':$("input[name='dlg_search_company']").val(),
		'productplanno':$("input[name='dlg_search_productplanno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productoutputid='+$id
+ '&productoutputno='+$("input[name='dlg_search_productoutputno']").val()
+ '&companyname='+$("input[name='dlg_search_company']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('reportprodout/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productoutputid='+$id
+ '&productoutputno='+$("input[name='dlg_search_productoutputno']").val()
+ '&companyname='+$("input[name='dlg_search_company']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('reportprodout/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productoutputid='+$id
$.fn.yiiGridView.update("DetailproductoutputfgList",{data:array});
$.fn.yiiGridView.update("DetailproductoutputdetailList",{data:array});
} 