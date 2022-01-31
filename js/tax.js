if("undefined"==typeof jQuery)throw new Error("Tax's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'tax/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='tax_0_taxid']").val(data.taxid);
			$("input[name='tax_0_taxcode']").val('');
      $("input[name='tax_0_taxvalue']").val('');
      $("input[name='tax_0_description']").val('');
      $("input[name='tax_0_taxvalue']").val('');
      $("input[name='tax_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'tax/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='tax_0_taxid']").val(data.taxid);
				$("input[name='tax_0_taxcode']").val(data.taxcode);
      $("input[name='tax_0_taxvalue']").val(data.taxvalue);
      $("input[name='tax_0_description']").val(data.description);
      $("input[name='tax_0_taxvalue']").val(data.taxvalue);
      if (data.recordstatus == 1)
			{
				$("input[name='tax_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='tax_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='tax_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'tax/save',
		'data':{
			'taxid':$("input[name='tax_0_taxid']").val(),
			'taxcode':$("input[name='tax_0_taxcode']").val(),
      'taxvalue':$("input[name='tax_0_taxvalue']").val(),
      'description':$("input[name='tax_0_description']").val(),
      'taxvalue':$("input[name='tax_0_taxvalue']").val(),
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
	jQuery.ajax({'url':'tax/delete',
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
	jQuery.ajax({'url':'tax/purge','data':{'id':$id},
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
	var array = 'taxid='+$id
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'taxid='+$id
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('tax/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'taxid='+$id
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('tax/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'taxid='+$id
} 