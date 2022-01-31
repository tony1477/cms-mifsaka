if("undefined"==typeof jQuery)throw new Error("Trouble Level's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'troublelevel/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='troublelevelid']").val(data.troublelevelid);
			
			$("input[name='levelcode']").val('');
      $("input[name='leveldesc']").val('');
      $("input[name='troubleminvalue']").val(data.troubleminvalue);
      $("input[name='troublemaxvalue']").val(data.troublemaxvalue);
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
	jQuery.ajax({'url':'troublelevel/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='troublelevelid']").val(data.troublelevelid);
				
				$("input[name='levelcode']").val(data.levelcode);
      $("input[name='leveldesc']").val(data.leveldesc);
      $("input[name='troubleminvalue']").val(data.troubleminvalue);
      $("input[name='troublemaxvalue']").val(data.troublemaxvalue);
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
	jQuery.ajax({'url':'troublelevel/save',
		'data':{
			
			'troublelevelid':$("input[name='troublelevelid']").val(),
			'levelcode':$("input[name='levelcode']").val(),
      'leveldesc':$("input[name='leveldesc']").val(),
      'troubleminvalue':$("input[name='troubleminvalue']").val(),
      'troublemaxvalue':$("input[name='troublemaxvalue']").val(),
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
	jQuery.ajax({'url':'troublelevel/delete',
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
	jQuery.ajax({'url':'troublelevel/purge','data':{'id':$id},
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
		'troublelevelid':$id,
		'levelcode':$("input[name='dlg_search_levelcode']").val(),
		'leveldesc':$("input[name='dlg_search_leveldesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'troublelevelid='+$id
+ '&levelcode='+$("input[name='dlg_search_levelcode']").val()
+ '&leveldesc='+$("input[name='dlg_search_leveldesc']").val();
	window.open('troublelevel/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'troublelevelid='+$id
+ '&levelcode='+$("input[name='dlg_search_levelcode']").val()
+ '&leveldesc='+$("input[name='dlg_search_leveldesc']").val();
	window.open('troublelevel/downxls?'+array);
}