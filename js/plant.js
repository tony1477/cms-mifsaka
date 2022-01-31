if("undefined"==typeof jQuery)throw new Error("Plant's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'plant/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='plant_0_plantid']").val(data.plantid);
			$("input[name='plant_0_companyid']").val(data.companyid);
      $("input[name='plant_0_plantcode']").val('');
      $("input[name='plant_0_description']").val('');
      $("input[name='plant_0_recordstatus']").prop('checked',true);
      $("input[name='plant_0_companyname']").val(data.companyname);
			
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
	jQuery.ajax({'url':'plant/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='plant_0_plantid']").val(data.plantid);
				$("input[name='plant_0_companyid']").val(data.companyid);
      $("input[name='plant_0_plantcode']").val(data.plantcode);
      $("input[name='plant_0_description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='plant_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='plant_0_recordstatus']").prop('checked',false)
			}
      $("input[name='plant_0_companyname']").val(data.companyname);
				
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
	if ($("input[name='plant_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'plant/save',
		'data':{
			'plantid':$("input[name='plant_0_plantid']").val(),
			'companyid':$("input[name='plant_0_companyid']").val(),
      'plantcode':$("input[name='plant_0_plantcode']").val(),
      'description':$("input[name='plant_0_description']").val(),
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
	jQuery.ajax({'url':'plant/delete',
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
	jQuery.ajax({'url':'plant/purge','data':{'id':$id},
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
	var array = 'plantid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&plantcode='+$("input[name='dlg_search_plantcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'plantid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&plantcode='+$("input[name='dlg_search_plantcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('plant/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'plantid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&plantcode='+$("input[name='dlg_search_plantcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('plant/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'plantid='+$id
} 