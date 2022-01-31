if("undefined"==typeof jQuery)throw new Error("Workflow Status's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'wfstatus/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='wfstatusid']").val(data.wfstatusid);
				$("input[name='workflowid']").val('');
			    $("input[name='wfstat']").val('');
			    $("input[name='wfstatusname']").val('');
			    $("input[name='wfdesc']").val('');
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
	jQuery.ajax({'url':'wfstatus/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='wfstatusid']").val(data.wfstatusid);
				$("input[name='workflowid']").val(data.workflowid);
			    $("input[name='wfstat']").val(data.wfstat);
			    $("input[name='wfstatusname']").val(data.wfstatusname);      							
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
	jQuery.ajax({'url':'wfstatus/save',
		'data':{
			'wfstatusid':$("input[name='wfstatusid']").val(),
			'workflowid':$("input[name='workflowid']").val(),
		    'wfstat':$("input[name='wfstat']").val(),
		    'wfstatusname':$("input[name='wfstatusname']").val(),
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

function purgedata($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'wfstatus/purge','data':{'id':$id},
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
		'wfstatusid':$id,
		'wfdesc':$("input[name='dlg_search_wfdesc']").val(),
		'wfstat':$("input[name='dlg_search_wfstat']").val(),
		'wfstatusname':$("input[name='dlg_search_wfstatusname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'wfstatusid='+$id
	+ '&wfdesc='+$("input[name='dlg_search_wfdesc']").val()
	+ '&wfstat='+$("input[name='dlg_search_wfstat']").val()
	+ '&wfstatusname='+$("input[name='dlg_search_wfstatusname']").val();
	window.open('wfstatus/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'wfstatusid='+$id
	+ '&wfdesc='+$("input[name='dlg_search_wfdesc']").val()
	+ '&wfstat='+$("input[name='dlg_search_wfstat']").val()
	+ '&wfstatusname='+$("input[name='dlg_search_wfstatusname']").val();
	window.open('wfstatus/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'wfstatusid='+$id
} 