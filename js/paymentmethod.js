if("undefined"==typeof jQuery)throw new Error("Payment Method's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'paymentmethod/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymentmethod_0_paymentmethodid']").val(data.paymentmethodid);
			$("input[name='paymentmethod_0_paycode']").val('');
      $("input[name='paymentmethod_0_paydays']").val('');
      $("input[name='paymentmethod_0_paymentname']").val('');
      $("input[name='paymentmethod_0_recordstatus']").prop('checked',true);
			
			$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function updatedata($id)
{
	jQuery.ajax({'url':'paymentmethod/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='paymentmethod_0_paymentmethodid']").val(data.paymentmethodid);
				$("input[name='paymentmethod_0_paycode']").val(data.paycode);
      $("input[name='paymentmethod_0_paydays']").val(data.paydays);
      $("input[name='paymentmethod_0_paymentname']").val(data.paymentname);
      if (data.recordstatus == 1)
			{
				$("input[name='paymentmethod_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='paymentmethod_0_recordstatus']").prop('checked',false)
			}
				
				$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function savedata()
{
var recordstatus = 0;
	if ($("input[name='paymentmethod_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'paymentmethod/save',
		'data':{
			'paymentmethodid':$("input[name='paymentmethod_0_paymentmethodid']").val(),
			'paycode':$("input[name='paymentmethod_0_paycode']").val(),
      'paydays':$("input[name='paymentmethod_0_paydays']").val(),
      'paymentname':$("input[name='paymentmethod_0_paymentname']").val(),
      'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}


function deletedata($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'paymentmethod/delete',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});});
	return false;
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'paymentmethod/purge','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	});
	return false;
}

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'paymentmethodid':$id,
		'paycode':$("input[name='dlg_search_paycode']").val(),
		'paymentname':$("input[name='dlg_search_paymentname']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'paymentmethodid='+$id
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&paymentname='+$("input[name='dlg_search_paymentname']").val();
	window.open('paymentmethod/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'paymentmethodid='+$id
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&paymentname='+$("input[name='dlg_search_paymentname']").val();
	window.open('paymentmethod/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'paymentmethodid='+$id
} 