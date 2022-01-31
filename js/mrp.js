if("undefined"==typeof jQuery)throw new Error("MRP's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'mrp/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='mrpid']").val(data.mrpid);
			
			$("input[name='companyid']").val(data.companyid);
      $("input[name='productid']").val('');
      $("input[name='slocid']").val('');
      $("input[name='uomid']").val('');
      $("input[name='minstock']").val(data.minstock);
      $("input[name='reordervalue']").val(data.reordervalue);
      $("input[name='maxvalue']").val(data.maxvalue);
      $("input[name='leadtime']").val(data.leadtime);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='productname']").val('');
      $("input[name='sloccode']").val('');
      $("input[name='uomcode']").val('');
			
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
	jQuery.ajax({'url':'mrp/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='mrpid']").val(data.mrpid);
				
				$("input[name='companyid']").val(data.companyid);
      $("input[name='productid']").val(data.productid);
      $("input[name='slocid']").val(data.slocid);
      $("input[name='uomid']").val(data.uomid);
      $("input[name='minstock']").val(data.minstock);
      $("input[name='reordervalue']").val(data.reordervalue);
      $("input[name='maxvalue']").val(data.maxvalue);
      $("input[name='leadtime']").val(data.leadtime);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='productname']").val(data.productname);
      $("input[name='sloccode']").val(data.sloccode);
      $("input[name='uomcode']").val(data.uomcode);
				
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

	jQuery.ajax({'url':'mrp/save',
		'data':{
			
			'mrpid':$("input[name='mrpid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'productid':$("input[name='productid']").val(),
      'slocid':$("input[name='slocid']").val(),
      'uomid':$("input[name='uomid']").val(),
      'minstock':$("input[name='minstock']").val(),
      'reordervalue':$("input[name='reordervalue']").val(),
      'maxvalue':$("input[name='maxvalue']").val(),
      'leadtime':$("input[name='leadtime']").val(),
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



function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'mrp/purge','data':{'id':$id},
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
		'mrpid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'productname':$("input[name='dlg_search_productname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'mrpid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('mrp/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'mrpid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('mrp/downxls?'+array);
}