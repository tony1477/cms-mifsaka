if("undefined"==typeof jQuery)throw new Error("Machine's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'machine/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='machineid']").val(data.machineid);
			
			$("input[name='productid']").val('');
      $("input[name='description']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='productname']").val('');
			
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
	jQuery.ajax({'url':'machine/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='machineid']").val(data.machineid);
				
				$("input[name='productid']").val(data.productid);
      $("input[name='description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='productname']").val(data.productname);
				
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
	jQuery.ajax({'url':'machine/save',
		'data':{
			
			'machineid':$("input[name='machineid']").val(),
			'productid':$("input[name='productid']").val(),
      'description':$("input[name='description']").val(),
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
	jQuery.ajax({'url':'machine/delete',
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
	jQuery.ajax({'url':'machine/purge','data':{'id':$id},
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
		'machineid':$id,
		'productname':$("input[name='dlg_search_productname']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'machineid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('machine/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'machineid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('machine/downxls?'+array);
}