<script type="text/javascript">
function downpdfrepaccpers() {
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
+ '&storagebin='+$("input[name='description']").val()
+ '&product='+$("input[name='productname']").val()
+ '&materialgroup='+$("input[name='materialgroupcode']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('accounting/repaccpers/downpdf')?>?'+array);
	}
};


function downxlsrepaccpers() {
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
+ '&storagebin='+$("input[name='description']").val()
+ '&product='+$("input[name='productname']").val()
+ '&materialgroup='+$("input[name='materialgroupcode']").val()
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
		<option value="1">(1).Rekap Persediaan (Detail)</option>
        <option value="2">(2).Rekap Persediaan (Detail) Data Harga</option>
        <option value="3">(3).Rekap Penerimaan Persediaan (Detail)</option>
        <option value="4">(4).Rekap Pengeluaran Persediaan (Detail)</option>
        <option value="5">(5).HPP</option>
        <option value="6">(6).HPP Berdasarkan BOM</option>
		<option value="7">(7).Rincian Nilai Pemakaian Stok</option>
        <option value="8">(8).Rekap Nilai Pemakaian Stok</option>
        <option value="9">(9).Rincian Nilai Stock Opname</option>
        <option value="10">(10).Rekap Nilai Stock Opname</option>
        <option value="11">(11).Rincian Harga Pokok Penjualan</option>
        <option value="12">(12).Rekap Harga Pokok Penjualan</option>                       
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
							'PopUpName'=>'common.components.views.SloccomuserPopUp','PopGrid'=>'slocidgrid')); 
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
                        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mareialgroupid','ColField'=>'materialgroupcode',
							'IDDialog'=>'materialgroup_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupPopUp','PopGrid'=>'materialgroupgrid')); 
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
                        <li><a onclick="downpdfrepaccpers()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsrepaccpers()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>
                
               
                