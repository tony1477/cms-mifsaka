if("undefined"==typeof jQuery)throw new Error("Employee Type Sick's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'employeetypesick/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeetypeid']").val(data.employeetypeid);
			
			$("input[name='employeetypename']").val('');
      $("input[name='sicksnroid']").val('');
      $("input[name='sickstatusid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='sickdesc']").val('');
      $("input[name='shortstat']").val('');
			
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
	jQuery.ajax({'url':'employeetypesick/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeetypeid']").val(data.employeetypeid);
				
				$("input[name='employeetypename']").val(data.employeetypename);
      $("input[name='sicksnroid']").val(data.sicksnroid);
      $("input[name='sickstatusid']").val(data.sickstatusid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='sickdesc']").val(data.sickdesc);
      $("input[name='shortstat']").val(data.shortstat);
				
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
	jQuery.ajax({'url':'employeetypesick/save',
		'data':{
			
			'employeetypeid':$("input[name='employeetypeid']").val(),
			'employeetypename':$("input[name='employeetypename']").val(),
      'sicksnroid':$("input[name='sicksnroid']").val(),
      'sickstatusid':$("input[name='sickstatusid']").val(),
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
	jQuery.ajax({'url':'employeetypesick/delete',
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
	jQuery.ajax({'url':'employeetypesick/purge','data':{'id':$id},
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
		'employeetypename':$("input[name='dlg_search_employeetypename']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val();
	window.open('employeetypesick/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val();
	window.open('employeetypesick/downxls?'+array);
}