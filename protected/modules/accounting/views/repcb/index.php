<script src="<?php echo Yii::app()->baseUrl;?>/js/repcb.js"></script>
<h3><?php echo $this->getCatalog('repcb') ?></h3>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('cb','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('cb','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('cbid'),
					'name'=>'cbid',
					'value'=>'$data["cbid"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('cashbankno'),
					'name'=>'cashbankno',
					'value'=>'$data["cashbankno"]'
				),
							array(
					'header'=>$this->getCatalog('receiptno'),
					'name'=>'receiptno',
					'value'=>'$data["receiptno"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isin',
					'header'=>$this->getCatalog('isin'),
					'selectableRows'=>'0',
					'checked'=>'$data["isin"]',
				),array(
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
						<label for="dlg_search_cashbankno"><?php echo $this->getCatalog('cashbankno')?></label>
						<input type="text" class="form-control" name="dlg_search_cashbankno">
					</div>
          <div class="form-group">
						<label for="dlg_search_receiptno"><?php echo $this->getCatalog('receiptno')?></label>
						<input type="text" class="form-control" name="dlg_search_receiptno">
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
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cb') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="cb_0_cbid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cb_0_companyid','ColField'=>'cb_0_companyname',
							'IDDialog'=>'cb_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'cb_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cb_0_receiptno"><?php echo $this->getCatalog('receiptno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cb_0_receiptno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cb_0_isin"><?php echo $this->getCatalog('isin')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="cb_0_isin">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cb_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="cb_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#cbacc"><?php echo $this->getCatalog("cbacc")?></a></li>
<li><a data-toggle="tab" href="#cheque"><?php echo $this->getCatalog("cheque")?></a></li>
<li><a data-toggle="tab" href="#bank"><?php echo $this->getCatalog("bank")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="cbacc" class="tab-pane">
	<?php if ($this->checkAccess('cb','iswrite')) { ?>
<button name="CreateButtoncbacc" type="button" class="btn btn-primary" onclick="newdatacbacc()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cb','ispurge')) { ?>
<button name="PurgeButtoncbacc" type="button" class="btn btn-danger" onclick="purgedatacbacc()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbacc,
		'id'=>'cbaccList',
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
							'visible'=>$this->booltostr($this->checkAccess('cb','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacbacc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cb','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacbacc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('cbaccid'),
					'name'=>'cbaccid',
					'value'=>'$data["cbaccid"]'
				),
							array(
					'header'=>$this->getCatalog('debitacc'),
					'name'=>'debitaccid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('creditacc'),
					'name'=>'creditaccid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
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
					'header'=>$this->getCatalog('cheque'),
					'name'=>'chequeid',
					'value'=>'$data["chequeno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('tgltolak'),
					'name'=>'tgltolak',
					'value'=>'Yii::app()->format->formatDate($data["tgltolak"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							
		)
));
?>
  </div>
<div id="cheque" class="tab-pane">
	<?php if ($this->checkAccess('cb','iswrite')) { ?>
<button name="CreateButtoncheque" type="button" class="btn btn-primary" onclick="newdatacheque()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cb','ispurge')) { ?>
<button name="PurgeButtoncheque" type="button" class="btn btn-danger" onclick="purgedatacheque()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercheque,
		'id'=>'chequeList',
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
							'visible'=>$this->booltostr($this->checkAccess('cb','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacheque($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cb','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacheque($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('chequeid'),
					'name'=>'chequeid',
					'value'=>'$data["chequeid"]'
				),
							array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('tglbayar'),
					'name'=>'tglbayar',
					'value'=>'Yii::app()->format->formatDate($data["tglbayar"])'
				),
							array(
					'header'=>$this->getCatalog('chequeno'),
					'name'=>'chequeno',
					'value'=>'$data["chequeno"]'
				),
							array(
					'header'=>$this->getCatalog('bank'),
					'name'=>'bankid',
					'value'=>'$data["bankname"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
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
					'header'=>$this->getCatalog('tglcheque'),
					'name'=>'tglcheque',
					'value'=>'Yii::app()->format->formatDate($data["tglcheque"])'
				),
							array(
					'header'=>$this->getCatalog('tgltempo'),
					'name'=>'tgltempo',
					'value'=>'Yii::app()->format->formatDate($data["tgltempo"])'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('tgltolak'),
					'name'=>'tgltolak',
					'value'=>'Yii::app()->format->formatDate($data["tgltolak"])'
				),
							array(
					'header'=>$this->getCatalog('addressbook'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'iscustomer',
					'header'=>$this->getCatalog('iscustomer'),
					'selectableRows'=>'0',
					'checked'=>'$data["iscustomer"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));
?>
  </div>
<div id="bank" class="tab-pane">
	<?php if ($this->checkAccess('cb','iswrite')) { ?>
<button name="CreateButtonbank" type="button" class="btn btn-primary" onclick="newdatabank()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cb','ispurge')) { ?>
<button name="PurgeButtonbank" type="button" class="btn btn-danger" onclick="purgedatabank()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderbank,
		'id'=>'bankList',
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
							'visible'=>$this->booltostr($this->checkAccess('cb','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatabank($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cb','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatabank($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('bankid'),
					'name'=>'bankid',
					'value'=>'$data["bankid"]'
				),
							array(
					'header'=>$this->getCatalog('bankname'),
					'name'=>'bankname',
					'value'=>'$data["bankname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
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
		<h3 class="box-title"><?php echo $this->getCatalog('cbacc')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbacc,
		'id'=>'DetailcbaccList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('cbaccid'),
					'name'=>'cbaccid',
					'value'=>'$data["cbaccid"]'
				),
							array(
					'header'=>$this->getCatalog('debitacc'),
					'name'=>'debitaccid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('creditacc'),
					'name'=>'creditaccid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
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
					'header'=>$this->getCatalog('cheque'),
					'name'=>'chequeid',
					'value'=>'$data["chequeno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('tgltolak'),
					'name'=>'tgltolak',
					'value'=>'Yii::app()->format->formatDate($data["tgltolak"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('cheque')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercheque,
		'id'=>'DetailchequeList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('chequeid'),
					'name'=>'chequeid',
					'value'=>'$data["chequeid"]'
				),
							array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('tglbayar'),
					'name'=>'tglbayar',
					'value'=>'Yii::app()->format->formatDate($data["tglbayar"])'
				),
							array(
					'header'=>$this->getCatalog('chequeno'),
					'name'=>'chequeno',
					'value'=>'$data["chequeno"]'
				),
							array(
					'header'=>$this->getCatalog('bank'),
					'name'=>'bankid',
					'value'=>'$data["bankname"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
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
					'header'=>$this->getCatalog('tglcheque'),
					'name'=>'tglcheque',
					'value'=>'Yii::app()->format->formatDate($data["tglcheque"])'
				),
							array(
					'header'=>$this->getCatalog('tgltempo'),
					'name'=>'tgltempo',
					'value'=>'Yii::app()->format->formatDate($data["tgltempo"])'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('tgltolak'),
					'name'=>'tgltolak',
					'value'=>'Yii::app()->format->formatDate($data["tgltolak"])'
				),
							array(
					'header'=>$this->getCatalog('addressbook'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'iscustomer',
					'header'=>$this->getCatalog('iscustomer'),
					'selectableRows'=>'0',
					'checked'=>'$data["iscustomer"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('bank')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderbank,
		'id'=>'DetailbankList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('bankid'),
					'name'=>'bankid',
					'value'=>'$data["bankid"]'
				),
							array(
					'header'=>$this->getCatalog('bankname'),
					'name'=>'bankname',
					'value'=>'$data["bankname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogcbacc" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cbacc') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="cbacc_1_debitaccid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbacc_1_creditaccid','ColField'=>'cbacc_1_accountname',
							'IDDialog'=>'cbacc_1_creditaccid_dialog','titledialog'=>$this->getCatalog('creditacc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.AccountPopUp','PopGrid'=>'cbacc_1_creditaccidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbacc_1_amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbacc_1_amount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbacc_1_currencyid','ColField'=>'cbacc_1_currencyname',
							'IDDialog'=>'cbacc_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'cbacc_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbacc_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbacc_1_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbacc_1_chequeid"><?php echo $this->getCatalog('chequeid')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbacc_1_chequeid">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbacc_1_tglcair"><?php echo $this->getCatalog('tglcair')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cbacc_1_tglcair">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbacc_1_tgltolak"><?php echo $this->getCatalog('tgltolak')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cbacc_1_tgltolak">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbacc_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbacc_1_description">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacbacc()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogcheque" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cheque') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="cheque_2_companyid">
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_tglbayar"><?php echo $this->getCatalog('tglbayar')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cheque_2_tglbayar">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_chequeno"><?php echo $this->getCatalog('chequeno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cheque_2_chequeno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cheque_2_bankid','ColField'=>'cheque_2_bankname',
							'IDDialog'=>'cheque_2_bankid_dialog','titledialog'=>$this->getCatalog('bank'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.AccountPopUp','PopGrid'=>'cheque_2_bankidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cheque_2_amount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cheque_2_currencyid','ColField'=>'cheque_2_currencyname',
							'IDDialog'=>'cheque_2_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'cheque_2_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cheque_2_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_tglcheque"><?php echo $this->getCatalog('tglcheque')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cheque_2_tglcheque">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_tgltempo"><?php echo $this->getCatalog('tgltempo')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cheque_2_tgltempo">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_tglcair"><?php echo $this->getCatalog('tglcair')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cheque_2_tglcair">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_tgltolak"><?php echo $this->getCatalog('tgltolak')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cheque_2_tgltolak">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cheque_2_addressbookid','ColField'=>'cheque_2_fullname',
							'IDDialog'=>'cheque_2_addressbookid_dialog','titledialog'=>$this->getCatalog('addressbook'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddressbookPopUp','PopGrid'=>'cheque_2_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cheque_2_iscustomer"><?php echo $this->getCatalog('iscustomer')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="cheque_2_iscustomer">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacheque()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogbank" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('bank') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="bank_3_bankname">
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatabank()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			