<script src="<?php echo Yii::app()->baseUrl;?>/js/repcbout.js"></script>
<h3><?php echo $this->getCatalog('repcbout') ?></h3>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('cashbankout','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('cashbankoutid'),
					'name'=>'cashbankoutid',
					'value'=>'$data["cashbankoutid"]'
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
					'header'=>$this->getCatalog('cashbankoutno'),
					'name'=>'cashbankoutno',
					'value'=>'$data["cashbankoutno"]'
				),
							array(
					'header'=>$this->getCatalog('reqpayno'),
					'name'=>'reqpayid',
					'value'=>'$data["reqpayno"]'
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
						<label for="dlg_search_cashbankoutno"><?php echo $this->getCatalog('cashbankoutno')?></label>
						<input type="text" class="form-control" name="dlg_search_cashbankoutno">
					</div>
          <div class="form-group">
						<label for="dlg_search_reqpayno"><?php echo $this->getCatalog('reqpayno')?></label>
						<input type="text" class="form-control" name="dlg_search_reqpayno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('cashbankout') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="cashbankout_0_cashbankoutid">
        <div class="row">
						<div class="col-md-4">
							<label for="cashbankout_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cashbankout_0_docdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cashbankout_0_cashbankoutno"><?php echo $this->getCatalog('cashbankoutno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cashbankout_0_cashbankoutno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cashbankout_0_reqpayid','ColField'=>'cashbankout_0_reqpayno',
							'IDDialog'=>'cashbankout_0_reqpayid_dialog','titledialog'=>$this->getCatalog('reqpayno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.ReqpaycomPopUp','PopGrid'=>'cashbankout_0_reqpayidgrid')); 
					?>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#cbapinv"><?php echo $this->getCatalog("cbapinv")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="cbapinv" class="tab-pane">
	<?php if ($this->checkAccess('cashbankout','iswrite')) { ?>
<button name="CreateButtoncbapinv" type="button" class="btn btn-primary" onclick="newdatacbapinv()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cashbankout','ispurge')) { ?>
<button name="PurgeButtoncbapinv" type="button" class="btn btn-danger" onclick="purgedatacbapinv()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbapinv,
		'id'=>'cbapinvList',
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
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacbapinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacbapinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('cbapinvid'),
					'name'=>'cbapinvid',
					'value'=>'$data["cbapinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('ekspedisi'),
					'name'=>'ekspedisiid',
					'value'=>'$data["ekspedisino"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('cashbankno'),
					'name'=>'cashbankno',
					'value'=>'$data["cashbankno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('cbapinv')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbapinv,
		'id'=>'DetailcbapinvList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('cbapinvid'),
					'name'=>'cbapinvid',
					'value'=>'$data["cbapinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('ekspedisi'),
					'name'=>'ekspedisiid',
					'value'=>'$data["ekspedisino"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('cashbankno'),
					'name'=>'cashbankno',
					'value'=>'$data["cashbankno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
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
			
<div id="InputDialogcbapinv" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cbapinv') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="cbapinv_1_accountid">
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_cashbankno"><?php echo $this->getCatalog('cashbankno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_cashbankno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_tglcair"><?php echo $this->getCatalog('tglcair')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cbapinv_1_tglcair">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_payamount"><?php echo $this->getCatalog('payamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbapinv_1_payamount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbapinv_1_currencyid','ColField'=>'cbapinv_1_currencyname',
							'IDDialog'=>'cbapinv_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'cbapinv_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbapinv_1_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_bankaccountno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_bankname"><?php echo $this->getCatalog('bankname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_bankname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_bankowner"><?php echo $this->getCatalog('bankowner')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_bankowner">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="cbapinv_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacbapinv()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			