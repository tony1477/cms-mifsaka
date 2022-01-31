if("undefined"==typeof jQuery)throw new Error("User Group's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'usergroup/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='usergroupid']").val(data.usergroupid);
			$("input[name='useraccessid']").val('');
      $("input[name='groupaccessid']").val('');
      $("input[name='username']").val('');
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
	jQuery.ajax({'url':'usergroup/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='usergroupid']").val(data.usergroupid);
				$("input[name='useraccessid']").val(data.useraccessid);
      $("input[name='groupaccessid']").val(data.groupaccessid);
      $("input[name='username']").val(data.username);
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
	jQuery.ajax({'url':'usergroup/save',
		'data':{
			'usergroupid':$("input[name='usergroupid']").val(),
			'useraccessid':$("input[name='useraccessid']").val(),
      'groupaccessid':$("input[name='groupaccessid']").val(),
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
	jQuery.ajax({'url':'usergroup/delete',
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
	jQuery.ajax({'url':'usergroup/purge','data':{'id':$id},
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
		'usergroupid':$id,
		'username':$("input[name='dlg_search_username']").val(),
		'groupname':$("input[name='dlg_search_groupname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'usergroupid='+$id
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('usergroup/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'usergroupid='+$id
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('usergroup/downxls?'+array);
}