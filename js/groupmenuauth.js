if("undefined"==typeof jQuery)throw new Error("Group Menu Authorization's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'groupmenuauth/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='groupmenuauth_0_groupmenuauthid']").val(data.groupmenuauthid);
			$("input[name='groupmenuauth_0_groupaccessid']").val('');
      $("input[name='groupmenuauth_0_menuauthid']").val('');
      $("input[name='groupmenuauth_0_menuvalueid']").val('');
      $("input[name='groupmenuauth_0_groupname']").val('');
      $("input[name='groupmenuauth_0_menuobject']").val('');
			
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
	jQuery.ajax({'url':'groupmenuauth/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='groupmenuauth_0_groupmenuauthid']").val(data.groupmenuauthid);
				$("input[name='groupmenuauth_0_groupaccessid']").val(data.groupaccessid);
      $("input[name='groupmenuauth_0_menuauthid']").val(data.menuauthid);
      $("input[name='groupmenuauth_0_menuvalueid']").val(data.menuvalueid);
      $("input[name='groupmenuauth_0_groupname']").val(data.groupname);
      $("input[name='groupmenuauth_0_menuobject']").val(data.menuobject);
				
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

	jQuery.ajax({'url':'groupmenuauth/save',
		'data':{
			'groupmenuauthid':$("input[name='groupmenuauth_0_groupmenuauthid']").val(),
			'groupaccessid':$("input[name='groupmenuauth_0_groupaccessid']").val(),
      'menuauthid':$("input[name='groupmenuauth_0_menuauthid']").val(),
      'menuvalueid':$("input[name='groupmenuauth_0_menuvalueid']").val(),
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
	jQuery.ajax({'url':'groupmenuauth/purge','data':{'id':$id},
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
		'groupmenuauthid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val(),
		'menuobject':$("input[name='dlg_search_menuobject']").val(),
		'menuvalueid':$("input[name='dlg_search_menuvalueid']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'groupmenuauthid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&menuobject='+$("input[name='dlg_search_menuobject']").val()
+ '&menuvalueid='+$("input[name='dlg_search_menuvalueid']").val();
	window.open('groupmenuauth/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'groupmenuauthid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&menuobject='+$("input[name='dlg_search_menuobject']").val()
+ '&menuvalueid='+$("input[name='dlg_search_menuvalueid']").val();
	window.open('groupmenuauth/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'groupmenuauthid='+$id
} 