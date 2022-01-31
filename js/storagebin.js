if("undefined"==typeof jQuery)throw new Error("Language's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'storagebin/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='storagebin_0_storagebinid']").val(data.storagebinid);
			$("input[name='storagebin_0_slocid']").val('');
      $("input[name='storagebin_0_description']").val('');
      $("input[name='storagebin_0_ismultiproduct']").prop('checked',true);
      $("input[name='storagebin_0_qtymax']").val(data.qtymax);
      $("input[name='storagebin_0_recordstatus']").prop('checked',true);
      $("input[name='storagebin_0_sloccode']").val('');
			
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
	jQuery.ajax({'url':'storagebin/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='storagebin_0_storagebinid']").val(data.storagebinid);
				$("input[name='storagebin_0_slocid']").val(data.slocid);
      $("input[name='storagebin_0_description']").val(data.description);
      if (data.ismultiproduct == 1)
			{
				$("input[name='storagebin_0_ismultiproduct']").prop('checked',true);
			}
			else
			{
				$("input[name='storagebin_0_ismultiproduct']").prop('checked',false)
			}
      $("input[name='storagebin_0_qtymax']").val(data.qtymax);
      if (data.recordstatus == 1)
			{
				$("input[name='storagebin_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='storagebin_0_recordstatus']").prop('checked',false)
			}
      $("input[name='storagebin_0_sloccode']").val(data.sloccode);
				
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
var ismultiproduct = 0;
	if ($("input[name='storagebin_0_ismultiproduct']").prop('checked'))
	{
		ismultiproduct = 1;
	}
	else
	{
		ismultiproduct = 0;
	}
var recordstatus = 0;
	if ($("input[name='storagebin_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'storagebin/save',
		'data':{
			'storagebinid':$("input[name='storagebin_0_storagebinid']").val(),
			'slocid':$("input[name='storagebin_0_slocid']").val(),
      'description':$("input[name='storagebin_0_description']").val(),
      'ismultiproduct':ismultiproduct,
      'qtymax':$("input[name='storagebin_0_qtymax']").val(),
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
	jQuery.ajax({'url':'storagebin/delete',
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
	jQuery.ajax({'url':'storagebin/purge','data':{'id':$id},
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
		'storagebinid':$id,
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'storagebinid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('storagebin/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'storagebinid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('storagebin/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'storagebinid='+$id
} 