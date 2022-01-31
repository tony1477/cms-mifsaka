if("undefined"==typeof jQuery)throw new Error("Menu Auth's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'menuauth/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='menuauthid']").val(data.menuauthid);
			$("input[name='menuobject']").val('');
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
	jQuery.ajax({'url':'menuauth/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='menuauthid']").val(data.menuauthid);
				$("input[name='menuobject']").val(data.menuobject);
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
	jQuery.ajax({'url':'menuauth/save',
		'data':{
			
			'menuauthid':$("input[name='menuauthid']").val(),
			'menuobject':$("input[name='menuobject']").val(),
			'recordstatus':$("input[name='recordstatus']").val(),
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
	jQuery.ajax({'url':'menuauth/delete',
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
	jQuery.ajax({'url':'menuauth/purge','data':{'id':$id},
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
		'menuauthid':$id,
		'menuobject':$("input[name='dlg_search_menuobject']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'menuauthid='+$id
+ '&menuobject='+$("input[name='dlg_search_menuobject']").val();
	window.open('menuauth/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'menuauthid='+$id
+ '&menuobject='+$("input[name='dlg_search_menuobject']").val();
	window.open('menuauth/downxls?'+array);
}