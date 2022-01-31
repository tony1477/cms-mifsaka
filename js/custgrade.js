if("undefined"==typeof jQuery)throw new Error("Customer Grade's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'custgrade/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='custgrade_0_custgradeid']").val(data.custgradeid);
                $("input[name='custgrade_0_custgradename']").val('');
                $("input[name='custgrade_0_custogradedesc']").val('');
                $("input[name='custgrade_0_description']").val('');
                $("input[name='custgrade_0_recordstatus']").prop('checked',true);
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
	jQuery.ajax({'url':'custgrade/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='custgrade_0_custgradeid']").val(data.custgradeid);
                $("input[name='custgrade_0_custgradename']").val(data.custgradename);
                $("input[name='custgrade_0_custogradedesc']").val(data.custogradedesc);
                $("input[name='custgrade_0_description']").val(data.description);
                if (data.recordstatus == 1)
                {
                    $("input[name='custgrade_0_recordstatus']").prop('checked',true);
                }
                else
                {
                    $("input[name='custgrade_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='custgrade_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'custgrade/save',
		'data':{
			'custgradeid':$("input[name='custgrade_0_custgradeid']").val(),
			'custgradename':$("input[name='custgrade_0_custgradename']").val(),
            'custogradedesc':$("input[name='custgrade_0_custogradedesc']").val(),
            'description':$("input[name='custgrade_0_description']").val(),
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
	jQuery.ajax({'url':'custgrade/delete',
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
	jQuery.ajax({'url':'custgrade/purge','data':{'id':$id},
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
		'custgradeid':$id,
		'custgradename':$("input[name='dlg_search_custgradename']").val(),
		'custogradedesc':$("input[name='dlg_search_custogradedesc']").val(),
		'description':$("input[name='dlg_search_description']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'custgradeid='+$id
+ '&custgradename='+$("input[name='dlg_search_custgradename']").val()
+ '&custogradedesc='+$("input[name='dlg_search_custogradedesc']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('custgrade/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'custgradeid='+$id
+ '&custgradename='+$("input[name='dlg_search_custgradename']").val()
+ '&custogradedesc='+$("input[name='dlg_search_custogradedesc']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('custgrade/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'custgradeid='+$id
} 