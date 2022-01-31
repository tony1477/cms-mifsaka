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
+ '&product='+$("input[name='productname']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&salesarea='+$("input[name='salesarea']").val()
+ '&umurpiutang='+$("input[name='umurpiutang']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccrec/downpdf')?>?'+array);
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
+ '&product='+$("input[name='productname']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&sales='+$("input[name='employeename']").val()
+ '&salesarea='+$("input[name='salesarea']").val()
+ '&umurpiutang='+$("input[name='umurpiutang']").val()
+ '&enddate='+$("input[name='enddate']").val()+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccrec/downxls')?>?'+array);
	}
};

</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('repaccrec') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepsales"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepsales" >
			 		<option value="1">1.Rincian Pelunasan Piutang Per Dokumen</option>
			        <option value="2">2.Rekap Pelunasan Piutang Per Divisi</option>
			        <option value="15">3.Rincian Pelunasan Piutang Per Sales</option>
			        <option value="16">4.Rekap Pelunasan Piutang Per Sales</option>
			        <option value="17">5.Rincian Pelunasan Piutang Per Sales Per Jenis Barang</option>
			        <option value="18">6.Rekap Pelunasan Piutang Per Sales Per Jenis Barang</option>
			        <option value="3">7.Kartu Piutang Dagang</option>
			        <option value="4">8.Rekap Piutang Dagang Per Customer</option>
			        <option value="5">9.Rincian Faktur & Retur Jual Belum Lunas</option>
			        <option value="6">10.Rincian Umur Piutang Dagang Per Customer</option>
			        <option value="7">11.Rekap Umur Piutang Dagang Per Customer</option>
			        <option value="8">12.Rincian Faktur & Retur Jual Belum Lunas Per Sales</option>
			        <option value="9">13.Rekap Kontrol Piutang Customer vs Plafon</option> 
			        <option value="10">14.Rincian Kontrol Piutang Customer vs Plafon</option>
			        <option value="11">15.Konfirmasi Piutang Dagang</option>
			        <option value="12">16.Rekap Invoice AR Per Dokumen Belum Status Max</option>
			        <option value="13">17.Rekap Nota Retur Penjualan Per Dokumen Belum Status Max</option>
			        <option value="14">18.Rekap Pelunasan Piutang Per Dokumen Belum Status Max</option>
              <option value="19">19.Rekap Penjualan VS Pelunasan Per Bulan Per Customer</option>
              <option value="20">20.Rekap Piutang VS Pelunasan Per Bulan Per Customer</option>
                        
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
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'description',
							'IDDialog'=>'materialgroup_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupPopUp','PopGrid'=>'materialgroupid')); 
					?> 
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'fullname',
							'IDDialog'=>'customer_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'customergrid')); 
					?>
                       
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>   
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employeename',
							'IDDialog'=>'sales_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.SalesPopUp','PopGrid'=>'salesgrid')); 
					?>   
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesareaid','ColField'=>'salearea',
							'IDDialog'=>'salesarea_dialog','titledialog'=>$this->getCatalog('salesarea'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesareaPopUp','PopGrid'=>'salesareagrid')); 
					?>   
					<div class="row">
<div class="col-md-4">
				<label for="umurpiutang"><?php echo $this->getCatalog('umurpiutang')?></label>
				</div>
				<div class="col-md-8">
							<input type="text" class="form-control" name="umurpiutang" ></input>
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
                        <li><a onclick="downpdfrepsales()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsrepsales()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>
                
               
                
