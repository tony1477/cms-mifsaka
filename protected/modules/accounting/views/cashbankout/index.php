<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankout_0_cashbankoutid']").val(data.cashbankoutid);
			$("input[name='cashbankout_0_companyid']").val('');
      $("input[name='cashbankout_0_docdate']").val(data.docdate);
      $("input[name='cashbankout_0_cashbankoutno']").val('');
      $("input[name='cashbankout_0_reqpayid']").val('');
      $("input[name='cashbankout_0_companyname']").val('');
      $("input[name='cashbankout_0_reqpayno']").val('');
			$.fn.yiiGridView.update('cbapinvList',{data:{'cashbankoutid':data.cashbankoutid}});

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
function newdatacbapinv()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/createcbapinv')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbapinv_1_accountid']").val('');
      $("input[name='cbapinv_1_cashbankno']").val('');
      $("input[name='cbapinv_1_tglcair']").val(data.tglcair);
      $("input[name='cbapinv_1_payamount']").val(data.payamount);
      $("input[name='cbapinv_1_currencyid']").val(data.currencyid);
      $("input[name='cbapinv_1_currencyrate']").val(data.currencyrate);
      $("input[name='cbapinv_1_bankaccountno']").val('');
      $("input[name='cbapinv_1_bankname']").val('');
      $("input[name='cbapinv_1_bankowner']").val('');
      $("textarea[name='cbapinv_1_itemnote']").val('');
      $("input[name='cbapinv_1_invoiceno']").val('');
      $("input[name='cbapinv_1_ekspedisino']").val('');
      $("input[name='cbapinv_1_accountname']").val('');
      $("input[name='cbapinv_1_currencyname']").val(data.currencyname);
			$('#InputDialogcbapinv').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cashbankout_0_cashbankoutid']").val(data.cashbankoutid);
				$("input[name='cashbankout_0_companyid']").val(data.companyid);
      $("input[name='cashbankout_0_docdate']").val(data.docdate);
      $("input[name='cashbankout_0_cashbankoutno']").val(data.cashbankoutno);
      $("input[name='cashbankout_0_reqpayid']").val(data.reqpayid);
      $("input[name='cashbankout_0_companyname']").val(data.companyname);
      $("input[name='cashbankout_0_reqpayno']").val(data.reqpayno);
				$.fn.yiiGridView.update('cbapinvList',{data:{'cashbankoutid':data.cashbankoutid}});

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
function updatedatacbapinv($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/updatecbapinv')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbapinv_1_accountid']").val(data.accountid);
      $("input[name='cbapinv_1_cashbankno']").val(data.cashbankno);
      $("input[name='cbapinv_1_tglcair']").val(data.tglcair);
      $("input[name='cbapinv_1_payamount']").val(data.payamount);
      $("input[name='cbapinv_1_currencyid']").val(data.currencyid);
      $("input[name='cbapinv_1_currencyrate']").val(data.currencyrate);
      $("input[name='cbapinv_1_bankaccountno']").val(data.bankaccountno);
      $("input[name='cbapinv_1_bankname']").val(data.bankname);
      $("input[name='cbapinv_1_bankowner']").val(data.bankowner);
      $("textarea[name='cbapinv_1_itemnote']").val(data.itemnote);
      $("input[name='cbapinv_1_invoiceno']").val(data.invoiceno);
      $("input[name='cbapinv_1_ekspedisino']").val(data.ekspedisino);
      $("input[name='cbapinv_1_accountname']").val(data.accountname);
      $("input[name='cbapinv_1_currencyname']").val(data.currencyname);
			$('#InputDialogcbapinv').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/save')?>',
		'data':{
			'cashbankoutid':$("input[name='cashbankout_0_cashbankoutid']").val(),
			'companyid':$("input[name='cashbankout_0_companyid']").val(),
      'docdate':$("input[name='cashbankout_0_docdate']").val(),
      'cashbankoutno':$("input[name='cashbankout_0_cashbankoutno']").val(),
      'reqpayid':$("input[name='cashbankout_0_reqpayid']").val(),
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

function savedatacbapinv()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/savecbapinv')?>',
		'data':{
			'cashbankoutid':$("input[name='cashbankout_0_cashbankoutid']").val(),
			'accountid':$("input[name='cbapinv_1_accountid']").val(),
      'cashbankno':$("input[name='cbapinv_1_cashbankno']").val(),
      'tglcair':$("input[name='cbapinv_1_tglcair']").val(),
      'payamount':$("input[name='cbapinv_1_payamount']").val(),
      'currencyid':$("input[name='cbapinv_1_currencyid']").val(),
      'currencyrate':$("input[name='cbapinv_1_currencyrate']").val(),
      'bankaccountno':$("input[name='cbapinv_1_bankaccountno']").val(),
      'bankname':$("input[name='cbapinv_1_bankname']").val(),
      'bankowner':$("input[name='cbapinv_1_bankowner']").val(),
      'itemnote':$("textarea[name='cbapinv_1_itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcbapinv').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cbapinvList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/purge')?>','data':{'id':$id},
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
function purgedatacbapinv()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cashbankout/purgecbapinv')?>','data':{'id':$.fn.yiiGridView.getSelection("cbapinvList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cbapinvList");
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
	var array = 'cashbankoutid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankoutno='+$("input[name='dlg_search_cashbankoutno']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'cashbankoutid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankoutno='+$("input[name='dlg_search_cashbankoutno']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/cashbankout/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'cashbankoutid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankoutno='+$("input[name='dlg_search_cashbankoutno']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/cashbankout/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cashbankoutid='+$id
$.fn.yiiGridView.update("DetailcbapinvList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('cashbankout') ?></h3>
<?php if ($this->checkAccess('cashbankout','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cashbankout','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('cashbankout','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('cashbankout','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('cashbankout','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('cashbankoutid'),
					'name'=>'cashbankoutid',
					'value'=>'$data["cashbankoutid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('cashbankoutno'),
					'name'=>'cashbankoutno',
					'value'=>'$data["cashbankoutno"]'
				),
							array(
					'header'=>$this->getCatalog('reqpayno'),
					'name'=>'reqpayid',
					'value'=>'$data["reqpayno"]'
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
						<label for="dlg_search_cashbankoutno"><?php echo $this->getCatalog('cashbankoutno')?></label>
						<input type="text" class="form-control" name="dlg_search_cashbankoutno">
					</div>
          <div class="form-group">
						<label for="dlg_search_reqpayno"><?php echo $this->getCatalog('reqpayno')?></label>
						<input type="text" class="form-control" name="dlg_search_reqpayno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('cashbankout') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="cashbankout_0_cashbankoutid">
        <div class="row">
						<div class="col-md-4">
							<label for="cashbankout_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cashbankout_0_docdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cashbankout_0_cashbankoutno"><?php echo $this->getCatalog('cashbankoutno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cashbankout_0_cashbankoutno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cashbankout_0_reqpayid','ColField'=>'cashbankout_0_reqpayno',
							'IDDialog'=>'cashbankout_0_reqpayid_dialog','titledialog'=>$this->getCatalog('reqpayno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.ReqpaycomPopUp','PopGrid'=>'cashbankout_0_reqpayidgrid')); 
					?>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#cbapinv"><?php echo $this->getCatalog("cbapinv")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="cbapinv" class="tab-pane">
	<?php if ($this->checkAccess('cashbankout','iswrite')) { ?>
<button name="CreateButtoncbapinv" type="button" class="btn btn-primary" onclick="newdatacbapinv()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cashbankout','ispurge')) { ?>
<button name="PurgeButtoncbapinv" type="button" class="btn btn-danger" onclick="purgedatacbapinv()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbapinv,
		'id'=>'cbapinvList',
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
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacbapinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cashbankout','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacbapinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('cbapinvid'),
					'name'=>'cbapinvid',
					'value'=>'$data["cbapinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('ekspedisi'),
					'name'=>'ekspedisiid',
					'value'=>'$data["ekspedisino"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('cashbankno'),
					'name'=>'cashbankno',
					'value'=>'$data["cashbankno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
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
					'header'=>$this->getCatalog('bankowner'),
					'name'=>'bankowner',
					'value'=>'$data["bankowner"]'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('cbapinv')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbapinv,
		'id'=>'DetailcbapinvList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('cbapinvid'),
					'name'=>'cbapinvid',
					'value'=>'$data["cbapinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('ekspedisi'),
					'name'=>'ekspedisiid',
					'value'=>'$data["ekspedisino"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('cashbankno'),
					'name'=>'cashbankno',
					'value'=>'$data["cashbankno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
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
					'header'=>$this->getCatalog('bankowner'),
					'name'=>'bankowner',
					'value'=>'$data["bankowner"]'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogcbapinv" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cbapinv') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="cbapinv_1_accountid">
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_cashbankno"><?php echo $this->getCatalog('cashbankno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_cashbankno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_tglcair"><?php echo $this->getCatalog('tglcair')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cbapinv_1_tglcair">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_payamount"><?php echo $this->getCatalog('payamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbapinv_1_payamount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbapinv_1_currencyid','ColField'=>'cbapinv_1_currencyname',
							'IDDialog'=>'cbapinv_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'cbapinv_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbapinv_1_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_bankaccountno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_bankname"><?php echo $this->getCatalog('bankname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_bankname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_bankowner"><?php echo $this->getCatalog('bankowner')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbapinv_1_bankowner">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbapinv_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="cbapinv_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacbapinv()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			