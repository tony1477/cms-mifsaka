if("undefined"==typeof jQuery)throw new Error("Jobs's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'jobs/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='jobsid']").val(data.jobsid);
			
			$("input[name='orgstructureid']").val('');
      $("textarea[name='jobdesc']").val('');
      $("textarea[name='qualification']").val('');
      $("input[name='positionid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='structurename']").val('');
      $("input[name='positionname']").val('');
			
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
	jQuery.ajax({'url':'jobs/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='jobsid']").val(data.jobsid);
				
				$("input[name='orgstructureid']").val(data.orgstructureid);
      $("textarea[name='jobdesc']").val(data.jobdesc);
      $("textarea[name='qualification']").val(data.qualification);
      $("input[name='positionid']").val(data.positionid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='structurename']").val(data.structurename);
      $("input[name='positionname']").val(data.positionname);
				
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
	jQuery.ajax({'url':'jobs/save',
		'data':{
			
			'jobsid':$("input[name='jobsid']").val(),
			'orgstructureid':$("input[name='orgstructureid']").val(),
      'jobdesc':$("textarea[name='jobdesc']").val(),
      'qualification':$("textarea[name='qualification']").val(),
      'positionid':$("input[name='positionid']").val(),
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
	jQuery.ajax({'url':'jobs/delete',
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
	jQuery.ajax({'url':'jobs/purge','data':{'id':$id},
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
		'jobsid':$id,
		'structurename':$("input[name='dlg_search_structurename']").val(),
		'positionname':$("input[name='dlg_search_positionname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'jobsid='+$id
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&positionname='+$("input[name='dlg_search_positionname']").val();
	window.open('jobs/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'jobsid='+$id
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&positionname='+$("input[name='dlg_search_positionname']").val();
	window.open('jobs/downxls?'+array);
}