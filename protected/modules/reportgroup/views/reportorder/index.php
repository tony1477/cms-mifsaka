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
+ '&customer='+$("input[name='fullname']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&spvid='+$("input[name='spvid']").val()
+ '&product='+$("input[name='productname']").val()
+ '&salesarea='+$("input[name='areaname']").val()
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
+ '&customer='+$("input[name='fullname']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&product='+$("input[name='productname']").val()
+ '&salesarea='+$("input[name='areaname']").val()
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
			<option value="1">1.Rincian Penjualan Per Dokumen</option>
      <option value="2">2.Rekap Penjualan Per Dokumen</option>
      <option value="3">3.Rekap Penjualan Per Customer</option>
      <option value="4">4.Rekap Penjualan Per Sales</option>
      <option value="5">5.Rekap Penjualan Per Barang</option>
      <option value="6">6.Rekap Penjualan Per Area</option>
      <option value="7">7.Rekap Penjualan Per Customer Per Barang (Total)</option>		
      <option value="8">8.Rekap Penjualan Per Customer Per Barang (Rincian)</option>		
      <option value="9">9.Rekap Penjualan Per Sales Per Barang (Total)</option>		
      <option value="10">10.Rekap Penjualan Per Sales Per Barang (Rincian)</option>		
      <option value="11">11.Rekap Penjualan Per Area Per Barang (Total)</option>		
      <option value="12">12.Rekap Penjualan Per Area Per Barang (Rincian)</option>	
      <option value="13">13.Rincian Retur Penjualan Per Dokumen</option>
      <option value="14">14.Rekap Retur Penjualan Per Dokumen</option>
      <option value="15">15.Rekap Retur Penjualan Per Customer</option>		
      <option value="16">16.Rekap Retur Penjualan Per Sales</option>
      <option value="17">17.Rekap Retur Penjualan Per Barang</option>
      <option value="18">18.Rekap Retur Penjualan Per Area</option>		
      <option value="19">19.Rekap Retur Penjualan Per Customer Per Barang (Total)</option>		
      <option value="20">20.Rekap Retur Penjualan Per Customer Per Barang (Rincian)</option>		
      <option value="21">21.Rekap Retur Penjualan Per Sales Per Barang (Total)</option>		
      <option value="22">22.Rekap Retur Penjualan Per Sales Per Barang (Rincian)</option>		
      <option value="23">23.Rekap Retur Penjualan Per Area Per Barang (Total)</option>		
      <option value="24">24.Rekap Retur Penjualan Per Area Per Barang (Rincian)</option>
      <option value="25">25.Rincian Penjualan - Retur Per Dokumen</option>
      <option value="26">26.Rekap Penjualan - Retur Per Dokumen</option>                        
      <option value="27">27.Rekap Penjualan - Retur Per Customer</option>		
      <option value="28">28.Rekap Penjualan - Retur Per Sales</option>
      <option value="29">29.Rekap Penjualan - Retur Per Barang</option>
      <option value="30">30.Rekap Penjualan - Retur Per Area</option>		
      <option value="31">31.Rekap Penjualan - Retur Per Barang Customer (Total)</option>		
      <option value="32">32.Rekap Penjualan - Retur Per Barang Per Customer (Rincian)</option>  	
      <option value="33">33.Rekap Penjualan - Retur Per Sales Per Barang (Total)</option>		
      <option value="34">34.Rekap Penjualan - Retur Per Sales Per Barang (Rincian)</option>	
      <option value="35">35.Rekap Penjualan - Retur Per Area (Total)</option>		
      <option value="36">36.Rekap Penjualan - Retur Per Area (Rincian)</option>		
      <option value="37">37.Rincian Sales Order Per Dokumen</option>		
      <option value="38">38.Rincian Sales Order Outstanding</option>		
      <option value="39">39.Rekap Surat Jalan Belum Dibuatkan Faktur</option>		
      <option value="40">40.Rekap Penjualan Per Customer Per Bulan Per Tahun</option>  		
      <option value="41">41.Rekap Retur Penjualan Per Customer Per Bulan Per Tahun</option>
      <option value="42">42.Rekap Penjualan - Retur Penjualan PerCustomer PerBulan PerTahun</option>
      <option value="43">43.Rekap Penjualan PerJenis Customer PerBulan PerTahun</option>
      <option value="44">44.Rekap Retur Penjualan PerJenis Customer PerBulan PerTahun</option>
      <option value="45">45.Rekap Penjualan Retur Penjualan Per Jenis Customer PerBulan PerTahun</option>
      <option value="46">46.Rekap Total Penjualan Per Jenis Customer PerBulan PerTahun</option>
      <option value="47">47.Rekap Total Retur Penjualan PerJenis Customer PerBulan PerTahun</option>
      <option value="48">48.Rekap Total Penjualan - Retur Penjualan PerJenis Customer PerBulan PerTahun</option>
      <option value="49">49.Rekap Penjualan Per Barang Per Bulan (Qty)</option>
      <option value="50">50.Rekap Penjualan Per Barang Per Bulan (Nilai)</option>
      <option value="51">51.Rekap Penjualan Per Barang Per Bulan (Nilai & Qty)</option>
      <option value="52">52.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Total Nilai</option>
      <option value="53">53.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Rincian Nilai</option>
      <option value="54">54.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Total Qty</option>
      <option value="55">55.Rekap Penjualan - Retur Per Customer Per Barang Per Bulan Per Tahun Rincian Qty</option>
      <option value="56">56.Rekap Sales Order Outstanding Per Barang</option>
      <option value="57">57.Rekap Penjualan - Retur Area, Customer, Barang Per Bulan Per Tahun Rincian Nilai</option>
      <option value="58">58.Rekap Penjualan - Retur Area, Customer, Barang Per Bulan Per Tahun Rincian Qty</option>
      <option value="59">59.Laporan Customer Belum Lengkap Lokasi</option>
      <option value="60">60.Laporan Customer Belum Lengkap Foto</option>
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
				<label for="startdate"><?php echo $this->getCatalog('date')?></label>
				</div>
				<div class="col-md-8">
		<input type="date" class="form-control" name="startdate" />s/d<input type="date" class="form-control" name="enddate" />
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

                
               
                