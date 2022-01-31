if("undefined"==typeof jQuery)throw new Error("User Dashboard's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'useraccess/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='useraccessid']").val(data.useraccessid);
			$("input[name='username']").val('');
      $("input[name='realname']").val('');
      $("input[name='password']").val('');
      $("input[name='email']").val('');
      $("input[name='phoneno']").val('');
      $("input[name='languageid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='languagename']").val('');
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
	jQuery.ajax({'url':'useraccess/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='useraccessid']").val(data.useraccessid);
				$("input[name='username']").val(data.username);
      $("input[name='realname']").val(data.realname);
      $("input[name='password']").val(data.password);
      $("input[name='email']").val(data.email);
      $("input[name='phoneno']").val(data.phoneno);
      $("input[name='languageid']").val(data.languageid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='languagename']").val(data.languagename);
				
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
	jQuery.ajax({'url':'useraccess/save',
		'data':{
			'useraccessid':$("input[name='useraccessid']").val(),
			'username':$("input[name='username']").val(),
      'realname':$("input[name='realname']").val(),
      'password':$("input[name='password']").val(),
      'email':$("input[name='email']").val(),
      'phoneno':$("input[name='phoneno']").val(),
      'languageid':$("input[name='languageid']").val(),
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
	jQuery.ajax({'url':'useraccess/delete',
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
	jQuery.ajax({'url':'useraccess/purge','data':{'id':$id},
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
		'useraccessid':$id,
		'username':$("input[name='dlg_search_username']").val(),
		'realname':$("input[name='dlg_search_realname']").val(),
		'email':$("input[name='dlg_search_email']").val(),
		'phoneno':$("input[name='dlg_search_phoneno']").val(),
		'languagename':$("input[name='dlg_search_languagename']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'useraccessid='+$id
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&realname='+$("input[name='dlg_search_realname']").val()
+ '&password='+$("input[name='dlg_search_password']").val()
+ '&email='+$("input[name='dlg_search_email']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&languagename='+$("input[name='dlg_search_languagename']").val();
	window.open('useraccess/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'useraccessid='+$id
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&realname='+$("input[name='dlg_search_realname']").val()
+ '&password='+$("input[name='dlg_search_password']").val()
+ '&email='+$("input[name='dlg_search_email']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&languagename='+$("input[name='dlg_search_languagename']").val();
	window.open('useraccess/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'useraccessid='+$id
}