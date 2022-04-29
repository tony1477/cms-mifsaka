<script type="text/javascript">
$(document).ready(function(){
	$("select[name='listrepaccrec']").on('change',function(){
		let repaccrecsloc =  ["5","35"];
		let repaccrecmaterialgroup =  ["5"];
		let repaccreccustomer =  ["1","2","3","4","5","6","7","8","9","10","11","15","16","17","18","19","20","21","22","23","24","25","26","27","28","35","36","38"];
		let repaccrecproduct =  ["1","5","15","16","17","18","19","22","23","24","25"];
		let repaccrecsales =  ["1","2","3","4","5","6","7","8","9","10","11","15","16","17","18","19","22","23","24","25","26","27","28","31","32","37","38","39"];
		let repaccrecspv =  ["37"];
		let repaccrecsalesarea =  ["5","15","16","17","18","19","22","23","24","25","26","27","28","35","38"];
		let repaccrecumur =  ["5","22","35","36"];
		let repaccrecdisplay =  ["5", "35"];
    var repaccrecbaddebt =  ["1","2","3","4","5","6","7","8","9","10","11","15","16","17","18","19","21","22","23","24","25","26","27","28","29","30","35","36","38","98","99"];
		let repaccrecstart =  ["1","2","3","4","12","13","14","15","16","17","18","19","20","22","23","24","25","27","29","30","33","34"];
		let repaccrecend =  ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39"];
		
		let select = $("select[name='listrepaccrec']").val();
		if(repaccrecsloc.includes(select)) {
				$('#repaccrec_slocid').show();
			}
			else {
				$('#repaccrec_slocid').hide();
			}
		if(repaccrecmaterialgroup.includes(select)) {
				$('#repaccrec_materialgroupid').show();
			}
			else {
				$('#repaccrec_materialgroupid').hide();
			}
		if(repaccreccustomer.includes(select)) {
				$('#repaccrec_addressbookid').show();
			}
			else {
				$('#repaccrec_addressbookid').hide();
			}
		if(repaccrecproduct.includes(select)) {
				$('#repaccrec_productid').show();
			}
			else {
				$('#repaccrec_productid').hide();
			}
		if(repaccrecsales.includes(select)) {
				$('#repaccrec_employeeid').show();
			}
			else {
				$('#repaccrec_employeeid').hide();
			}
		if(repaccrecspv.includes(select)) {
				$('#repaccrec_spvid').show();
			}
			else {
				$('#repaccrec_spvid').hide();
			}
		if(repaccrecsalesarea.includes(select)) {
				$('#repaccrec_salesareaid').show();
			}
			else {
				$('#repaccrec_salesareaid').hide();
			}
		if(repaccrecumur.includes(select)) {
				$('#repaccrec_umurpiutang').show();
			}
			else {
				$('#repaccrec_umurpiutang').hide();
			}
		if(repaccrecdisplay.includes(select)) {
				$('#repaccrec_isdisplay').show();
			}
			else {
				$('#repaccrec_isdisplay').hide();
			}
    if(repaccrecbaddebt.includes(select)) {
      $("#repaccrec_isbaddebt").show();
    }
    else {
      $("#repaccrec_isbaddebt").hide();
    }
		if(repaccrecstart.includes(select)) {
				$('#repaccrec_startdate').show();
			}
			else {
				$('#repaccrec_startdate').hide();
			}
		if(repaccrecend.includes(select)) {
				$('#repaccrec_enddate').show();
			}
			else {
				$('#repaccrec_enddate').hide();
			}
	})    
});

function downpdfrepaccrec() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
	if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
		var array = 'lro='+$("select[name='listrepaccrec']").val()
			+ '&company='+$("input[name='companyid']").val()
			+ '&plantid='+$("input[name='plantid']").val()
			+ '&sloc='+$("input[name='sloccode']").val()
			+ '&materialgroup='+$("input[name='description']").val()
			+ '&customer='+$("input[name='fullname']").val()
			+ '&product='+$("input[name='productname']").val()
			+ '&sales='+$("input[name='employeename']").val()
			+ '&spv='+$("input[name='spvname']").val()
			+ '&salesarea='+$("input[name='salesarea']").val()
			+ '&groupcustomer='+$("input[name='groupcustomer']").val()
			+ '&umurpiutang='+$("input[name='umurpiutang']").val()
			+ '&isdisplay='+$("select[name='isdisplay']").val()
      + '&isbaddebt='+$("select[name='isbaddebt']").val()
			+ '&startdate='+$("input[name='startdate']").val()
			+ '&enddate='+$("input[name='enddate']").val()
			+ '&per=10';
		window.open('<?php echo Yii::app()->createUrl('accounting/repaccrec/downpdf')?>?'+array);
	}
};

