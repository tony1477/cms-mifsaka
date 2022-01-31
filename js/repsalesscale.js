if("undefined"==typeof jQuery)throw new Error("Sales Scale's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'salesscale':$id,
		'companyname':$("input[name='companyname']").val(),
		'docno':$("input[name='docno']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'salesscale_0_salesscaleid='+$id	
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('salesscale/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'salesscale_0_salesscaleid='+$id
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('salesscale/downpdf?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salesscaleid='+$id;
	$.fn.yiiGridView.update("DetailsalesscaledetList",{data:array});
	$.fn.yiiGridView.update("DetailsalesscalecatList",{data:array});
} 