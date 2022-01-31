if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'productsales/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productsales_0_productsalesid']").val(data.productsalesid);
			$("input[name='productsales_0_productid']").val('');
      $("input[name='productsales_0_currencyid']").val(data.currencyid);
      $("input[name='productsales_0_currencyvalue']").val(data.currencyvalue);
      $("input[name='productsales_0_pricecategoryid']").val('');
      $("input[name='productsales_0_uomid']").val('');
      $("input[name='productsales_0_productname']").val('');
      $("input[name='productsales_0_currencyname']").val(data.currencyname);
      $("input[name='productsales_0_categoryname']").val('');
      $("input[name='productsales_0_uomcode']").val('');
			
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
	jQuery.ajax({'url':'productsales/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='productsales_0_productsalesid']").val(data.productsalesid);
				$("input[name='productsales_0_productid']").val(data.productid);
      $("input[name='productsales_0_currencyid']").val(data.currencyid);
      $("input[name='productsales_0_currencyvalue']").val(data.currencyvalue);
      $("input[name='productsales_0_pricecategoryid']").val(data.pricecategoryid);
      $("input[name='productsales_0_uomid']").val(data.uomid);
      $("input[name='productsales_0_productname']").val(data.productname);
      $("input[name='productsales_0_currencyname']").val(data.currencyname);
      $("input[name='productsales_0_categoryname']").val(data.categoryname);
      $("input[name='productsales_0_uomcode']").val(data.uomcode);
				
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

	jQuery.ajax({'url':'productsales/save',
		'data':{
			'productsalesid':$("input[name='productsales_0_productsalesid']").val(),
			'productid':$("input[name='productsales_0_productid']").val(),
      'currencyid':$("input[name='productsales_0_currencyid']").val(),
      'currencyvalue':$("input[name='productsales_0_currencyvalue']").val(),
      'pricecategoryid':$("input[name='productsales_0_pricecategoryid']").val(),
      'uomid':$("input[name='productsales_0_uomid']").val(),
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
	jQuery.ajax({'url':'productsales/delete',
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
	jQuery.ajax({'url':'productsales/purge','data':{'id':$id},
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
		'productsalesid':$id,
		'productname':$("input[name='dlg_search_productname']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val(),
		'categoryname':$("input[name='dlg_search_categoryname']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productsalesid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('productsales/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productsalesid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('productsales/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productsalesid='+$id
} 