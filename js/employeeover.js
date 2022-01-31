if("undefined"==typeof jQuery)throw new Error("Employee Overtime's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeoverid']").val(data.employeeoverid);
			$("input[name='actiontype']").val(0);
			$("input[name='overtimeno']").val('');
      $("input[name='overtimedate']").val(data.overtimedate);
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
			$.fn.yiiGridView.update('employeeoverdetList',{data:{'employeeoverid':data.employeeoverid}});

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
function newdataemployeeoverdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/createemployeeoverdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeoverdetid']").val('');
      $("input[name='employeeid']").val('');
      $("input[name='overtimestart']").val(data.overtimestart);
      $("input[name='overtimeend']").val(data.overtimeend);
      $("textarea[name='reason']").val('');
      $("input[name='fullname']").val('');
			$('#InputDialogemployeeoverdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeeoverid']").val(data.employeeoverid);
				$("input[name='actiontype']").val(1);
				$("input[name='overtimeno']").val(data.overtimeno);
      $("input[name='overtimedate']").val(data.overtimedate);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
				$.fn.yiiGridView.update('employeeoverdetList',{data:{'employeeoverid':data.employeeoverid}});

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
function updatedataemployeeoverdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/updateemployeeoverdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeoverdetid']").val(data.employeeoverdetid);
      $("input[name='employeeid']").val(data.employeeid);
      $("input[name='overtimestart']").val(data.overtimestart);
      $("input[name='overtimeend']").val(data.overtimeend);
      $("textarea[name='reason']").val(data.reason);
      $("input[name='fullname']").val(data.fullname);
			$('#InputDialogemployeeoverdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/save')?>',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'employeeoverid':$("input[name='employeeoverid']").val(),
			'overtimeno':$("input[name='overtimeno']").val(),
      'overtimedate':$("input[name='overtimedate']").val(),
      'headernote':$("textarea[name='headernote']").val(),
      'recordstatus':$("input[name='recordstatus']").val(),
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

function savedataemployeeoverdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/saveemployeeoverdet')?>',
		'data':{
			'employeeoverid':$("input[name='employeeoverid']").val(),
			'employeeoverdetid':$("input[name='employeeoverdetid']").val(),
      'employeeid':$("input[name='employeeid']").val(),
      'overtimestart':$("input[name='overtimestart']").val(),
      'overtimeend':$("input[name='overtimeend']").val(),
      'reason':$("textarea[name='reason']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeeoverdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeoverdetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/approve')?>',
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
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/delete')?>',
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
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/purge')?>','data':{'id':$id},
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
function purgedataemployeeoverdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('absence/employeeover/purgeemployeeoverdet')?>','data':{'id':$.fn.yiiGridView.getSelection("employeeoverdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeoverdetList");
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
		'employeeoverid':$id,
		'overtimeno':$("input[name='dlg_search_overtimeno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'employeeoverid='+$id
+ '&overtimeno='+$("input[name='dlg_search_overtimeno']").val();
	window.open('<?php echo Yii::app()->createUrl('Absence/employeeover/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'employeeoverid='+$id
+ '&overtimeno='+$("input[name='dlg_search_overtimeno']").val();
	window.open('<?php echo Yii::app()->createUrl('Absence/employeeover/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'employeeoverid='+$id
$.fn.yiiGridView.update("DetailemployeeoverdetList",{data:array});
} 