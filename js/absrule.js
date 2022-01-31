if("undefined"==typeof jQuery)throw new Error("Absence Rule's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'absrule/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='absruleid']").val(data.absruleid);
			$("input[name='absscheduleid']").val('');
      $("input[name='difftimein']").val('');
      $("input[name='difftimeout']").val('');
      $("input[name='absstatusid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='absschedulename']").val('');
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
	jQuery.ajax({'url':'absrule/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='absruleid']").val(data.absruleid);
				$("input[name='absscheduleid']").val(data.absscheduleid);
      $("input[name='difftimein']").val(data.difftimein);
      $("input[name='difftimeout']").val(data.difftimeout);
      $("input[name='absstatusid']").val(data.absstatusid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='absschedulename']").val(data.absschedulename);
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
	jQuery.ajax({'url':'absrule/save')?>',
		'data':{
			'absruleid':$("input[name='absruleid']").val(),
			'absscheduleid':$("input[name='absscheduleid']").val(),
      'difftimein':$("input[name='difftimein']").val(),
      'difftimeout':$("input[name='difftimeout']").val(),
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
	$.msg.confirmation('Confirm','Are you sure ?')?>',function(){	
	jQuery.ajax({'url':'absrule/delete')?>',
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
	$.msg.confirmation('Confirm','Are you sure ?')?>',function(){
	jQuery.ajax({'url':'absrule/purge')?>','data':{'id':$id},
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
		'absruleid':$id,
		'absschedulename':$("input[name='dlg_search_absschedulename']").val(),
		'difftimein':$("input[name='dlg_search_difftimein']").val(),
		'difftimeout':$("input[name='dlg_search_difftimeout']").val(),
		'shortstat':$("input[name='dlg_search_shortstat']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'absruleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val()
+ '&difftimein='+$("input[name='dlg_search_difftimein']").val()
+ '&difftimeout='+$("input[name='dlg_search_difftimeout']").val()
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val();
	window.open('absrule/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'absruleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val()
+ '&difftimein='+$("input[name='dlg_search_difftimein']").val()
+ '&difftimeout='+$("input[name='dlg_search_difftimeout']").val()
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val();
	window.open('absrule/downxls')?>?'+array);
}