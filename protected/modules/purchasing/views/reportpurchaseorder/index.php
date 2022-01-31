<script src="<?php echo Yii::app()->baseUrl;?>/js/reportpurchaseorder.js"></script>
<h3><?php echo $this->getCatalog('reportpurchaseorder') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('reportpurchaseorder','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
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
				'template'=>'{select} {pdf}',
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
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
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
					'header'=>$this->getCatalog('prmaterialid'),
					'name'=>'prmaterialid',
					'value'=>'$data["prmaterialid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
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