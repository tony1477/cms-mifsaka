if("undefined"==typeof jQuery)throw new Error("Ticket Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'tickettype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='tickettypeid']").val(data.tickettypeid);
			
			$("input[name='tickettypecode']").val('');
      $("input[name='tickettypedesc']").val('');
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
	jQuery.ajax({'url':'tickettype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='tickettypeid']").val(data.tickettypeid);
				
				$("input[name='tickettypecode']").val(data.tickettypecode);
      $("input[name='tickettypedesc']").val(data.tickettypedesc);
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
	jQuery.ajax({'url':'tickettype/save',
		'data':{
			
			'tickettypeid':$("input[name='tickettypeid']").val(),
			'tickettypecode':$("input[name='tickettypecode']").val(),
      'tickettypedesc':$("input[name='tickettypedesc']").val(),
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
	jQuery.ajax({'url':'tickettype/delete',
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
	jQuery.ajax({'url':'tickettype/purge','data':{'id':$id},
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
		'tickettypeid':$id,
		'tickettypecode':$("input[name='dlg_search_tickettypecode']").val(),
		'tickettypedesc':$("input[name='dlg_search_tickettypedesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'tickettypeid='+$id
+ '&tickettypecode='+$("input[name='dlg_search_tickettypecode']").val()
+ '&tickettypedesc='+$("input[name='dlg_search_tickettypedesc']").val();
	window.open('tickettype/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'tickettypeid='+$id
+ '&tickettypecode='+$("input[name='dlg_search_tickettypecode']").val()
+ '&tickettypedesc='+$("input[name='dlg_search_tickettypedesc']").val();
	window.open('tickettype/downxls?'+array);
}