if("undefined"==typeof jQuery)throw new Error("User Dashboard's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'groupaccess/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='groupaccessid']").val(data.groupaccessid);
			$("input[name='groupname']").val('');
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
	jQuery.ajax({'url':'groupaccess/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='groupaccessid']").val(data.groupaccessid);
				$("input[name='groupname']").val(data.groupname);
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
	jQuery.ajax({'url':'groupaccess/save',
		'data':{
			'groupaccessid':$("input[name='groupaccessid']").val(),
			'groupname':$("input[name='groupname']").val(),
			'recordstatus':recordstatus
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
	jQuery.ajax({'url':'groupaccess/delete',
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
	jQuery.ajax({'url':'groupaccess/purge','data':{'id':$id},
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
		'groupaccessid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'groupaccessid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('groupaccess/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'groupaccessid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('groupaccess/downxls?'+array);
}