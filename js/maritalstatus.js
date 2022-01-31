if("undefined"==typeof jQuery)throw new Error("Marital Status's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'maritalstatus/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='maritalstatusid']").val(data.maritalstatusid);
			$("input[name='maritalstatusname']").val('');
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
	jQuery.ajax({'url':'maritalstatus/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='maritalstatusid']").val(data.maritalstatusid);
				$("input[name='maritalstatusname']").val(data.maritalstatusname);
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
	jQuery.ajax({'url':'maritalstatus/save',
		'data':{
			
			'maritalstatusid':$("input[name='maritalstatusid']").val(),
			'maritalstatusname':$("input[name='maritalstatusname']").val(),
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'maritalstatus/delete',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'maritalstatus/purge','data':{'id':$id},
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
		'maritalstatusid':$id,
		'maritalstatusname':$("input[name='dlg_search_maritalstatusname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'maritalstatusid='+$id
+ '&maritalstatusname='+$("input[name='dlg_search_maritalstatusname']").val();
	window.open('maritalstatus/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'maritalstatusid='+$id
+ '&maritalstatusname='+$("input[name='dlg_search_maritalstatusname']").val();
	window.open('maritalstatus/downxls?'+array);
}