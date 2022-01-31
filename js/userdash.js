if("undefined"==typeof jQuery)throw new Error("User Dashboard's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'userdash/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='userdashid']").val(data.userdashid);
			$("input[name='groupaccessid']").val('');
      $("input[name='widgetid']").val('');
      $("input[name='menuaccessid']").val('');
      $("input[name='position']").val('0');
      $("input[name='webformat']").val('col-md-3');
      $("input[name='dashgroup']").val('0');
      $("input[name='groupname']").val('');
      $("input[name='widgetname']").val('');
      $("input[name='menuname']").val('');
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
	jQuery.ajax({'url':'userdash/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='userdashid']").val(data.userdashid);
				$("input[name='groupaccessid']").val(data.groupaccessid);
				$("input[name='widgetid']").val(data.widgetid);
				$("input[name='menuaccessid']").val(data.menuaccessid);
				$("input[name='position']").val(data.position);
				$("input[name='webformat']").val(data.webformat);
				$("input[name='dashgroup']").val(data.dashgroup);
				$("input[name='groupname']").val(data.groupname);
				$("input[name='widgetname']").val(data.widgetname);
				$("input[name='menuname']").val(data.menuname);
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
	jQuery.ajax({'url':'userdash/save',
		'data':{
			'userdashid':$("input[name='userdashid']").val(),
			'groupaccessid':$("input[name='groupaccessid']").val(),
      'widgetid':$("input[name='widgetid']").val(),
      'menuaccessid':$("input[name='menuaccessid']").val(),
      'position':$("input[name='position']").val(),
      'webformat':$("input[name='webformat']").val(),
      'dashgroup':$("input[name='dashgroup']").val(),
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
	jQuery.ajax({'url':'userdash/purge','data':{'id':$id},
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
		'userdashid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val(),
		'widgetname':$("input[name='dlg_search_widgetname']").val(),
		'menuname':$("input[name='dlg_search_menuname']").val(),
		'webformat':$("input[name='dlg_search_webformat']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'userdashid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&widgetname='+$("input[name='dlg_search_widgetname']").val()
+ '&menuname='+$("input[name='dlg_search_menuname']").val()
+ '&webformat='+$("input[name='dlg_search_webformat']").val();
	window.open('userdash/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'userdashid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&widgetname='+$("input[name='dlg_search_widgetname']").val()
+ '&menuname='+$("input[name='dlg_search_menuname']").val()
+ '&webformat='+$("input[name='dlg_search_webformat']").val();
	window.open('userdash/downxls?'+array);
}