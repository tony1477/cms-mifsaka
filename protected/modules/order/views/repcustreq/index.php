<script type="text/javascript">
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'custreq_0_custreqid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&custcode='+$("input[name='dlg_search_custcode']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&cityname='+$("input[name='dlg_search_cityname']").val()
+ '&provincename='+$("input[name='dlg_search_provincename']").val()
+ '&zipcode='+$("input[name='dlg_search_zipcode']").val()
+ '&countryname='+$("input[name='dlg_search_countryname']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&mobileno='+$("input[name='dlg_search_mobileno']").val()
+ '&faxno='+$("input[name='dlg_search_faxno']").val()
+ '&idno='+$("input[name='dlg_search_idno']").val()
+ '&contactperson='+$("input[name='dlg_search_contactperson']").val()
+ '&owner='+$("input[name='dlg_search_owner']").val()
+ '&homeno='+$("input[name='dlg_search_homeno']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&buildingstatus='+$("input[name='dlg_search_buildingstatus']").val()
+ '&pramuniaga='+$("input[name='dlg_search_pramuniaga']").val()
+ '&taxgroupname='+$("input[name='dlg_search_taxgroupname']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&bankname='+$("input[name='dlg_search_bankname']").val()
+ '&taxname='+$("input[name='dlg_search_taxname']").val()
+ '&accountno='+$("input[name='dlg_search_accountno']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&custcategoryname='+$("input[name='dlg_search_custcategoryname']").val()
+ '&custgradename='+$("input[name='dlg_search_custgradename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'custreq_0_custreqid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&custcode='+$("input[name='dlg_search_custcode']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&cityname='+$("input[name='dlg_search_cityname']").val()
+ '&provincename='+$("input[name='dlg_search_provincename']").val()
+ '&zipcode='+$("input[name='dlg_search_zipcode']").val()
+ '&countryname='+$("input[name='dlg_search_countryname']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&mobileno='+$("input[name='dlg_search_mobileno']").val()
+ '&faxno='+$("input[name='dlg_search_faxno']").val()
+ '&idno='+$("input[name='dlg_search_idno']").val()
+ '&contactperson='+$("input[name='dlg_search_contactperson']").val()
+ '&owner='+$("input[name='dlg_search_owner']").val()
+ '&homeno='+$("input[name='dlg_search_homeno']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&buildingstatus='+$("input[name='dlg_search_buildingstatus']").val()
+ '&pramuniaga='+$("input[name='dlg_search_pramuniaga']").val()
+ '&taxgroupname='+$("input[name='dlg_search_taxgroupname']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&bankname='+$("input[name='dlg_search_bankname']").val()
+ '&taxname='+$("input[name='dlg_search_taxname']").val()
+ '&accountno='+$("input[name='dlg_search_accountno']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&custcategoryname='+$("input[name='dlg_search_custcategoryname']").val()
+ '&custgradename='+$("input[name='dlg_search_custgradename']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/custreq/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'custreq_0_custreqid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&custcode='+$("input[name='dlg_search_custcode']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&cityname='+$("input[name='dlg_search_cityname']").val()
+ '&provincename='+$("input[name='dlg_search_provincename']").val()
+ '&zipcode='+$("input[name='dlg_search_zipcode']").val()
+ '&countryname='+$("input[name='dlg_search_countryname']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&mobileno='+$("input[name='dlg_search_mobileno']").val()
+ '&faxno='+$("input[name='dlg_search_faxno']").val()
+ '&idno='+$("input[name='dlg_search_idno']").val()
+ '&contactperson='+$("input[name='dlg_search_contactperson']").val()
+ '&owner='+$("input[name='dlg_search_owner']").val()
+ '&homeno='+$("input[name='dlg_search_homeno']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&buildingstatus='+$("input[name='dlg_search_buildingstatus']").val()
+ '&pramuniaga='+$("input[name='dlg_search_pramuniaga']").val()
+ '&taxgroupname='+$("input[name='dlg_search_taxgroupname']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&bankname='+$("input[name='dlg_search_bankname']").val()
+ '&taxname='+$("input[name='dlg_search_taxname']").val()
+ '&accountno='+$("input[name='dlg_search_accountno']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&categoryname='+$("input[name='dlg_search_categoryname']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&custcategoryname='+$("input[name='dlg_search_custcategoryname']").val()
+ '&custgradename='+$("input[name='dlg_search_custgradename']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/custreq/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'custreqid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('custreq') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('custreq','isdownload')) { ?>
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
				'template'=>'{pdf} {xls}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('custreq','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('custreq','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('custreqid'),
					'name'=>'custreqid',
					'value'=>'$data["custreqid"]'
				),
							array(
					'header'=>$this->getCatalog('custreqno'),
					'name'=>'custreqno',
					'value'=>'$data["custreqno"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('custcode'),
					'name'=>'custcode',
					'value'=>'$data["custcode"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'fullname',
					'value'=>'$data["fullname"]'
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
					'header'=>$this->getCatalog('provincename'),
					'name'=>'provinceid',
					'value'=>'$data["provincename"]'
				),
							array(
					'header'=>$this->getCatalog('zipcode'),
					'name'=>'zipcode',
					'value'=>'$data["zipcode"]'
				),
							array(
					'header'=>$this->getCatalog('countryname'),
					'name'=>'countryid',
					'value'=>'$data["countryname"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('mobileno'),
					'name'=>'mobileno',
					'value'=>'$data["mobileno"]'
				),
							array(
					'header'=>$this->getCatalog('faxno'),
					'name'=>'faxno',
					'value'=>'$data["faxno"]'
				),
							array(
					'header'=>$this->getCatalog('ktpno'),
					'name'=>'idno',
					'value'=>'$data["idno"]'
				),
							array(
					'header'=>$this->getCatalog('contactperson'),
					'name'=>'contactperson',
					'value'=>'$data["contactperson"]'
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
					'header'=>$this->getCatalog('owner'),
					'name'=>'owner',
					'value'=>'$data["owner"]'
				),
							array(
					'header'=>$this->getCatalog('homeno'),
					'name'=>'homeno',
					'value'=>'$data["homeno"]'
				),
							array(
					'header'=>$this->getCatalog('owneraddress'),
					'name'=>'owneraddress',
					'value'=>'$data["owneraddress"]'
				),
							array(
					'header'=>$this->getCatalog('religionname'),
					'name'=>'religionid',
					'value'=>'$data["religionname"]'
				),
							array(
					'header'=>$this->getCatalog('buildingstatus'),
					'name'=>'buildingstatus',
					'value'=>'$data["buildingstatus"]'
				),
							array(
					'header'=>$this->getCatalog('empno'),
					'name'=>'empno',
					'value'=>'$data["empno"]'
				),
							array(
					'header'=>$this->getCatalog('pramuniaga'),
					'name'=>'pramuniaga',
					'value'=>'$data["pramuniaga"]'
				),
							array(
					'header'=>$this->getCatalog('taxgroupname'),
					'name'=>'taxgroupid',
					'value'=>'$data["taxgroupname"]'
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
					'header'=>$this->getCatalog('taxname'),
					'name'=>'taxname',
					'value'=>'$data["taxname"]'
				),
							array(
					'header'=>$this->getCatalog('bankaddress'),
					'name'=>'bankaddress',
					'value'=>'$data["bankaddress"]'
				),
							array(
					'header'=>$this->getCatalog('taxaddress'),
					'name'=>'taxaddress',
					'value'=>'$data["taxaddress"]'
				),
							array(
					'header'=>$this->getCatalog('accountno'),
					'name'=>'accountno',
					'value'=>'$data["accountno"]'
				),
							array(
					'header'=>$this->getCatalog('accountname'),
					'name'=>'accountname',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('birthdatetoko'),
					'name'=>'birthdatetoko',
					'value'=>'Yii::app()->format->formatDate($data["birthdatetoko"])'
				),
							array(
					'header'=>$this->getCatalog('salesname'),
					'name'=>'employeeid',
					'value'=>'$data["salesname"]'
				),
							array(
					'header'=>$this->getCatalog('creditlimit'),
					'name'=>'creditlimit',
					'value'=>'Yii::app()->format->formatNumber($data["creditlimit"])'
				),
							array(
					'header'=>$this->getCatalog('paycode'),
					'name'=>'paymentid',
					'value'=>'$data["paycode"]'
				),
							array(
					'header'=>$this->getCatalog('categoryname'),
					'name'=>'pricecategoryid',
					'value'=>'$data["categoryname"]'
				),
            
                            array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupcustomerid',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('areaname'),
					'name'=>'salesareaid',
					'value'=>'$data["areaname"]'
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
							array(
					'header'=>$this->getCatalog('custcategoryname'),
					'name'=>'custcategoryid',
					'value'=>'$data["custcategoryname"]'
				),
							array(
					'header'=>$this->getCatalog('custgradename'),
					'name'=>'custgradeid',
					'value'=>'$data["custgradename"]'
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
						<label for="dlg_search_custcode"><?php echo $this->getCatalog('custcode')?></label>
						<input type="text" class="form-control" name="dlg_search_custcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_cityname"><?php echo $this->getCatalog('cityname')?></label>
						<input type="text" class="form-control" name="dlg_search_cityname">
					</div>
          <div class="form-group">
						<label for="dlg_search_provincename"><?php echo $this->getCatalog('provincename')?></label>
						<input type="text" class="form-control" name="dlg_search_provincename">
					</div>
          <div class="form-group">
						<label for="dlg_search_zipcode"><?php echo $this->getCatalog('zipcode')?></label>
						<input type="text" class="form-control" name="dlg_search_zipcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_countryname"><?php echo $this->getCatalog('countryname')?></label>
						<input type="text" class="form-control" name="dlg_search_countryname">
					</div>
          <div class="form-group">
						<label for="dlg_search_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						<input type="text" class="form-control" name="dlg_search_phoneno">
					</div>
          <div class="form-group">
						<label for="dlg_search_mobileno"><?php echo $this->getCatalog('mobileno')?></label>
						<input type="text" class="form-control" name="dlg_search_mobileno">
					</div>
          <div class="form-group">
						<label for="dlg_search_faxno"><?php echo $this->getCatalog('faxno')?></label>
						<input type="text" class="form-control" name="dlg_search_faxno">
					</div>
          <div class="form-group">
						<label for="dlg_search_idno"><?php echo $this->getCatalog('ktpno')?></label>
						<input type="text" class="form-control" name="dlg_search_idno">
					</div>
          <div class="form-group">
						<label for="dlg_search_contactperson"><?php echo $this->getCatalog('contactperson')?></label>
						<input type="text" class="form-control" name="dlg_search_contactperson">
					</div>
          <div class="form-group">
						<label for="dlg_search_owner"><?php echo $this->getCatalog('owner')?></label>
						<input type="text" class="form-control" name="dlg_search_owner">
					</div>
          <div class="form-group">
						<label for="dlg_search_homeno"><?php echo $this->getCatalog('homeno')?></label>
						<input type="text" class="form-control" name="dlg_search_homeno">
					</div>
          <div class="form-group">
						<label for="dlg_search_religionname"><?php echo $this->getCatalog('religionname')?></label>
						<input type="text" class="form-control" name="dlg_search_religionname">
					</div>
          <div class="form-group">
						<label for="dlg_search_buildingstatus"><?php echo $this->getCatalog('buildingstatus')?></label>
						<input type="text" class="form-control" name="dlg_search_buildingstatus">
					</div>
          <div class="form-group">
						<label for="dlg_search_pramuniaga"><?php echo $this->getCatalog('pramuniaga')?></label>
						<input type="text" class="form-control" name="dlg_search_pramuniaga">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxgroupname"><?php echo $this->getCatalog('taxgroupname')?></label>
						<input type="text" class="form-control" name="dlg_search_taxgroupname">
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
						<label for="dlg_search_taxname"><?php echo $this->getCatalog('taxname')?></label>
						<input type="text" class="form-control" name="dlg_search_taxname">
					</div>
          <div class="form-group">
						<label for="dlg_search_accountno"><?php echo $this->getCatalog('accountno')?></label>
						<input type="text" class="form-control" name="dlg_search_accountno">
					</div>
          <div class="form-group">
						<label for="dlg_search_accountname"><?php echo $this->getCatalog('accountname')?></label>
						<input type="text" class="form-control" name="dlg_search_accountname">
					</div>
          <div class="form-group">
						<label for="dlg_search_salesname"><?php echo $this->getCatalog('sales')?></label>
						<input type="text" class="form-control" name="dlg_search_salesname">
					</div>
          <div class="form-group">
						<label for="dlg_search_paycode"><?php echo $this->getCatalog('paycode')?></label>
						<input type="text" class="form-control" name="dlg_search_paycode">
					</div>
          <div class="form-group">
						<label for="dlg_search_categoryname"><?php echo $this->getCatalog('categoryname')?></label>
						<input type="text" class="form-control" name="dlg_search_categoryname">
					</div>
          <div class="form-group">
						<label for="dlg_search_groupname"><?php echo $this->getCatalog('groupname')?></label>
						<input type="text" class="form-control" name="dlg_search_groupname">
					</div>
          <div class="form-group">
						<label for="dlg_search_custcategoryname"><?php echo $this->getCatalog('custcategoryname')?></label>
						<input type="text" class="form-control" name="dlg_search_custcategoryname">
					</div>
          <div class="form-group">
						<label for="dlg_search_custgradename"><?php echo $this->getCatalog('custgradename')?></label>
						<input type="text" class="form-control" name="dlg_search_custgradename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('custreq') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="custreq_0_custreqid">
						
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_reqdate"><?php echo $this->getCatalog('reqdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="custreq_0_reqdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_companyid','ColField'=>'custreq_0_companyname',
							'IDDialog'=>'custreq_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'custreq_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_custcode"><?php echo $this->getCatalog('custcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_custcode">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_fullname"><?php echo $this->getCatalog('customer')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_fullname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_address"><?php echo $this->getCatalog('address')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="custreq_0_address"></textarea>
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_cityid','ColField'=>'custreq_0_cityname',
							'IDDialog'=>'custreq_0_cityid_dialog','titledialog'=>$this->getCatalog('cityname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'custreq_0_cityidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_provinceid','ColField'=>'custreq_0_provincename',
							'IDDialog'=>'custreq_0_provinceid_dialog','titledialog'=>$this->getCatalog('provincename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.ProvincePopUp','PopGrid'=>'custreq_0_provinceidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_countryid','ColField'=>'custreq_0_countryname',
							'IDDialog'=>'custreq_0_countryid_dialog','titledialog'=>$this->getCatalog('countryname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CountryPopUp','PopGrid'=>'custreq_0_countryidgrid')); 
					?>
					
					        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_zipcode"><?php echo $this->getCatalog('zipcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_zipcode">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_phoneno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_mobileno"><?php echo $this->getCatalog('mobileno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_mobileno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_faxno"><?php echo $this->getCatalog('faxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_faxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_idno"><?php echo $this->getCatalog('ktpno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_idno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_contactperson"><?php echo $this->getCatalog('contactperson')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_contactperson">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_birthdate"><?php echo $this->getCatalog('birthdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="custreq_0_birthdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_owner"><?php echo $this->getCatalog('owner')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_owner">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_homeno"><?php echo $this->getCatalog('homeno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_homeno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_owneraddress"><?php echo $this->getCatalog('owneraddress')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="custreq_0_owneraddress"></textarea>
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_religionid','ColField'=>'custreq_0_religionname',
							'IDDialog'=>'custreq_0_religionid_dialog','titledialog'=>$this->getCatalog('religionname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.ReligionPopUp','PopGrid'=>'custreq_0_religionidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_buildingstatus"><?php echo $this->getCatalog('buildingstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_buildingstatus">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_empno"><?php echo $this->getCatalog('empno')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="custreq_0_empno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_pramuniaga"><?php echo $this->getCatalog('pramuniaga')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_pramuniaga">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_taxgroupid','ColField'=>'custreq_0_taxgroupname',
							'IDDialog'=>'custreq_0_taxgroupid_dialog','titledialog'=>$this->getCatalog('taxgroupname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.TaxgroupPopUp','PopGrid'=>'custreq_0_taxgroupidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_taxno"><?php echo $this->getCatalog('taxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_taxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_bankname"><?php echo $this->getCatalog('bankname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_bankname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_taxname"><?php echo $this->getCatalog('taxname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_taxname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_bankaddress"><?php echo $this->getCatalog('bankaddress')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="custreq_0_bankaddress"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_taxaddress"><?php echo $this->getCatalog('taxaddress')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="custreq_0_taxaddress"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_accountno"><?php echo $this->getCatalog('accountno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_accountno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_accountname"><?php echo $this->getCatalog('accountname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_accountname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_birthdatetoko"><?php echo $this->getCatalog('birthdatetoko')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="custreq_0_birthdatetoko">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_employeeid','ColField'=>'custreq_0_salesname',
							'IDDialog'=>'custreq_0_employeeid_dialog','titledialog'=>$this->getCatalog('salesname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.SalesPopUp','PopGrid'=>'custreq_0_employeeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_creditlimit"><?php echo $this->getCatalog('creditlimit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="custreq_0_creditlimit">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_paymentid','ColField'=>'custreq_0_paycode',
							'IDDialog'=>'custreq_0_paymentid_dialog','titledialog'=>$this->getCatalog('paycode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'custreq_0_paymentidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_pricecategoryid','ColField'=>'custreq_0_categoryname',
							'IDDialog'=>'custreq_0_pricecategoryid_dialog','titledialog'=>$this->getCatalog('categoryname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PricecategoryPopUp','PopGrid'=>'custreq_0_pricecategoryidgrid')); 
					?>
          
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_groupcustomerid','ColField'=>'custreq_0_groupname',
							'IDDialog'=>'custreq_0_groupcustomerid_dialog','titledialog'=>$this->getCatalog('groupname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.GroupcustomerPopUp','PopGrid'=>'custreq_0_groupcustomerid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_salesareaid','ColField'=>'custreq_0_areaname',
							'IDDialog'=>'custreq_0_salesareaid_dialog','titledialog'=>$this->getCatalog('areaname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesareaPopUp','PopGrid'=>'custreq_0_salesareaidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_lat"><?php echo $this->getCatalog('lat')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="custreq_0_lat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_lng"><?php echo $this->getCatalog('lng')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="custreq_0_lng">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_custcategoryid','ColField'=>'custreq_0_custcategoryname',
							'IDDialog'=>'custreq_0_custcategoryid_dialog','titledialog'=>$this->getCatalog('custcategoryname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustcategoryPopUp','PopGrid'=>'custreq_0_custcategoryidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'custreq_0_custgradeid','ColField'=>'custreq_0_custgradename',
							'IDDialog'=>'custreq_0_custgradeid_dialog','titledialog'=>$this->getCatalog('custgradename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustgradePopUp','PopGrid'=>'custreq_0_custgradeidgrid')); 
					?>
        <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_custphoto"><?php echo $this->getCatalog('custphoto')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_custphoto" readonly="readonly">
						</div>
        </div>
							
        <script>
				function successUp2(param,param2,param3)
				{
					$('input[name="custreq_0_custphoto"]').val(param2);
				}
        </script>
				
				<?php
					$events = array(
						'success' => 'successUp2(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('order/custreq/uploadcustphoto'),
						'mimeTypes' => array('.jpg','.png','.jpeg'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
          
          <div class="row">
						<div class="col-md-4">
							<label for="custreq_0_custktp"><?php echo $this->getCatalog('custktp')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="custreq_0_custktp" readonly="readonly">
						</div>
        </div>
							
        <script>
				function successUp1(param,param2,param3)
				{
					$('input[name="custreq_0_custktp"]').val(param2);
				}
        </script>
				
				<?php
					$events = array(
						'success' => 'successUp1(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('order/custreq/uploadcustktp'),
						'mimeTypes' => array('.jpg','.png','.jpeg'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
							<input type="hidden" class="form-control" name="custreq_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


