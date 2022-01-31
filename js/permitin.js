if("undefined"==typeof jQuery)throw new Error("Permit In's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'permitin/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='permitinid']").val(data.permitinid);
			
			$("input[name='permitinname']").val('');
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
	jQuery.ajax({'url':'permitin/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='permitinid']").val(data.permitinid);
				
				$("input[name='permitinname']").val(data.permitinname);
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
	jQuery.ajax({'url':'permitin/save',
		'data':{
			
			'permitinid':$("input[name='permitinid']").val(),
			'permitinname':$("input[name='permitinname']").val(),
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
	jQuery.ajax({'url':'permitin/delete',
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
	jQuery.ajax({'url':'permitin/purge','data':{'id':$id},
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
		'permitinid':$id,
		'permitinname':$("input[name='dlg_search_permitinname']").val(),
		'snrodesc':$("input[name='dlg_search_snrodesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'permitinid='+$id
+ '&permitinname='+$("input[name='dlg_search_permitinname']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val();
	window.open('permitin/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'permitinid='+$id
+ '&permitinname='+$("input[name='dlg_search_permitinname']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val();
	window.open('permitin/downxls?'+array);
}