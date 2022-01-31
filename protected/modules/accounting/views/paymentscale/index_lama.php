<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymentscale_0_paymentscaleid']").val(data.paymentscaleid);
			$("input[name='paymentscale_0_companyid']").val('');
      $("input[name='paymentscale_0_docdate']").val(data.docdate);
      $("input[name='paymentscale_0_perioddate']").val(data.perioddate);
      $("input[name='paymentscale_0_paramspv']").val(data.paramspv);
      $("input[name='paymentscale_0_companyname']").val('');
			$.fn.yiiGridView.update('paymentscaledetList',{data:{'paymentscaleid':data.paymentscaleid}});

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
function newdatapaymentscaledet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/createpaymentscaledet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymentscaledet_1_paymentscaledetid']").val('');
      $("input[name='paymentscaledet_1_min']").val('');
      $("input[name='paymentscaledet_1_max']").val('');
      $("input[name='paymentscaledet_1_gt30']").val(data.gt30);
      $("input[name='paymentscaledet_1_gt15']").val(data.gt15);
      $("input[name='paymentscaledet_1_gt7']").val(data.gt7);
      $("input[name='paymentscaledet_1_gt0']").val(data.gt0);
      $("input[name='paymentscaledet_1_x0']").val(data.x0);
      $("input[name='paymentscaledet_1_lt0']").val(data.lt0);
      $("input[name='paymentscaledet_1_lt14']").val(data.lt14);
			$('#InputDialogpaymentscaledet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='paymentscale_0_paymentscaleid']").val(data.paymentscaleid);
				$("input[name='paymentscale_0_companyid']").val(data.companyid);
      $("input[name='paymentscale_0_docdate']").val(data.docdate);
      $("input[name='paymentscale_0_perioddate']").val(data.perioddate);
      $("input[name='paymentscale_0_paramspv']").val(data.paramspv);
      $("input[name='paymentscale_0_minscale']").val(data.minscale);
      $("input[name='paymentscale_0_companyname']").val(data.companyname);
				$.fn.yiiGridView.update('paymentscaledetList',{data:{'paymentscaleid':data.paymentscaleid}});

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
function updatedatapaymentscaledet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/updatepaymentscaledet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='paymentscaledet_1_paymentscaledetid']").val(data.paymentscaledetid);
      $("input[name='paymentscaledet_1_min']").val(data.min);
      $("input[name='paymentscaledet_1_max']").val(data.max);
      $("input[name='paymentscaledet_1_gt30']").val(data.gt30);
      $("input[name='paymentscaledet_1_gt15']").val(data.gt15);
      $("input[name='paymentscaledet_1_gt7']").val(data.gt7);
      $("input[name='paymentscaledet_1_gt0']").val(data.gt0);
      $("input[name='paymentscaledet_1_x0']").val(data.x0);
      $("input[name='paymentscaledet_1_lt0']").val(data.lt0);
      $("input[name='paymentscaledet_1_lt14']").val(data.lt14);
			$('#InputDialogpaymentscaledet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/save')?>',
		'data':{
			'paymentscaleid':$("input[name='paymentscale_0_paymentscaleid']").val(),
			'companyid':$("input[name='paymentscale_0_companyid']").val(),
      'docdate':$("input[name='paymentscale_0_docdate']").val(),
      'perioddate':$("input[name='paymentscale_0_perioddate']").val(),
      'paramspv':$("input[name='paymentscale_0_paramspv']").val(),
      'minscale':$("input[name='paymentscale_0_minscale']").val(),
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

function savedatapaymentscaledet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/savepaymentscaledet')?>',
		'data':{
			'paymentscaleid':$("input[name='paymentscale_0_paymentscaleid']").val(),
			'paymentscaledetid':$("input[name='paymentscaledet_1_paymentscaledetid']").val(),
      'min':$("input[name='paymentscaledet_1_min']").val(),
      'max':$("input[name='paymentscaledet_1_max']").val(),
      'gt30':$("input[name='paymentscaledet_1_gt30']").val(),
      'gt15':$("input[name='paymentscaledet_1_gt15']").val(),
      'gt7':$("input[name='paymentscaledet_1_gt7']").val(),
      'gt0':$("input[name='paymentscaledet_1_gt0']").val(),
      'x0':$("input[name='paymentscaledet_1_x0']").val(),
      'lt0':$("input[name='paymentscaledet_1_lt0']").val(),
      'lt14':$("input[name='paymentscaledet_1_lt14']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogpaymentscaledet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("paymentscaledetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/purge')?>','data':{'id':$id},
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
function purgedatapaymentscaledet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/paymentscale/purgepaymentscaledet')?>','data':{'id':$.fn.yiiGridView.getSelection("paymentscaledetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("paymentscaledetList");
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

function copypaymentscale($id=0)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'paymentscale/copypaymentscale','data':{'id':$id},
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
	var array = 'companyname='+$("input[name='dlg_search_companyname']").val()
    + '&perioddate='+$("input[name='dlg_search_perioddate']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'paymentscale_0_paymentscaleid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/paymentscale/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'paymentscale_0_paymentscaleid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/paymentscale/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'paymentscaleid='+$id
$.fn.yiiGridView.update("DetailpaymentscaledetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('paymentscale') ?></h3>
<?php if ($this->checkAccess('paymentscale','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymentscale','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymentscale','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymentscale','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('paymentscale','isdownload')) { ?>
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
				'template'=>'{select} {edit} {copy} {purge} {pdf}',
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
							'visible'=>$this->booltostr($this->checkAccess('paymentscale','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
                    'copy' => array
					(
							'label'=>$this->getCatalog('copy'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/copy.png',
							'visible'=>$this->booltostr($this->checkAccess('salesscale','iswrite')),
							'url'=>'"#"',
							'click'=>"function() { 
								copypaymentscale($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('paymentscale','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('paymentscale','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('paymentscaleid'),
					'name'=>'paymentscaleid',
					'value'=>'$data["paymentscaleid"]'
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
					'header'=>$this->getCatalog('perioddate'),
					'name'=>'perioddate',
					'value'=>'Yii::app()->format->formatDate($data["perioddate"])'
				),
                            array(
					'header'=>$this->getCatalog('paramspv'),
					'name'=>'paramspv',
					'value'=>'Yii::app()->format->formatNumber($data["paramspv"])'
				),
                            array(
					'header'=>$this->getCatalog('minscale'),
					'name'=>'minscale',
					'value'=>'Yii::app()->format->formatNumber($data["minscale"])'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('company')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
                    <div class="form-group">
						<label for="dlg_search_perioddate"><?php echo $this->getCatalog('perioddate')?></label>
						<input type="date" class="form-control" name="dlg_search_perioddate">

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
        <h4 class="modal-title"><?php echo $this->getCatalog('paymentscale') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="paymentscale_0_paymentscaleid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'paymentscale_0_companyid','ColField'=>'paymentscale_0_companyname',
							'IDDialog'=>'paymentscale_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'paymentscale_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscale_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="paymentscale_0_docdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscale_0_perioddate"><?php echo $this->getCatalog('perioddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="paymentscale_0_perioddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscale_0_paramspv"><?php echo $this->getCatalog('paramspv')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscale_0_paramspv">
						</div>
					</div>
          
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscale_0_minscale"><?php echo $this->getCatalog('minscale')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscale_0_minscale">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#paymentscaledet"><?php echo $this->getCatalog("paymentscaledet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="paymentscaledet" class="tab-pane">
	<?php if ($this->checkAccess('paymentscale','iswrite')) { ?>
<button name="CreateButtonpaymentscaledet" type="button" class="btn btn-primary" onclick="newdatapaymentscaledet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('paymentscale','iswrite')) { ?>
<button name="PurgeButtonpaymentscaledet" type="button" class="btn btn-danger" onclick="purgedatapaymentscaledet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpaymentscaledet,
		'id'=>'paymentscaledetList',
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
							'visible'=>$this->booltostr($this->checkAccess('paymentscale','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatapaymentscaledet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('paymentscale','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatapaymentscaledet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('paymentscaledetid'),
					'name'=>'paymentscaledetid',
					'value'=>'$data["paymentscaledetid"]'
				),
							array(
					'header'=>$this->getCatalog('range'),
					'name'=>'min',
					'value'=>'$data["range"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('paymentscaledet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpaymentscaledet,
		'id'=>'DetailpaymentscaledetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('paymentscaledetid'),
					'name'=>'paymentscaledetid',
					'value'=>'$data["paymentscaledetid"]'
				),
							array(
					'header'=>$this->getCatalog('range'),
					'name'=>'min',
					'value'=>'$data["range"]'
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
			
<div id="InputDialogpaymentscaledet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('paymentscaledet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="paymentscaledet_1_paymentscaledetid">
        <div class="row">
            <div class="col-md-4">
                    <label for="paymentscaledet_1_gt30"><?php echo $this->getCatalog('range')?></label>
            </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon3"> >= </span>
              <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon3" name="paymentscaledet_1_min">
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-addon" id="basic_addon4"> < </span>
              <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon4" name="paymentscaledet_1_max">
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_gt30"><?php echo $this->getCatalog('gt30')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_gt30">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_gt15"><?php echo $this->getCatalog('gt15')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_gt15">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_gt7"><?php echo $this->getCatalog('gt7')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_gt7">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_gt0"><?php echo $this->getCatalog('gt0')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_gt0">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_x0"><?php echo $this->getCatalog('x0')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_x0">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_lt0"><?php echo $this->getCatalog('lt0')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_lt0">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="paymentscaledet_1_lt14"><?php echo $this->getCatalog('lt14')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="paymentscaledet_1_lt14">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatapaymentscaledet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			