if("undefined"==typeof jQuery)throw new Error("Group Customer's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'groupcustomer/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='groupcustomer_0_groupcustomerid']").val(data.groupcustomerid);
			$("input[name='groupcustomer_0_groupname']").val('');
      $("input[name='groupcustomer_0_recordstatus']").prop('checked',true);
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
	jQuery.ajax({'url':'groupcustomer/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='groupcustomer_0_groupcustomerid']").val(data.groupcustomerid);
				$("input[name='groupcustomer_0_groupname']").val(data.groupname);
      if (data.recordstatus == 1)
			{
				$("input[name='groupcustomer_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='groupcustomer_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='groupcustomer_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'groupcustomer/save',
		'data':{
			'groupcustomerid':$("input[name='groupcustomer_0_groupcustomerid']").val(),
			'groupname':$("input[name='groupcustomer_0_groupname']").val(),
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
	jQuery.ajax({'url':'groupcustomer/delete',
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
	jQuery.ajax({'url':'groupcustomer/purge','data':{'id':$id},
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
		'groupcustomerid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'groupcustomer='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('groupcustomer/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'groupcustomerid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('groupcustomer/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'groupcustomerid='+$id
} 