if("undefined"==typeof jQuery)throw new Error("General Ledger's JavaScript requires jQuery");
function searchdata()
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'accountname':$("input[name='dlg_search_accountname']").val(),
		'journalno':$("input[name='dlg_search_journalno']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val()
	}});
	return false;
}

function downpdf() {
	var array = 'accountname='+$("input[name='dlg_search_accountname']").val()
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('genledger/downpdf?'+array);
}

function downxls() {
	var array = 'accountname='+$("input[name='dlg_search_accountname']").val()
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('genledger/downxls?'+array);
}