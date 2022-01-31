if("undefined"==typeof jQuery)throw new Error("Romawi's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'romawi/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='romawi_0_romawiid']").val(data.romawiid);
			$("input[name='romawi_0_monthcal']").val('');
      $("input[name='romawi_0_monthrm']").val('');
      $("input[name='romawi_0_recordstatus']").prop('checked',true);
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
	jQuery.ajax({'url':'romawi/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='romawi_0_romawiid']").val(data.romawiid);
				$("input[name='romawi_0_monthcal']").val(data.monthcal);
				$("input[name='romawi_0_monthrm']").val(data.monthrm);
				if (data.recordstatus == 1)
				{
					$("input[name='romawi_0_recordstatus']").prop('checked',true);
				}
				else
				{
					$("input[name='romawi_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='romawi_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'romawi/save',
		'data':{
			'romawiid':$("input[name='romawi_0_romawiid']").val(),
			'monthcal':$("input[name='romawi_0_monthcal']").val(),
      'monthrm':$("input[name='romawi_0_monthrm']").val(),
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
	jQuery.ajax({'url':'romawi/delete',
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
	jQuery.ajax({'url':'romawi/purge','data':{'id':$id},
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
		'romawiid':$id,
		'monthrm':$("input[name='dlg_search_monthrm']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'romawiid='+$id
+ '&monthrm='+$("input[name='dlg_search_monthrm']").val();
	window.open('romawi/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'romawiid='+$id
+ '&monthrm='+$("input[name='dlg_search_monthrm']").val();
	window.open('romawi/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'romawiid='+$id
} 