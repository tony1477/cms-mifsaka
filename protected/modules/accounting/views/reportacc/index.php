<script type="text/javascript">
  $(document).ready(function(){
	$("select[name='listrepacc']").on('change',function(){
      
      var plant = ['1','2','5','6','7','8','9','10','11','12','13','29'];
      var acccode = ['1','2'];
      var accname = ['1','2'];
      var employee = ['20','21','22','23','24'];
      var supplier = ['25','27'];
      var customer = ['9','26','28'];
	  var startdate = ['29'];
      
      let select = $("select[name='listrepacc']").val();
      if(plant.includes(select)) {
          $('#repacc_plantid').show();
      }
      else {
          $('#repacc_plantid').hide();
      }
      if(acccode.includes(select)) {
          $('#repacc_startacccode').show();
          $('#repacc_endacccode').show();
      }
      else {
          $('#repacc_startacccode').hide();
          $('#repacc_endacccode').hide();
      }
      if(accname.includes(select)) {
          $('#repacc_account').show();
      }
      else {
          $('#repacc_account').hide();
      }
      if(employee.includes(select)) {
          $('#repacc_employee').show();
      }
      else {
          $('#repacc_employee').hide();
      }
      if(supplier.includes(select)) {
          $('#repacc_supplier').show();
      }
      else {
          $('#repacc_supplier').hide();
      }
      if(customer.includes(select)) {
          $('#repacc_addressbookid').show();
      }
      else {
          $('#repacc_addressbookid').hide();
      }
      if(startdate.includes(select)) {
          $('#repacc_startdate').hide();
      }
      else {
          $('#repacc_startdate').show();
      }
      
    });
});
  
function setacccode() {
    var x = $("input[name='acccode']").val('1');
    $("input[name='startacccodeid']").val('');
    $("input[name='startacccode']").val('');
    $("input[name='endacccodeid']").val('');
    $("input[name='endacccode']").val('');
}
function clearacccode() {
  $("input[name='acccode']").val('');
}
function downpdfreportacc() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
	if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
