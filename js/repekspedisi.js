if("undefined"==typeof jQuery)throw new Error("Ekspedisi Report's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'ekspedisiid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'ekspedisino':$("input[name='dlg_search_ekspedisino']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'ekspedisiid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&ekspedisino='+$("input[name='dlg_search_ekspedisino']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('repekspedisi/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'ekspedisiid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&ekspedisino='+$("input[name='dlg_search_ekspedisino']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('repekspedisi/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'ekspedisiid='+$id
$.fn.yiiGridView.update("DetailekspedisipoList",{data:array});
$.fn.yiiGridView.update("DetaileksmatList",{data:array});
} 