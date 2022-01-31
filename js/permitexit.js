if("undefined"==typeof jQuery)throw new Error("Permit Exit's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'permitexit/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='permitexitid']").val(data.permitexitid);
				$("input[name='permitexitname']").val('');
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
	jQuery.ajax({'url':'permitexit/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='permitexitid']").val(data.permitexitid);
				$("input[name='permitexitname']").val(data.permitexitname);
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
	jQuery.ajax({'url':'permitexit/save',
		'data':{
			'permitexitid':$("input[name='permitexitid']").val(),
			'permitexitname':$("input[name='permitexitname']").val(),
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
	jQuery.ajax({'url':'permitexit/delete',
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
	jQuery.ajax({'url':'permitexit/purge','data':{'id':$id},
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
		'permitexitid':$id,
		'permitexitname':$("input[name='dlg_search_permitexitname']").val(),
		'snrodesc':$("input[name='dlg_search_snrodesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'permitexitid='+$id
+ '&permitexitname='+$("input[name='dlg_search_permitexitname']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val();
	window.open('permitexit/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'permitexitid='+$id
+ '&permitexitname='+$("input[name='dlg_search_permitexitname']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val();
	window.open('permitexit/downxls?'+array);
}