function downxlsrepaccrec() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
	if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
		var array = 'lro='+$("select[name='listrepaccrec']").val()
			+ '&company='+$("input[name='companyid']").val()
			+ '&plantid='+$("input[name='plantid']").val()
			+ '&sloc='+$("input[name='sloccode']").val()
			+ '&materialgroup='+$("input[name='description']").val()
			+ '&customer='+$("input[name='fullname']").val()
			+ '&product='+$("input[name='productname']").val()
			+ '&sales='+$("input[name='employeename']").val()
			+ '&spv='+$("input[name='spvname']").val()
			+ '&salesarea='+$("input[name='salesarea']").val()
			+ '&groupcustomer='+$("input[name='groupcustomer']").val()
			+ '&umurpiutang='+$("input[name='umurpiutang']").val()
			+ '&isdisplay='+$("select[name='isdisplay']").val()
      + '&isbaddebt='+$("select[name='isbaddebt']").val()
			+ '&startdate='+$("input[name='startdate']").val()
			+ '&enddate='+$("input[name='enddate']").val()
			+ '&per=10';
		window.open('<?php echo Yii::app()->createUrl('accounting/repaccrec/downxls')?>?'+array);
	}
};

</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('repaccrec') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepaccrec"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepaccrec" >
				<option value="">Pilih Laporan</option>
				<option value="1">1.1.Rincian Pelunasan Piutang Per Dokumen</option>
					<option value="2">1.2.Rekap Pelunasan Piutang Per Divisi</option>
					<option value="15">1.3.Rincian Pelunasan Piutang Per Sales</option>
					<option value="16">1.4.Rekap Pelunasan Piutang Per Sales</option>
					<option value="17">1.5.Rincian Pelunasan Piutang Per Sales Per Jenis Barang</option>
					<option value="18">1.6.Rincian Pelunasan Piutang Per Sales Per Jenis Barang (Tanpa OB)</option>
					<option value="19">1.7.Rekap Pelunasan Piutang Per Sales Per Jenis Barang</option>
					<option value="22">1.8.Rincian Pelunasan Piutang Per Customer</option>
					<option value="23">1.9.Rekap Pelunasan Piutang Per Customer</option>
					<option value="24">1.10.Rincian Pelunasan Piutang Per Customer Per Jenis Barang</option>
					<option value="25">1.11.Rekap Pelunasan Piutang Per Customer Per Jenis Barang</option>
					<option value="29">1.12.Rincian Pelunasan Piutang (Filter Tanggal Invoice)</option>
					<option value="30">1.13.Rincian Pelunasan Piutang (Filter Tanggal Pelunasan)</option>
					<option value="20">1.14.Rekap Penjualan VS Pelunasan Per Bulan Per Customer</option>
					<option value="21">1.15.Rekap Piutang VS Pelunasan Per Bulan Per Customer</option>
					<option value="3">2.1.Kartu Piutang Dagang</option>
					<option value="4">2.2.Rekap Piutang Dagang Per Customer</option>
					<option value="26">2.3.Rekap Umur Piutang Dagang</option>
					<option value="27">2.4.Rekap Umur Piutang Dagang Per Bulan Per Tahun</option>
					<option value="5">2.5.1.Rincian Faktur & Retur Jual Belum Lunas</option>
					<option value="41">2.5.2.Rincian Faktur & Retur Jual Belum Lunas Per Kategori Customer</option>
					<option value="28">2.6.Rincian Faktur & Retur Jual Belum Lunas (Filter Tanggal JTT)</option>
					<option value="6">2.7.Rincian Umur Piutang Dagang Per Customer</option>
					<option value="7">2.8.Rekap Umur Piutang Dagang Per Customer</option>
					<option value="35">2.9.Rekap Umur Piutang Dagang Per Customer VS TOP</option>
					<option value="8">2.10.Rincian Faktur & Retur Jual Belum Lunas Per Sales</option>
					<option value="9">2.11.Rekap Kontrol Piutang Customer vs Plafon</option> 
					<option value="10">2.12.Rincian Kontrol Piutang Customer vs Plafon</option>
					<option value="36">2.13.Rekap Monitoring Piutang Per Minggu Per Customer Per Sales</option>
					<option value="11">2.14.Konfirmasi Piutang Dagang</option>
					<option value="38">2.15.Rekap Umur Piutang Dagang Per Company</option>
					<option value="31">3.1.Rekap Target VS Realisasi Tagihan</option>
					<option value="32">3.2.Rincian Komisi Tagihan Per Sales</option>
					<option value="39">3.3.Rekap Komisi Tagihan Per Sales</option>
					<option value="37">3.5.Rekap Komisi Tagihan Per SPV</option>
					<option value="12">4.1.Rekap Invoice AR Per Dokumen Belum Status Max</option>
					<option value="13">4.2.Rekap Nota Retur Penjualan Per Dokumen Belum Status Max</option>
					<option value="14">4.3.Rekap Pelunasan Piutang Per Dokumen Belum Status Max</option>
					<option value="33">4.4.Rekap Target Tagihan Per Dokumen Belum Status Max</option>
					<option value="34">4.5.Rekap Skala Komisi Tagihan Per Dokumen Belum Status Max</option>
		</select>
	</div>
