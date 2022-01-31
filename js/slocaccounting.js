if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'slocaccounting/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='slocaccounting_0_slocaccid']").val(data.slocaccid);
			$("input[name='slocaccounting_0_slocid']").val('');
      $("input[name='slocaccounting_0_materialgroupid']").val('');
      $("input[name='slocaccounting_0_accaktivatetap']").val('');
      $("input[name='slocaccounting_0_accakumat']").val('');
      $("input[name='slocaccounting_0_accbiayaat']").val('');
      $("input[name='slocaccounting_0_accpersediaan']").val('');
      $("input[name='slocaccounting_0_accreturpembelian']").val('');
      $("input[name='slocaccounting_0_accdiscpembelian']").val('');
      $("input[name='slocaccounting_0_accpenjualan']").val('');
      $("input[name='slocaccounting_0_accbiaya']").val('');
      $("input[name='slocaccounting_0_accreturpenjualan']").val('');
      $("input[name='slocaccounting_0_accspsi']").val('');
      $("input[name='slocaccounting_0_accexpedisi']").val('');
      $("input[name='slocaccounting_0_hpp']").val('');
      $("input[name='slocaccounting_0_accupahlembur']").val('');
      $("input[name='slocaccounting_0_foh']").val('');
      $("input[name='slocaccounting_0_sloccode']").val('');
      $("input[name='slocaccounting_0_materialgroupcode']").val('');
      $("input[name='slocaccounting_0_accaktivatetap']").val('');
      $("input[name='slocaccounting_0_accakumatname']").val('');
      $("input[name='slocaccounting_0_accbiayaatname']").val('');
      $("input[name='slocaccounting_0_accpersediaanname']").val('');
      $("input[name='slocaccounting_0_accreturpembelianname']").val('');
      $("input[name='slocaccounting_0_accdiscpembelianname']").val('');
      $("input[name='slocaccounting_0_accpenjualanname']").val('');
      $("input[name='slocaccounting_0_accbiayaname']").val('');
      $("input[name='slocaccounting_0_accreturpenjualanname']").val('');
      $("input[name='slocaccounting_0_accspsiname']").val('');
      $("input[name='slocaccounting_0_accexpedisiname']").val('');
      $("input[name='slocaccounting_0_acchppname']").val('');
      $("input[name='slocaccounting_0_accupahlemburname']").val('');
      $("input[name='slocaccounting_0_accfohname']").val('');
      $("input[name='slocaccounting_0_acckoreksiname']").val('');
      $("input[name='slocaccounting_0_acccadanganname']").val('');
			
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
	jQuery.ajax({'url':'slocaccounting/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='slocaccounting_0_slocaccid']").val(data.slocaccid);
				$("input[name='slocaccounting_0_slocid']").val(data.slocid);
                $("input[name='slocaccounting_0_materialgroupid']").val(data.materialgroupid);
                $("input[name='slocaccounting_0_accaktivatetap']").val(data.accaktivatetap);
                $("input[name='slocaccounting_0_accakumat']").val(data.accakumat);
                $("input[name='slocaccounting_0_accbiayaat']").val(data.accbiayaat);
                $("input[name='slocaccounting_0_accpersediaan']").val(data.accpersediaan);
                $("input[name='slocaccounting_0_accreturpembelian']").val(data.accreturpembelian);
                $("input[name='slocaccounting_0_accdiscpembelian']").val(data.accdiscpembelian);
                $("input[name='slocaccounting_0_accpenjualan']").val(data.accpenjualan);
                $("input[name='slocaccounting_0_accbiaya']").val(data.accbiaya);
                $("input[name='slocaccounting_0_accreturpenjualan']").val(data.accreturpenjualan);
                $("input[name='slocaccounting_0_accspsi']").val(data.accspsi);
                $("input[name='slocaccounting_0_accexpedisi']").val(data.accexpedisi);
                $("input[name='slocaccounting_0_hpp']").val(data.hpp);
                $("input[name='slocaccounting_0_accupahlembur']").val(data.accupahlembur);
                $("input[name='slocaccounting_0_foh']").val(data.foh);
                $("input[name='slocaccounting_0_sloccode']").val(data.sloccode);
                $("input[name='slocaccounting_0_materialgroupcode']").val(data.materialgroupcode);
                $("input[name='slocaccounting_0_accaktivatetap']").val(data.accaktivatetap);
                $("input[name='slocaccounting_0_accakumatname']").val(data.accakumatname);
                $("input[name='slocaccounting_0_accbiayaatname']").val(data.accbiayaatname);
                $("input[name='slocaccounting_0_accpersediaanname']").val(data.accpersediaanname);
                $("input[name='slocaccounting_0_accreturpembelianname']").val(data.accreturpembelianname);
                $("input[name='slocaccounting_0_accdiscpembelianname']").val(data.accdiscpembelianname);
                $("input[name='slocaccounting_0_accpenjualanname']").val(data.accpenjualanname);
                $("input[name='slocaccounting_0_accbiayaname']").val(data.accbiayaname);
                $("input[name='slocaccounting_0_accreturpenjualanname']").val(data.accreturpenjualanname);
                $("input[name='slocaccounting_0_accspsiname']").val(data.accspsiname);
                $("input[name='slocaccounting_0_accexpedisiname']").val(data.accexpedisiname);
                $("input[name='slocaccounting_0_acchppname']").val(data.acchppname);
                $("input[name='slocaccounting_0_accupahlemburname']").val(data.accupahlemburname);
                $("input[name='slocaccounting_0_accfohname']").val(data.accfohname);
                $("input[name='slocaccounting_0_acckoreksiname']").val(data.acckoreksiname);
                $("input[name='slocaccounting_0_acccadanganname']").val(data.acccadanganname);
				
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

	jQuery.ajax({'url':'slocaccounting/save',
		'data':{
			'slocaccid':$("input[name='slocaccounting_0_slocaccid']").val(),
			'slocid':$("input[name='slocaccounting_0_slocid']").val(),
      'materialgroupid':$("input[name='slocaccounting_0_materialgroupid']").val(),
      'accaktivatetap':$("input[name='slocaccounting_0_accaktivatetap']").val(),
      'accakumat':$("input[name='slocaccounting_0_accakumat']").val(),
      'accbiayaat':$("input[name='slocaccounting_0_accbiayaat']").val(),
      'accpersediaan':$("input[name='slocaccounting_0_accpersediaan']").val(),
      'accreturpembelian':$("input[name='slocaccounting_0_accreturpembelian']").val(),
      'accdiscpembelian':$("input[name='slocaccounting_0_accdiscpembelian']").val(),
      'accpenjualan':$("input[name='slocaccounting_0_accpenjualan']").val(),
      'accbiaya':$("input[name='slocaccounting_0_accbiaya']").val(),
      'accreturpenjualan':$("input[name='slocaccounting_0_accreturpenjualan']").val(),
      'accspsi':$("input[name='slocaccounting_0_accspsi']").val(),
      'accexpedisi':$("input[name='slocaccounting_0_accexpedisi']").val(),
      'hpp':$("input[name='slocaccounting_0_hpp']").val(),
      'accupahlembur':$("input[name='slocaccounting_0_accupahlembur']").val(),
      'foh':$("input[name='slocaccounting_0_foh']").val(),
      'acckoreksi':$("input[name='slocaccounting_0_acckoreksi']").val(),
      'acccadangan':$("input[name='slocaccounting_0_acccadangan']").val(),
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
	jQuery.ajax({'url':'slocaccounting/delete',
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
	jQuery.ajax({'url':'slocaccounting/purge','data':{'id':$id},
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
		'slocaccid':$id,
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'materialgroupcode':$("input[name='dlg_search_materialgroupcode']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'slocaccid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&materialgroupcode='+$("input[name='dlg_search_materialgroupcode']").val();
	window.open('slocaccounting/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'slocaccid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&materialgroupcode='+$("input[name='dlg_search_materialgroupcode']").val();
	window.open('slocaccounting/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'slocaccid='+$id
} 