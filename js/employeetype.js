if("undefined"==typeof jQuery)throw new Error("Employee Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'employeetype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeetypeid']").val(data.employeetypeid);
			
			$("input[name='employeetypename']").val('');
      $("input[name='snroid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='snrodesc']").val('');
			
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
	jQuery.ajax({'url':'employeetype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeetypeid']").val(data.employeetypeid);
				
				$("input[name='employeetypename']").val(data.employeetypename);
      $("input[name='snroid']").val(data.snroid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='snrodesc']").val(data.snrodesc);
				
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
	jQuery.ajax({'url':'employeetype/save',
		'data':{
			
			'employeetypeid':$("input[name='employeetypeid']").val(),
			'employeetypename':$("input[name='employeetypename']").val(),
      'snroid':$("input[name='snroid']").val(),
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
	jQuery.ajax({'url':'employeetype/delete',
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
	jQuery.ajax({'url':'employeetype/purge','data':{'id':$id},
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
		'employeetypeid':$id,
		'employeetypename':$("input[name='dlg_search_employeetypename']").val(),
		'snrodesc':$("input[name='dlg_search_snrodesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val();
	window.open('employeetype/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val();
	window.open('employeetype/downxls?'+array);
}