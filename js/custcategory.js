if("undefined"==typeof jQuery)throw new Error("Customer Category's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'custcategory/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='custcategory_0_custcategoryid']").val(data.custcategoryid);
                $("input[name='custcategory_0_custcategoryname']").val('');
                $("input[name='custcategory_0_recordstatus']").prop('checked',true);
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
	jQuery.ajax({'url':'custcategory/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='custcategory_0_custcategoryid']").val(data.custcategoryid);
                $("input[name='custcategory_0_custcategoryname']").val(data.custcategoryname);
                if (data.recordstatus == 1)
                {
                    $("input[name='custcategory_0_recordstatus']").prop('checked',true);
                }
                else
                {
                    $("input[name='custcategory_0_recordstatus']").prop('checked',false)
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
	if ($("input[name='custcategory_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'custcategory/save',
		'data':{
			'custcategoryid':$("input[name='custcategory_0_custcategoryid']").val(),
			'custcategoryname':$("input[name='custcategory_0_custcategoryname']").val(),
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
	jQuery.ajax({'url':'custcategory/delete',
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
	jQuery.ajax({'url':'custcategory/purge','data':{'id':$id},
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
		'custcategoryid':$id,
		'custcategoryname':$("input[name='dlg_search_custcategoryname']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'custcategoryid='+$id
+ '&custcategoryname='+$("input[name='dlg_search_custcategoryname']").val();
	window.open('custcategory/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'custcategoryid='+$id
+ '&custcategoryname='+$("input[name='dlg_search_custcategoryname']").val();
	window.open('custcategory/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'custcategoryid='+$id
} 