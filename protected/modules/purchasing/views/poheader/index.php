<style type="text/css">
.ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +1000 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:10%;
  left:10%;
}
</style>
<div class="ajax-loader">
  <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" class="img-responsive" />
</div>
<script src="<?php echo Yii::app()->baseUrl;?>/js/poheader.js"></script>
<script type="text/javascript">
function generateaddress()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/poheader/generateaddress')?>',
	'data':{
		'id':$("input[name='poheader_0_companyid']").val()
	},
		'type':'post','dataType':'json',
		'success':function(data) {
      $("textarea[name='poheader_0_shipto']").val(data.shipto);
      $("textarea[name='poheader_0_billto']").val(data.billto);
		},
		'cache':false});
	return false;
}

function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
						'productid':$("input[name='podetail_1_productid']").val(),
						'companyid':$("input[name='poheader_0_companyid']").val(),
						'currencyid':$("input[name='podetail_1_currencyid']").val(),
						'addressbookid':$("input[name='poheader_0_addressbookid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='podetail_1_unitofmeasureid']").val(data.uomid);
				$("input[name='podetail_1_uomcode']").val(data.uomcode);
				$("input[name='podetail_1_netprice']").val(data.currencyvalue);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}

function getprmaterial() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('inventory/prheader/getprmaterial')?>',
		'data': {
						'prmaterialid':$("input[name='podetail_1_prmaterialid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='podetail_1_productid']").val(data.productid);
				$("input[name='podetail_1_productname']").val(data.productname);
				$("input[name='podetail_1_unitofmeasureid']").val(data.uomid);
				$("input[name='podetail_1_uomcode']").val(data.uomcode);
				$("input[name='podetail_1_poqty']").val(data.qty);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}
</script>
<h3><?php echo $this->getCatalog('poheader') ?></h3>
<?php if ($this->checkAccess('poheader','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('poheader','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('poheader','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('poheader','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('poheader','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
    </ul>
  </div>
<?php } ?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
				'htmlOptions' => array('style'=>'width:10px'),
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{select} {edit} {purge} {pdf}',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('detail'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'url'=>'"#"',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('poheader','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('poheader','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('poheader','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('poheaderid'),
					'name'=>'poheaderid',
					'value'=>'$data["poheaderid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('pono'),
					'name'=>'pono',
					'value'=>'$data["pono"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('purchasinggroupcode'),
					'name'=>'purchasinggroupid',
					'value'=>'$data["purchasinggroupcode"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('paycode'),
					'name'=>'paymentmethodid',
					'value'=>'$data["paycode"]'
				),
							array(
					'header'=>$this->getCatalog('taxcode'),
					'name'=>'taxid',
					'value'=>'$data["taxcode"]'
				),
							array(
					'header'=>$this->getCatalog('shipto'),
					'name'=>'shipto',
					'value'=>'$data["shipto"]'
				),
							array(
					'header'=>$this->getCatalog('billto'),
					'name'=>'billto',
					'value'=>'$data["billto"]'
				),
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'statusname',
					'value'=>'$data["statusname"]'
				),
							
		)
));
?>
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_pono"><?php echo $this->getCatalog('pono')?></label>
						<input type="text" class="form-control" name="dlg_search_pono">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_paycode"><?php echo $this->getCatalog('paycode')?></label>
						<input type="text" class="form-control" name="dlg_search_paycode">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxcode"><?php echo $this->getCatalog('taxcode')?></label>
						<input type="text" class="form-control" name="dlg_search_taxcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_headernote"><?php echo $this->getCatalog('headernote')?></label>
						<input type="text" class="form-control" name="dlg_search_headernote">
					</div>
          <div class="form-group">
						<label for="dlg_search_prmaterialid"><?php echo $this->getCatalog('prmaterialid')?></label>
						<input type="text" class="form-control" name="dlg_search_prmaterialid">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
				</div>
		</div>
	</div>
