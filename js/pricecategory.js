if("undefined"==typeof jQuery)throw new Error("Price Category's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'pricecategory/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='pricecategory_0_pricecategoryid']").val(data.pricecategoryid);
			$("input[name='pricecategory_0_categoryname']").val('');
      $("input[name='pricecategory_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'pricecategory/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='pricecategory_0_pricecategoryid']").val(data.pricecategoryid);
				$("input[name='pricecategory_0_categoryname']").val(data.categoryname);
      if (data.recordstatus == 1)
			{
				$("input[name='pricecategory_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='pricecategory_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='pricecategory_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'pricecategory/save',
		'data':{
			'pricecategoryid':$("input[name='pricecategory_0_pricecategoryid']").val(),
			'categoryname':$("input[name='pricecategory_0_categoryname']").val(),
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
	jQuery.ajax({'url':'pricecategory/delete',
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
	jQuery.ajax({'url':'pricecategory/purge','data':{'id':$id},
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
		'pricecategoryid':$id,
		'categoryname':$("input[name='dlg_search_categoryname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'pricecategoryid='+$id
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val();
	window.open('pricecategory/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'pricecategoryid='+$id
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val();
	window.open('pricecategory/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'pricecategoryid='+$id
} 