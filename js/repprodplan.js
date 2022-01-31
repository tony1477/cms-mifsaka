if("undefined"==typeof jQuery)throw new Error("Production Planning Report's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'productplanid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'productplanid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('repprodplan/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productplanid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('repprodplan/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productplanid='+$id
$.fn.yiiGridView.update("DetailproductplanfgList",{data:array});
$.fn.yiiGridView.update("DetailproductplandetailList",{data:array});
} 