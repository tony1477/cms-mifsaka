if("undefined"==typeof jQuery)throw new Error("Unit of Measure's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'unitofmeasure/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='unitofmeasure_0_unitofmeasureid']").val(data.unitofmeasureid);
			$("input[name='unitofmeasure_0_uomcode']").val('');
      $("input[name='unitofmeasure_0_description']").val('');
      $("input[name='unitofmeasure_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'unitofmeasure/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='unitofmeasure_0_unitofmeasureid']").val(data.unitofmeasureid);
				$("input[name='unitofmeasure_0_uomcode']").val(data.uomcode);
      $("input[name='unitofmeasure_0_description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='unitofmeasure_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='unitofmeasure_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='unitofmeasure_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'unitofmeasure/save',
		'data':{
			'unitofmeasureid':$("input[name='unitofmeasure_0_unitofmeasureid']").val(),
			'uomcode':$("input[name='unitofmeasure_0_uomcode']").val(),
      'description':$("input[name='unitofmeasure_0_description']").val(),
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
	jQuery.ajax({'url':'unitofmeasure/delete',
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
	jQuery.ajax({'url':'unitofmeasure/purge','data':{'id':$id},
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
		'unitofmeasureid':$id,
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'description':$("input[name='dlg_search_description']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'unitofmeasureid='+$id
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('unitofmeasure/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'unitofmeasureid='+$id
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('unitofmeasure/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'unitofmeasureid='+$id
} 