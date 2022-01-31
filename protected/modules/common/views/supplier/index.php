<script src="<?php echo Yii::app()->baseUrl;?>/js/supplier.js"></script>
<h3><?php echo $this->getCatalog('supplier') ?></h3>
<?php if ($this->checkAccess('supplier','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('supplier','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('supplier','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('supplier','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('supplier','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('supplier','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('supplier','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
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
					'name'=>'isvendor',
					'header'=>$this->getCatalog('isvendor'),
					'selectableRows'=>'0',
					'checked'=>'$data["isvendor"]',
				),array(
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
          <div class="form-group">
						<label for="dlg_search_taxno"><?php echo $this->getCatalog('taxno')?></label>
						<input type="text" class="form-control" name="dlg_search_taxno">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankname"><?php echo $this->getCatalog('bankname')?></label>
						<input type="text" class="form-control" name="dlg_search_bankname">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						<input type="text" class="form-control" name="dlg_search_bankaccountno">
					</div>
          <div class="form-group">
						<label for="dlg_search_accountowner"><?php echo $this->getCatalog('accountowner')?></label>
						<input type="text" class="form-control" name="dlg_search_accountowner">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('supplier') ?></h4>
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
							<label for="addressbook_0_isvendor"><?php echo $this->getCatalog('isvendor')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_isvendor">
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
					<div class="row">
						<div class="col-md-4">
							<label for="logo"><?php echo $this->getCatalog('logo')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_logo" readonly>
						</div>
					</div>
					<script>
function successUp(param,param2,param3)
{
	$('input[name="addressbook_0_logo"]').val(param2);
	$('div.dz-success').remove();
}
function addedfile(param,param2,param3)
{
	$('div.dz-success').remove();
}
</script>
<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-8">
				<?php
				$events = array(
						'success' => 'successUp(param,param2,param3)',
						'addedfile' => 'addedfile(param,param2,param3)'
				);
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('common/supplier/upload'),
    'mimeTypes' => array('.jpg','.png','.jpeg'),		
		'events' => $events,
		'options' => CMap::mergeArray($this->options, $this->dict ),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?></div>
</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressbook_0_recordstatus">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#address"><?php echo $this->getCatalog("address")?></a></li>
<li><a data-toggle="tab" href="#addresscontact"><?php echo $this->getCatalog("addresscontact")?></a></li>
<li><a data-toggle="tab" href="#addressaccount"><?php echo $this->getCatalog("addressaccount")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="address" class="tab-pane">
	<?php if ($this->checkAccess('supplier','iswrite')) { ?>
<button name="CreateButtonaddress" type="button" class="btn btn-primary" onclick="newdataaddress()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('supplier','ispurge')) { ?>
<button name="PurgeButtonaddress" type="button" class="btn btn-danger" onclick="purgedataaddress()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddress,
		'id'=>'addressList',
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
							'visible'=>$this->booltostr($this->checkAccess('supplier','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('supplier','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('addressid'),
					'name'=>'addressid',
					'value'=>'$data["addressid"]'
				),
							array(
					'header'=>$this->getCatalog('addresstype'),
					'name'=>'addresstypeid',
					'value'=>'$data["addresstypename"]'
				),
							array(
					'header'=>$this->getCatalog('addressname'),
					'name'=>'addressname',
					'value'=>'$data["addressname"]'
				),
							array(
					'header'=>$this->getCatalog('rt'),
					'name'=>'rt',
					'value'=>'$data["rt"]'
				),
							array(
					'header'=>$this->getCatalog('rw'),
					'name'=>'rw',
					'value'=>'$data["rw"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('faxno'),
					'name'=>'faxno',
					'value'=>'$data["faxno"]'
				),
							array(
					'header'=>$this->getCatalog('lat'),
					'name'=>'lat',
					'value'=>'$data["lat"]'
				),
							array(
					'header'=>$this->getCatalog('lng'),
					'name'=>'lng',
					'value'=>'$data["lng"]'
				),
							
		)
));
?>
  </div>
<div id="addresscontact" class="tab-pane">
	<?php if ($this->checkAccess('supplier','iswrite')) { ?>
<button name="CreateButtonaddresscontact" type="button" class="btn btn-primary" onclick="newdataaddresscontact()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('supplier','ispurge')) { ?>
<button name="PurgeButtonaddresscontact" type="button" class="btn btn-danger" onclick="purgedataaddresscontact()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddresscontact,
		'id'=>'addresscontactList',
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
							'visible'=>$this->booltostr($this->checkAccess('supplier','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddresscontact($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('supplier','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataaddresscontact($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('addresscontactid'),
					'name'=>'addresscontactid',
					'value'=>'$data["addresscontactid"]'
				),
							array(
					'header'=>$this->getCatalog('contacttype'),
					'name'=>'contacttypeid',
					'value'=>'$data["contacttypename"]'
				),
							array(
					'header'=>$this->getCatalog('addresscontactname'),
					'name'=>'addresscontactname',
					'value'=>'$data["addresscontactname"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('mobilephone'),
					'name'=>'mobilephone',
					'value'=>'$data["mobilephone"]'
				),
							array(
					'header'=>$this->getCatalog('emailaddress'),
					'name'=>'emailaddress',
					'value'=>'$data["emailaddress"]'
				),
							
		)
));
?>
  </div>
<div id="addressaccount" class="tab-pane">
	<?php if ($this->checkAccess('supplier','iswrite')) { ?>
<button name="CreateButtonaddressaccount" type="button" class="btn btn-primary" onclick="newdataaddressaccount()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('supplier','ispurge')) { ?>
<button name="PurgeButtonaddressaccount" type="button" class="btn btn-danger" onclick="purgedataaddressaccount()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddressaccount,
		'id'=>'addressaccountList',
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
							'visible'=>$this->booltostr($this->checkAccess('supplier','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddressaccount($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('supplier','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataaddressaccount($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('addressaccountid'),
					'name'=>'addressaccountid',
					'value'=>'$data["addressaccountid"]'
				),
							array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('acchutang'),
					'name'=>'acchutangid',
					'value'=>'$data["acchutangname"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('address')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddress,
		'id'=>'DetailaddressList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('addressid'),
					'name'=>'addressid',
					'value'=>'$data["addressid"]'
				),
							array(
					'header'=>$this->getCatalog('addresstype'),
					'name'=>'addresstypeid',
					'value'=>'$data["addresstypename"]'
				),
							array(
					'header'=>$this->getCatalog('addressname'),
					'name'=>'addressname',
					'value'=>'$data["addressname"]'
				),
							array(
					'header'=>$this->getCatalog('rt'),
					'name'=>'rt',
					'value'=>'$data["rt"]'
				),
							array(
					'header'=>$this->getCatalog('rw'),
					'name'=>'rw',
					'value'=>'$data["rw"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('faxno'),
					'name'=>'faxno',
					'value'=>'$data["faxno"]'
				),
							array(
					'header'=>$this->getCatalog('lat'),
					'name'=>'lat',
					'value'=>'$data["lat"]'
				),
							array(
					'header'=>$this->getCatalog('lng'),
					'name'=>'lng',
					'value'=>'$data["lng"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('addresscontact')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddresscontact,
		'id'=>'DetailaddresscontactList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('addresscontactid'),
					'name'=>'addresscontactid',
					'value'=>'$data["addresscontactid"]'
				),
							array(
					'header'=>$this->getCatalog('contacttype'),
					'name'=>'contacttypeid',
					'value'=>'$data["contacttypename"]'
				),
							array(
					'header'=>$this->getCatalog('addresscontactname'),
					'name'=>'addresscontactname',
					'value'=>'$data["addresscontactname"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('mobilephone'),
					'name'=>'mobilephone',
					'value'=>'$data["mobilephone"]'
				),
							array(
					'header'=>$this->getCatalog('emailaddress'),
					'name'=>'emailaddress',
					'value'=>'$data["emailaddress"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('addressaccount')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddressaccount,
		'id'=>'DetailaddressaccountList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('addressaccountid'),
					'name'=>'addressaccountid',
					'value'=>'$data["addressaccountid"]'
				),
							array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('acchutang'),
					'name'=>'acchutangid',
					'value'=>'$data["acchutangname"]'
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
			
<div id="InputDialogaddress" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('address') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="address_1_addressid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'address_1_addresstypeid','ColField'=>'address_1_addresstypename',
							'IDDialog'=>'address_1_addresstypeid_dialog','titledialog'=>$this->getCatalog('addresstype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddresstypePopUp','PopGrid'=>'address_1_addresstypeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_addressname"><?php echo $this->getCatalog('addressname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_addressname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_rt"><?php echo $this->getCatalog('rt')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_rt">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_rw"><?php echo $this->getCatalog('rw')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_rw">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'address_1_cityid','ColField'=>'address_1_cityname',
							'IDDialog'=>'address_1_cityid_dialog','titledialog'=>$this->getCatalog('city'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'address_1_cityidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_phoneno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_faxno"><?php echo $this->getCatalog('faxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_faxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_lat"><?php echo $this->getCatalog('lat')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="address_1_lat">
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<label for="address_1_lng"><?php echo $this->getCatalog('lng')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="address_1_lng">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataaddress()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogaddresscontact" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('addresscontact') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="addresscontact_2_addresscontactid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addresscontact_2_contacttypeid','ColField'=>'addresscontact_2_contacttypename',
							'IDDialog'=>'addresscontact_2_contacttypeid_dialog','titledialog'=>$this->getCatalog('contacttype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ContacttypePopUp','PopGrid'=>'addresscontact_2_contacttypeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addresscontact_2_addresscontactname"><?php echo $this->getCatalog('addresscontactname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addresscontact_2_addresscontactname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addresscontact_2_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addresscontact_2_phoneno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addresscontact_2_mobilephone"><?php echo $this->getCatalog('mobilephone')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addresscontact_2_mobilephone">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addresscontact_2_emailaddress"><?php echo $this->getCatalog('emailaddress')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addresscontact_2_emailaddress">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataaddresscontact()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogaddressaccount" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('addressaccount') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="addressaccount_3_addressaccountid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressaccount_3_companyid','ColField'=>'addressaccount_3_companyname',
							'IDDialog'=>'addressaccount_3_companyid_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'addressaccount_3_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressaccount_3_acchutangid','ColField'=>'addressaccount_3_acchutangname',
							'IDDialog'=>'addressaccount_3_acchutangid_dialog','titledialog'=>$this->getCatalog('acchutang'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'addressaccount_4_company',
							'PopUpName'=>'accounting.components.views.AccountcomdetPopUp','PopGrid'=>'addressaccount_3_acchutangidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressaccount_3_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressaccount_3_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataaddressaccount()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			