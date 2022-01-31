<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbin_0_cbinid']").val(data.cbinid);
			$("input[name='cbin_0_docdate']").val(data.docdate);
      $("input[name='cbin_0_companyid']").val('');
      $("input[name='cbin_0_ttntid']").val('');
      $("textarea[name='cbin_0_headernote']").val('');
      $("input[name='cbin_0_companyname']").val('');
      $("input[name='cbin_0_docno']").val('');
			$.fn.yiiGridView.update('cbinjournalList',{data:{'cbinid':data.cbinid}});

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
function newdatacbinjournal()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/createcbinjournal')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbinjournal_1_accountid']").val('');
      $("input[name='cbinjournal_1_debit']").val(data.debit);
      $("input[name='cbinjournal_1_currencyid']").val(data.currencyid);
      $("input[name='cbinjournal_1_currencyrate']").val(data.currencyrate);
      $("input[name='cbinjournal_1_chequeid']").val('');
      $("input[name='cbinjournal_1_tglcair']").val(data.tglcair);
      $("input[name='cbinjournal_1_description']").val('');
      $("input[name='cbinjournal_1_accountname']").val('');
      $("input[name='cbinjournal_1_currencyname']").val('');
      $("input[name='cbinjournal_1_chequeno']").val('');
			$('#InputDialogcbinjournal').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cbin_0_cbinid']").val(data.cbinid);
				$("input[name='cbin_0_docdate']").val(data.docdate);
      $("input[name='cbin_0_companyid']").val(data.companyid);
      $("input[name='cbin_0_ttntid']").val(data.ttntid);
      $("textarea[name='cbin_0_headernote']").val(data.headernote);
      $("input[name='cbin_0_companyname']").val(data.companyname);
      $("input[name='cbin_0_docno']").val(data.docno);
				$.fn.yiiGridView.update('cbinjournalList',{data:{'cbinid':data.cbinid}});

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
function updatedatacbinjournal($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/updatecbinjournal')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbinjournal_1_accountid']").val(data.accountid);
      $("input[name='cbinjournal_1_debit']").val(data.debit);
      $("input[name='cbinjournal_1_currencyid']").val(data.currencyid);
      $("input[name='cbinjournal_1_currencyrate']").val(data.currencyrate);
      $("input[name='cbinjournal_1_chequeid']").val(data.chequeid);
      $("input[name='cbinjournal_1_tglcair']").val(data.tglcair);
      $("input[name='cbinjournal_1_description']").val(data.description);
      $("input[name='cbinjournal_1_accountname']").val(data.accountname);
      $("input[name='cbinjournal_1_currencyname']").val(data.currencyname);
      $("input[name='cbinjournal_1_chequeno']").val(data.chequeno);
			$('#InputDialogcbinjournal').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/save')?>',
		'data':{
			'cbinid':$("input[name='cbin_0_cbinid']").val(),
			'docdate':$("input[name='cbin_0_docdate']").val(),
      'companyid':$("input[name='cbin_0_companyid']").val(),
      'ttntid':$("input[name='cbin_0_ttntid']").val(),
      'headernote':$("textarea[name='cbin_0_headernote']").val(),
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

function savedatacbinjournal()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/savecbinjournal')?>',
		'data':{
			'cbinid':$("input[name='cbin_0_cbinid']").val(),
			'accountid':$("input[name='cbinjournal_1_accountid']").val(),
      'debit':$("input[name='cbinjournal_1_debit']").val(),
      'currencyid':$("input[name='cbinjournal_1_currencyid']").val(),
      'currencyrate':$("input[name='cbinjournal_1_currencyrate']").val(),
      'chequeid':$("input[name='cbinjournal_1_chequeid']").val(),
      'tglcair':$("input[name='cbinjournal_1_tglcair']").val(),
      'description':$("input[name='cbinjournal_1_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcbinjournal').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cbinjournalList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/purge')?>','data':{'id':$id},
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
function purgedatacbinjournal()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cbin/purgecbinjournal')?>','data':{'id':$.fn.yiiGridView.getSelection("cbinjournalList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cbinjournalList");
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
	var array = 'cbinid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'cbinid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/cbin/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'cbinid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/cbin/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cbinid='+$id
$.fn.yiiGridView.update("DetailcbinjournalList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('cbin') ?></h3>
<?php if ($this->checkAccess('cbin','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cbin','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('cbin','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('cbin','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('cbin','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('cbin','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cbin','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('cbin','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('cbinid'),
					'name'=>'cbinid',
					'value'=>'$data["cbinid"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('cbinno'),
					'name'=>'cbinno',
					'value'=>'$data["cbinno"]'
				),
							array(
					'header'=>$this->getCatalog('docno'),
					'name'=>'ttntid',
					'value'=>'$data["docno"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_cbinno"><?php echo $this->getCatalog('cbinno')?></label>
						<input type="text" class="form-control" name="dlg_search_cbinno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('cbin') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="cbin_0_cbinid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbin_0_companyid','ColField'=>'cbin_0_companyname',
							'IDDialog'=>'cbin_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'cbin_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbin_0_ttntid','ColField'=>'cbin_0_docno',
							'IDDialog'=>'cbin_0_ttntid_dialog','titledialog'=>$this->getCatalog('docno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.TtntPopUp','PopGrid'=>'cbin_0_ttntidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbin_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="cbin_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#cbinjournal"><?php echo $this->getCatalog("cbinjournal")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="cbinjournal" class="tab-pane">
	<?php if ($this->checkAccess('cbin','iswrite')) { ?>
<button name="CreateButtoncbinjournal" type="button" class="btn btn-primary" onclick="newdatacbinjournal()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cbin','ispurge')) { ?>
<button name="PurgeButtoncbinjournal" type="button" class="btn btn-danger" onclick="purgedatacbinjournal()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbinjournal,
		'id'=>'cbinjournalList',
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
							'visible'=>$this->booltostr($this->checkAccess('cbin','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacbinjournal($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cbin','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacbinjournal($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('cbinjournalid'),
					'name'=>'cbinjournalid',
					'value'=>'$data["cbinjournalid"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('debit'),
					'name'=>'debit',
					'value'=>'Yii::app()->format->formatNumber($data["debit"])'
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
					'header'=>$this->getCatalog('cheque'),
					'name'=>'chequeid',
					'value'=>'$data["chequeno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('cbinjournal')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercbinjournal,
		'id'=>'DetailcbinjournalList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('cbinjournalid'),
					'name'=>'cbinjournalid',
					'value'=>'$data["cbinjournalid"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('debit'),
					'name'=>'debit',
					'value'=>'Yii::app()->format->formatNumber($data["debit"])'
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
					'header'=>$this->getCatalog('cheque'),
					'name'=>'chequeid',
					'value'=>'$data["chequeno"]'
				),
							array(
					'header'=>$this->getCatalog('tglcair'),
					'name'=>'tglcair',
					'value'=>'Yii::app()->format->formatDate($data["tglcair"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogcbinjournal" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cbinjournal') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="cbinjournal_1_accountid">
        <div class="row">
						<div class="col-md-4">
							<label for="cbinjournal_1_debit"><?php echo $this->getCatalog('debit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbinjournal_1_debit">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbinjournal_1_currencyid','ColField'=>'cbinjournal_1_currencyname',
							'IDDialog'=>'cbinjournal_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'cbinjournal_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbinjournal_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cbinjournal_1_currencyrate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cbinjournal_1_chequeid','ColField'=>'cbinjournal_1_chequeno',
							'IDDialog'=>'cbinjournal_1_chequeid_dialog','titledialog'=>$this->getCatalog('cheque'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ChequePopUp','PopGrid'=>'cbinjournal_1_chequeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbinjournal_1_tglcair"><?php echo $this->getCatalog('tglcair')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="cbinjournal_1_tglcair">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cbinjournal_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cbinjournal_1_description">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacbinjournal()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			