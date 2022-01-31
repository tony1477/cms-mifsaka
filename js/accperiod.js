if("undefined"==typeof jQuery)throw new Error("Accounting Period's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'accperiod/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='accperiod_0_accperiodid']").val(data.accperiodid);
			$("input[name='accperiod_0_period']").val(data.period);
      $("input[name='accperiod_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'accperiod/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='accperiod_0_accperiodid']").val(data.accperiodid);
				$("input[name='accperiod_0_period']").val(data.period);
      if (data.recordstatus == 1)
			{
				$("input[name='accperiod_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='accperiod_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='accperiod_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'accperiod/save',
		'data':{
			'accperiodid':$("input[name='accperiod_0_accperiodid']").val(),
			'period':$("input[name='accperiod_0_period']").val(),
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
	jQuery.ajax({'url':'accperiod/delete',
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
	jQuery.ajax({'url':'accperiod/purge','data':{'id':$id},
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
		'accperiodid':$id,
		'period':$("input[name='dlg_search_period']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'accperiodid='+$id
+ '&period='+$("input[name='dlg_search_period']").val();
	window.open('accperiod/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'accperiodid='+$id
+ '&period='+$("input[name='dlg_search_period']").val();
	window.open('accperiod/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'accperiodid='+$id
} 