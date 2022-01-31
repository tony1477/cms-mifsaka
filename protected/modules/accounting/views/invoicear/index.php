<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoicear/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoice_0_invoiceid']").val(data.invoiceid);
			$("input[name='invoice_0_invoicedate']").val(data.invoicedate);
      $("input[name='invoice_0_invoiceno']").val('');
      $("input[name='invoice_0_giheaderid']").val('');
      $("input[name='invoice_0_amount']").val(data.amount);
      $("input[name='invoice_0_currencyid']").val(data.currencyid);
      $("input[name='invoice_0_currencyrate']").val(data.currencyrate);
      $("input[name='invoice_0_payamount']").val(data.payamount);
      $("textarea[name='invoice_0_headernote']").val('');
      $("input[name='invoice_0_recordstatus']").val(data.recordstatus);
      $("input[name='invoice_0_gino']").val('');
      $("input[name='invoice_0_currencyname']").val(data.currencyname);
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoicear/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='invoice_0_invoiceid']").val(data.invoiceid);
				$("input[name='invoice_0_invoicedate']").val(data.invoicedate);
      $("input[name='invoice_0_invoiceno']").val(data.invoiceno);
      $("input[name='invoice_0_giheaderid']").val(data.giheaderid);
      $("input[name='invoice_0_amount']").val(data.amount);
      $("input[name='invoice_0_currencyid']").val(data.currencyid);
      $("input[name='invoice_0_currencyrate']").val(data.currencyrate);
      $("input[name='invoice_0_payamount']").val(data.payamount);
      $("textarea[name='invoice_0_headernote']").val(data.headernote);
      $("input[name='invoice_0_recordstatus']").val(data.recordstatus);
      $("input[name='invoice_0_gino']").val(data.gino);
      $("input[name='invoice_0_currencyname']").val(data.currencyname);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoicear/save')?>',
		'data':{
			'invoiceid':$("input[name='invoice_0_invoiceid']").val(),
			'invoicedate':$("input[name='invoice_0_invoicedate']").val(),
      'invoiceno':$("input[name='invoice_0_invoiceno']").val(),
      'giheaderid':$("input[name='invoice_0_giheaderid']").val(),
      'amount':$("input[name='invoice_0_amount']").val(),
      'currencyid':$("input[name='invoice_0_currencyid']").val(),
      'currencyrate':$("input[name='invoice_0_currencyrate']").val(),
      'payamount':$("input[name='invoice_0_payamount']").val(),
      'headernote':$("textarea[name='invoice_0_headernote']").val(),
      'recordstatus':$("input[name='invoice_0_recordstatus']").val(),
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

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoicear/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoicear/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoicear/purge')?>','data':{'id':$id},
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
	var array = 'invoiceid='+$id
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'invoiceid='+$id
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/invoicear/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'invoiceid='+$id
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/invoicear/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'invoiceid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('invoicear') ?></h3>
<?php if ($this->checkAccess('invoicear','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoicear','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoicear','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoicear','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('invoicear','isdownload')) { ?>
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
				'template'=>'{edit} {delete} {purge} {pdf}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('invoicear','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('invoicear','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('invoicear','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('invoicear','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('invoiceid'),
					'name'=>'invoiceid',
					'value'=>'$data["invoiceid"]'
				),
							array(
					'header'=>$this->getCatalog('invoicedate'),
					'name'=>'invoicedate',
					'value'=>'Yii::app()->format->formatDate($data["invoicedate"])'
				),
							array(
					'header'=>$this->getCatalog('invoiceno'),
					'name'=>'invoiceno',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('gino'),
					'name'=>'giheaderid',
					'value'=>'$data["gino"]'
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
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
				),
							array(
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
						<label for="dlg_search_invoiceno"><?php echo $this->getCatalog('invoiceno')?></label>
						<input type="text" class="form-control" name="dlg_search_invoiceno">
					</div>
          <div class="form-group">
						<label for="dlg_search_gino"><?php echo $this->getCatalog('gino')?></label>
						<input type="text" class="form-control" name="dlg_search_gino">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('invoicear') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="invoice_0_invoiceid">
        <div class="row">
						<div class="col-md-4">
							<label for="invoice_0_invoicedate"><?php echo $this->getCatalog('invoicedate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="invoice_0_invoicedate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoice_0_invoiceno"><?php echo $this->getCatalog('invoiceno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="invoice_0_invoiceno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoice_0_giheaderid','ColField'=>'invoice_0_gino',
							'IDDialog'=>'invoice_0_giheaderid_dialog','titledialog'=>$this->getCatalog('gino'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GiheaderPopUp','PopGrid'=>'invoice_0_giheaderidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoice_0_amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoice_0_amount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoice_0_currencyid','ColField'=>'invoice_0_currencyname',
							'IDDialog'=>'invoice_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'invoice_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoice_0_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoice_0_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoice_0_payamount"><?php echo $this->getCatalog('payamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoice_0_payamount">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoice_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="invoice_0_headernote"></textarea>
						</div>
					</div>
							<input type="hidden" class="form-control" name="invoice_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


