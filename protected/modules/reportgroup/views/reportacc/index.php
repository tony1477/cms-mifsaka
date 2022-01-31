
<script type="text/javascript">
function downpdfreportacc() {
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
	var array = 'lro='+$("select[name='listrepacc']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&materialgroup='+$("input[name='materialgroupcode']").val()
+ '&customer='+$("input[name='fullname']").val()
+ '&product='+$("input[name='productname']").val()
+ '&account='+$("input[name='accountname']").val()
+	'&startacccode='+$("input[name='startacccode']").val()
+	'&endacccode='+$("input[name='endacccode']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/reportacc/downpdf')?>?'+array);
	}
};


function downxlsrepportacc() {
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
	var array = 'lro='+$("select[name='listrepacc']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&sloc='+$("input[name='sloccode']").val()
+ '&materialgroup='+$("input[name='materialgroupcode']").val()
+ '&customer='+$("input[name='fullname']").val()
+ '&product='+$("input[name='productname']").val()
+ '&account='+$("input[name='accountname']").val()
+	'&startacccode='+$("input[name='startacccode']").val()
+	'&endacccode='+$("input[name='endacccode']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/reportacc/downxls')?>?'+array);
	}
};




 
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('reportacc') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepacc"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepacc" >
			
		<option value="1">1.Rincian Jurnal Transaksi</option>
		<option value="2">2.Buku Besar</option>
		<option value="3">3.Neraca - Uji Coba</option>
		<option value="4">4.Laba (Rugi) - Uji Coba</option>
		<option value="5">5.Rincian Umur Piutang Cek/Giro</option>
		<option value="6">6.Rekap Umur Piutang Cek/Giro</option>
		<option value="7">7.Rincian Cek/Giro Cair - Ekstern</option>
		<option value="8">8.Rincian Cek/Giro Tolak - Ekstern</option>
		<option value="9">9.Rincian Cek/Giro Opname - Ekstern</option>
		<option value="10">10.Rincian Umur Hutang Cek/Giro</option>
		<option value="11">11.Rekap Umur Hutang Cek/Giro</option>
		<option value="12">12.Rincian Cek/Giro Cair - Intern</option>
		<option value="13">13.Rincian Cek/Giro Tolak - Intern</option>
		<option value="14">14.Rekap Jurnal Umum Per Dokumen Belum Status Max</option>
		<option value="15">15.Rekap Penerimaan Kas/Bank Per Dokumen Belum Status Max</option>
		<option value="16">16.Rekap Pengeluaran Kas/Bank Per Dokumen Belum Status Max</option>
		<option value="17">17.Rekap Cash Bank Per Dokumen Belum Status Max</option>
		<option value="18">18.Lampiran Neraca 1</option>
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
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'common.components.views.SloccomPopUp','PopGrid'=>'slocidgrid')); 
					?>
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'materialgroupid','ColField'=>'materialgroupcode',
							'IDDialog'=>'materialgroup_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupPopUp','PopGrid'=>'materialgroupgrid')); 
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
						array('id'=>'Widget','IDField'=>'accountid','ColField'=>'accountname',
							'IDDialog'=>'account_dialog','titledialog'=>$this->getCatalog('accountname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.AccountPopUp','PopGrid'=>'accountgrid')); 
					?>  
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'startacccodeid','ColField'=>'startacccode',
							'IDDialog'=>'startacccode_dialog','titledialog'=>$this->getCatalog('startacccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomPopUp','PopGrid'=>'startacccodegrid'));
					?>  
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'endacccodeid','ColField'=>'endacccode',
							'IDDialog'=>'endacccode_dialog','titledialog'=>$this->getCatalog('endacccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomPopUp','PopGrid'=>'endacccodegrid')); 
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
                        <li><a onclick="downpdfreportacc()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsrepportacc()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>
                
               
                
