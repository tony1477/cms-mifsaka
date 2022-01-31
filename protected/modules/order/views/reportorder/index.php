<script type="text/javascript">
function downpdfrepsales() {
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
	var array = 'lro='+$("select[name='listrepsales']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&materialgroup='+$("input[name='description']").val()
+ '&customer='+$("input[name='fullname']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&spvid='+$("input[name='spvname']").val()
+ '&product='+$("input[name='productname']").val()
+ '&salesarea='+$("input[name='areaname']").val()
+ '&isdisplay='+$("select[name='isdisplay']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('order/reportorder/downpdf')?>?'+array);
	}
};


function downxlsrepsales() {
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
	var array = 'lro='+$("select[name='listrepsales']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&materialgroup='+$("input[name='description']").val()
+ '&customer='+$("input[name='fullname']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&spvid='+$("input[name='spvname']").val()
+ '&product='+$("input[name='productname']").val()
+ '&salesarea='+$("input[name='areaname']").val()
+ '&isdisplay='+$("select[name='isdisplay']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('order/reportorder/downxls')?>?'+array);
	}
};




 
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('reportorder') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepsales"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepsales" >
			<option value="1">1.1.Rincian Penjualan Per Dokumen</option>
      <option value="2">1.2.Rekap Penjualan Per Dokumen</option>
      <option value="3">1.3.Rekap Penjualan Per Customer</option>
      <option value="4">1.4.Rekap Penjualan Per Sales</option>
      <option value="5">1.5.Rekap Penjualan Per Barang</option>
      <option value="6">1.6.Rekap Penjualan Per Area</option>
      <option value="7">1.7.Rekap Penjualan Per Customer Per Barang (Total)</option>
      <option value="8">1.8.Rekap Penjualan Per Customer Per Barang (Rincian)</option>
      <option value="9">1.9.Rekap Penjualan Per Sales Per Barang (Total)</option>
      <option value="10">1.10.Rekap Penjualan Per Sales Per Barang (Rincian)</option>
      <option value="11">1.11.Rekap Penjualan Per Area Per Barang (Total)</option>
      <option value="12">1.12.Rekap Penjualan Per Area Per Barang (Rincian)</option>
      <option value="40">1.13.Rekap Penjualan Per Customer Per Bulan Per Tahun</option>
      <option value="43">1.14.Rekap Penjualan Per Jenis Customer Per Bulan Per Tahun</option>
      <option value="46">1.15.Rekap Total Penjualan Per Jenis Customer Per Bulan Per Tahun</option>
      <option value="49">1.16.Rekap Penjualan Per Barang Per Bulan (Qty)</option>
      <option value="50">1.17.Rekap Penjualan Per Barang Per Bulan (Nilai)</option>
      <option value="51">1.18.Rekap Penjualan Per Barang Per Bulan (Nilai & Qty)</option>
      <option value="13">2.1.Rincian Retur Penjualan Per Dokumen</option>
      <option value="14">2.2.Rekap Retur Penjualan Per Dokumen</option>
      <option value="15">2.3.Rekap Retur Penjualan Per Customer</option>
      <option value="16">2.4.Rekap Retur Penjualan Per Sales</option>
      <option value="17">2.5.Rekap Retur Penjualan Per Barang</option>
      <option value="18">2.6.Rekap Retur Penjualan Per Area</option>
      <option value="19">2.7.Rekap Retur Penjualan Per Customer Per Barang (Total)</option>
      <option value="20">2.8.Rekap Retur Penjualan Per Customer Per Barang (Rincian)</option>
      <option value="21">2.9.Rekap Retur Penjualan Per Sales Per Barang (Total)</option>
      <option value="22">2.10.Rekap Retur Penjualan Per Sales Per Barang (Rincian)</option>
      <option value="23">2.11.Rekap Retur Penjualan Per Area Per Barang (Total)</option>
      <option value="24">2.12.Rekap Retur Penjualan Per Area Per Barang (Rincian)</option>
      <option value="41">2.13.Rekap Retur Penjualan Per Customer Per Bulan Per Tahun</option>
      <option value="44">2.14.Rekap Retur Penjualan Per Jenis Customer Per Bulan Per Tahun</option>
      <option value="47">2.15.Rekap Total Retur Penjualan Per Jenis Customer Per Bulan Per Tahun</option>
      <option value="25">3.1.Rincian Penjualan - Retur Per Dokumen</option>
      <option value="26">3.2.Rekap Penjualan - Retur Per Dokumen</option>
      <option value="27">3.3.Rekap Penjualan - Retur Per Customer</option>
      <option value="28">3.4.Rekap Penjualan - Retur Per Sales</option>
      <option value="29">3.5.Rekap Penjualan - Retur Per Barang</option>
      <option value="30">3.6.Rekap Penjualan - Retur Per Area</option>
      <option value="31">3.7.Rekap Penjualan - Retur Per Barang Customer (Total)</option>
      <option value="32">3.8.Rekap Penjualan - Retur Per Barang Per Customer (Rincian)</option>
      <option value="33">3.9.Rekap Penjualan - Retur Per Sales Per Barang (Total)</option>
      <option value="34">3.10.Rekap Penjualan - Retur Per Sales Per Barang (Rincian)</option>
      <option value="35">3.11.Rekap Penjualan - Retur Per Area (Total)</option>
      <option value="36">3.12.Rekap Penjualan - Retur Per Area (Rincian)</option>
      <option value="42">3.13.Rekap Penjualan - Retur Penjualan Per Customer PerBulan Per Tahun</option>
      <option value="45">3.14.Rekap Penjualan Retur Penjualan Per Jenis Customer Per Bulan Per Tahun</option>
      <option value="48">3.15.Rekap Total Penjualan - Retur Penjualan Per Jenis Customer Per Bulan Per Tahun</option>
      <option value="52">3.19.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Total Nilai</option>
      <option value="53">3.20.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Rincian Nilai</option>
      <option value="54">3.21.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Total Qty</option>
      <option value="55">3.22.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Rincian Qty</option>
      <option value="58">3.23.Rekap Penjualan - Retur Per Sales Per Bulan Per Tahun Total</option>
      <option value="59">3.24.Rekap Penjualan - Retur Per Sales Per Barang Per Bulan Per Tahun Total</option>
      <option value="60">3.25.Rekap Penjualan - Retur Per Sales Per Customer Per Bulan Per Tahun Total</option>
      <option value="61">3.26.Rekap Penjualan - Retur Area, Customer, Barang Per Bulan Per Tahun Rincian Nilai</option>
      <option value="62">3.27.Rekap Penjualan - Retur Area, Customer, Barang Per Bulan Per Tahun Rincian Qty</option>
      <option value="85">3.28.Laporan Penjualan - Retur Per Cabang Per Sales Per Group Material FG</option>
      <option value="90">3.29.Rekap Penjualan - Retur Per Customer Per Jenis Material Per Bulan Per Tahun Total Nilai</option>
      <option value="92">3.30.Rekap Penjualan - Retur Per Jenis Material Per Kasta Per Bulan</option>
      <option value="93">3.31.Rekap Penjualan - Retur Per Kasta Per Group Material</option>
      <option value="94">3.32.Rekap Penjualan - Retur Market Area, Customer, Barang Per Bulan - Rincian (Nilai)</option>
      <option value="95">3.33.Rekap Penjualan - Retur Market Area, Customer, Barang Per Bulan - Rincian (Qty)</option>
      <option value="37">4.1.Rincian Sales Order Per Dokumen</option>
      <option value="38">4.2.Rincian Sales Order Outstanding</option>
      <option value="56">4.3.Rekap Sales Order Outstanding Per Barang</option>
	  <option value="91">4.4.Rekap Sales Order Outstanding Per Tanggal Kirim Per Barang</option>
	  <option value="96">4.5.Rincian SO Paket Outstanding (Belum Terkirim Semua Barang Dalam Paket)</option>
      <option value="39">5.1.Rekap Surat Jalan Belum Dibuatkan Faktur</option>
      <option value="63">6.1.Laporan Customer Belum Lengkap Lokasi</option>
			<option value="67">6.2.Laporan Customer Sudah Lengkap Lokasi</option>
      <option value="64">6.3.Laporan Customer Belum Lengkap Foto</option>
			<option value="68">6.4.Laporan Customer Sudah Lengkap Foto</option>
      <option value="65">6.5.Laporan Customer Belum Ada KTP</option>
			<option value="69">6.6.Laporan Customer Sudah Ada KTP</option>
      <option value="66">6.7.Laporan Customer Belum Ada NPWP</option>
			<option value="70">6.8.Laporan Customer Sudah Ada NPWP</option>
			<option value="81">6.9.Laporan Customer Belum Ada Kategori Customer</option>
			<option value="82">6.10.Laporan Customer Sudah Ada Kategori Customer</option>
			<option value="83">6.11.Laporan Customer Belum Ada Grade</option>
			<option value="84">6.12.Laporan Customer Sudah Ada Grade</option>
			<option value="89">6.13.Rincian Data Customer</option>
			<!--<option value="72">7.1.Rincian Realisasi Penjualan Per Sales Per Group Material</option>-->
			<option value="71">7.2.Rekap Realisasi Penjualan Per Sales Per Group Material</option>
			<option value="86">7.3.Rekap Realisasi Penjualan SPV Per Sales Per Group Material</option>
				<option value="88">7.4.Rekap Sales Target Per Barang</option>
			<option value="73">7.5.Rekap Penjualan VS Hasil Produksi VS Saldo Akhir</option>
      <option value="57">8.1.Rekap SO Per Dokumen Belum Status Max</option>
      <option value="74">8.2.Rekap TTNT Per Dokumen Belum Status Max</option>
      <option value="75">8.3.Rekap TTF Per Dokumen Belum Status Max</option>
			<option value="76">8.4.Rekap Skala Komisi Penjualan Per Dokumen Belum Status Max</option>
			<option value="77">8.5.Rekap Target Penjualan Per Dokumen Belum Status Max</option>
			<option value="78">8.6.Rekap Perubahan Plafon Per Dokumen Belum Status Max</option>
			<option value="80">9.Daily Monitoring Report</option>
		</select>
	</div>
</div>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companyidgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocid','ColField'=>'sloccode',
							'IDDialog'=>'slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'slocidgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'materialgroupid','ColField'=>'description',
							'IDDialog'=>'materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupPopUp','PopGrid'=>'materialgroupidgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'fullname',
							'IDDialog'=>'customer_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'customergrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employeename',
							'IDDialog'=>'sales_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'salesgrid')); 
					?>  
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'spvid','ColField'=>'spvname',
							'IDDialog'=>'spv_dialog','titledialog'=>$this->getCatalog('salesspv'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'spvgrid')); 
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
		<label for="isdisplay"><?php echo $this->getCatalog('indisplay')?></label>
	</div>
	<div class="col-md-2">
		<select class="form-control" name="isdisplay" >
			<option value="0">No</option>
			<option value="1">Yes</option>
			<option value="">All</option>
		</select>
		<br>
	</div>
</div>
<div class="row">
<div class="col-md-4">
				<label for="startdate"><?php echo $this->getCatalog('date')?></label>
				</div>
				<div class="col-md-2">
		<input type="date" class="form-control" name="startdate" ></input>s/d<input type="date" class="form-control" name="enddate"></input>
                <br>
                </div>
	</div>
                
                <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="downpdfrepsales()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsrepsales()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
										</div>

                
               
                
