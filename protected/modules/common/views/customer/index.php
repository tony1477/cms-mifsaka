<script src="<?php echo Yii::app()->baseUrl;?>/js/customer.js"></script>
<?php if ($this->checkAccess('customer','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('common/customer/uploadinfo'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<h3><?php echo $this->getCatalog('customer') ?></h3>
<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('customer','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('customer','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('customer','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
      <li><a onclick="downpdf1($.fn.yiiGridView.getSelection('GridList'))">Download PDF Info TOP & Disc Customer</a></li>
      <li><a onclick="downxls1($.fn.yiiGridView.getSelection('GridList'))">Download XLS Info TOP & Disc Customer</a></li>
    </ul>
  </div>
<?php } ?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
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
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','ispurge')),
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','isdownload')),
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
					'header'=>$this->getCatalog('taxcode'),
					'name'=>'taxid',
					'value'=>'$data["taxcode"]'
				),
                            array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
                            array(
					'header'=>$this->getCatalog('ktpno'),
					'name'=>'taxno',
					'value'=>'$data["ktpno"]'
				),
                            array(
					'header'=>$this->getCatalog('creditlimit'),
					'name'=>'creditlimit',
					'value'=>'Yii::app()->format->formatNumber($data["creditlimit"])'
				),
							array(
					'header'=>$this->getCatalog('currentlimit'),
					'name'=>'currentlimit',
					'value'=>'Yii::app()->format->formatNumber($data["currentlimit"])'
				),	
                            array(
					'header'=>$this->getCatalog('paymentmethod'),
					'name'=>'paymentmethodid',
					'value'=>'$data["paycode"]'
				),
                            array(
					'header'=>$this->getCatalog('overdue'),
					'name'=>'overdue',
					'value'=>'$data["overdue"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isstrictlimit',
					'header'=>$this->getCatalog('isstrictlimit'),
					'selectableRows'=>'0',
					'checked'=>'$data["isstrictlimit"]',
				),
                            array(
					'header'=>$this->getCatalog('husbandbirthdate'),
					'name'=>'husbandbirthdate',
					'value'=>'Yii::app()->format->formatDate($data["husbandbirthdate"])'
				),
                            array(
					'header'=>$this->getCatalog('wifebirthdate'),
					'name'=>'wifebirthdate',
					'value'=>'Yii::app()->format->formatDate($data["wifebirthdate"])'
				),
                            array(
					'header'=>$this->getCatalog('weddingdate'),
					'name'=>'weddingdate',
					'value'=>'Yii::app()->format->formatDate($data["weddingdate"])'
				),
                            array(
					'header'=>$this->getCatalog('areaname'),
					'name'=>'salesareaid',
					'value'=>'$data["areaname"]'
				),
                            array(
					'header'=>$this->getCatalog('pricecategory'),
					'name'=>'pricecategoryid',
					'value'=>'$data["categoryname"]'
				),
                            array(
					'header'=>$this->getCatalog('groupcustomer'),
					'name'=>'groupcustomerid',
					'value'=>'$data["groupname"]'
				),
                            array(
					'header'=>$this->getCatalog('custcategory'),
					'name'=>'custcategoryid',
					'value'=>'$data["custcategoryname"]'
				),
                            array(
					'header'=>$this->getCatalog('custgrade'),
					'name'=>'custgradeid',
					'value'=>'$data["custgradename"]'
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
					'header'=>$this->getCatalog('province'),
					'name'=>'provinceid',
					'value'=>'$data["provincename"]'
				),	
							array(
					'header'=>$this->getCatalog('marketarea'),
					'name'=>'marketareaid',
					'value'=>'$data["marketname"]'
				),	
							array(
					'header'=>$this->getCatalog('customertype'),
					'name'=>'customertypeid',
					'value'=>'$data["customertypename"]'
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
						<label for="dlg_search_company"><?php echo $this->getCatalog('company')?></label>
						<input type="text" class="form-control" name="dlg_search_company">
					</div>
				</div>
        <div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_areaname"><?php echo $this->getCatalog('areaname')?></label>
						<input type="text" class="form-control" name="dlg_search_areaname">
					</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_categoryname"><?php echo $this->getCatalog('categoryname')?></label>
						<input type="text" class="form-control" name="dlg_search_categoryname">
					</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_groupname"><?php echo $this->getCatalog('groupname')?></label>
						<input type="text" class="form-control" name="dlg_search_groupname">
					</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_overdue"><?php echo $this->getCatalog('overdue')?></label>
						<input type="text" class="form-control" name="dlg_search_overdue">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('customer') ?></h4>
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
          
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_taxid','ColField'=>'addressbook_0_taxcode',
							'IDDialog'=>'addressbook_0_taxid_dialog','titledialog'=>$this->getCatalog('taxcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.TaxPopUp','PopGrid'=>'addressbook_0_taxid')); 
					?>
													
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
							<label for="addressbook_0_ktpno"><?php echo $this->getCatalog('ktpno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_ktpno">
						</div>
					</div>
				<div class="row">
				<div class="col-md-4">
					<label for="husbandbirthdate"><?php echo $this->getCatalog('husbandbirthdate')?></label>
				</div>
				<div class="col-md-8">
					<input type="date" class="form-control" name="addressbook_0_husbandbirthdate" >
				</div>
			</div>
      <div class="row">
				<div class="col-md-4">
					<label for="wifebirthdate"><?php echo $this->getCatalog('wifebirthdate')?></label>
				</div>
				<div class="col-md-8">
					<input type="date" class="form-control" name="addressbook_0_wifebirthdate" >
				</div>
			</div>
      <div class="row">
				<div class="col-md-4">
					<label for="weddingdate"><?php echo $this->getCatalog('weddingdate')?></label>
				</div>
				<div class="col-md-8">
					<input type="date" class="form-control" name="addressbook_0_weddingdate" >
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
          
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_paymentmethodid','ColField'=>'addressbook_0_paycode',
							'IDDialog'=>'addressbook_0_paymentmethodid_dialog','titledialog'=>$this->getCatalog('paycode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'addressbook_0_paymentmethodid')); 
					?>
          
          <div class="row">
						<div class="col-md-4">
							<label for="addressbook_0_overdue"><?php echo $this->getCatalog('overdue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="addressbook_0_overdue">
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
							'IDDialog'=>'addressbook_0_pricecategoryid_dialog','titledialog'=>$this->getCatalog('pricecategory'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PricecategoryPopUp','PopGrid'=>'addressbook_0_pricecategoryidgrid')); 
					?>
        
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
							<label for="addressbook_0_bankname"><?php echo $this->getCatalog('bankname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addressbook_0_bankname">
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
						array('id'=>'Widget','IDField'=>'addressbook_0_groupcustomerid','ColField'=>'addressbook_0_groupname',
							'IDDialog'=>'addressbook_0_groupcustomerid_dialog','titledialog'=>$this->getCatalog('groupname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.GroupcustomerPopUp','PopGrid'=>'addressbook_0_groupcustomerid')); 
					?>
          
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_custcategoryid','ColField'=>'addressbook_0_custcategoryname',
							'IDDialog'=>'addressbook_0_custcategoryid_dialog','titledialog'=>$this->getCatalog('custcategoryname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustcategoryPopUp','PopGrid'=>'addressbook_0_custcategoryidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_custgradeid','ColField'=>'addressbook_0_custgradename',
							'IDDialog'=>'addressbook_0_custgradeid_dialog','titledialog'=>$this->getCatalog('custgradename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustgradePopUp','PopGrid'=>'addressbook_0_custgradeidgrid')); 
					?>
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_provinceid','ColField'=>'addressbook_0_provincename',
							'IDDialog'=>'addressbook_0_provinceid_dialog','titledialog'=>$this->getCatalog('province'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.ProvincePopUp','PopGrid'=>'addressbook_0_provinceidgrid')); 
					?>
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressbook_0_marketareaid','ColField'=>'addressbook_0_marketname',
							'IDDialog'=>'addressbook_0_marketareaid_dialog','titledialog'=>$this->getCatalog('marketarea'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MarketareaPopUp','PopGrid'=>'addressbook_0_marketareaidgrid')); 
					?>
				<div class="row">
          <div class="col-md-4">
            <label for="addressbook_0_customertype"><?php echo $this->getCatalog('customertype')?></label> 
          </div>
          <div class="col-md-8">
            <select class="form-control" id="addressbook_0_customertypeid" name="addressbook_0_customertypeid">
              <option disabled value="0"><?php echo getCatalog('customertype')?></option>
              <?php foreach($customertype as $row) :?>
                <option value=<?=$row['id']?> ><?=$row['name']?></option>
              <?php endforeach;?>
            </select>
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
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#address"><?php echo $this->getCatalog("address")?></a></li>
<li><a data-toggle="tab" href="#addresscontact"><?php echo $this->getCatalog("addresscontact")?></a></li>
<li><a data-toggle="tab" href="#customerdisc"><?php echo $this->getCatalog("customerdisc")?></a></li>
<li><a data-toggle="tab" href="#addressaccount"><?php echo $this->getCatalog("addressaccount")?></a></li>
<li><a data-toggle="tab" href="#customerpotensi"><?php echo $this->getCatalog("customerpotensi")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="address" class="tab-pane">
	<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="CreateButtonaddress" type="button" class="btn btn-primary" onclick="newdataaddress()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('customer','iswrite')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
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
				),array(
					'header'=>$this->getCatalog('lng'),
					'name'=>'lng',
					'value'=>'$data["lng"]'
				),
				array(
				'header'=>$this->getCatalog('foto'),
				'name'=>'foto',
				'type'=>'raw',
				'value'=>'CHtml::image(Yii::app()->baseUrl."/images/addressbook/".$data["foto"],$data["foto"],
					array("width"=>"100"))'
			),
							
		)
));
?>
  </div>
<div id="addresscontact" class="tab-pane">
	<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="CreateButtonaddresscontact" type="button" class="btn btn-primary" onclick="newdataaddresscontact()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('customer','iswrite')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddresscontact($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
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
					'header'=>$this->getCatalog('wanumber'),
					'name'=>'wanumber',
					'value'=>'$data["wanumber"]'
				),
							array(
					'header'=>$this->getCatalog('telegramid'),
					'name'=>'telegramid',
					'value'=>'$data["telegramid"]'
				),
							array(
					'header'=>$this->getCatalog('emailaddress'),
					'name'=>'emailaddress',
					'value'=>'$data["emailaddress"]'
				),
            
                            array(
                    'header'=>$this->getCatalog('custktp'),
                    'name'=>'foto',
                    'type'=>'raw',
                    'value'=>'CHtml::image(Yii::app()->baseUrl."/images/addressbook/".$data["ktp"],$data["ktp"],
                        array("width"=>"100"))'
                ),
							
		)
));
?>
  </div>
  <div id="customerdisc" class="tab-pane">
	<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="CreateButtoncustomerdisc" type="button" class="btn btn-primary" onclick="newdatacustomerdisc()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="PurgeButtoncustomerdisc" type="button" class="btn btn-danger" onclick="purgedatacustomerdisc()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercustomerdisc,
		'id'=>'customerdiscList',
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
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacustomerdisc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacustomerdisc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('custdiscid'),
					'name'=>'custdiscid',
					'value'=>'$data["custdiscid"]'
				),
							array(
					'header'=>$this->getCatalog('materialtype'),
					'name'=>'materialtypeid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('discvalue'),
					'name'=>'discvalue',
					'value'=>'$data["discvalue"]'
				),
                            array(
					'header'=>$this->getCatalog('sopaymethod'),
					'name'=>'sopaymethodid',
					'value'=>'$data["sopaycode"]'
				),
                            array(
					'header'=>$this->getCatalog('realpaymethod'),
					'name'=>'realpaymethodid',
					'value'=>'$data["realpaycode"]',
                    'visible'=>$this->booltostr($this->GetMenuAuth('realpayment')),
				),		
		)
));
?>
  </div>
  <div id="customerpotensi" class="tab-pane">
	<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="CreateButtoncustomerpotensi" type="button" class="btn btn-primary" onclick="newdatacustomerpotensi()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="PurgeButtoncustomerpotensi" type="button" class="btn btn-danger" onclick="purgedatacustomerpotensi()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercustomerpotensi,
		'id'=>'customerpotensiList',
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
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacustomerpotensi($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacustomerpotensi($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('addresspotensiid'),
					'name'=>'addresspotensiid',
					'value'=>'$data["addresspotensiid"]'
				),
							array(
					'header'=>$this->getCatalog('groupline'),
					'name'=>'grouplineid',
					'value'=>'$data["grouplinename"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'$data["amount"]'
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
<div id="addressaccount" class="tab-pane">
	<?php if ($this->checkAccess('customer','iswrite')) { ?>
<button name="CreateButtonaddressaccount" type="button" class="btn btn-primary" onclick="newdataaddressaccount()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('customer','iswrite')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddressaccount($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('customer','iswrite')),							
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
					'header'=>$this->getCatalog('accpiutang'),
					'name'=>'accpiutangid',
					'value'=>'$data["accpiutangname"]'
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
				),array(
					'header'=>$this->getCatalog('lng'),
					'name'=>'lng',
					'value'=>'$data["lng"]'
				),
				array(
				'header'=>$this->getCatalog('foto'),
				'name'=>'foto',
				'type'=>'raw',
				'value'=>'CHtml::image(Yii::app()->baseUrl."/images/addressbook/".$data["foto"],$data["foto"],
					array("width"=>"100"))'
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
				),          array(
                    'header'=>$this->getCatalog('custktp'),
                    'name'=>'foto',
                    'type'=>'raw',
                    'value'=>'CHtml::image(Yii::app()->baseUrl."/images/addressbook/".$data["ktp"],$data["ktp"],
                        array("width"=>"100"))'
                ),
							
		)
));?>
		</div>		
		</div>	
    <div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('customerdisc')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercustomerdisc,
		'id'=>'DetailcustomerdiscList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('custdiscid'),
					'name'=>'custdiscid',
					'value'=>'$data["custdiscid"]'
				),
							array(
					'header'=>$this->getCatalog('materialtype'),
					'name'=>'materialtypeid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('discvalue'),
					'name'=>'discvalue',
					'value'=>'$data["discvalue"]'
				),
                            array(
					'header'=>$this->getCatalog('sopaymethod'),
					'name'=>'sopaymethodid',
					'value'=>'$data["sopaycode"]'
				),
                            array(
					'header'=>$this->getCatalog('realpaymethod'),
					'name'=>'realpaymethodid',
					'value'=>'$data["realpaycode"]',
                    'visible'=>$this->booltostr($this->GetMenuAuth('realpayment')),
				),
		)
));?>
		</div>		
		</div>
    <div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('customerpotensi')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercustomerpotensi,
		'id'=>'DetailcustomerpotensiList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('addresspotensiid'),
					'name'=>'addresspotensiid',
					'value'=>'$data["addresspotensiid"]'
				),
							array(
					'header'=>$this->getCatalog('groupline'),
					'name'=>'grouplineid',
					'value'=>'$data["grouplinename"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'$data["amount"]'
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
					'header'=>$this->getCatalog('accpiutang'),
					'name'=>'accpiutangid',
					'value'=>'$data["accpiutangname"]'
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
					
					<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-8">
				<script>
function successUp(param,param2,param3)
{
	$('input[name="address_1_foto"]').val(param2);
}
</script>
				<?php
				$events = array(
						'success' => 'successUp(param,param2,param3)',
				);
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('common/customer/upload'),
    'mimeTypes' => array('.jpg','.png','.jpeg'),		
		'events' => $events,
		'options' => CMap::mergeArray($this->options, $this->dict ),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
</div>
</div>

<div class="row">
						<div class="col-md-4">
							<label for="address_1_foto"><?php echo $this->getCatalog('foto')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="address_1_foto">
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
							<label for="addresscontact_2_wanumber"><?php echo $this->getCatalog('wanumber')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addresscontact_2_wanumber">
						</div>
					</div>
        <div class="row">
						<div class="col-md-4">
							<label for="addresscontact_2_telegramid"><?php echo $this->getCatalog('telegramid')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="addresscontact_2_telegramid">
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
        
        <div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-8">
				<script>
function successUp2(param,param2,param3)
{
	$('input[name="addresscontact_2_ktp"]').val(param2);
}
</script>
				<?php
				$events = array(
						'success' => 'successUp2(param,param2,param3)',
				);
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('common/customer/uploadktp'),
    'mimeTypes' => array('.jpg','.png','.jpeg'),		
		'events' => $events,
		'options' => CMap::mergeArray($this->options, $this->dict ),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
</div>
</div>

<div class="row">
						<div class="col-md-4">
							<label for="addresscontact_2_ktp"><?php echo $this->getCatalog('custktp')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="addresscontact_2_ktp">
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
  <div id="InputDialogcustomerdisc" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('customerdisc') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="customerdisc_4_custdiscid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'customerdisc_4_materialtypeid','ColField'=>'customerdisc_4_description',
							'IDDialog'=>'customerdisc_4_materialtypeid_dialog','titledialog'=>$this->getCatalog('materialtype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialtypePopUp','PopGrid'=>'customerdisc_4_materialtypeidgrid')); 
					?>
        <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'customerdisc_4_sopaymethodid','ColField'=>'customerdisc_4_sopaycode',
					'IDDialog'=>'customerdisc_4_sopaymethodid_dialog','titledialog'=>$this->getCatalog('paymentmethod'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'customerdisc_4_sopaymethodid')); 
			?>
        <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'customerdisc_4_realpaymethodid','ColField'=>'customerdisc_4_realpaycode',
					'IDDialog'=>'customerdisc_4_realpaymethodid_dialog','titledialog'=>$this->getCatalog('realpayment'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'customerdisc_4_realpaymethodid')); 
			?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="customerdisc_4_discvalue"><?php echo $this->getCatalog('discvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="customerdisc_4_discvalue">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacustomerdisc()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
      </div>
      </div>
    </div>
    <div id="InputDialogcustomerpotensi" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('customerpotensi') ?></h4>
      </div>
			<div class="modal-body">
        <input type="hidden" class="form-control" name="customerpotensi_5_addresspotensiid">
				
        <div class="row">
          <div class="col-md-4">
            <label for="customerpotensi_5_grouplineid"><?php echo $this->getCatalog('groupname')?></label> 
          </div>
          <div class="col-md-8">
            <select class="form-control" id="customerpotensi_5_grouplineid" name="customerpotensi_5_grouplineid">
              <option disabled value="0"><?php echo getCatalog('groupline')?></option>
              <?php foreach($groupline as $row) :?>
                <option value=<?=$row['id']?> ><?=$row['name']?></option>
              <?php endforeach;?>
            </select>
          </div>
		    </div>
        
        <div class="row">
						<div class="col-md-4">
							<label for="customerpotensi_5_amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="customerpotensi_5_amount">
						</div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <label for="customerpotensi_5_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
          </div>
          <div class="col-md-8">
            <input type="checkbox" name="customerpotensi_5_recordstatus">
          </div>
        </div>
							
			</div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacustomerpotensi()"><?php echo $this->getCatalog('save') ?></button>
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
						array('id'=>'Widget','IDField'=>'addressaccount_3_accpiutangid','ColField'=>'addressaccount_3_accpiutangname',
							'IDDialog'=>'addressaccount_3_accpiutangid_dialog','titledialog'=>$this->getCatalog('accpiutang'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'addressaccount_4_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomdetPopUp','PopGrid'=>'addressaccount_3_accpiutangidgrid')); 
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
<script type="text/javascript">
function running(id,param2)
{
	jQuery.ajax({'url':'customer/running',
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