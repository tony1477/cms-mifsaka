if("undefined"==typeof jQuery)throw new Error("Legal Document's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'legaldoc/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='legaldocid']").val(data.legaldocid);
			
			$("input[name='legaldoctitle']").val('');
      $("input[name='legaldocfile']").val('');
      $("input[name='expiredate']").val(data.expiredate);
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
	jQuery.ajax({'url':'legaldoc/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='legaldocid']").val(data.legaldocid);
				
				$("input[name='legaldoctitle']").val(data.legaldoctitle);
      $("input[name='legaldocfile']").val(data.legaldocfile);
      $("input[name='expiredate']").val(data.expiredate);
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
	jQuery.ajax({'url':'legaldoc/save',
		'data':{
			
			'legaldocid':$("input[name='legaldocid']").val(),
			'legaldoctitle':$("input[name='legaldoctitle']").val(),
      'legaldocfile':$("input[name='legaldocfile']").val(),
      'expiredate':$("input[name='expiredate']").val(),
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
	jQuery.ajax({'url':'legaldoc/delete',
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
	jQuery.ajax({'url':'legaldoc/purge','data':{'id':$id},
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
		'legaldocid':$id,
		'legaldoctitle':$("input[name='dlg_search_legaldoctitle']").val(),
		'legaldocfile':$("input[name='dlg_search_legaldocfile']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'legaldocid='+$id
+ '&legaldoctitle='+$("input[name='dlg_search_legaldoctitle']").val()
+ '&legaldocfile='+$("input[name='dlg_search_legaldocfile']").val();
	window.open('legaldoc/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'legaldocid='+$id
+ '&legaldoctitle='+$("input[name='dlg_search_legaldoctitle']").val()
+ '&legaldocfile='+$("input[name='dlg_search_legaldocfile']").val();
	window.open('legaldoc/downxls?'+array);
}