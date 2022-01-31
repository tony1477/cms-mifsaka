<script type="text/javascript">
function downpdfreportinventory() {
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
	var array = 'lro='+$("select[name='listreportinventory']").val()
+ '&companyid='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&slocto='+$("input[name='sloctocode']").val()
+ '&storagebin='+$("input[name='description']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&product='+$("input[name='productname']").val()
+ '&salesarea='+$("input[name='areaname']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+ '&keluar3='+$("input[name='keluar3']").val();
	window.open('<?php echo Yii::app()->createUrl('inventory/reportinventory/downpdf')?>?'+array);
	}
};


function downxlsreportinventory() {
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
	var array = 'lro='+$("select[name='listreportinventory']").val()
+ '&companyid='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&slocto='+$("input[name='sloctocode']").val()
+ '&storagebin='+$("input[name='description']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&product='+$("input[name='productname']").val()
+ '&salesarea='+$("input[name='areaname']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+ '&keluar3='+$("input[name='keluar3']").val();
	window.open('<?php echo Yii::app()->createUrl('inventory/reportinventory/downxls')?>?'+array);
	}
};




 
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('reportinventory') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listreportinventory"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listreportinventory" >
				<option value="1">1.Rincian Histori Barang</option>
        <option value="2">2.Rekap Histori Barang</option>
        <option value="3">3.Kartu Stok Barang</option>
        <option value="4">4.Kartu  Stock Barang Per Rak</option>
        <option value="5">5.Rekap Stok Barang</option>				
        <option value="26">6.Rekap Stok Barang (Ada Transaksi Keluar Masuk)</option>
        <option value="6">7.Rekap Stok Barang per Hari</option>
        <option value="7">8.Rekap Stok Barang per Rak</option>
        <option value="8">9.Rincian Surat Jalan Per Dokumen</option>
        <option value="9">10.Rekap Surat Jalan Per Barang</option>
        <option value="10">11.Rekap Surat Jalan Per Customer</option>
        <option value="11">12.Rincian Retur Jual Per Dokumen</option>
        <option value="12">13.Rekap Retur Jual Per Barang</option>
        <option value="13">14.Rekap Retur Jual Per Customer</option>
        <option value="14">15.Rincian Terima Barang Per Dokumen</option>
        <option value="15">16.Rekap Terima Barang Per Barang</option>
        <option value="16">17.Rekap Terima Barang Per Supplier</option>
        <option value="17">18.Rincian Retur Beli Per Dokumen</option>
        <option value="18">19.Rekap Retur Beli Per Barang</option>
        <option value="19">20.Rekap Retur Beli Per Supplier</option>
        <option value="20">21.Pendingan FPB</option>
        <option value="21">22.Pendingan FPP</option>
        <option value="44">23.Rekap Monitoring Stock</option>
        <option value="45">24.Rincian Monitoring Stock</option>
        <option value="22">25.Rincian Transfer Gudang Keluar Per Dokumen</option>
        <option value="23">26.Rekap Transfer Gudang Keluar Per Barang</option>
        <option value="24">27.Rincian Transfer Gudang Masuk Per Dokumen</option>
        <option value="25">28.Rekap Transfer Gudang Masuk Per Barang</option>
        <option value="27">29.Rekap STTB Per Dokumen Belum Status Max</option>
        <option value="28">30.Rekap Retur Pembelian Per Dokumen Belum Status Max</option>
        <option value="29">31.Rekap Surat Jalan Per Dokumen Belum Status Max</option>
        <option value="30">32.Rekap Retur Penjualan Per Dokumen Belum Status Max</option>
        <option value="31">33.Rekap Transfer Per Dokumen Belum Status Max</option>
        <option value="32">34.Rekap Stock Opname Per Dokumen Belum Status Max</option>
        <option value="33">35.Rekap Konversi Per Dokumen Belum Status Max</option>
        <option value="34">36.Raw Material Gudang Asal Belum Ada di Data Gudang - FPB</option>
        <option value="35">37.Raw Material Gudang Tujuan Belum Ada di Data Gudang - FPB</option>
        <option value="36">38.Rekap FPB Belum Ada Transfer Per Dokumen</option>
        <option value="37">39.Raw Material Belum Ada Data Gudang - Stock Opname</option>
        <option value="38">40.Rekap FPB Per Dokumen Belum Status Max</option>
        <option value="39">41.Laporan Ketersediaan Barang (MRP)</option>
        <option value="40">42.Laporan Material Not Moving </option>
        <option value="41">43.Laporan Material Slow Moving </option>
        <option value="42">44.Laporan Material Fast Moving </option> 
        <option value="43">45.Laporan Harian</option>                    
		</select>
	</div>
</div>
			         <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'companyidgrid')); 
					?>
			         <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocid','ColField'=>'sloccode',
							'IDDialog'=>'slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'common.components.views.SloccomPopUp','PopGrid'=>'slocidgrid')); 
					?>
                     <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'sloctoid','ColField'=>'sloctocode',
							'IDDialog'=>'sloctoid_dialog','titledialog'=>$this->getCatalog('slocto'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'common.components.views.SloccomPopUp','PopGrid'=>'sloctoidgrid')); 
					?>
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'storagebinid','ColField'=>'description',
							'IDDialog'=>'storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocid',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'storagebingrid')); 
					?>
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employeename',
							'IDDialog'=>'sales_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'salesgrid')); 
					?>       
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>   
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesareaid','ColField'=>'areaname',
							'IDDialog'=>'salesarea_dialog','titledialog'=>$this->getCatalog('salesarea'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesareaPopUp','PopGrid'=>'salesareagrid')); 
					?>
					<div class="row">
					<div class="col-md-4">
					<label for="keluar3"> Qty Keluar</label>
					</div>
					<div class="col-md-8">
		<input type="text" class="form-control" name="keluar3" ></input>
		</div></div>
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
                        <li><a onclick="downpdfreportinventory()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsreportinventory()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>