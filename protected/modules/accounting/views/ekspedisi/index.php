<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='ekspedisi_0_ekspedisiid']").val(data.ekspedisiid);
			$("input[name='ekspedisi_0_companyid']").val('');
      $("input[name='ekspedisi_0_docdate']").val(data.docdate);
      $("input[name='ekspedisi_0_addressbookid']").val('');
      $("input[name='ekspedisi_0_amount']").val(data.amount);
      $("input[name='ekspedisi_0_currencyid']").val(data.currencyid);
      $("input[name='ekspedisi_0_currencyrate']").val(data.currencyrate);
      $("input[name='ekspedisi_0_companyname']").val('');
      $("input[name='ekspedisi_0_fullname']").val('');
      $("input[name='ekspedisi_0_currencyname']").val(data.currencyname);
			$.fn.yiiGridView.update('ekspedisipoList',{data:{'ekspedisiid':data.ekspedisiid}});
$.fn.yiiGridView.update('eksmatList',{data:{'ekspedisiid':data.ekspedisiid}});

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
function newdataekspedisipo()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/createekspedisipo')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='ekspedisipo_1_poheaderid']").val('');
      $("input[name='ekspedisipo_1_pono']").val('');
			$('#InputDialogekspedisipo').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataeksmat()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/createeksmat')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='eksmat_2_productid']").val('');
      $("input[name='eksmat_2_qty']").val(data.qty);
      $("input[name='eksmat_2_uomid']").val('');
      $("input[name='eksmat_2_expense']").val(data.expense);
      $("input[name='eksmat_2_currencyid']").val(data.currencyid);
      $("input[name='eksmat_2_currencyrate']").val(data.currencyrate);
      $("input[name='eksmat_2_productname']").val('');
      $("input[name='eksmat_2_uomcode']").val('');
      $("input[name='eksmat_2_currencyname']").val(data.currencyname);
			$('#InputDialogeksmat').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='ekspedisi_0_ekspedisiid']").val(data.ekspedisiid);
				$("input[name='ekspedisi_0_companyid']").val(data.companyid);
      $("input[name='ekspedisi_0_docdate']").val(data.docdate);
      $("input[name='ekspedisi_0_addressbookid']").val(data.addressbookid);
      $("input[name='ekspedisi_0_amount']").val(data.amount);
      $("input[name='ekspedisi_0_currencyid']").val(data.currencyid);
      $("input[name='ekspedisi_0_currencyrate']").val(data.currencyrate);
      $("input[name='ekspedisi_0_companyname']").val(data.companyname);
      $("input[name='ekspedisi_0_fullname']").val(data.fullname);
      $("input[name='ekspedisi_0_currencyname']").val(data.currencyname);
				$.fn.yiiGridView.update('ekspedisipoList',{data:{'ekspedisiid':data.ekspedisiid}});