/*		if ($startdate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptystartdate')?>');
	}
	else
*/		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
	var array = 'lro='+$("select[name='listrepacc']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&plant='+$("input[name='plantid']").val()
+ '&sloc='
+ '&materialgroup='
+ '&customer='+$("input[name='customer']").val()
+ '&supplier='+$("input[name='supplier']").val()
+ '&employee='+$("input[name='employee']").val()
+ '&product='
+ '&account='+$("input[name='accountname']").val()
+ '&startacccode='+$("input[name='startacccode']").val()
+ '&endacccode='+$("input[name='endacccode']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+ '&per=10';
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
/*		if ($startdate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptystartdate')?>');
	}
	else
*/		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
	var array = 'lro='+$("select[name='listrepacc']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&plant='+$("input[name='plantid']").val()
+ '&sloc='
+ '&materialgroup='
+ '&customer='+$("input[name='customer']").val()
+ '&supplier='+$("input[name='supplier']").val()
+ '&employee='+$("input[name='employee']").val()
+ '&product='
+ '&account='+$("input[name='accountname']").val()
+ '&startacccode='+$("input[name='startacccode']").val()
+ '&endacccode='+$("input[name='endacccode']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+ '&per=10';
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
			
		<option value="">Pilih Laporan</option>
		<option value="1">1.Rincian Jurnal Transaksi</option>
		<option value="2">2.Buku Besar</option>
		<option value="29">3.Laporan Cash & Bank Harian</option>
		<!--<option value="3">3.Neraca - Uji Coba</option>
		<option value="4">4.Laba (Rugi) - Uji Coba</option>-->
		<option value="5">5.Rincian Umur Piutang Cek/Giro</option>
		<option value="6">6.Rekap Umur Piutang Cek/Giro</option>
		<option value="7">7.Rincian Cek/Giro Cair - Ekstern</option>
		<option value="8">8.Rincian Cek/Giro Tolak - Ekstern</option>
		<option value="9">9.Rincian Cek/Giro Opname - Ekstern</option>
		<option value="10">10.Rincian Umur Hutang Cek/Giro</option>
		<option value="11">11.Rekap Umur Hutang Cek/Giro</option>
		<option value="12">12.Rincian Cek/Giro Cair - Intern</option>
		<option value="13">13.Rincian Cek/Giro Tolak - Intern</option>
		<!--<option value="18">14.Lampiran Neraca 1</option>-->
		<option value="20">15.Rincian Piutang Karyawan</option>
		<option value="21">16.Rincian Hutang Deposito Staff</option>
		<option value="22">17.Rincian Hutang Deposito Salesman</option>
		<option value="23">18.Rincian Hutang Deposito Supervisor</option>
		<option value="24">19.Rincian Hutang Deposito BM</option>
		<option value="30">20.Rincian Hutang Finalty Tagihan Sales/SPV</option>
		<option value="25">21.Rincian Uang Muka Pembelian</option>
		<option value="26">22.Rincian Uang Muka Penjualan</option>
		<option value="27">23.Rincian Hutang Ekspedisi</option>
		<option value="28">24.Rincian Cadangan Insentif Toko</option>
		<option value="14">25.Rekap Jurnal Umum Per Dokumen Belum Status Max</option>
		<option value="15">26.Rekap Penerimaan Kas/Bank Per Dokumen Belum Status Max</option>
		<option value="16">27.Rekap Pengeluaran Kas/Bank Per Dokumen Belum Status Max</option>
		<option value="17">28.Rekap Cash Bank Per Dokumen Belum Status Max</option>
		</select>
	</div>
</div>
          <input type="hidden" name="acccode" id="acccode" value="" />
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companyidgrid')); 
					?>
            <div id="repacc_plantid">  
            <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'plantid','ColField'=>'plantcode',
							'IDDialog'=>'plant_dialog','titledialog'=>$this->getCatalog('plant'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PlantCompanyPopUp','PopGrid'=>'plantidgrid',
                            'onaftersign'=>'setacccode();','RelationID'=>'companyid','onclicksign'=>'clearacccode();')); 
					?>
            </div>
            <!--
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
            -->
                    <div id="repacc_addressbookid">
                    <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'customer',
							'IDDialog'=>'customer_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'customergrid')); 
					?>
                    </div>
                    <div id="repacc_supplier">
                    <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'supplierid','ColField'=>'supplier',
							'IDDialog'=>'supplier_dialog','titledialog'=>$this->getCatalog('supplier'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SupplierPopUp','PopGrid'=>'suppliergrid')); 
					?>
                    </div>
                    <div id="repacc_employee">
                    <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employee',
							'IDDialog'=>'employee_dialog','titledialog'=>$this->getCatalog('employee'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'employeegrid')); 
					?>
                    </div>
                    <!--    
                    <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>
                    -->
                    <div id="repacc_account">
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'accountid','ColField'=>'accountname',
							'IDDialog'=>'account_dialog','titledialog'=>$this->getCatalog('accountname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.AccountPopUp','PopGrid'=>'accountgrid')); 
					?>  
                    </div>
                    <div id="repacc_startacccode">
                      <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'startacccodeid','ColField'=>'startacccode',
							'IDDialog'=>'startacccode_dialog','titledialog'=>$this->getCatalog('startacccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomAccPopUp','PopGrid'=>'startacccodegrid','RelationID2'=>'acccode'));
					?>
                    </div>
                    <div id="repacc_endacccode">
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'endacccodeid','ColField'=>'endacccode',
							'IDDialog'=>'endacccode_dialog','titledialog'=>$this->getCatalog('endacccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomAccPopUp','PopGrid'=>'endacccodegrid','RelationID2'=>'acccode')); 
					?>
                    </div>
<div class="row">
<div class="col-md-4">
				<label for="startdate"><?php echo $this->getCatalog('date')?></label>
				</div>
				<div class="col-md-8">
		<span id='repacc_startdate'><input type="date" class="form-control" name="startdate" ></input>s/d</span><input type="date" class="form-control" name="enddate"></input>
                <br>
              
                
                <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="downpdfreportacc()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsrepportacc()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>
                
               
                
