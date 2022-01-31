<script src="<?php echo Yii::app()->baseUrl;?>/js/repreqpay.js"></script>
<h3><?php echo $this->getCatalog('repreqpay') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('repreqpay','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('reqpay','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('reqpayid'),
					'name'=>'reqpayid',
					'value'=>'$data["reqpayid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('reqpayno'),
					'name'=>'reqpayno',
					'value'=>'$data["reqpayno"]'
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
						<label for="dlg_search_reqpayno"><?php echo $this->getCatalog('reqpayno')?></label>
						<input type="text" class="form-control" name="dlg_search_reqpayno">
					</div>
          <div class="form-group">
						<label for="dlg_search_invoiceno"><?php echo $this->getCatalog('invoiceno')?></label>
						<input type="text" class="form-control" name="dlg_search_invoiceno">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxno"><?php echo $this->getCatalog('taxno')?></label>
						<input type="text" class="form-control" name="dlg_search_taxno">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						<input type="text" class="form-control" name="dlg_search_bankaccountno">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankname"><?php echo $this->getCatalog('bankname')?></label>
						<input type="text" class="form-control" name="dlg_search_bankname">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankowner"><?php echo $this->getCatalog('bankowner')?></label>
						<input type="text" class="form-control" name="dlg_search_bankowner">
					</div>
          <div class="form-group">
						<label for="dlg_search_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						<input type="text" class="form-control" name="dlg_search_itemnote">
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
		<h3 class="box-title"><?php echo $this->getCatalog('reqpayinv')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderreqpayinv,
		'id'=>'DetailreqpayinvList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('reqpayinvid'),
					'name'=>'reqpayinvid',
					'value'=>'$data["reqpayinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('amou'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
				),
							array(
					'header'=>$this->getCatalog('tax'),
					'name'=>'taxid',
					'value'=>'$data["taxcode"]'
				),
							array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
							array(
					'header'=>$this->getCatalog('taxdate'),
					'name'=>'taxdate',
					'value'=>'Yii::app()->format->formatDate($data["taxdate"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'$data["currencyrate"]'
				),
							array(
					'header'=>$this->getCatalog('bankaccountno'),
					'name'=>'bankaccountno',
					'value'=>'$data["bankaccountno"]'
				),
							array(
					'header'=>$this->getCatalog('bankname'),
					'name'=>'bankname',
					'value'=>'$data["bankname"]'
				),
							array(
					'header'=>$this->getCatalog('bankowner'),
					'name'=>'bankowner',
					'value'=>'$data["bankowner"]'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>