$.fn.yiiGridView.update('eksmatList',{data:{'ekspedisiid':data.ekspedisiid}});

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
function updatedataekspedisipo($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/updateekspedisipo')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='ekspedisipo_1_poheaderid']").val(data.poheaderid);
      $("input[name='ekspedisipo_1_pono']").val(data.pono);
			$('#InputDialogekspedisipo').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataeksmat($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/updateeksmat')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='eksmat_2_productid']").val(data.productid);
      $("input[name='eksmat_2_qty']").val(data.qty);
      $("input[name='eksmat_2_uomid']").val(data.uomid);
      $("input[name='eksmat_2_expense']").val(data.expense);
      $("input[name='eksmat_2_currencyid']").val(data.currencyid);
      $("input[name='eksmat_2_currencyrate']").val(data.currencyrate);
      $("input[name='eksmat_2_productname']").val(data.productname);
      $("input[name='eksmat_2_uomcode']").val(data.uomcode);
      $("input[name='eksmat_2_currencyname']").val(data.currencyname);
			$('#InputDialogeksmat').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/save')?>',
		'data':{
			'ekspedisiid':$("input[name='ekspedisi_0_ekspedisiid']").val(),
			'companyid':$("input[name='ekspedisi_0_companyid']").val(),
      'docdate':$("input[name='ekspedisi_0_docdate']").val(),
      'addressbookid':$("input[name='ekspedisi_0_addressbookid']").val(),
      'amount':$("input[name='ekspedisi_0_amount']").val(),
      'currencyid':$("input[name='ekspedisi_0_currencyid']").val(),
      'currencyrate':$("input[name='ekspedisi_0_currencyrate']").val(),
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

function savedataekspedisipo()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/saveekspedisipo')?>',
		'data':{
			'ekspedisiid':$("input[name='ekspedisi_0_ekspedisiid']").val(),
			'poheaderid':$("input[name='ekspedisipo_1_poheaderid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogekspedisipo').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("ekspedisipoList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedataeksmat()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/saveeksmat')?>',
		'data':{
			'ekspedisiid':$("input[name='ekspedisi_0_ekspedisiid']").val(),
			'productid':$("input[name='eksmat_2_productid']").val(),
      'qty':$("input[name='eksmat_2_qty']").val(),
      'uomid':$("input[name='eksmat_2_uomid']").val(),
      'expense':$("input[name='eksmat_2_expense']").val(),
      'currencyid':$("input[name='eksmat_2_currencyid']").val(),
      'currencyrate':$("input[name='eksmat_2_currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogeksmat').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("eksmatList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/approve')?>',
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
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/purge')?>','data':{'id':$id},
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
function purgedataekspedisipo()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/purgeekspedisipo')?>','data':{'id':$.fn.yiiGridView.getSelection("ekspedisipoList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("ekspedisipoList");
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
function purgedataeksmat()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/ekspedisi/purgeeksmat')?>','data':{'id':$.fn.yiiGridView.getSelection("eksmatList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("eksmatList");
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
	var array = 'ekspedisiid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&ekspedisino='+$("input[name='dlg_search_ekspedisino']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'ekspedisiid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&ekspedisino='+$("input[name='dlg_search_ekspedisino']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/ekspedisi/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'ekspedisiid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&ekspedisino='+$("input[name='dlg_search_ekspedisino']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/ekspedisi/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'ekspedisiid='+$id
$.fn.yiiGridView.update("DetailekspedisipoList",{data:array});
$.fn.yiiGridView.update("DetaileksmatList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('ekspedisi') ?></h3>
<?php if ($this->checkAccess('ekspedisi','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('ekspedisi','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('ekspedisi','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('ekspedisi','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('ekspedisi','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('ekspedisiid'),
					'name'=>'ekspedisiid',
					'value'=>'$data["ekspedisiid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('ekspedisino'),
					'name'=>'ekspedisino',
					'value'=>'$data["ekspedisino"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
				),
							array(
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
						<label for="dlg_search_ekspedisino"><?php echo $this->getCatalog('ekspedisino')?></label>
						<input type="text" class="form-control" name="dlg_search_ekspedisino">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('ekspedisi') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="ekspedisi_0_ekspedisiid">
        <div class="row">
						<div class="col-md-4">
							<label for="ekspedisi_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="ekspedisi_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'ekspedisi_0_addressbookid','ColField'=>'ekspedisi_0_fullname',
							'IDDialog'=>'ekspedisi_0_addressbookid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddressbookPopUp','PopGrid'=>'ekspedisi_0_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="ekspedisi_0_amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="ekspedisi_0_amount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'ekspedisi_0_currencyid','ColField'=>'ekspedisi_0_currencyname',
							'IDDialog'=>'ekspedisi_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'ekspedisi_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="ekspedisi_0_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="ekspedisi_0_currencyrate">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#ekspedisipo"><?php echo $this->getCatalog("ekspedisipo")?></a></li>
<li><a data-toggle="tab" href="#eksmat"><?php echo $this->getCatalog("eksmat")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="ekspedisipo" class="tab-pane">
	<?php if ($this->checkAccess('ekspedisi','iswrite')) { ?>
<button name="CreateButtonekspedisipo" type="button" class="btn btn-primary" onclick="newdataekspedisipo()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('ekspedisi','ispurge')) { ?>
<button name="PurgeButtonekspedisipo" type="button" class="btn btn-danger" onclick="purgedataekspedisipo()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderekspedisipo,
		'id'=>'ekspedisipoList',
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
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataekspedisipo($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataekspedisipo($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('ekspedisipoid'),
					'name'=>'ekspedisipoid',
					'value'=>'$data["ekspedisipoid"]'
				),
							array(
					'header'=>$this->getCatalog('poheader'),
					'name'=>'poheaderid',
					'value'=>'$data["pono"]'
				),
							
		)
));
?>
  </div>
<div id="eksmat" class="tab-pane">
	<?php if ($this->checkAccess('ekspedisi','iswrite')) { ?>
<button name="CreateButtoneksmat" type="button" class="btn btn-primary" onclick="newdataeksmat()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('ekspedisi','ispurge')) { ?>
<button name="PurgeButtoneksmat" type="button" class="btn btn-danger" onclick="purgedataeksmat()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidereksmat,
		'id'=>'eksmatList',
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
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataeksmat($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('ekspedisi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataeksmat($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('eksmatid'),
					'name'=>'eksmatid',
					'value'=>'$data["eksmatid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('expense'),
					'name'=>'expense',
					'value'=>'Yii::app()->format->formatNumber($data["expense"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('ekspedisipo')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderekspedisipo,
		'id'=>'DetailekspedisipoList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('ekspedisipoid'),
					'name'=>'ekspedisipoid',
					'value'=>'$data["ekspedisipoid"]'
				),
							array(
					'header'=>$this->getCatalog('poheader'),
					'name'=>'poheaderid',
					'value'=>'$data["pono"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('eksmat')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidereksmat,
		'id'=>'DetaileksmatList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('eksmatid'),
					'name'=>'eksmatid',
					'value'=>'$data["eksmatid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('expense'),
					'name'=>'expense',
					'value'=>'Yii::app()->format->formatNumber($data["expense"])'
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
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogekspedisipo" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('ekspedisipo') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="ekspedisipo_1_poheaderid">
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataekspedisipo()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogeksmat" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('eksmat') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="eksmat_2_productid">
        <div class="row">
						<div class="col-md-4">
							<label for="eksmat_2_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="eksmat_2_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'eksmat_2_uomid','ColField'=>'eksmat_2_uomcode',
							'IDDialog'=>'eksmat_2_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'eksmat_2_uomidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="eksmat_2_expense"><?php echo $this->getCatalog('expense')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="eksmat_2_expense">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'eksmat_2_currencyid','ColField'=>'eksmat_2_currencyname',
							'IDDialog'=>'eksmat_2_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.GroupaccessPopUp','PopGrid'=>'eksmat_2_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="eksmat_2_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="eksmat_2_currencyrate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataeksmat()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			