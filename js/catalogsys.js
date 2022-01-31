if("undefined"==typeof jQuery)throw new Error("Catalog Translation System's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'catalogsys/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='catalogsysid']").val(data.catalogsysid);
				$("input[name='languageid']").val('');
				$("input[name='catalogname']").val('');
				$("input[name='catalogval']").val('');
				$("input[name='languagename']").val('');
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
	jQuery.ajax({'url':'catalogsys/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='catalogsysid']").val(data.catalogsysid);
				$("input[name='languageid']").val(data.languageid);
				$("input[name='catalogname']").val(data.catalogname);
				$("input[name='catalogval']").val(data.catalogval);
				$("input[name='languagename']").val(data.languagename);
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
	jQuery.ajax({'url':'catalogsys/save',
		'data':{
			'catalogsysid':$("input[name='catalogsysid']").val(),
			'languageid':$("input[name='languageid']").val(),
      'catalogname':$("input[name='catalogname']").val(),
      'catalogval':$("input[name='catalogval']").val(),
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
	jQuery.ajax({'url':'catalogsys/delete',
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
	jQuery.ajax({'url':'catalogsys/purge','data':{'id':$id},
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
		'catalogsysid':$id,
		'languagename':$("input[name='dlg_search_languagename']").val(),
		'catalogname':$("input[name='dlg_search_catalogname']").val(),
		'catalogval':$("input[name='dlg_search_catalogval']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'catalogsysid='+$id
+ '&languagename='+$("input[name='dlg_search_languagename']").val()
+ '&catalogname='+$("input[name='dlg_search_catalogname']").val()
+ '&catalogval='+$("input[name='dlg_search_catalogval']").val();
	window.open('catalogsys/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'catalogsysid='+$id
+ '&languagename='+$("input[name='dlg_search_languagename']").val()
+ '&catalogname='+$("input[name='dlg_search_catalogname']").val()
+ '&catalogval='+$("input[name='dlg_search_catalogval']").val();
	window.open('catalogsys/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'catalogsysid='+$id
} 