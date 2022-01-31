if("undefined"==typeof jQuery)throw new Error("Sloc Accounting's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'slocacc/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='slocaccid']").val(data.slocaccid);
			
			$("input[name='companyid']").val(data.companyid);
      $("input[name='slocid']").val('');
      $("input[name='materialgroupid']").val('');
      $("input[name='accaktivatetap']").val('');
      $("input[name='accakumat']").val('');
      $("input[name='accbiayaat']").val('');
      $("input[name='accpersediaan']").val('');
      $("input[name='accreturpembelian']").val('');
      $("input[name='accdiscpembelian']").val('');
      $("input[name='accpenjualan']").val('');
      $("input[name='accbiaya']").val('');
      $("input[name='accreturpenjualan']").val('');
      $("input[name='accspsi']").val('');
      $("input[name='accexpedisi']").val('');
      $("input[name='hpp']").val('');
      $("input[name='accupahlembur']").val('');
      $("input[name='foh']").val('');
      $("input[name='companyname']").val(data.companyname);
      $("input[name='sloccode']").val('');
      $("input[name='materialgroupdesc']").val('');
      $("input[name='accaktivaname']").val('');
      $("input[name='accakumatname']").val('');
      $("input[name='accbiayaatname']").val('');
      $("input[name='accpersediaanname']").val('');
      $("input[name='accreturpembelianname']").val('');
      $("input[name='accdiscbeliname']").val('');
      $("input[name='accpenjualanname']").val('');
      $("input[name='accbiayaname']").val('');
      $("input[name='accreturjualname']").val('');
      $("input[name='accspsiname']").val('');
      $("input[name='accexpedisiname']").val('');
      $("input[name='hppname']").val('');
      $("input[name='accupahlemname']").val('');
      $("input[name='fohname']").val('');
			
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
	jQuery.ajax({'url':'slocacc/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='slocaccid']").val(data.slocaccid);
				
				$("input[name='companyid']").val(data.companyid);
      $("input[name='slocid']").val(data.slocid);
      $("input[name='materialgroupid']").val(data.materialgroupid);
      $("input[name='accaktivatetap']").val(data.accaktivatetap);
      $("input[name='accakumat']").val(data.accakumat);
      $("input[name='accbiayaat']").val(data.accbiayaat);
      $("input[name='accpersediaan']").val(data.accpersediaan);
      $("input[name='accreturpembelian']").val(data.accreturpembelian);
      $("input[name='accdiscpembelian']").val(data.accdiscpembelian);
      $("input[name='accpenjualan']").val(data.accpenjualan);
      $("input[name='accbiaya']").val(data.accbiaya);
      $("input[name='accreturpenjualan']").val(data.accreturpenjualan);
      $("input[name='accspsi']").val(data.accspsi);
      $("input[name='accexpedisi']").val(data.accexpedisi);
      $("input[name='hpp']").val(data.hpp);
      $("input[name='accupahlembur']").val(data.accupahlembur);
      $("input[name='foh']").val(data.foh);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='sloccode']").val(data.sloccode);
      $("input[name='materialgroupdesc']").val(data.materialgroupdesc);
      $("input[name='accaktivaname']").val(data.accaktivaname);
      $("input[name='accakumatname']").val(data.accakumatname);
      $("input[name='accbiayaatname']").val(data.accbiayaatname);
      $("input[name='accpersediaanname']").val(data.accpersediaanname);
      $("input[name='accreturpembelianname']").val(data.accreturpembelianname);
      $("input[name='accdiscbeliname']").val(data.accdiscbeliname);
      $("input[name='accpenjualanname']").val(data.accpenjualanname);
      $("input[name='accbiayaname']").val(data.accbiayaname);
      $("input[name='accreturjualname']").val(data.accreturjualname);
      $("input[name='accspsiname']").val(data.accspsiname);
      $("input[name='accexpedisiname']").val(data.accexpedisiname);
      $("input[name='hppname']").val(data.hppname);
      $("input[name='accupahlemname']").val(data.accupahlemname);
      $("input[name='fohname']").val(data.fohname);
				
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

	jQuery.ajax({'url':'slocacc/save',
		'data':{
			
			'slocaccid':$("input[name='slocaccid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'slocid':$("input[name='slocid']").val(),
      'materialgroupid':$("input[name='materialgroupid']").val(),
      'accaktivatetap':$("input[name='accaktivatetap']").val(),
      'accakumat':$("input[name='accakumat']").val(),
      'accbiayaat':$("input[name='accbiayaat']").val(),
      'accpersediaan':$("input[name='accpersediaan']").val(),
      'accreturpembelian':$("input[name='accreturpembelian']").val(),
      'accdiscpembelian':$("input[name='accdiscpembelian']").val(),
      'accpenjualan':$("input[name='accpenjualan']").val(),
      'accbiaya':$("input[name='accbiaya']").val(),
      'accreturpenjualan':$("input[name='accreturpenjualan']").val(),
      'accspsi':$("input[name='accspsi']").val(),
      'accexpedisi':$("input[name='accexpedisi']").val(),
      'hpp':$("input[name='hpp']").val(),
      'accupahlembur':$("input[name='accupahlembur']").val(),
      'foh':$("input[name='foh']").val(),
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
	jQuery.ajax({'url':'slocacc/delete',
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
	jQuery.ajax({'url':'slocacc/purge','data':{'id':$id},
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
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'materialgroupdesc':$("input[name='dlg_search_materialgroupdesc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'slocaccid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&materialgroupdesc='+$("input[name='dlg_search_materialgroupdesc']").val();
	window.open('slocacc/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'slocaccid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&materialgroupdesc='+$("input[name='dlg_search_materialgroupdesc']").val();
	window.open('slocacc/downxls?'+array);
}