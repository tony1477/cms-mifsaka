if("undefined"==typeof jQuery)throw new Error("Group Menu's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'groupmenu/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='groupmenuid']").val(data.groupmenuid);
			$("input[name='groupname']").val('');
			$("input[name='description']").val('');
      		$("input[name='isread']").prop('checked',true);
      		$("input[name='iswrite']").prop('checked',true);
      		$("input[name='ispost']").prop('checked',true);
      		$("input[name='isreject']").prop('checked',true);
      		$("input[name='isupload']").prop('checked',true);
      		$("input[name='isdownload']").prop('checked',true);
      		$("input[name='ispurge']").prop('checked',true);
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
	jQuery.ajax({'url':'groupmenu/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='groupmenuid']").val(data.groupmenuid);
				$("input[name='groupname']").val(data.groupname);
				$("input[name='groupaccessid']").val(data.groupaccessid);
				$("input[name='menuaccessid']").val(data.menuaccessid);
				$("input[name='description']").val(data.description);
			    if (data.isread == 1)
				{
					$("input[name='isread']").prop('checked',true);
				}
				else
				{
					$("input[name='isread']").prop('checked',false)
				}
				if (data.iswrite == 1)
				{
					$("input[name='iswrite']").prop('checked',true);
				}
				else
				{
					$("input[name='iswrite']").prop('checked',false)
				}
				if (data.ispost == 1)
				{
					$("input[name='ispost']").prop('checked',true);
				}
				else
				{
					$("input[name='ispost']").prop('checked',false)
				}
				if (data.isreject == 1)
				{
					$("input[name='isreject']").prop('checked',true);
				}
				else
				{
					$("input[name='isreject']").prop('checked',false)
				}
				if (data.isupload == 1)
				{
					$("input[name='isupload']").prop('checked',true);
				}
				else
				{
					$("input[name='isupload']").prop('checked',false)
				}
				if (data.isdownload == 1)
				{
					$("input[name='isdownload']").prop('checked',true);
				}
				else
				{
					$("input[name='isdownload']").prop('checked',false)
				}
				if (data.ispurge == 1)
				{
					$("input[name='ispurge']").prop('checked',true);
				}
				else
				{
					$("input[name='ispurge']").prop('checked',false)
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
	var isread = 0;
	if ($("input[name='isread']").prop('checked'))
	{
		isread = 1;
	}
	else
	{
		isread = 0;
	}
	var iswrite = 0;
	if ($("input[name='iswrite']").prop('checked'))
	{
		iswrite = 1;
	}
	else
	{
		iswrite = 0;
	}
	var isreject = 0;
	if ($("input[name='isreject']").prop('checked'))
	{
		isreject = 1;
	}
	else
	{
		isreject = 0;
	}
	var ispost = 0;
	if ($("input[name='ispost']").prop('checked'))
	{
		ispost = 1;
	}
	else
	{
		ispost = 0;
	}
	var isupload = 0;
	if ($("input[name='isupload']").prop('checked'))
	{
		isupload = 1;
	}
	else
	{
		isupload = 0;
	}
	var isdownload = 0;
	if ($("input[name='isdownload']").prop('checked'))
	{
		isdownload = 1;
	}
	else
	{
		isdownload = 0;
	}
	var ispurge = 0;
	if ($("input[name='ispurge']").prop('checked'))
	{
		ispurge = 1;
	}
	else
	{
		ispurge = 0;
	}

	jQuery.ajax({'url':'groupmenu/save',
		'data':{
			
			'groupmenuid':$("input[name='groupmenuid']").val(),
			'groupaccessid':$("input[name='groupaccessid']").val(),
			'menuaccessid':$("input[name='menuaccessid']").val(),
			'isread':isread,
			'iswrite':iswrite,
			'ispost':ispost,
			'isreject':isreject,
			'isupload':isupload,
			'isdownload':isdownload,
			'ispurge':ispurge,

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
	jQuery.ajax({'url':'groupmenu/delete',
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
	jQuery.ajax({'url':'groupmenu/purge','data':{'id':$id},
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
		'groupmenuid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'groupmenuid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('groupmenu/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'groupmenuid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('groupmenu/downxls?'+array);
}