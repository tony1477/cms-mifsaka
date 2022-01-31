if("undefined"==typeof jQuery)throw new Error("Payment Scale's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'paymentscaleid':$id,
		'fullname':$("input[name='fullname']").val(),
		'companyname':$("input[name='companyname']").val(),
		'docno':$("input[name='docno']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'paymentscale_0_paymentscaleid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('paymentscale/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'paymentscale_0_paymentscaleid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('paymentscale/downpdf?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'paymentscaleid='+$id;
	$.fn.yiiGridView.update("DetailpaymentscaledetList",{data:array});
	$.fn.yiiGridView.update("DetailpaymentscalecatList",{data:array});
} 