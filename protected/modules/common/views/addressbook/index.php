<script src="<?php echo Yii::app()->baseUrl;?>/js/addressbook.js"></script>
<h3><?php echo $this->getCatalog('addressbook') ?></h3>
<?php if ($this->checkAccess('addressbook','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('addressbook','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('addressbook','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('addressbook','isdownload')) { ?>
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
				'template'=>'{edit} {delete} {purge} {pdf} {xls}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('addressbook','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('addressbook','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('addressbook','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('addressbook','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('addressbook','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('addressbookid'),
					'name'=>'addressbookid',
					'value'=>'$data["addressbookid"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'fullname',
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
					'name'=>'isemployee',
					'header'=>$this->getCatalog('isemployee'),
					'selectableRows'=>'0',
					'checked'=>'$data["isemployee"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isvendor',
					'header'=>$this->getCatalog('isvendor'),
					'selectableRows'=>'0',
					'checked'=>'$data["isvendor"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'ishospital',
					'header'=>$this->getCatalog('ishospital'),
					'selectableRows'=>'0',
					'checked'=>'$data["ishospital"]',
				),array(
					'header'=>$this->getCatalog('currentlimit'),
					'name'=>'currentlimit',
					'value'=>'Yii::app()->format->formatNumber($data["currentlimit"])'
				),
							array(
					'header'=>$this->getCatalog('currentdebt'),
					'name'=>'currentdebt',
					'value'=>'Yii::app()->format->formatNumber($data["currentdebt"])'
				),
							array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
							array(
					'header'=>$this->getCatalog('creditlimit'),
					'name'=>'creditlimit',
					'value'=>'Yii::app()->format->formatNumber($data["creditlimit"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isstrictlimit',
					'header'=>$this->getCatalog('isstrictlimit'),
					'selectableRows'=>'0',
					'checked'=>'$data["isstrictlimit"]',
				),array(
					'header'=>$this->getCatalog('bankname'),
					'name'=>'bankname',
					'value'=>'$data["bankname"]'
				),
							array(
					'header'=>$this->getCatalog('bankaccountno'),
					'name'=>'bankaccountno',
					'value'=>'$data["bankaccountno"]'
				),
							array(
					'header'=>$this->getCatalog('accountowner'),
					'name'=>'accountowner',
					'value'=>'$data["accountowner"]'
				),
							array(
					'header'=>$this->getCatalog('areaname'),
					'name'=>'salesareaid',
					'value'=>'$data["areaname"]'
				),
							array(
					'header'=>$this->getCatalog('categoryname'),
					'name'=>'pricecategoryid',
					'value'=>'$data["categoryname"]'
				),
							array(
					'header'=>$this->getCatalog('overdue'),
					'name'=>'overdue',
					'value'=>'$data["overdue"]'
				),
							array(
					'header'=>$this->getCatalog('invoicedate'),
					'name'=>'invoicedate',
					'value'=>'Yii::app()->format->formatDate($data["invoicedate"])'
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
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('addressbook') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="addressbook_0_addressbookid">
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_fullname"><?php echo $this->getCatalog('fullname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_fullname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_iscustomer"><?php echo $this->getCatalog('iscustomer')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_iscustomer">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_isemployee"><?php echo $this->getCatalog('isemployee')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_isemployee">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_isvendor"><?php echo $this->getCatalog('isvendor')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_isvendor">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_ishospital"><?php echo $this->getCatalog('ishospital')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_ishospital">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_currentlimit"><?php echo $this->getCatalog('currentlimit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="addressbook_0_currentlimit">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_currentdebt"><?php echo $this->getCatalog('currentdebt')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="addressbook_0_currentdebt">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_taxno"><?php echo $this->getCatalog('taxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_taxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_creditlimit"><?php echo $this->getCatalog('creditlimit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="addressbook_0_creditlimit">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_isstrictlimit"><?php echo $this->getCatalog('isstrictlimit')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_isstrictlimit">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_bankname"><?php echo $this->getCatalog('bankname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_bankname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_bankaccountno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_accountowner"><?php echo $this->getCatalog('accountowner')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_accountowner">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_salesareaid','ColField'=>'addressbook_0_areaname',
							'IDDialog'=>'addressbook_0_salesareaid_dialog','titledialog'=>$this->getCatalog('areaname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesareaPopUp','PopGrid'=>'addressbook_0_salesareaidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_pricecategoryid','ColField'=>'addressbook_0_categoryname',
							'IDDialog'=>'addressbook_0_pricecategoryid_dialog','titledialog'=>$this->getCatalog('categoryname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PricecategoryPopUp','PopGrid'=>'addressbook_0_pricecategoryidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_overdue"><?php echo $this->getCatalog('overdue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="addressbook_0_overdue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_invoicedate"><?php echo $this->getCatalog('invoicedate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="addressbook_0_invoicedate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_recordstatus">
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


