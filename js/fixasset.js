if("undefined"==typeof jQuery)throw new Error("Fix Asset's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'fixasset/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='fixassetid']").val(data.fixassetid);
			$("input[name='companyid']").val(data.companyid);
      $("input[name='podetailid']").val('');
      $("input[name='assetno']").val('');
      $("input[name='buydate']").val(data.buydate);
      $("input[name='productid']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='uomid']").val('');
      $("input[name='price']").val(data.price);
      $("input[name='nilairesidu']").val(data.nilairesidu);
      $("input[name='famethodid']").val('');
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='accakum']").val('');
      $("input[name='accbiaya']").val('');
      $("input[name='accperolehan']").val('');
      $("input[name='acckorpem']").val('');
      $("input[name='umur']").val(data.umur);
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='pono']").val('');
      $("input[name='productname']").val('');
      $("input[name='uomcode']").val('');
      $("input[name='methodname']").val('');
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='accakumcode']").val('');
      $("input[name='accbiayacode']").val('');
      $("input[name='accperolehancode']").val('');
      $("input[name='acckorpemcode']").val('');
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
	jQuery.ajax({'url':'fixasset/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='fixassetid']").val(data.fixassetid);
				$("input[name='companyid']").val(data.companyid);
      $("input[name='podetailid']").val(data.podetailid);
      $("input[name='assetno']").val(data.assetno);
      $("input[name='buydate']").val(data.buydate);
      $("input[name='productid']").val(data.productid);
      $("input[name='qty']").val(data.qty);
      $("input[name='uomid']").val(data.uomid);
      $("input[name='price']").val(data.price);
      $("input[name='nilairesidu']").val(data.nilairesidu);
      $("input[name='famethodid']").val(data.famethodid);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='accakum']").val(data.accakum);
      $("input[name='accbiaya']").val(data.accbiaya);
      $("input[name='accperolehan']").val(data.accperolehan);
      $("input[name='acckorpem']").val(data.acckorpem);
      $("input[name='umur']").val(data.umur);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='companyname']").val(data.companyname);
      $("input[name='pono']").val(data.pono);
      $("input[name='productname']").val(data.productname);
      $("input[name='uomcode']").val(data.uomcode);
      $("input[name='methodname']").val(data.methodname);
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='accakumcode']").val(data.accakumcode);
      $("input[name='accbiayacode']").val(data.accbiayacode);
      $("input[name='accperolehancode']").val(data.accperolehancode);
      $("input[name='acckorpemcode']").val(data.acckorpemcode);
				
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
	jQuery.ajax({'url':'fixasset/save',
		'data':{
			
			'fixassetid':$("input[name='fixassetid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'podetailid':$("input[name='podetailid']").val(),
      'assetno':$("input[name='assetno']").val(),
      'buydate':$("input[name='buydate']").val(),
      'productid':$("input[name='productid']").val(),
      'qty':$("input[name='qty']").val(),
      'uomid':$("input[name='uomid']").val(),
      'price':$("input[name='price']").val(),
      'nilairesidu':$("input[name='nilairesidu']").val(),
      'famethodid':$("input[name='famethodid']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'currencyrate':$("input[name='currencyrate']").val(),
      'accakum':$("input[name='accakum']").val(),
      'accbiaya':$("input[name='accbiaya']").val(),
      'accperolehan':$("input[name='accperolehan']").val(),
      'acckorpem':$("input[name='acckorpem']").val(),
      'umur':$("input[name='umur']").val(),
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
	jQuery.ajax({'url':'fixasset/delete',
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
	jQuery.ajax({'url':'fixasset/purge','data':{'id':$id},
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
		'fixassetid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'assetno':$("input[name='dlg_search_assetno']").val(),
		'productname':$("input[name='dlg_search_productname']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val(),
		'accakumcode':$("input[name='dlg_search_accakumcode']").val(),
		'accbiayacode':$("input[name='dlg_search_accbiayacode']").val(),
		'accperolehancode':$("input[name='dlg_search_accperolehancode']").val(),
		'acckorpemcode':$("input[name='dlg_search_acckorpemcode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'fixassetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&assetno='+$("input[name='dlg_search_assetno']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&accakumcode='+$("input[name='dlg_search_accakumcode']").val()
+ '&accbiayacode='+$("input[name='dlg_search_accbiayacode']").val()
+ '&accperolehancode='+$("input[name='dlg_search_accperolehancode']").val()
+ '&acckorpemcode='+$("input[name='dlg_search_acckorpemcode']").val();
	window.open('fixasset/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'fixassetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&assetno='+$("input[name='dlg_search_assetno']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&accakumcode='+$("input[name='dlg_search_accakumcode']").val()
+ '&accbiayacode='+$("input[name='dlg_search_accbiayacode']").val()
+ '&accperolehancode='+$("input[name='dlg_search_accperolehancode']").val()
+ '&acckorpemcode='+$("input[name='dlg_search_acckorpemcode']").val();
	window.open('fixasset/downxls?'+array);
}