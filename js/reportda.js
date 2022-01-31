if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'deliveryadviceid':$id,
		'dano':$("input[name='dlg_search_dano']").val(),
		'username':$("input[name='dlg_search_username']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('reportda/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('reportda/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'deliveryadviceid='+$id
$.fn.yiiGridView.update("DetaildeliveryadvicedetailList",{data:array});
} 