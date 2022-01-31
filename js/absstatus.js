if("undefined"==typeof jQuery)throw new Error("Absence Status's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'absstatus/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='absstatusid']").val(data.absstatusid);
			$("input[name='shortstat']").val('');
      $("input[name='longstat']").val('');
      $("input[name='isin']").prop('checked',true);
      $("input[name='priority']").val('');
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
	jQuery.ajax({'url':'absstatus/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='absstatusid']").val(data.absstatusid);
				$("input[name='shortstat']").val(data.shortstat);
      $("input[name='longstat']").val(data.longstat);
      if (data.isin == 1)
			{
				$("input[name='isin']").prop('checked',true);
			}
			else
			{
				$("input[name='isin']").prop('checked',false)
			}
      $("input[name='priority']").val(data.priority);
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
var isin = 0;
	if ($("input[name='isin']").prop('checked'))
	{
		isin = 1;
	}
	else
	{
		isin = 0;
	}
var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'absstatus/save',
		'data':{
			'absstatusid':$("input[name='absstatusid']").val(),
			'shortstat':$("input[name='shortstat']").val(),
      'longstat':$("input[name='longstat']").val(),
      'isin':isin,
      'priority':$("input[name='priority']").val(),
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
	jQuery.ajax({'url':'absstatus/delete',
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
	jQuery.ajax({'url':'absstatus/purge','data':{'id':$id},
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
		'absstatusid':$id,
		'shortstat':$("input[name='dlg_search_shortstat']").val(),
		'longstat':$("input[name='dlg_search_longstat']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'absstatusid='+$id
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	window.open('absstatus/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'absstatusid='+$id
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	window.open('absstatus/downxls?'+array);
}