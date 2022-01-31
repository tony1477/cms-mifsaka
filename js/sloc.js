if("undefined"==typeof jQuery)throw new Error("Sloc's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'sloc/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='sloc_0_slocid']").val(data.slocid);
			$("input[name='sloc_0_plantid']").val('');
      $("input[name='sloc_0_sloccode']").val('');
      $("input[name='sloc_0_description']").val('');
      $("input[name='sloc_0_recordstatus']").prop('checked',true);
      $("input[name='sloc_0_plantcode']").val('');
			
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
	jQuery.ajax({'url':'sloc/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='sloc_0_slocid']").val(data.slocid);
				$("input[name='sloc_0_plantid']").val(data.plantid);
      $("input[name='sloc_0_sloccode']").val(data.sloccode);
      $("input[name='sloc_0_description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='sloc_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='sloc_0_recordstatus']").prop('checked',false)
			}
      $("input[name='sloc_0_plantcode']").val(data.plantcode);
				
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
	if ($("input[name='sloc_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'sloc/save',
		'data':{
			'slocid':$("input[name='sloc_0_slocid']").val(),
			'plantid':$("input[name='sloc_0_plantid']").val(),
      'sloccode':$("input[name='sloc_0_sloccode']").val(),
      'description':$("input[name='sloc_0_description']").val(),
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'sloc/delete',
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'sloc/purge','data':{'id':$id},
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
	var array = 'slocid='+$id
+ '&plantcode='+$("input[name='dlg_search_plantcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'slocid='+$id
+ '&plantcode='+$("input[name='dlg_search_plantcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('sloc/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'slocid='+$id
+ '&plantcode='+$("input[name='dlg_search_plantcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('sloc/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'slocid='+$id
} 