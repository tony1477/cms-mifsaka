if("undefined"==typeof jQuery)throw new Error("Position's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'position/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='positionid']").val(data.positionid);
			
			$("input[name='positionname']").val('');
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
	jQuery.ajax({'url':'position/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='positionid']").val(data.positionid);
				
				$("input[name='positionname']").val(data.positionname);
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
	jQuery.ajax({'url':'position/save',
		'data':{
			
			'positionid':$("input[name='positionid']").val(),
			'positionname':$("input[name='positionname']").val(),
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
	jQuery.ajax({'url':'position/delete',
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
	jQuery.ajax({'url':'position/purge','data':{'id':$id},
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
		'positionid':$id,
		'positionname':$("input[name='dlg_search_positionname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'positionid='+$id
+ '&positionname='+$("input[name='dlg_search_positionname']").val();
	window.open('position/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'positionid='+$id
+ '&positionname='+$("input[name='dlg_search_positionname']").val();
	window.open('position/downxls?'+array);
}