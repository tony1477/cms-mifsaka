if("undefined"==typeof jQuery)throw new Error("Employee Benefit's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'employeebenefit/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeebenefitid']").val(data.employeebenefitid);
			$("input[name='actiontype']").val(0);
			$("input[name='employeeid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='fullname']").val('');
			$.fn.yiiGridView.update('employeebenefitdetailList',{data:{'employeebenefitid':data.employeebenefitid}});

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
function newdataemployeebenefitdetail()
{
	jQuery.ajax({'url':'employeebenefit/createemployeebenefitdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeebenefitdetailid']").val('');
      $("input[name='wagetypeid']").val('');
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='ratevalue']").val(data.ratevalue);
      $("input[name='isfinal']").prop('checked',true);
      $("input[name='reason']").val('');
      $("input[name='wagename']").val('');
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogemployeebenefitdetail').modal();
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
	jQuery.ajax({'url':'employeebenefit/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeebenefitid']").val(data.employeebenefitid);
				$("input[name='actiontype']").val(1);
				$("input[name='employeeid']").val(data.employeeid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='fullname']").val(data.fullname);
				$.fn.yiiGridView.update('employeebenefitdetailList',{data:{'employeebenefitid':data.employeebenefitid}});

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
function updatedataemployeebenefitdetail($id)
{
	jQuery.ajax({'url':'employeebenefit/updateemployeebenefitdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeebenefitdetailid']").val(data.employeebenefitdetailid);
      $("input[name='wagetypeid']").val(data.wagetypeid);
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='ratevalue']").val(data.ratevalue);
      if (data.isfinal == 1)
			{
				$("input[name='isfinal']").prop('checked',true);
			}
			else
			{
				$("input[name='isfinal']").prop('checked',false)
			}
      $("input[name='reason']").val(data.reason);
      $("input[name='wagename']").val(data.wagename);
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogemployeebenefitdetail').modal();
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
	jQuery.ajax({'url':'employeebenefit/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'employeebenefitid':$("input[name='employeebenefitid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
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

function savedataemployeebenefitdetail()
{
var isfinal = 0;
	if ($("input[name='isfinal']").prop('checked'))
	{
		isfinal = 1;
	}
	else
	{
		isfinal = 0;
	}
	jQuery.ajax({'url':'employeebenefit/saveemployeebenefitdetail',
		'data':{
			'employeebenefitid':$("input[name='employeebenefitid']").val(),
			'employeebenefitdetailid':$("input[name='employeebenefitdetailid']").val(),
      'wagetypeid':$("input[name='wagetypeid']").val(),
      'startdate':$("input[name='startdate']").val(),
      'enddate':$("input[name='enddate']").val(),
      'amount':$("input[name='amount']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'ratevalue':$("input[name='ratevalue']").val(),
      'isfinal':isfinal,
      'reason':$("input[name='reason']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeebenefitdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeebenefitdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}



function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'employeebenefit/purge','data':{'id':$id},
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
function purgedataemployeebenefitdetail()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'employeebenefit/purgeemployeebenefitdetail','data':{'id':$.fn.yiiGridView.getSelection("employeebenefitdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeebenefitdetailList");
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
		'employeebenefitid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'employeebenefitid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('employeebenefit/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'employeebenefitid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('employeebenefit/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'employeebenefitid='+$id
$.fn.yiiGridView.update("DetailemployeebenefitdetailList",{data:array});
} 