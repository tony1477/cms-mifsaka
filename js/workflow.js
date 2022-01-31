if("undefined"==typeof jQuery)throw new Error("Workflow's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'workflow/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='workflowid']").val(data.workflowid);
			$("input[name='wfname']").val('');
      $("input[name='wfdesc']").val('');
      $("input[name='wfminstat']").val('');
      $("input[name='wfmaxstat']").val('');
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
	jQuery.ajax({'url':'workflow/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='workflowid']").val(data.workflowid);
				$("input[name='wfname']").val(data.wfname);
      $("input[name='wfdesc']").val(data.wfdesc);
      $("input[name='wfminstat']").val(data.wfminstat);
      $("input[name='wfmaxstat']").val(data.wfmaxstat);
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
	jQuery.ajax({'url':'workflow/save',
		'data':{
			'workflowid':$("input[name='workflowid']").val(),
			'wfname':$("input[name='wfname']").val(),
      'wfdesc':$("input[name='wfdesc']").val(),
      'wfminstat':$("input[name='wfminstat']").val(),
      'wfmaxstat':$("input[name='wfmaxstat']").val(),
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
	jQuery.ajax({'url':'workflow/delete',
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
	jQuery.ajax({'url':'workflow/purge','data':{'id':$id},
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
		'workflowid':$id,
		'wfname':$("input[name='dlg_search_wfname']").val(),
		'wfdesc':$("input[name='dlg_search_wfdesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'workflowid='+$id
+ '&wfname='+$("input[name='dlg_search_wfname']").val()
+ '&wfdesc='+$("input[name='dlg_search_wfdesc']").val();
	window.open('workflow/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'workflowid='+$id
+ '&wfname='+$("input[name='dlg_search_wfname']").val()
+ '&wfdesc='+$("input[name='dlg_search_wfdesc']").val();
	window.open('workflow/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'workflowid='+$id
} 