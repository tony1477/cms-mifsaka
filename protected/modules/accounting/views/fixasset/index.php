<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/fixasset/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='fixasset_0_fixassetid']").val(data.fixassetid);
			$("input[name='fixasset_0_companyid']").val('');
      $("input[name='fixasset_0_assetno']").val('');
      $("input[name='fixasset_0_slocaccid']").val('');
      $("input[name='fixasset_0_buydate']").val(data.buydate);
      $("input[name='fixasset_0_productid']").val('');
      $("input[name='fixasset_0_qty']").val(data.qty);
      $("input[name='fixasset_0_uomid']").val('');
      $("input[name='fixasset_0_price']").val(data.price);
      $("input[name='fixasset_0_nilairesidu']").val(data.nilairesidu);
      $("input[name='fixasset_0_metode']").prop('checked',true);
      $("input[name='fixasset_0_currencyid']").val(data.currencyid);
      $("input[name='fixasset_0_currencyrate']").val(data.currencyrate);
      $("input[name='fixasset_0_umur']").val(data.umur);
      $("input[name='fixasset_0_recordstatus']").prop('checked',true);
      $("input[name='fixasset_0_companyname']").val('');
      $("input[name='fixasset_0_sloccode']").val('');
      $("input[name='fixasset_0_productname']").val('');
      $("input[name='fixasset_0_uomcode']").val('');
      $("input[name='fixasset_0_currencyname']").val(data.currencyname);
			
			$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/fixasset/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='fixasset_0_fixassetid']").val(data.fixassetid);
				$("input[name='fixasset_0_companyid']").val(data.companyid);
      $("input[name='fixasset_0_assetno']").val(data.assetno);
      $("input[name='fixasset_0_slocaccid']").val(data.slocaccid);
      $("input[name='fixasset_0_buydate']").val(data.buydate);
      $("input[name='fixasset_0_productid']").val(data.productid);
      $("input[name='fixasset_0_qty']").val(data.qty);
      $("input[name='fixasset_0_uomid']").val(data.uomid);
      $("input[name='fixasset_0_price']").val(data.price);
      $("input[name='fixasset_0_nilairesidu']").val(data.nilairesidu);
      if (data.metode == 1)
			{
				$("input[name='fixasset_0_metode']").prop('checked',true);
			}
			else
			{
				$("input[name='fixasset_0_metode']").prop('checked',false)
			}
      $("input[name='fixasset_0_currencyid']").val(data.currencyid);
      $("input[name='fixasset_0_currencyrate']").val(data.currencyrate);
      $("input[name='fixasset_0_umur']").val(data.umur);
      if (data.recordstatus == 1)
			{
				$("input[name='fixasset_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='fixasset_0_recordstatus']").prop('checked',false)
			}
      $("input[name='fixasset_0_companyname']").val(data.companyname);
      $("input[name='fixasset_0_sloccode']").val(data.sloccode);
      $("input[name='fixasset_0_productname']").val(data.productname);
      $("input[name='fixasset_0_uomcode']").val(data.uomcode);
      $("input[name='fixasset_0_currencyname']").val(data.currencyname);
				
				$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function savedata()
{
var recordstatus = 0;
	if ($("input[name='fixasset_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/fixasset/save')?>',
		'data':{
			'fixassetid':$("input[name='fixasset_0_fixassetid']").val(),
			'companyid':$("input[name='fixasset_0_companyid']").val(),
      'assetno':$("input[name='fixasset_0_assetno']").val(),
      'slocaccid':$("input[name='fixasset_0_slocaccid']").val(),
      'buydate':$("input[name='fixasset_0_buydate']").val(),
      'productid':$("input[name='fixasset_0_productid']").val(),
      'qty':$("input[name='fixasset_0_qty']").val(),
      'uomid':$("input[name='fixasset_0_uomid']").val(),
      'price':$("input[name='fixasset_0_price']").val(),
      'nilairesidu':$("input[name='fixasset_0_nilairesidu']").val(),
      'metode':$("input[name='fixasset_0_metode']").val(),
      'currencyid':$("input[name='fixasset_0_currencyid']").val(),
      'currencyrate':$("input[name='fixasset_0_currencyrate']").val(),
      'umur':$("input[name='fixasset_0_umur']").val(),
      'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}


function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/fixasset/delete')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});});
	return false;
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/fixasset/purge')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	});
	return false;
}

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'fixasset_0_fixassetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&assetno='+$("input[name='dlg_search_assetno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'fixasset_0_fixassetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&assetno='+$("input[name='dlg_search_assetno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/fixasset/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'fixasset_0_fixassetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&assetno='+$("input[name='dlg_search_assetno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/fixasset/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'fixassetid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('fixasset') ?></h3>
<?php if ($this->checkAccess('fixasset','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('fixasset','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('fixasset','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('fixasset','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('fixasset','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('fixasset','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('fixasset','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('fixasset','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('fixasset','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('fixassetid'),
					'name'=>'fixassetid',
					'value'=>'$data["fixassetid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('assetno'),
					'name'=>'assetno',
					'value'=>'$data["assetno"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocaccid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('buydate'),
					'name'=>'buydate',
					'value'=>'Yii::app()->format->formatDate($data["buydate"])'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatNumber($data["price"])'
				),
							array(
					'header'=>$this->getCatalog('nilairesidu'),
					'name'=>'nilairesidu',
					'value'=>'Yii::app()->format->formatNumber($data["nilairesidu"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'metode',
					'header'=>$this->getCatalog('metode'),
					'selectableRows'=>'0',
					'checked'=>'$data["metode"]',
				),array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatNumber($data["currencyrate"])'
				),
							array(
					'header'=>$this->getCatalog('umur'),
					'name'=>'umur',
					'value'=>'Yii::app()->format->formatNumber($data["umur"])'
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
						<label for="dlg_search_assetno"><?php echo $this->getCatalog('assetno')?></label>
						<input type="text" class="form-control" name="dlg_search_assetno">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('fixasset') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="fixasset_0_fixassetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'fixasset_0_companyid','ColField'=>'fixasset_0_companyname',
							'IDDialog'=>'fixasset_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'fixasset_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_assetno"><?php echo $this->getCatalog('assetno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="fixasset_0_assetno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'fixasset_0_slocaccid','ColField'=>'fixasset_0_sloccode',
							'IDDialog'=>'fixasset_0_slocaccid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocaccPopUp','PopGrid'=>'fixasset_0_slocaccidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_buydate"><?php echo $this->getCatalog('buydate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="fixasset_0_buydate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'fixasset_0_productid','ColField'=>'fixasset_0_productname',
							'IDDialog'=>'fixasset_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'fixasset_0_productidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="fixasset_0_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'fixasset_0_uomid','ColField'=>'fixasset_0_uomcode',
							'IDDialog'=>'fixasset_0_uomid_dialog','titledialog'=>$this->getCatalog('uomcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'fixasset_0_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'fixasset_0_uomidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_price"><?php echo $this->getCatalog('price')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="fixasset_0_price">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_nilairesidu"><?php echo $this->getCatalog('nilairesidu')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="fixasset_0_nilairesidu">
						</div>
					</div>
					
					<div class="row">
					<div class="col-md-4">
					<label for="fixasset_0_metode">Select list:</label>
					</div>
					<div class="col-md-8">
					<select class="form-control" id="fixasset_0_metode">
						<option value="1">Metode Garis Lurus</option>
					</select>
					</div>
				</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_metode"><?php echo $this->getCatalog('metode')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="fixasset_0_metode">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'fixasset_0_currencyid','ColField'=>'fixasset_0_currencyname',
							'IDDialog'=>'fixasset_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'fixasset_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="fixasset_0_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_umur"><?php echo $this->getCatalog('umur')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="fixasset_0_umur">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="fixasset_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="fixasset_0_recordstatus">
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


