if("undefined"==typeof jQuery)throw new Error("Sales Target's JavaScript requires jQuery");

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'salestargetid':$id,
		'fullname':$("input[name='fullname']").val(),
		'companyname':$("input[name='companyname']").val(),
		'docno':$("input[name='docno']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'salestargetid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('salestarget/downpdf?'+array);
}
function downpdfrekap($id=0) {
	var array = 'salestargetid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('repsalestarget/downpdfrekap?'+array);
}
function downxlsrekap($id=0) {
	var array = 'salestargetid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('repsalestarget/downxlsrekap?'+array);
}
function downxls($id=0) {
	var array = 'salestargetid='+$id
	+ '&fullname='+$("input[name='fullname']").val()
	+ '&companyname='+$("input[name='companyname']").val()
	+ '&docno='+$("input[name='docno']").val();
	window.open('salestarget/downpdf?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salestargetid='+$id;
	$.fn.yiiGridView.update("DetailsalestargetdetList",{data:array});
} 