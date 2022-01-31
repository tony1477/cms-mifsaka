if("undefined"==typeof jQuery)throw new Error("Forecast's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'forecast/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='forecast_0_forecastid']").val(data.forecastid);
			$("input[name='forecast_0_bulan']").val('');
      $("input[name='forecast_0_tahun']").val('');
      $("input[name='forecast_0_productid']").val('');
      $("input[name='forecast_0_qty']").val(data.qty);
      $("input[name='forecast_0_uomid']").val('');
      $("input[name='forecast_0_bomid']").val('');
      $("input[name='forecast_0_slocid']").val('');
      $("input[name='forecast_0_productname']").val('');
      $("input[name='forecast_0_uomcode']").val('');
      $("input[name='forecast_0_sloccode']").val('');
      $("input[name='forecast_0_bomversion']").val('');
			
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
	jQuery.ajax({'url':'forecast/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='forecast_0_forecastid']").val(data.forecastid);
				$("input[name='forecast_0_bulan']").val(data.bulan);
      $("input[name='forecast_0_tahun']").val(data.tahun);
      $("input[name='forecast_0_productid']").val(data.productid);
      $("input[name='forecast_0_qty']").val(data.qty);
      $("input[name='forecast_0_uomid']").val(data.uomid);
      $("input[name='forecast_0_bomid']").val(data.bomid);
      $("input[name='forecast_0_slocid']").val(data.slocid);
      $("input[name='forecast_0_productname']").val(data.productname);
      $("input[name='forecast_0_uomcode']").val(data.uomcode);
      $("input[name='forecast_0_sloccode']").val(data.sloccode);
      $("input[name='forecast_0_bomversion']").val(data.bomversion);
				
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

	jQuery.ajax({'url':'forecast/save',
		'data':{
			'forecastid':$("input[name='forecast_0_forecastid']").val(),
			'bulan':$("input[name='forecast_0_bulan']").val(),
      'tahun':$("input[name='forecast_0_tahun']").val(),
      'productid':$("input[name='forecast_0_productid']").val(),
      'qty':$("input[name='forecast_0_qty']").val(),
      'uomid':$("input[name='forecast_0_uomid']").val(),
      'slocid':$("input[name='forecast_0_slocid']").val(),
      'bomid':$("input[name='forecast_0_bomid']").val(),
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
	jQuery.ajax({'url':'forecast/delete',
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
	jQuery.ajax({'url':'forecast/purge','data':{'id':$id},
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

function generatefg()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'forecast/generatefg','data':
		{
			'companyname':$("input[name='dlg_search_companyname']").val(),
			'bulan':$("input[name='dlg_search_bulan']").val(),
			'tahun':$("input[name='dlg_search_tahun']").val(),
		},
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
		'forecastid':$id,
		'productname':$("input[name='dlg_search_productname']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'bulan':$("input[name='dlg_search_bulan']").val(),
		'tahun':$("input[name='dlg_search_tahun']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'forecastid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&bulan='+$("input[name='dlg_search_bulan']").val()
+ '&tahun='+$("input[name='dlg_search_tahun']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('forecast/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'forecastid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&bulan='+$("input[name='dlg_search_bulan']").val()
+ '&tahun='+$("input[name='dlg_search_tahun']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('forecast/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'forecastid='+$id
} 

function running(id,param2)
{
	jQuery.ajax({'url':'forecast/running',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.reload();
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}