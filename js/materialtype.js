if("undefined"==typeof jQuery)throw new Error("Material Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'materialtype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='materialtype_0_materialtypeid']").val(data.materialtypeid);
			$("input[name='materialtype_0_materialtypecode']").val('');
      $("input[name='materialtype_0_description']").val('');
      $("input[name='materialtype_0_recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'materialtype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='materialtype_0_materialtypeid']").val(data.materialtypeid);
				$("input[name='materialtype_0_materialtypecode']").val(data.materialtypecode);
      $("input[name='materialtype_0_description']").val(data.description);
      $("input[name='materialtype_0_nourut']").val(data.nourut);
      if (data.recordstatus == 1)
			{
				$("input[name='materialtype_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='materialtype_0_recordstatus']").prop('checked',false)
			}
            if (data.isview == 1)
			{
				$("input[name='materialtype_0_isview']").prop('checked',true);
			}
			else
			{
				$("input[name='materialtype_0_isview']").prop('checked',false)
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
var isview = 0;
	if ($("input[name='materialtype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
    
    if ($("input[name='materialtype_0_isview']").prop('checked'))
	{
		isview = 1;
	}
	else
	{
		isview = 0;
	}
	jQuery.ajax({'url':'materialtype/save',
		'data':{
			'materialtypeid':$("input[name='materialtype_0_materialtypeid']").val(),
			'materialtypecode':$("input[name='materialtype_0_materialtypecode']").val(),
      'description':$("input[name='materialtype_0_description']").val(),
      'nourut':$("input[name='materialtype_0_nourut']").val(),
      'isview':isview,
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
	jQuery.ajax({'url':'materialtype/delete',
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
	jQuery.ajax({'url':'materialtype/purge','data':{'id':$id},
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
		'materialtypeid':$id,
		'materialtypecode':$("input[name='dlg_search_materialtypecode']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'materialtypeid='+$id
+ '&materialtypecode='+$("input[name='dlg_search_materialtypecode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('materialtype/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'materialtypeid='+$id
+ '&materialtypecode='+$("input[name='dlg_search_materialtypecode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('materialtype/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'materialtypeid='+$id
} 