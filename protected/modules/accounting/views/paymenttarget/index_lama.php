<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymenttarget_0_paymenttargetid']").val(data.paymenttargetid);
			$("input[name='paymenttarget_0_companyid']").val('');
      $("input[name='paymenttarget_0_employeeid']").val('');
      $("input[name='paymenttarget_0_docdate']").val(data.docdate);
      $("input[name='paymenttarget_0_perioddate']").val(data.perioddate);
      $("input[name='paymenttarget_0_companyname']").val('');
      $("input[name='paymenttarget_0_fullname']").val('');
			$.fn.yiiGridView.update('paymenttargetdetList',{data:{'paymenttargetid':data.paymenttargetid}});

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
function newdatapaymenttargetdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/createpaymenttargetdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymenttargetdet_1_paymenttargetdetid']").val('');
      $("input[name='paymenttargetdet_1_addressbookid']").val('');
      $("input[name='paymenttargetdet_1_gt30']").val(data.gt30);
      $("input[name='paymenttargetdet_1_gt15']").val(data.gt15);
      $("input[name='paymenttargetdet_1_gt7']").val(data.gt7);
      $("input[name='paymenttargetdet_1_gt0']").val(data.gt0);
      $("input[name='paymenttargetdet_1_x0']").val(data.x0);
      $("input[name='paymenttargetdet_1_lt0']").val(data.lt0);
      $("input[name='paymenttargetdet_1_lt14']").val(data.lt14);
      $("input[name='paymenttargetdet_1_customer']").val('');
			$('#InputDialogpaymenttargetdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='paymenttarget_0_paymenttargetid']").val(data.paymenttargetid);
				$("input[name='paymenttarget_0_companyid']").val(data.companyid);
      $("input[name='paymenttarget_0_employeeid']").val(data.employeeid);
      $("input[name='paymenttarget_0_docdate']").val(data.docdate);
      $("input[name='paymenttarget_0_perioddate']").val(data.perioddate);
      $("input[name='paymenttarget_0_companyname']").val(data.companyname);
      $("input[name='paymenttarget_0_fullname']").val(data.fullname);
				$.fn.yiiGridView.update('paymenttargetdetList',{data:{'paymenttargetid':data.paymenttargetid}});

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
function updatedatapaymenttargetdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/updatepaymenttargetdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymenttargetdet_1_paymenttargetdetid']").val(data.paymenttargetdetid);
      $("input[name='paymenttargetdet_1_addressbookid']").val(data.addressbookid);
      $("input[name='paymenttargetdet_1_gt30']").val(data.gt30);
      $("input[name='paymenttargetdet_1_gt15']").val(data.gt15);
      $("input[name='paymenttargetdet_1_gt7']").val(data.gt7);
      $("input[name='paymenttargetdet_1_gt0']").val(data.gt0);
      $("input[name='paymenttargetdet_1_x0']").val(data.x0);
      $("input[name='paymenttargetdet_1_lt0']").val(data.lt0);
      $("input[name='paymenttargetdet_1_lt14']").val(data.lt14);
      $("input[name='paymenttargetdet_1_customer']").val(data.customername);
			$('#InputDialogpaymenttargetdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/save')?>',
		'data':{
			'paymenttargetid':$("input[name='paymenttarget_0_paymenttargetid']").val(),
			'companyid':$("input[name='paymenttarget_0_companyid']").val(),
      'employeeid':$("input[name='paymenttarget_0_employeeid']").val(),
      'docdate':$("input[name='paymenttarget_0_docdate']").val(),
      'perioddate':$("input[name='paymenttarget_0_perioddate']").val(),
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

function savedatapaymenttargetdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/savepaymenttargetdet')?>',
		'data':{
			'paymenttargetid':$("input[name='paymenttarget_0_paymenttargetid']").val(),
			'paymenttargetdetid':$("input[name='paymenttargetdet_1_paymenttargetdetid']").val(),
      'addressbookid':$("input[name='paymenttargetdet_1_addressbookid']").val(),
      'gt30':$("input[name='paymenttargetdet_1_gt30']").val(),
      'gt15':$("input[name='paymenttargetdet_1_gt15']").val(),
      'gt7':$("input[name='paymenttargetdet_1_gt7']").val(),
      'gt0':$("input[name='paymenttargetdet_1_gt0']").val(),
      'x0':$("input[name='paymenttargetdet_1_x0']").val(),
      'lt0':$("input[name='paymenttargetdet_1_lt0']").val(),
      'lt14':$("input[name='paymenttargetdet_1_lt14']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogpaymenttargetdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("paymenttargetdetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/purge')?>','data':{'id':$id},
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
function purgedatapaymenttargetdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymenttarget/purgepaymenttargetdet')?>','data':{'id':$.fn.yiiGridView.getSelection("paymenttargetdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("paymenttargetdetList");
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
	var array = 'fullname='+$("input[name='dlg_search_fullname']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'paymenttarget_0_paymenttargetid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/paymenttarget/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'paymenttarget_0_paymenttargetid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/paymenttarget/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'paymenttargetid='+$id
$.fn.yiiGridView.update("DetailpaymenttargetdetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('paymenttarget') ?></h3>
<?php if ($this->checkAccess('paymenttarget','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymenttarget','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymenttarget','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymenttarget','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('paymenttarget','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('paymenttarget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('paymenttarget','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('paymenttarget','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('paymenttargetid'),
					'name'=>'paymenttargetid',
					'value'=>'$data["paymenttargetid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('perioddate'),
					'name'=>'perioddate',
					'value'=>'Yii::app()->format->formatDate($data["perioddate"])'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'recordstatus',
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
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('salesname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
                    <div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('company')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('paymenttarget') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="paymenttarget_0_paymenttargetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'paymenttarget_0_companyid','ColField'=>'paymenttarget_0_companyname',
							'IDDialog'=>'paymenttarget_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'paymenttarget_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'paymenttarget_0_employeeid','ColField'=>'paymenttarget_0_fullname',
							'IDDialog'=>'paymenttarget_0_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeecomsalesPopUp','PopGrid'=>'paymenttarget_0_employeeidgrid','RelationID'=>'paymenttarget_0_companyid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttarget_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="paymenttarget_0_docdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttarget_0_perioddate"><?php echo $this->getCatalog('perioddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="paymenttarget_0_perioddate">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#paymenttargetdet"><?php echo $this->getCatalog("paymenttargetdet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="paymenttargetdet" class="tab-pane">
	<?php if ($this->checkAccess('paymenttarget','iswrite')) { ?>
<button name="CreateButtonpaymenttargetdet" type="button" class="btn btn-primary" onclick="newdatapaymenttargetdet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymenttarget','iswrite')) { ?>
<button name="PurgeButtonpaymenttargetdet" type="button" class="btn btn-danger" onclick="purgedatapaymenttargetdet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpaymenttargetdet,
		'id'=>'paymenttargetdetList',
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
							'visible'=>$this->booltostr($this->checkAccess('paymenttarget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatapaymenttargetdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('paymenttarget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatapaymenttargetdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('paymenttargetdetid'),
					'name'=>'paymenttargetdetid',
					'value'=>'$data["paymenttargetdetid"]'
				),
							array(
					'header'=>$this->getCatalog('addressbook'),
					'name'=>'addressbookid',
					'value'=>'$data["customername"]'
				),
							array(
					'header'=>$this->getCatalog('gt30'),
					'name'=>'gt30',
					'value'=>'Yii::app()->format->formatNumber($data["gt30"])'
				),
							array(
					'header'=>$this->getCatalog('gt15'),
					'name'=>'gt15',
					'value'=>'Yii::app()->format->formatNumber($data["gt15"])'
				),
							array(
					'header'=>$this->getCatalog('gt7'),
					'name'=>'gt7',
					'value'=>'Yii::app()->format->formatNumber($data["gt7"])'
				),
							array(
					'header'=>$this->getCatalog('gt0'),
					'name'=>'gt0',
					'value'=>'Yii::app()->format->formatNumber($data["gt0"])'
				),
							array(
					'header'=>$this->getCatalog('x0'),
					'name'=>'x0',
					'value'=>'Yii::app()->format->formatNumber($data["x0"])'
				),
							array(
					'header'=>$this->getCatalog('lt0'),
					'name'=>'lt0',
					'value'=>'Yii::app()->format->formatNumber($data["lt0"])'
				),
							array(
					'header'=>$this->getCatalog('lt14'),
					'name'=>'lt14',
					'value'=>'Yii::app()->format->formatNumber($data["lt14"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('paymenttargetdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpaymenttargetdet,
		'id'=>'DetailpaymenttargetdetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('paymenttargetdetid'),
					'name'=>'paymenttargetdetid',
					'value'=>'$data["paymenttargetdetid"]'
				),
							array(
					'header'=>$this->getCatalog('customer'),
					'name'=>'addressbookid',
					'value'=>'$data["customername"]'
				),
							array(
					'header'=>$this->getCatalog('gt30'),
					'name'=>'gt30',
					'value'=>'Yii::app()->format->formatNumber($data["gt30"])'
				),
							array(
					'header'=>$this->getCatalog('gt15'),
					'name'=>'gt15',
					'value'=>'Yii::app()->format->formatNumber($data["gt15"])'
				),
							array(
					'header'=>$this->getCatalog('gt7'),
					'name'=>'gt7',
					'value'=>'Yii::app()->format->formatNumber($data["gt7"])'
				),
							array(
					'header'=>$this->getCatalog('gt0'),
					'name'=>'gt0',
					'value'=>'Yii::app()->format->formatNumber($data["gt0"])'
				),
							array(
					'header'=>$this->getCatalog('x0'),
					'name'=>'x0',
					'value'=>'Yii::app()->format->formatNumber($data["x0"])'
				),
							array(
					'header'=>$this->getCatalog('lt0'),
					'name'=>'lt0',
					'value'=>'Yii::app()->format->formatNumber($data["lt0"])'
				),
							array(
					'header'=>$this->getCatalog('lt14'),
					'name'=>'lt14',
					'value'=>'Yii::app()->format->formatNumber($data["lt14"])'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogpaymenttargetdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('paymenttargetdet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="paymenttargetdet_1_paymenttargetdetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'paymenttargetdet_1_addressbookid','ColField'=>'paymenttargetdet_1_customer',
							'IDDialog'=>'paymenttargetdet_1_addressbookid_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'paymenttargetdet_1_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_gt30"><?php echo $this->getCatalog('gt30')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_gt30">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_gt15"><?php echo $this->getCatalog('gt15')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_gt15">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_gt7"><?php echo $this->getCatalog('gt7')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_gt7">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_gt0"><?php echo $this->getCatalog('gt0')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_gt0">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_x0"><?php echo $this->getCatalog('x0')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_x0">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_lt0"><?php echo $this->getCatalog('lt0')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_lt0">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymenttargetdet_1_lt14"><?php echo $this->getCatalog('lt14')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymenttargetdet_1_lt14">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatapaymenttargetdet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			