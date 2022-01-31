<script src="<?php echo Yii::app()->baseUrl;?>/js/company.js"></script>
<h3><?php echo $this->getCatalog('company') ?></h3>
<?php if ($this->checkAccess('company','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('company','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('company','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('company','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('company','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('company','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('company','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('company','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('company','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('company','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('companyid'),
					'name'=>'companyid',
					'value'=>'$data["companyid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyname',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('companycode'),
					'name'=>'companycode',
					'value'=>'$data["companycode"]'
				),
							array(
					'header'=>$this->getCatalog('address'),
					'name'=>'address',
					'value'=>'$data["address"]'
				),
							array(
					'header'=>$this->getCatalog('cityname'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('zipcode'),
					'name'=>'zipcode',
					'value'=>'$data["zipcode"]'
				),
							array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
							array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('faxno'),
					'name'=>'faxno',
					'value'=>'$data["faxno"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('webaddress'),
					'name'=>'webaddress',
					'value'=>'$data["webaddress"]'
				),
							array(
					'header'=>$this->getCatalog('email'),
					'name'=>'email',
					'value'=>'$data["email"]'
				),
							array(
					'header'=>$this->getCatalog('leftlogofile'),
					'name'=>'leftlogofile',
					'value'=>'$data["leftlogofile"]'
				),
							array(
					'header'=>$this->getCatalog('rightlogofile'),
					'name'=>'rightlogofile',
					'value'=>'$data["rightlogofile"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isholding',
					'header'=>$this->getCatalog('isholding'),
					'selectableRows'=>'0',
					'checked'=>'$data["isholding"]',
				),
              array(
					'header'=>$this->getCatalog('billto'),
					'name'=>'billto',
					'value'=>'$data["billto"]'
				),
              array(
					'header'=>$this->getCatalog('bankacc1'),
					'name'=>'bankacc1',
					'value'=>'$data["bankacc1"]'
				),
              array(
					'header'=>$this->getCatalog('bankacc2'),
					'name'=>'bankacc2',
					'value'=>'$data["bankacc2"]'
				),
              array(
					'header'=>$this->getCatalog('bankacc3'),
					'name'=>'bankacc3',
					'value'=>'$data["bankacc3"]'
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
						<label for="dlg_search_companycode"><?php echo $this->getCatalog('companycode')?></label>
						<input type="text" class="form-control" name="dlg_search_companycode">
					</div>
          <div class="form-group">
						<label for="dlg_search_address"><?php echo $this->getCatalog('address')?></label>
						<input type="text" class="form-control" name="dlg_search_address">
					</div>
          <div class="form-group">
						<label for="dlg_search_cityname"><?php echo $this->getCatalog('cityname')?></label>
						<input type="text" class="form-control" name="dlg_search_cityname">
					</div>
          <div class="form-group">
						<label for="dlg_search_zipcode"><?php echo $this->getCatalog('zipcode')?></label>
						<input type="text" class="form-control" name="dlg_search_zipcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxno"><?php echo $this->getCatalog('taxno')?></label>
						<input type="text" class="form-control" name="dlg_search_taxno">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_faxno"><?php echo $this->getCatalog('faxno')?></label>
						<input type="text" class="form-control" name="dlg_search_faxno">
					</div>
          <div class="form-group">
						<label for="dlg_search_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						<input type="text" class="form-control" name="dlg_search_phoneno">
					</div>
          <div class="form-group">
						<label for="dlg_search_webaddress"><?php echo $this->getCatalog('webaddress')?></label>
						<input type="text" class="form-control" name="dlg_search_webaddress">
					</div>
          <div class="form-group">
						<label for="dlg_search_email"><?php echo $this->getCatalog('email')?></label>
						<input type="text" class="form-control" name="dlg_search_email">
					</div>
          <div class="form-group">
						<label for="dlg_search_leftlogofile"><?php echo $this->getCatalog('leftlogofile')?></label>
						<input type="text" class="form-control" name="dlg_search_leftlogofile">
					</div>
          <div class="form-group">
						<label for="dlg_search_rightlogofile"><?php echo $this->getCatalog('rightlogofile')?></label>
						<input type="text" class="form-control" name="dlg_search_rightlogofile">
					</div>
          <div class="form-group">
						<label for="dlg_search_billto"><?php echo $this->getCatalog('billto')?></label>
						<input type="text" class="form-control" name="dlg_search_billto">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankacc1"><?php echo $this->getCatalog('bankacc1')?></label>
						<input type="text" class="form-control" name="dlg_search_bankacc1">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankacc2"><?php echo $this->getCatalog('bankacc2')?></label>
						<input type="text" class="form-control" name="dlg_search_bankacc2">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankacc3"><?php echo $this->getCatalog('bankacc3')?></label>
						<input type="text" class="form-control" name="dlg_search_bankacc3">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('company') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="company_0_companyid">
				
				<div class="row">
						<div class="col-md-4">
							<label for="company_0_companyname"><?php echo $this->getCatalog('companyname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_companyname">
						</div>
					</div>
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_companycode"><?php echo $this->getCatalog('companycode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_companycode">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_address"><?php echo $this->getCatalog('address')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_address">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'company_0_cityid','ColField'=>'company_0_cityname',
							'IDDialog'=>'company_0_cityid_dialog','titledialog'=>$this->getCatalog('cityname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'company_0_cityidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_zipcode"><?php echo $this->getCatalog('zipcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_zipcode">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_taxno"><?php echo $this->getCatalog('taxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_taxno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'company_0_currencyid','ColField'=>'company_0_currencyname',
							'IDDialog'=>'company_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'company_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_faxno"><?php echo $this->getCatalog('faxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_faxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_phoneno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_webaddress"><?php echo $this->getCatalog('webaddress')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_webaddress">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_email"><?php echo $this->getCatalog('email')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_email">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_leftlogofile"><?php echo $this->getCatalog('leftlogofile')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_leftlogofile">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_rightlogofile"><?php echo $this->getCatalog('rightlogofile')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_rightlogofile">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_isholding"><?php echo $this->getCatalog('isholding')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="company_0_isholding">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_billto"><?php echo $this->getCatalog('billto')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_billto">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_bankacc1"><?php echo $this->getCatalog('bankacc1')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_bankacc1">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_bankacc2"><?php echo $this->getCatalog('bankacc2')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_bankacc2">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="company_0_bankacc3"><?php echo $this->getCatalog('bankacc3')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="company_0_bankacc3">
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


