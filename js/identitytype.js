if("undefined"==typeof jQuery)throw new Error("Identity Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'identitytype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='identitytype_0_identitytypeid']").val(data.identitytypeid);
			$("input[name='identitytype_0_identitytypename']").val('');
      $("input[name='identitytype_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'identitytype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='identitytype_0_identitytypeid']").val(data.identitytypeid);
				$("input[name='identitytype_0_identitytypename']").val(data.identitytypename);
      if (data.recordstatus == 1)
			{
				$("input[name='identitytype_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='identitytype_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='identitytype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'identitytype/save',
		'data':{
			'identitytypeid':$("input[name='identitytype_0_identitytypeid']").val(),
			'identitytypename':$("input[name='identitytype_0_identitytypename']").val(),
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
	jQuery.ajax({'url':'identitytype/delete',
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
	jQuery.ajax({'url':'identitytype/purge','data':{'id':$id},
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
	var array = 'identitytypeid='+$id
+ '&identitytypename='+$("input[name='dlg_search_identitytypename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'identitytypeid='+$id
+ '&identitytypename='+$("input[name='dlg_search_identitytypename']").val();
	window.open('identitytype/downpdf'+array);
}

function downxls($id=0) {
	var array = 'identitytypeid='+$id
+ '&identitytypename='+$("input[name='dlg_search_identitytypename']").val();
	window.open('identitytype/downxls'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'identitytypeid='+$id
} 