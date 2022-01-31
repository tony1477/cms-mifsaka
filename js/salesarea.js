if("undefined"==typeof jQuery)throw new Error("Sales Area's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'salesarea/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesarea_0_salesareaid']").val(data.salesareaid);
			$("input[name='salesarea_0_areaname']").val('');
      $("input[name='salesarea_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'salesarea/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='salesarea_0_salesareaid']").val(data.salesareaid);
				$("input[name='salesarea_0_areaname']").val(data.areaname);
      if (data.recordstatus == 1)
			{
				$("input[name='salesarea_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='salesarea_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='salesarea_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'salesarea/save',
		'data':{
			'salesareaid':$("input[name='salesarea_0_salesareaid']").val(),
			'areaname':$("input[name='salesarea_0_areaname']").val(),
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
	jQuery.ajax({'url':'salesarea/delete',
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
	jQuery.ajax({'url':'salesarea/purge','data':{'id':$id},
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
		'salesareaid':$id,
		'areaname':$("input[name='dlg_search_areaname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'salesareaid='+$id
+ '&areaname='+$("input[name='dlg_search_areaname']").val();
	window.open('salesarea/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'salesareaid='+$id
+ '&areaname='+$("input[name='dlg_search_areaname']").val();
	window.open('salesarea/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salesareaid='+$id
} 