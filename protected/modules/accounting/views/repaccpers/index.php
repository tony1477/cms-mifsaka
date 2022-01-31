<script type="text/javascript">
$(document).ready(function(){
    $('.selectpicker').selectpicker({
      size:10
  });
  jQuery.ajax({
      'url':'<?php echo Yii::app()->createUrl('common/productcollection/getproductcollect')?>',
      'dataType':'json',
      'type':'POST',
      'data':{
        'index' : 'index',
      },
      success:function(data) {
        for (var i = 0; i < 11; i++) {
          $("select[name='productcollectid']").append($('<option value="' + data.rows[i].productcollectid + '">' + data.rows[i].collectionname + '</option>'));
          //$images.push(data.data[i].images.standard_resolution.url);
        }
      $('.selectpicker').selectpicker('refresh');
      },
      cache: false,
    });
});

function downpdfrepaccpers() {
  $productcollectid = $("select[name='productcollectid']").val();
  //console.log($productcollectid);
  if($productcollectid==null) $productcollectid='';
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
	if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
		if ($startdate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptystartdate')?>');
	}
	else
		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
	var array = 'lro='+$("select[name='listrepaccpers']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&materialgroup='+$("input[name='materialgroupcodedesc']").val()
+ '&storagebin='+$("input[name='description']").val()
+ '&product='+$("input[name='productname']").val()
+ '&productcollect='+$productcollectid
+ '&account='+$("input[name='accountname']").val()
+ '&startacccode='+$("input[name='startacccode']").val()
+ '&endacccode='+$("input[name='endacccode']").val()
+ '&keluar3='+$("input[name='keluar3']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccpers/downpdf')?>?'+array);
	}
};


function downxlsrepaccpers() {
  $productcollectid = $("select[name='productcollectid']").val();
  //console.log($productcollectid);
  if($productcollectid==null) $productcollectid='';
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
	if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
		if ($startdate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptystartdate')?>');
	}
	else
		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
	var array = 'lro='+$("select[name='listrepaccpers']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&materialgroup='+$("input[name='materialgroupcodedesc']").val()
+ '&storagebin='+$("input[name='description']").val()
+ '&product='+$("input[name='productname']").val()
+ '&productcollect='+$productcollectid
+ '&account='+$("input[name='accountname']").val()
+ '&startacccode='+$("input[name='startacccode']").val()
+ '&endacccode='+$("input[name='endacccode']").val()
+ '&keluar3='+$("input[name='keluar3']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccpers/downxls')?>?'+array);
	}
};




 
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('repaccpers') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepaccpers"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepaccpers" >
			<option value="1">1.Rekap Persediaan (Detail)</option>
			<option value="2">2.Rekap Penerimaan Persediaan (Detail)</option>
			<option value="3">3.Rekap Pengeluaran Persediaan (Detail)</option>
			<option value="21">4.HPP Actual Hasil Produksi</option>
			<option value="4">5.HPP</option>
			<option value="5">6.HPP Berdasarkan BOM</option> 
			<option value="6">7.Rincian Nilai Pemakaian Stok - Data Harga</option>
			<option value="7">8.Rekap Nilai Pemakaian Stok - Data Harga</option>
			<option value="8">9.Rincian Nilai Stock Opname</option>
			<option value="9">10.Rekap Nilai Stock Opname</option>
			<option value="10">11.Rincian Harga Pokok Penjualan - Data Harga</option>
			<option value="11">12.Rekap Harga Pokok Penjualan - Data Harga</option>
			<option value="13">13.Rekap Perbandingan Nilai HPP, Nilai Penjualan dan Nilai Jurnal Per Dokumen</option>
<!--			<option value="14">14.Rekap Perbandingan Nilai HPP, Nilai Retur Penjualan dan Nilai Jurnal Per Dokumen</option>
			<option value="23">15.Rekap Perbandingan Nilai HPP, Nilai Penjualan - Retur dan Nilai Jurnal Per Dokumen</option>
