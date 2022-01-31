if("undefined"==typeof jQuery)throw new Error("Contact Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'contacttype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='contacttype_0_contacttypeid']").val(data.contacttypeid);
			$("input[name='contacttype_0_contacttypename']").val('');
      $("input[name='contacttype_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'contacttype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='contacttype_0_contacttypeid']").val(data.contacttypeid);
				$("input[name='contacttype_0_contacttypename']").val(data.contacttypename);
      if (data.recordstatus == 1)
			{
				$("input[name='contacttype_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='contacttype_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='contacttype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'contacttype/save',
		'data':{
			'contacttypeid':$("input[name='contacttype_0_contacttypeid']").val(),
			'contacttypename':$("input[name='contacttype_0_contacttypename']").val(),
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
	jQuery.ajax({'url':'contacttype/delete',
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
	jQuery.ajax({'url':'contacttype/purge','data':{'id':$id},
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
		'contacttypeid':$id,
		'contacttypename':$("input[name='dlg_search_contacttypename']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'contacttypeid='+$id
+ '&contacttypename='+$("input[name='dlg_search_contacttypename']").val();
	window.open('contacttype/downpdf'+array);
}

function downxls($id=0) {
	var array = 'contacttypeid='+$id
+ '&contacttypename='+$("input[name='dlg_search_contacttypename']").val();
	window.open('contacttype/downxls'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'contacttypeid='+$id
} 