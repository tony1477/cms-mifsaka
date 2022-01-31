if("undefined"==typeof jQuery)throw new Error("Workflow Group's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'wfgroup/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='wfgroupid']").val(data.wfgroupid);
			$("input[name='workflowid']").val('');
			$("input[name='groupaccessid']").val('');
			$("input[name='wfbefstat']").val('');
			$("input[name='wfrecstat']").val('');
			$("input[name='wfdesc']").val('');
			$("input[name='groupname']").val('');
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
	jQuery.ajax({'url':'wfgroup/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='wfgroupid']").val(data.wfgroupid);
				$("input[name='workflowid']").val(data.workflowid);
				$("input[name='groupaccessid']").val(data.groupaccessid);
				$("input[name='wfbefstat']").val(data.wfbefstat);
				$("input[name='wfrecstat']").val(data.wfrecstat);
			    $("input[name='wfdesc']").val(data.wfdesc);
			    $("input[name='groupname']").val(data.groupname);
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
	
	jQuery.ajax({'url':'wfgroup/save',
		'data':{
			
			'wfgroupid':$("input[name='wfgroupid']").val(),
			'workflowid':$("input[name='workflowid']").val(),
			'groupaccessid':$("input[name='groupaccessid']").val(),
			'wfbefstat':$("input[name='wfbefstat']").val(),
			'wfrecstat':$("input[name='wfrecstat']").val(),

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
	jQuery.ajax({'url':'wfgroup/purge','data':{'id':$id},
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
		'wfgroupid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val(),
		'wfdesc':$("input[name='dlg_search_wfdesc']").val(),
		'wfbefstat':$("input[name='dlg_search_wfbefstat']").val(),
		'wfrecstat':$("input[name='dlg_search_wfrecstat']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'wfgroupid='+$id
+ '&wfdesc='+$("input[name='dlg_search_wfdesc']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&wfbefstat='+$("input[name='dlg_search_groupname']").val()
+ '&wfrecstat='+$("input[name='dlg_search_wfrecstat']").val();
	window.open('wfgroup/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'wfgroupid='+$id
+ '&wfdesc='+$("input[name='dlg_search_wfdesc']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&wfbefstat='+$("input[name='dlg_search_groupname']").val()
+ '&wfrecstat='+$("input[name='dlg_search_wfrecstat']").val();
	window.open('wfgroup/downxls?'+array);
}