</div>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('poheader') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="poheader_0_poheaderid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'poheader_0_companyid','ColField'=>'poheader_0_companyname',
							'IDDialog'=>'poheader_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'poheader_0_companyidgrid',
							'onaftersign'=>'generateaddress();')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="poheader_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="poheader_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'poheader_0_purchasinggroupid','ColField'=>'poheader_0_purchasinggroupcode',
							'IDDialog'=>'poheader_0_purchasinggroupid_dialog','titledialog'=>$this->getCatalog('purchasinggroupcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'purchasing.components.views.PurchasinggroupPopUp','PopGrid'=>'poheader_0_purchasinggroupidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'poheader_0_addressbookid','ColField'=>'poheader_0_fullname',
							'IDDialog'=>'poheader_0_addressbookid_dialog','titledialog'=>$this->getCatalog('supplier'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SupplierPopUp','PopGrid'=>'poheader_0_addressbookidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'poheader_0_paymentmethodid','ColField'=>'poheader_0_paycode',
							'IDDialog'=>'poheader_0_paymentmethodid_dialog','titledialog'=>$this->getCatalog('paycode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'poheader_0_paymentmethodidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'poheader_0_taxid','ColField'=>'poheader_0_taxcode',
							'IDDialog'=>'poheader_0_taxid_dialog','titledialog'=>$this->getCatalog('taxcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.TaxPopUp','PopGrid'=>'poheader_0_taxidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="poheader_0_shipto"><?php echo $this->getCatalog('shipto')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="poheader_0_shipto"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="poheader_0_billto"><?php echo $this->getCatalog('billto')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="poheader_0_billto"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="poheader_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="poheader_0_headernote">
						</div>
					</div>
							<input type="hidden" class="form-control" name="poheader_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#podetail"><?php echo $this->getCatalog("podetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="podetail" class="tab-pane">
	<?php if ($this->checkAccess('poheader','iswrite')) { ?>
<button name="CreateButtonpodetail" type="button" class="btn btn-primary" onclick="newdatapodetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('poheader','ispurge')) { ?>
<button name="PurgeButtonpodetail" type="button" class="btn btn-danger" onclick="purgedatapodetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpodetail,
		'id'=>'podetailList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('poheader','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatapodetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('poheader','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatapodetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('podetailid'),
					'name'=>'podetailid',
					'value'=>'$data["podetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
							'class'=>'ext.TotalColumn',
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])',
					'type'=>'raw',
					'footer'=>true
				),
				array(
					'header'=>$this->getCatalog('qtyres'),
					'name'=>'qtyres',
					'value'=>'$data["qtyres"]'
				),array(
					'header'=>$this->getCatalog('saldoqty'),
					'name'=>'saldoqty',
					'value'=>'$data["saldoqty"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('delvdate'),
					'name'=>'delvdate',
					'value'=>'Yii::app()->format->formatDate($data["delvdate"])'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
				array(
							'class'=>'ext.TotalColumn',
					'header'=>$this->getCatalog('total'),
					'name'=>'total',
					'value'=>'Yii::app()->format->formatNumber($data["total"])',
					'type'=>'raw',
					'footer'=>true
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('ratevalue'),
					'name'=>'ratevalue',
					'value'=>'Yii::app()->format->formatNumber($data["ratevalue"])'
				),
							array(
					'header'=>$this->getCatalog('diskon'),
					'name'=>'diskon',
					'value'=>'Yii::app()->format->formatNumber($data["diskon"])'
				),
							array(
					'header'=>$this->getCatalog('underdelvtol'),
					'name'=>'underdelvtol',
					'value'=>'$data["underdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('overdelvtol'),
					'name'=>'overdelvtol',
					'value'=>'$data["overdelvtol"]'
				),				
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							
		)
));
?>
  </div>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>

<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
				<div class="modal-body">
			<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('podetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpodetail,
		'id'=>'DetailpodetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('podetailid'),
					'name'=>'podetailid',
					'value'=>'$data["podetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
							'class'=>'ext.TotalColumn',
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])',
					'type'=>'raw',
					'footer'=>true
				),
				array(
					'header'=>$this->getCatalog('qtyres'),
					'name'=>'qtyres',
					'value'=>'$data["qtyres"]'
				),
				array(
					'header'=>$this->getCatalog('saldoqty'),
					'name'=>'saldoqty',
					'value'=>'$data["saldoqty"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('delvdate'),
					'name'=>'delvdate',
					'value'=>'Yii::app()->format->formatDate($data["delvdate"])'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('ratevalue'),
					'name'=>'ratevalue',
					'value'=>'Yii::app()->format->formatNumber($data["ratevalue"])'
				),
							array(
					'header'=>$this->getCatalog('diskon'),
					'name'=>'diskon',
					'value'=>'Yii::app()->format->formatNumber($data["diskon"])'
				),
							array(
					'header'=>$this->getCatalog('underdelvtol'),
					'name'=>'underdelvtol',
					'value'=>'$data["underdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('overdelvtol'),
					'name'=>'overdelvtol',
					'value'=>'$data["overdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogpodetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('podetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="podetail_1_podetailid">
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_prmaterialid','ColField'=>'podetail_1_prno',
							'IDDialog'=>'podetail_1_prmaterialid_dialog','titledialog'=>$this->getCatalog('prheader'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'poheader_0_companyid',
							'PopUpName'=>'inventory.components.views.PrmaterialPopUp','PopGrid'=>'podetail_1_prmaterialidgrid',
							'onaftersign'=>'getprmaterial();')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_productid','ColField'=>'podetail_1_productname',
							'IDDialog'=>'podetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'podetail_1_productidgrid',
							'onaftersign'=>'getproductdata();')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_poqty"><?php echo $this->getCatalog('poqty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_poqty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_unitofmeasureid','ColField'=>'podetail_1_uomcode',
							'IDDialog'=>'podetail_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'podetail_1_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'podetail_1_unitofmeasureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_delvdate"><?php echo $this->getCatalog('delvdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="podetail_1_delvdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_netprice"><?php echo $this->getCatalog('netprice')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_netprice">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_currencyid','ColField'=>'podetail_1_currencyname',
							'IDDialog'=>'podetail_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'podetail_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_ratevalue"><?php echo $this->getCatalog('ratevalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_ratevalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_diskon"><?php echo $this->getCatalog('diskon')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_diskon">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_underdelvtol"><?php echo $this->getCatalog('underdelvtol')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_underdelvtol">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_overdelvtol"><?php echo $this->getCatalog('overdelvtol')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_overdelvtol">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_itemtext"><?php echo $this->getCatalog('itemtext')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="podetail_1_itemtext"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatapodetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			
