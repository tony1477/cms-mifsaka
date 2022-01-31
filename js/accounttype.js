if("undefined"==typeof jQuery)throw new Error("Account Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'accounttype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='accounttype_0_accounttypeid']").val(data.accounttypeid);
			$("input[name='accounttype_0_accounttypename']").val('');
      $("input[name='accounttype_0_parentaccounttypeid']").val('');
      $("input[name='accounttype_0_recordstatus']").prop('checked',true);
      $("input[name='accounttype_0_accountcode']").val('');
			
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
	jQuery.ajax({'url':'accounttype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='accounttype_0_accounttypeid']").val(data.accounttypeid);
				$("input[name='accounttype_0_accounttypename']").val(data.accounttypename);
      $("input[name='accounttype_0_parentaccounttypeid']").val(data.parentaccounttypeid);
      if (data.recordstatus == 1)
			{
				$("input[name='accounttype_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='accounttype_0_recordstatus']").prop('checked',false)
			}
      $("input[name='accounttype_0_accountcode']").val(data.accountcode);
				
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
	if ($("input[name='accounttype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'accounttype/save',
		'data':{
			'accounttypeid':$("input[name='accounttype_0_accounttypeid']").val(),
			'accounttypename':$("input[name='accounttype_0_accounttypename']").val(),
      'parentaccounttypeid':$("input[name='accounttype_0_parentaccounttypeid']").val(),
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
	jQuery.ajax({'url':'accounttype/delete',
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
	jQuery.ajax({'url':'accounttype/purge','data':{'id':$id},
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
	var array = 'accounttype_0_accounttypeid='+$id
+ '&accounttype_0_accounttypename='+$("input[name='dlg_search_accounttype_0_accounttypename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'accounttype_0_accounttypeid='+$id
+ '&accounttype_0_accounttypename='+$("input[name='dlg_search_accounttype_0_accounttypename']").val();
	window.open('accounttype/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'accounttype_0_accounttypeid='+$id
+ '&accounttype_0_accounttypename='+$("input[name='dlg_search_accounttype_0_accounttypename']").val();
	window.open('accounttype/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'accounttypeid='+$id
} 