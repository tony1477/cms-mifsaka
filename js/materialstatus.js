if("undefined"==typeof jQuery)throw new Error("Language's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'materialstatus/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='materialstatusid']").val(data.materialstatusid);
			$("input[name='materialstatusname']").val('');
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
	jQuery.ajax({'url':'materialstatus/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='materialstatusid']").val(data.materialstatusid);
				$("input[name='materialstatusname']").val(data.materialstatusname);
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
	jQuery.ajax({'url':'materialstatus/save',
		'data':{
			'materialstatusid':$("input[name='materialstatusid']").val(),
			'materialstatusname':$("input[name='materialstatusname']").val(),
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
	jQuery.ajax({'url':'materialstatus/delete',
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
	jQuery.ajax({'url':'materialstatus/purge','data':{'id':$id},
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
		'materialstatusid':$id,
		'materialstatusname':$("input[name='dlg_search_materialstatusname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'materialstatusid='+$id
+ '&materialstatusname='+$("input[name='dlg_search_materialstatusname']").val();
	window.open('materialstatus/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'materialstatusid='+$id
+ '&materialstatusname='+$("input[name='dlg_search_materialstatusname']").val();
	window.open('materialstatus/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'materialstatusid='+$id
} 