-->			<option value="15">16.1.Rekap Perbandingan Nilai HPP dan Nilai Penjualan Per Barang</option>
			<option value="33">16.2.Rekap Perbandingan Nilai HPP dan Nilai Penjualan Per Kasta Per Barang</option>
			<option value="37">16.3.Rekap Perbandingan Nilai HPP dan Nilai Penjualan Per Kasta Per Group Material Per Barang</option>
			<option value="38">16.4.Rekap Perbandingan Nilai HPP dan Nilai Penjualan-Retur Per Kasta Per Group Material Per Barang</option>
			<option value="39">16.5.Rekap Perbandingan Nilai HPP dan Nilai Penjualan-Retur Per Provinsi Per Zona Per Subzona Per Customer Per Material Group</option>
				<option value="42">16.6.Rekap Perbandingan Nilai HPP dan Nilai Penjualan-Retur Per Provinsi Per Zona Per Subzona Per Customer</option>
			<option value="28">17.Rekap Perbandingan Nilai HPP dan Nilai Penjualan Per Customer Per Barang</option>
			<option value="16">18.1.Rekap Persediaan Barang Not Moving FG</option>
			<option value="36">18.2.Rekap Persediaan Barang Not Moving BB / WIP</option>
			<option value="17">19.Rekap Persediaan Barang Slow Moving</option>
			<option value="18">20.Rekap Persediaan Barang Fast Moving</option>
			<option value="19">21.Kartu Stok Barang (Nilai)</option>
			<option value="24">22.1.HPP Actual Hasil Produksi VS BOM</option>
			<option value="48">22.2.Rekap HPP Actual Hasil Produksi VS BOM</option>
			<option value="30">30.Rincian Harga Pemakaian Barang</option>
			<option value="31">31.Rincian Biaya UL Barang</option>
			<option value="32">32.Rincian Biaya FOH Barang</option>
			<option value="35">33.Rekap Persediaan Bahan Baku, Setengah Jadi & Barang Jadi</option>
			<option value="40">34.Rekap Potensi Market, Penjualan - Retur, Pembayaran, & GM Per Tipe Per Kategori Per Customer</option>
			<option value="43">35.Rekap Potensi Market, Target, Penjualan - Retur, Pembayaran, & GM Per Zona Per Subzona Per Tipe Per Kategori Per Customer</option>
			<option value="44">36.Rekap Potensi Market, Target, Penjualan - Retur, Pembayaran, & GM Per Zona Per Subzona Per Customer</option>
			<option value="41">37.Harga Bahan Baku Kimia Per Cabang</option>
		</select>
	</div>
</div>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'companyid_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companyidgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocid','ColField'=>'sloccode',
							'IDDialog'=>'slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'common.components.views.SloccomuserPopUp','PopGrid'=>'slocidgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'materialgroupid','ColField'=>'materialgroupcodedesc',
							'IDDialog'=>'materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupdescPopUp','PopGrid'=>'materialgroupidgrid')); 
					?>
            <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'storagebinid','ColField'=>'description',
							'IDDialog'=>'storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'storagebingrid')); 
					?>       
            <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>
        <div class="row">
          <div class="col-md-4">
            <label for="productcollectid">Multiple</label>
          </div>
          <div class="col-md-8">
            <select class="selectpicker form-control" name="productcollectid" id="productcollectid" data-live-search="true" title="Select <?=GetCatalog('productcollect')?>" data-hide-disabled="true" data-actions-box="true" multiple>
          </select>
          </div>
        </div>
            <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'accountid','ColField'=>'accountname',
							'IDDialog'=>'accountname_dialog','titledialog'=>$this->getCatalog('accountname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.AccountPopUp','PopGrid'=>'accountgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'startacccodeid','ColField'=>'startacccode',
							'IDDialog'=>'startacccode_dialog','titledialog'=>$this->getCatalog('startacccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomAccPopUp','PopGrid'=>'startacccodegrid','RelationID2'=>'acccode'));
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'endacccodeid','ColField'=>'endacccode',
							'IDDialog'=>'endacccode_dialog','titledialog'=>$this->getCatalog('endacccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomAccPopUp','PopGrid'=>'endacccodegrid','RelationID2'=>'acccode')); 
					?>

<div class="row">
	<div class="col-md-4">
		<label for="keluar3"> Qty Keluar</label>
	</div>
	<div class="col-md-8">
		<input type="text" class="form-control" name="keluar3" ></input>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<label for="startdate"><?php echo $this->getCatalog('date')?></label>
	</div>
	<div class="col-md-8">
		<input type="date" class="form-control" name="startdate" ></input>s/d<input type="date" class="form-control" name="enddate"></input>
    <br>
    
    <div class="btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
      <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
      <ul class="dropdown-menu" role="menu">
          <li><a onclick="downpdfrepaccpers()"><?php echo $this->getCatalog('downpdf')?></a></li>
          <li><a onclick="downxlsrepaccpers()"><?php echo $this->getCatalog('downxls')?></a></li>
      </ul>
  </div>