if("undefined"==typeof jQuery)throw new Error("Language Value's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'languagevalue/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='languagevalueid']").val(data.languagevalueid);
			$("input[name='languagevaluename']").val('');
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
	jQuery.ajax({'url':'languagevalue/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='languagevalueid']").val(data.languagevalueid);
				$("input[name='languagevaluename']").val(data.languagevaluename);
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
if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'languagevalue/save',
		'data':{
			
			'languagevalueid':$("input[name='languagevalueid']").val(),
			'languagevaluename':$("input[name='languagevaluename']").val(),
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
	jQuery.ajax({'url':'languagevalue/delete',
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
	jQuery.ajax({'url':'languagevalue/purge','data':{'id':$id},
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
	var array = 'languagevalueid='+$id
+ '&languagevaluename='+$("input[name='dlg_search_languagevaluename']").val();
	$.fn.yiiGridView.update("GridList",{data:{
		'languagevalueid':$id,
		'languagevaluename':$("input[name='dlg_search_languagevaluename']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'languagevalueid='+$id
+ '&languagevaluename='+$("input[name='dlg_search_languagevaluename']").val();
	window.open('languagevalue/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'languagevalueid='+$id
+ '&languagevaluename='+$("input[name='dlg_search_languagevaluename']").val();
	window.open('languagevalue/downxls?'+array);
}