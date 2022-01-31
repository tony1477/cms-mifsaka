if("undefined"==typeof jQuery)throw new Error("Menu Access's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'menuaccess/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='menuaccess_0_menuaccessid']").val(data.menuaccessid);
			$("input[name='menuaccess_0_menuname']").val('');
      $("input[name='menuaccess_0_description']").val('');
      $("input[name='menuaccess_0_menuurl']").val('');
      $("input[name='menuaccess_0_menuicon']").val('');
      $("input[name='menuaccess_0_parentid']").val('');
      $("input[name='menuaccess_0_moduleid']").val('');
      $("input[name='menuaccess_0_sortorder']").prop('checked',true);
      $("input[name='menuaccess_0_recordstatus']").prop('checked',true);
      $("input[name='menuaccess_0_modulename']").val('');
			
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
	jQuery.ajax({'url':'menuaccess/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='menuaccess_0_menuaccessid']").val(data.menuaccessid);
				$("input[name='menuaccess_0_menuname']").val(data.menuname);
      $("input[name='menuaccess_0_description']").val(data.description);
      $("input[name='menuaccess_0_menuurl']").val(data.menuurl);
      $("input[name='menuaccess_0_menuicon']").val(data.menuicon);
      $("input[name='menuaccess_0_parentid']").val(data.parentid);
      $("input[name='menuaccess_0_moduleid']").val(data.moduleid);
      if (data.sortorder == 1)
			{
				$("input[name='menuaccess_0_sortorder']").prop('checked',true);
			}
			else
			{
				$("input[name='menuaccess_0_sortorder']").prop('checked',false)
			}
      if (data.recordstatus == 1)
			{
				$("input[name='menuaccess_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='menuaccess_0_recordstatus']").prop('checked',false)
			}
      $("input[name='menuaccess_0_modulename']").val(data.modulename);
				
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
var sortorder = 0;
	if ($("input[name='menuaccess_0_sortorder']").prop('checked'))
	{
		sortorder = 1;
	}
	else
	{
		sortorder = 0;
	}
var recordstatus = 0;
	if ($("input[name='menuaccess_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'menuaccess/save',
		'data':{
			'menuaccessid':$("input[name='menuaccess_0_menuaccessid']").val(),
			'menuname':$("input[name='menuaccess_0_menuname']").val(),
      'description':$("input[name='menuaccess_0_description']").val(),
      'menuurl':$("input[name='menuaccess_0_menuurl']").val(),
      'menuicon':$("input[name='menuaccess_0_menuicon']").val(),
      'parentid':$("input[name='menuaccess_0_parentid']").val(),
      'moduleid':$("input[name='menuaccess_0_moduleid']").val(),
      'sortorder':sortorder,
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
	jQuery.ajax({'url':'menuaccess/delete',
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
	jQuery.ajax({'url':'menuaccess/purge','data':{'id':$id},
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
		'menuaccessid':$id,
		'menuname':$("input[name='dlg_search_menuname']").val(),
		'description':$("input[name='dlg_search_description']").val(),
		'menuurl':$("input[name='dlg_search_menuurl']").val(),
		'menuicon':$("input[name='dlg_search_menuicon']").val(),
		'modulename':$("input[name='dlg_search_modulename']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'menuaccessid='+$id
+ '&menuname='+$("input[name='dlg_search_menuname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&menuurl='+$("input[name='dlg_search_menuurl']").val()
+ '&menuicon='+$("input[name='dlg_search_menuicon']").val()
+ '&modulename='+$("input[name='dlg_search_modulename']").val();
	window.open('menuaccess/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'menuaccessid='+$id
+ '&menuname='+$("input[name='dlg_search_menuname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&menuurl='+$("input[name='dlg_search_menuurl']").val()
+ '&menuicon='+$("input[name='dlg_search_menuicon']").val()
+ '&modulename='+$("input[name='dlg_search_modulename']").val();
	window.open('menuaccess/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'menuaccessid='+$id
} 