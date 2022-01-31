<script type="text/javascript">
function downpdfrepsales() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
  $productcollectid = $("select[name='productcollectid']").val();
  //console.log($productcollectid);
  if($productcollectid==null) $productcollectid='';
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
+ '&fullname='+$("input[name='employeename']").val()
+ '&product='+$("input[name='productname']").val()
+ '&productcollectid='+$productcollectid
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('production/repprod/downpdf')?>?'+array);
	}
};


function downxlsrepsales() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
  $productcollectid = $("select[name='productcollectid']").val();
  //console.log($productcollectid);
  if($productcollectid==null) $productcollectid='';
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
+ '&fullname='+$("input[name='employeename']").val()
+ '&product='+$("input[name='productname']").val()
+ '&productcollectid='+$productcollectid
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('production/repprod/downxls')?>?'+array);
	}
};

</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('repprod') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepsales"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepsales" >
			<option value="1">1.Rincian Produksi Per Dokumen</option>
						<option value="2">2.Rekap Produksi Per Material Group Per Barang - G</option>
						<option value="3">3.Rincian Pemakaian Per Dokumen</option>
						<option value="4">4.Rekap Pemakaian Per Gudang Per Barang</option>
						<option value="23">5.Rekap Pemakaian Per Barang - G</option>
						<option value="5">5.Perbandingan Planning vs Output</option>
						<option value="6">6.Raw Material yang Gudang Asal Belum Ada di Data Gudang - SPP</option>
						<option value="7">7.Raw Material yang Gudang Tujuan Belum Ada di Data Gudang - SPP</option>		
						<option value="8">8.Pendingan Produksi</option>		
						<option value="9">9.Rincian Pendingan Produksi PerBarang</option>		
						<option value="10">10.Rekap Pendingan Produksi PerBarang</option>
            <option value="11">11.Rekap Produksi Per Material Group Per Barang Per Hari</option>
            <option value="12">12.Rekap Produksi Per Dokumen Belum Status Max</option>
            <option value="13">13.Rekap Produksi Material Group Per Barang Per Bulan</option>
            <option value="14">14.Jadwal Produksi (SPP)</option>
            <option value="15">15.SPP yang belum status Max</option>
            <option value="16">16.Laporan Perbandingan</option>
            <option value="17">17.Laporan Material SPP</option>
            <option value="18">18.Laporan Hasil Produksi Menggunakan Scan</option>
            <option value="19">19.Laporan Hasil Operator Per Man Power</option>
            <option value="20">20.Laporan Hasil Produksi By Kapasitas Cycle Time</option>
            <option value="21">21.Laporan Rincian Hasil Produksi Per Material Group Process</option>
            <option value="22">22.Laporan Rekap Hasil Produksi Per Material Group Process</option>
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
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employeename',
							'IDDialog'=>'employee_dialog','titledialog'=>$this->getCatalog('employee'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'employeegrid')); 
					?> 
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
					?>   
<div class="row">
  <div class="col-md-4">
    <label for="productcollectid"><?=getCatalog('productcollection')?></label>
  </div>
  <div class="col-md-8">
    <select class="selectpicker form-control" name="productcollectid" id="productcollectid" data-live-search="true" title="Select <?=GetCatalog('productcollect')?>" data-hide-disabled="true" data-actions-box="true" multiple>
    </select>
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

  </script>      