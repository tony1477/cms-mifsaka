if("undefined"==typeof jQuery)throw new Error("Employee Status's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'employeestatus/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeestatusid']").val(data.employeestatusid);
			
			$("input[name='employeestatusname']").val('');
      $("input[name='taxvalue']").val(data.taxvalue);
      $("input[name='recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'employeestatus/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeestatusid']").val(data.employeestatusid);
				
				$("input[name='employeestatusname']").val(data.employeestatusname);
      $("input[name='taxvalue']").val(data.taxvalue);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
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
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'employeestatus/save',
		'data':{
			
			'employeestatusid':$("input[name='employeestatusid']").val(),
			'employeestatusname':$("input[name='employeestatusname']").val(),
      'taxvalue':$("input[name='taxvalue']").val(),
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
	jQuery.ajax({'url':'employeestatus/delete',
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
	jQuery.ajax({'url':'employeestatus/purge','data':{'id':$id},
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
		'employeestatusid':$id,
		'employeestatusname':$("input[name='dlg_search_employeestatusname']").val()
	});
	return false;
}

function downpdf($id=0) {
	var array = 'employeestatusid='+$id
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val();
	window.open('employeestatus/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'employeestatusid='+$id
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val();
	window.open('employeestatus/downxls?'+array);
}