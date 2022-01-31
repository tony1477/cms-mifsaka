if("undefined"==typeof jQuery)throw new Error("Address Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'addresstype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addresstype_0_addresstypeid']").val(data.addresstypeid);
			$("input[name='addresstype_0_addresstypename']").val('');
      $("input[name='addresstype_0_recordstatus']").prop('checked',true);
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
	jQuery.ajax({'url':'addresstype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addresstype_0_addresstypeid']").val(data.addresstypeid);
				$("input[name='addresstype_0_addresstypename']").val(data.addresstypename);
      if (data.recordstatus == 1)
			{
				$("input[name='addresstype_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='addresstype_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='addresstype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'addresstype/save',
		'data':{
			'addresstypeid':$("input[name='addresstype_0_addresstypeid']").val(),
			'addresstypename':$("input[name='addresstype_0_addresstypename']").val(),
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
	jQuery.ajax({'url':'addresstype/delete',
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
	jQuery.ajax({'url':'addresstype/purge','data':{'id':$id},
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
		'addresstypeid':$id,
		'addresstypename':$("input[name='dlg_search_addresstypename']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'addresstypeid='+$id
+ '&addresstypename='+$("input[name='dlg_search_addresstypename']").val();
	window.open('addresstype/downpdf'+array);
}

function downxls($id=0) {
	var array = 'addresstypeid='+$id
+ '&addresstypename='+$("input[name='dlg_search_addresstypename']").val();
	window.open('addresstype/downxls'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'addresstypeid='+$id
} 