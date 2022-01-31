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
+ '&supplier='+$("input[name='fullname']").val()
+ '&productcollectid='+$productcollectid
+ '&product='+$("input[name='productname']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('purchasing/reportpurchasing/downpdf')?>?'+array);
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
+ '&supplier='+$("input[name='fullname']").val()
+ '&productcollectid='+$productcollectid
+ '&product='+$("input[name='productname']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('purchasing/reportpurchasing/downxls')?>?'+array);
	}
};

</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('reportpurchasing') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listrepsales"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listrepsales" >
			
        <option value="1">1.Rincian PO Per Dokumen</option>

        <option value="2">2.Rekap PO Per Dokumen</option>

        <option value="3">3.Rekap PO Per Supplier</option>

        <option value="4">4.Rekap PO Per Barang</option>
                
        <option value="5">5.Rincian Pembelian Per Dokumen</option>        

        <option value="6">6.Rekap Pembelian Per Dokumen</option>

        <option value="7">7.Rekap Pembelian Per Supplier</option>

        <option value="8">8.Rekap Pembelian Per Barang</option>

        <option value="9">9.Rincian Retur Pembelian Per Dokumen</option>        

        <option value="10">10.Rekap Retur Pembelian Per Dokumen</option>

        <option value="11">11.Rekap Retur Pembelian Per Supplier</option>

        <option value="12">12.Rekap Retur Pembelian Per Barang</option>

        <option value="13">13.Rincian Pembelian - Retur Per Dokumen</option>

        <option value="14">14.Rekap Pembelian - Retur Per Dokumen</option>

        <option value="15">15.Rekap Pembelian - Retur Per Supplier</option>

        <option value="16">16.Rekap Pembelian - Retur Per Barang</option>

        <option value="17">17.Pendingan PO Per Dokumen</option>
        
        <option value="23">18.Rincian Pendingan PO Per Dokumen ke Supplier</option>

        <option value="18">19.Rincian Pendingan PO Per Barang</option>

        <option value="19">20.Rekap Pendingan PO Per Barang</option>
        
        <option value="26">21.Rincian Pendingan PO Per Barang Per Dokumen</option>
        
        <option value="24">22.Rincian Pendingan PO Per Barang ke Supplier</option>
        
        <option value="25">23.Rekap Pendingan PO Per Barang ke Supplier</option>
        
        <option value="27">24.Rincian Pendingan PO Per Gudang</option>

        <option value="20">25.Dokumen PO yang belum Max</option>

        <option value="21">26.Rekap Pembelian Per Barang Per Tanggal</option>
								
        <option value="22">27.Laporan Pembelian Per Supplier Per Bulan Per Tahun</option>
		
        <option value="28">Rekap Forecast FPP</option>
                        
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
						array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'fullname',
							'IDDialog'=>'slocid_dialog','titledialog'=>$this->getCatalog('supplier'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SupplierPopUp','PopGrid'=>'slocidgrid')); 
					?>
      <div class="row">
        <div class="col-md-4">
          <label for="productcollectid">Multiple</label>
        </div>
        <div class="col-md-8">
          <select class="selectpicker form-control" name="productcollectid" id="productcollectid" data-live-search="true" title="Select <?=GetCatalog('productcollect')?>" data-hide-disabled="true" data-actions-box="true" multiple>
          
          </select>
        </div>
      </div>            
                              
      <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
							'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productgrid')); 
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
        for (var i = 0; i < data.total; i++) {
          $("select[name='productcollectid']").append($('<option value="' + data.rows[i].productcollectid + '">' + data.rows[i].collectionname + '</option>'));
          //$images.push(data.data[i].images.standard_resolution.url);
        }
      $('.selectpicker').selectpicker('refresh');
      },
      cache: false,
    });
});

  </script>