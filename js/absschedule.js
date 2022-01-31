if("undefined"==typeof jQuery)throw new Error("Absence Schedule's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'absschedule/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='absscheduleid']").val(data.absscheduleid);
			$("input[name='absschedulename']").val('');
      $("input[name='absin']").val('');
      $("input[name='absout']").val('');
      $("input[name='absstatusid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='shortstat']").val('');
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
	jQuery.ajax({'url':'absschedule/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='absscheduleid']").val(data.absscheduleid);
				$("input[name='absschedulename']").val(data.absschedulename);
      $("input[name='absin']").val(data.absin);
      $("input[name='absout']").val(data.absout);
      $("input[name='absstatusid']").val(data.absstatusid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='shortstat']").val(data.shortstat);
				
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
	jQuery.ajax({'url':'absschedule/save',
		'data':{
			
			'absscheduleid':$("input[name='absscheduleid']").val(),
			'absschedulename':$("input[name='absschedulename']").val(),
      'absin':$("input[name='absin']").val(),
      'absout':$("input[name='absout']").val(),
      'absstatusid':$("input[name='absstatusid']").val(),
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
	jQuery.ajax({'url':'absschedule/delete',
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
	jQuery.ajax({'url':'absschedule/purge','data':{'id':$id},
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
		'absscheduleid':$id,
		'absschedulename':$("input[name='dlg_search_absschedulename']").val(),
		'absin':$("input[name='dlg_search_absin']").val(),
		'absout':$("input[name='dlg_search_absout']").val(),
		'shortstat':$("input[name='dlg_search_shortstat']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'absscheduleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val()
+ '&absin='+$("input[name='dlg_search_absin']").val()
+ '&absout='+$("input[name='dlg_search_absout']").val()
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val();
	window.open('absschedule/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'absscheduleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val()
+ '&absin='+$("input[name='dlg_search_absin']").val()
+ '&absout='+$("input[name='dlg_search_absout']").val()
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val();
	window.open('absschedule/downxls?'+array);
}