</div>
			<div id="repaccrec_companyid">
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companyidgrid')); 
					?>
            </div>
			<div id="repaccrec_plantid">
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'plantid','ColField'=>'plantcode',
							'IDDialog'=>'plant_dialog','titledialog'=>$this->getCatalog('plant'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PlantCompanyPopUp','PopGrid'=>'plantidgrid','RelationID'=>'companyid')); 
					?>
			</div>
            <div id="repaccrec_slocid">
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocid','ColField'=>'sloccode',
							'IDDialog'=>'slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'slocidgrid')); 
					?>
            </div>
            <div id="repaccrec_materialgroupid">
					 <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'materialgroupid','ColField'=>'description',
							'IDDialog'=>'materialgroup_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupPopUp','PopGrid'=>'materialgroupid')); 
					?> 
            </div>
            <div id="repaccrec_addressbookid">
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'fullname',
							'IDDialog'=>'customer_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'customergrid')); 
					?>
            </div>
            <div id="repaccrec_productid">  
                       
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>   
            </div>
            <div id="repaccrec_employeeid">
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employeename',
							'IDDialog'=>'sales_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.SalesPopUp','PopGrid'=>'salesgrid')); 
					?>
            </div>
            <div id="repaccrec_spvid">
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'spvid','ColField'=>'spvname',
							'IDDialog'=>'spv_dialog','titledialog'=>$this->getCatalog('salesspv'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.SalesPopUp','PopGrid'=>'spvgrid')); 
					?>   
            </div>
						<div id="repaccrec_groupcustomer">
						<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'groupcustomerid','ColField'=>'groupcustomer',
							'IDDialog'=>'groupcustomer_dialog','titledialog'=>$this->getCatalog('groupcustomer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.GroupcustomerPopUp','PopGrid'=>'groupcustomergrid')); 
					?>
						</div>
            <div id="repaccrec_salesareaid">
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesareaid','ColField'=>'salesarea',
							'IDDialog'=>'salesarea_dialog','titledialog'=>$this->getCatalog('salesarea'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesareaPopUp','PopGrid'=>'salesareagrid')); 
					?>   
            </div>
					<div class="row" id="repaccrec_umurpiutang">
<div class="col-md-4">
				<label for="umurpiutang"><?php echo $this->getCatalog('umurpiutang')?></label>
				</div>
				<div class="col-md-8">
							<input type="text" class="form-control" name="umurpiutang" ></input>
  </div>
	</div>
<div class="row" id="repaccrec_isdisplay">
	<div class="col-md-4">
		<label for="isdisplay"><?php echo $this->getCatalog('indisplay')?></label>
	</div>
	<div class="col-md-2">
		<select class="form-control" name="isdisplay" >
			<option value="0">No</option>
			<option value="1">Yes</option>
			<option value="">All</option>
		</select> 
	</div>
</div>

<div class="row" id="repaccrec_isbaddebt">
	<div class="col-md-4">
		<label for="isbaddebt"><?php echo $this->getCatalog('Tipe Faktur')?></label>
	</div>
	<div class="col-md-2">
		<select class="form-control" name="isbaddebt" >
			<option value="0">Good</option>
			<option value="1">Bad Debt</option>
		</select>
		
	</div>
</div>
                       
<div class="row">
<div class="col-md-4">
				<label for="startdate"><?php echo $this->getCatalog('date')?></label>
				</div>
				<div class="col-md-8">
		<input type="date" class="form-control" name="startdate" id="repaccrec_startdate"></input>s/d<input type="date" class="form-control" name="enddate" id="repaccrec_enddate"></input>
                <br>
								
                <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="downpdfrepaccrec()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsrepaccrec()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>
                
               
                
