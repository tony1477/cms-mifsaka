if("undefined"==typeof jQuery)throw new Error("Payment Target's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'paymenttargetid':$id,
		'fullname':$("input[name='fullname']").val(),
		'companyname':$("input[name='companyname']").val(),
		'docno':$("input[name='docno']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'paymenttarget_0_paymenttargetid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('paymenttarget/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'paymenttarget_0_paymenttargetid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('paymenttarget/downpdf?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'paymenttargetid='+$id;
	$.fn.yiiGridView.update("DetailpaymenttargetdetList",{data:array});
	$.fn.yiiGridView.update("DetailpaymenttargetcatList",{data:array});
} 