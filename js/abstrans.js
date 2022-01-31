if("undefined"==typeof jQuery)throw new Error("Absence Transaction's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'abstrans/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='abstransid']").val(data.abstransid);
			$("input[name='employeeid']").val('');
      $("input[name='datetimeclock']").val(data.datetimeclock);
      $("input[name='reason']").val('');
      $("input[name='status']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val('');
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
	jQuery.ajax({'url':'abstrans/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='abstransid']").val(data.abstransid);
				$("input[name='employeeid']").val(data.employeeid);
      $("input[name='datetimeclock']").val(data.datetimeclock);
      $("input[name='reason']").val(data.reason);
      $("input[name='status']").val(data.status);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val(data.fullname);
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
	jQuery.ajax({'url':'abstrans/save',
		'data':{
			'abstransid':$("input[name='abstransid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
      'datetimeclock':$("input[name='datetimeclock']").val(),
      'reason':$("input[name='reason']").val(),
      'status':$("input[name='status']").val(),
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

function approvedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'abstrans/approve',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'abstrans/delete',
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
	jQuery.ajax({'url':'abstrans/purge','data':{'id':$id},
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
		'abstransid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'reason':$("input[name='dlg_search_reason']").val(),
		'status':$("input[name='dlg_search_status']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'abstransid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&reason='+$("input[name='dlg_search_reason']").val()
+ '&status='+$("input[name='dlg_search_status']").val();
	window.open('abstrans/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'abstransid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&reason='+$("input[name='dlg_search_reason']").val()
+ '&status='+$("input[name='dlg_search_status']").val();
	window.open('abstrans/downxls?'+array);
}

function running(id,param2)
{
	jQuery.ajax({'url':'abstrans/install',
		'data':{
			'id':param2,
		},
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
}