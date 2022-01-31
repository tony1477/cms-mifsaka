if("undefined"==typeof jQuery)throw new Error("Purchasing Organization's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'purchasingorg/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='purchasingorg_0_purchasingorgid']").val(data.purchasingorgid);
			$("input[name='purchasingorg_0_purchasingorgcode']").val('');
      $("input[name='purchasingorg_0_description']").val('');
      $("input[name='purchasingorg_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'purchasingorg/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='purchasingorg_0_purchasingorgid']").val(data.purchasingorgid);
				$("input[name='purchasingorg_0_purchasingorgcode']").val(data.purchasingorgcode);
      $("input[name='purchasingorg_0_description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='purchasingorg_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='purchasingorg_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='purchasingorg_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'purchasingorg/save',
		'data':{
			'purchasingorgid':$("input[name='purchasingorg_0_purchasingorgid']").val(),
			'purchasingorgcode':$("input[name='purchasingorg_0_purchasingorgcode']").val(),
      'description':$("input[name='purchasingorg_0_description']").val(),
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
	jQuery.ajax({'url':'purchasingorg/delete',
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
	jQuery.ajax({'url':'purchasingorg/purge','data':{'id':$id},
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
		'purchasingorgid':$id,
		'purchasingorgcode':$("input[name='dlg_search_purchasingorgcode']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'purchasingorgid='+$id
+ '&purchasingorgcode='+$("input[name='dlg_search_purchasingorgcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('purchasingorg/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'purchasingorgid='+$id
+ '&purchasingorgcode='+$("input[name='dlg_search_purchasingorgcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('purchasingorg/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'purchasingorgid='+$id
} 