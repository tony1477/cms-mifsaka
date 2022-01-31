if("undefined"==typeof jQuery)throw new Error("SNRO Detail's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'snrodet/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='snrodid']").val(data.snroid);
				$("input[name='companyname ']").val('');
				$("input[name='description ']").val('');
				$("input[name='curdd  ']").val('');
				$("input[name='curmm ']").val('');
				$("input[name='curyy ']").val('');
				$("input[name='curvalue ']").val('');
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
	jQuery.ajax({'url':'snro/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='snroid']").val(data.snroid);
				$("input[name='description']").val(data.description);
				$("input[name='formatdoc']").val(data.formatdoc);
				$("input[name='formatno']").val(data.formatno);
				$("input[name='repeatby']").val(data.repeatby);
				if (data.recordstatus == 1)
				{
					$("input[name='recordstatus']").prop('checked',true);
				}
				else
				{
					$("input[name='recordstatus']").prop('checked',false)
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
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'snrodet/save',
		'data':{
			$("input[name='snroid']").val(data.snroid),
			$("input[name='description']").val(data.description),
			$("input[name='formatdoc']").val(data.formatdoc),
			$("input[name='formatno']").val(data.formatno),
			$("input[name='repeatby']").val(data.repeatby)
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
	jQuery.ajax({'url':'snro/delete',
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
	jQuery.ajax({'url':'snro/purge','data':{'id':$id},
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
		'snroid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'description':$("input[name='dlg_search_description']").val(),
		'curyy':$("input[name='dlg_search_curyy']").val()
		
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'snroid='+$id
	+ '&description='+$("input[name='dlg_search_description']").val()
	+ '&formatdoc='+$("input[name='dlg_search_formatdoc']").val()
	+ '&formatno='+$("input[name='dlg_search_formatno']").val()
	+ '&repeatby='+$("input[name='dlg_search_repeatby']").val();
	window.open('snro/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'snroid='+$id
	+ '&description='+$("input[name='dlg_search_description']").val()
	+ '&formatdoc='+$("input[name='dlg_search_formatdoc']").val()
	+ '&formatno='+$("input[name='dlg_search_formatno']").val()
	+ '&repeatby='+$("input[name='dlg_search_repeatby']").val();
	window.open('snro/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'snroid='+$id
} 