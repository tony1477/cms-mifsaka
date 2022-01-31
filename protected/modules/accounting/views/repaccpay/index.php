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
+ '&product='+$("input[name='productname']").val()
+ '&supplier='+$("input[name='fullname']").val()
+ '&invoice='+$("input[name='invoiceapid']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccpay/downpdf')?>?'+array);
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
+ '&product='+$("input[name='productname']").val()
+ '&supplier='+$("input[name='fullname']").val()
+ '&invoice='+$("input[name='invoiceapid']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccpay/downxls')?>?'+array);
	}
};




 
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('repaccpay') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepsales"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepsales" >
			<option value="1">Rincian Biaya Ekspedisi Per Dokumen</option>
			<option value="2">Rekap Biaya Ekspedisi Per Dokumen</option>
			<option value="3">Rekap Biaya Ekspedisi Per Barang</option>        
			<option value="4">Rincian Pembayaran Hutang per Dokumen</option>
			<option value="5">Kartu Hutang</option>
			<option value="6">Rekap Hutang per Supplier</option>
			<option value="7">Rincian Pembelian & Retur Beli Belum Lunas</option>
			<option value="8">Rincian  Umur Hutang per STTB</option>       
			<option value="9">Rekap Umur Hutang per Supplier</option>  
			<option value="10">Rekap Invoice AP Per Dokumen Belum Status Max</option>
			<option value="11">Rekap Permohonan Pembayaran Per Dokumen Belum Status Max</option>
			<option value="12">Rekap Nota Retur Pembelian Per Dokumen Belum Status Max</option> 
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
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>   
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'supplierid','ColField'=>'fullname',
							'IDDialog'=>'suplier_dialog','titledialog'=>$this->getCatalog('Supplier'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SupplierPopUp','PopGrid'=>'supplierid')); 
					?>
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceapid','ColField'=>'invoiceapid',
							'IDDialog'=>'invoiceap_dialog','titledialog'=>$this->getCatalog('no_doc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.InvoiceapcommaxPopUp','PopGrid'=>'invoiceapid')); 
					?>
                       
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
                
               
                