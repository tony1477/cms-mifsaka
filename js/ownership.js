if("undefined"==typeof jQuery)throw new Error("Ownership's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'ownership/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='ownership_0_ownershipid']").val(data.ownershipid);
			$("input[name='ownership_0_ownershipname']").val('');
      $("input[name='ownership_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'ownership/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='ownership_0_ownershipid']").val(data.ownershipid);
				$("input[name='ownership_0_ownershipname']").val(data.ownershipname);
      if (data.recordstatus == 1)
			{
				$("input[name='ownership_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='ownership_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='ownership_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'ownership/save',
		'data':{
			'ownershipid':$("input[name='ownership_0_ownershipid']").val(),
			'ownershipname':$("input[name='ownership_0_ownershipname']").val(),
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
	jQuery.ajax({'url':'ownership/delete',
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
	jQuery.ajax({'url':'ownership/purge','data':{'id':$id},
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
		'ownershipid':$id,
		'ownershipname':$("input[name='dlg_search_ownershipname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'ownershipid='+$id
+ '&ownershipname='+$("input[name='dlg_search_ownershipname']").val();
	window.open('ownership/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'ownershipid='+$id
+ '&ownershipname='+$("input[name='dlg_search_ownershipname']").val();
	window.open('ownership/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'ownershipid='+$id
} 