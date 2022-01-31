<script src="<?php echo Yii::app()->baseUrl;?>/js/account.js"></script>
<script>
function running(id,param2)
{
	jQuery.ajax({'url':'account/running',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.reload();
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
</script>
<h3><?php echo $this->getCatalog('account') ?></h3>
<?php if ($this->checkAccess('account','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('accounting/account/uploaddata'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('account','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('account','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('account','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('account','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('account','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('account','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('account','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('account','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('account','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('accountid'),
					'name'=>'accountid',
					'value'=>'$data["accountid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('accountcode'),
					'name'=>'accountcode',
					'value'=>'$data["accountcode"]'
				),
							array(
					'header'=>$this->getCatalog('accountname'),
					'name'=>'accountname',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('parentaccount'),
					'name'=>'parentaccountid',
					'value'=>'$data["parentaccountcode"]'
				),
							array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('accounttypename'),
					'name'=>'accounttypeid',
					'value'=>'$data["accounttypename"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_accountcode"><?php echo $this->getCatalog('accountcode')?></label>
						<input type="text" class="form-control" name="dlg_search_accountcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_accountname"><?php echo $this->getCatalog('accountname')?></label>
						<input type="text" class="form-control" name="dlg_search_accountname">
					</div>
          <div class="form-group">
						<label for="dlg_search_parentaccountname"><?php echo $this->getCatalog('parentaccountname')?></label>
						<input type="text" class="form-control" name="dlg_search_parentaccountname">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_accounttypename"><?php echo $this->getCatalog('accounttypename')?></label>
						<input type="text" class="form-control" name="dlg_search_accounttypename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('account') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="account_0_accountid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'account_0_companyid','ColField'=>'account_0_companyname',
							'IDDialog'=>'account_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'account_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="account_0_accountcode"><?php echo $this->getCatalog('accountcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="account_0_accountcode">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="account_0_accountname"><?php echo $this->getCatalog('accountname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="account_0_accountname">
						</div>
					</div>
					
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'account_0_parentaccountid','ColField'=>'account_0_parentaccountname',
							'IDDialog'=>'account_0_parentid_dialog','titledialog'=>$this->getCatalog('parent'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8', 'RelationID'=>'account_0_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomPopUp','PopGrid'=>'account_0_parentidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'account_0_currencyid','ColField'=>'account_0_currencyname',
							'IDDialog'=>'account_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'account_0_currencyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'account_0_accounttypeid','ColField'=>'account_0_accounttypename',
							'IDDialog'=>'account_0_accounttypeid_dialog','titledialog'=>$this->getCatalog('accounttypename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.AccounttypePopUp','PopGrid'=>'account_0_accounttypeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="account_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="account_0_recordstatus">
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


