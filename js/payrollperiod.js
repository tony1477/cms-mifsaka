if("undefined"==typeof jQuery)throw new Error("Payroll Period's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'payrollperiod/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='payrollperiodid']").val(data.payrollperiodid);
			
			$("input[name='payrollperiodname']").val('');
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='parentperiodid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='payrollparentname']").val('');
			
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
	jQuery.ajax({'url':'payrollperiod/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='payrollperiodid']").val(data.payrollperiodid);
				
				$("input[name='payrollperiodname']").val(data.payrollperiodname);
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='parentperiodid']").val(data.parentperiodid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='payrollparentname']").val(data.payrollparentname);
				
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
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'payrollperiod/save',
		'data':{
			
			'payrollperiodid':$("input[name='payrollperiodid']").val(),
			'payrollperiodname':$("input[name='payrollperiodname']").val(),
      'startdate':$("input[name='startdate']").val(),
      'enddate':$("input[name='enddate']").val(),
      'parentperiodid':$("input[name='parentperiodid']").val(),
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'payrollperiod/delete',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'payrollperiod/purge','data':{'id':$id},
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
		'payrollperiodid':$id,
		'payrollperiodname':$("input[name='dlg_search_payrollperiodname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'payrollperiodid='+$id
+ '&payrollperiodname='+$("input[name='dlg_search_payrollperiodname']").val()
+ '&payrollperiodname='+$("input[name='dlg_search_payrollperiodname']").val();
	window.open('payrollperiod/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'payrollperiodid='+$id
+ '&payrollperiodname='+$("input[name='dlg_search_payrollperiodname']").val()
+ '&payrollperiodname='+$("input[name='dlg_search_payrollperiodname']").val();
	window.open('payrollperiod/downxls?'+array);
}