<script type="text/javascript">
function checkdetail()
{
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/checkdetail')?>','data':{'id':$("input[name='salesscale_0_salesscaleid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                toastr.success(data.div);
				$.fn.yiiGridView.update("salesscaledetList");
                $.fn.yiiGridView.update("salesscalecatList");
			}
			else
			{
				toastr.info(data.div);
                $.fn.yiiGridView.update("salesscaledetList");
                $.fn.yiiGridView.update("salesscalecatList");
			}
		},
		'cache':false});
	return false;
}
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesscale_0_salesscaleid']").val(data.salesscaleid);
			$("input[name='salesscale_0_companyid']").val('');
      $("input[name='salesscale_0_perioddate']").val(data.perioddate);
      $("input[name='salesscale_0_docdate']").val(data.docdate);
      $("input[name='salesscale_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesscale_0_paramspv']").val('');
      $("input[name='salesscale_0_minscale']").val('');
      $("input[name='salesscale_0_spvscale']").val('');
      $("input[name='salesscale_0_spvscale']").val('');
      $("input[name='salesscale_0_companyname']").val('');
			$.fn.yiiGridView.update('salesscaledetList',{data:{'salesscaleid':data.salesscaleid}});

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
function newdatasalesscaledet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/createsalesscaledet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesscaledet_1_salesscaledetid']").val('');
      $("input[name='salesscaledet_1_materialgroupid']").val('');
      $("input[name='salesscaledet_1_gt120']").val(data.gt120);
      $("input[name='salesscaledet_1_gt100']").val(data.gt100);
      $("input[name='salesscaledet_1_gt90']").val(data.gt90);
      $("input[name='salesscaledet_1_gt80']").val(data.gt80);
      $("input[name='salesscaledet_1_gt70']").val(data.gt70);
      $("input[name='salesscaledet_1_description']").val('');
			$('#InputDialogsalesscaledet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='salesscale_0_salesscaleid']").val(data.salesscaleid);
				$("input[name='salesscale_0_companyid']").val(data.companyid);
                $("input[name='salesscale_0_perioddate']").val(data.perioddate);
                $("input[name='salesscale_0_docdate']").val(data.docdate);
                $("input[name='salesscale_0_paramspv']").val(data.paramspv);
                $("input[name='salesscale_0_minscale']").val(data.minscale);
                $("input[name='salesscale_0_spvscale']").val(data.spvscale);
                $("input[name='salesscale_0_companyname']").val(data.companyname);
				$.fn.yiiGridView.update('salesscaledetList',{data:{'salesscaleid':data.salesscaleid}});
                $.fn.yiiGridView.update('salesscalecatList',{data:{'salesscaleid':data.salesscaleid}});

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
function updatedatasalesscaledet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/updatesalesscaledet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesscaledet_1_salesscaledetid']").val(data.salesscaledetid);
      $("input[name='salesscaledet_1_materialgroupid']").val(data.materialgroupid);
      $("input[name='salesscaledet_1_gt120']").val(data.gt120);
      $("input[name='salesscaledet_1_gt100']").val(data.gt100);
      $("input[name='salesscaledet_1_gt90']").val(data.gt90);
      $("input[name='salesscaledet_1_gt80']").val(data.gt80);
      $("input[name='salesscaledet_1_gt70']").val(data.gt70);
      $("input[name='salesscaledet_1_description']").val(data.description);
			$('#InputDialogsalesscaledet').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatasalesscalecat($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/updatesalesscalecat')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='salesscalecat_2_salesscalecatid']").val(data.salesscalecatid);
                $("input[name='salesscalecat_2_custcategoryid']").val(data.custcategoryid);
                $("input[name='salesscalecat_2_custcategoryname']").val(data.custcategoryname);
                $("input[name='salesscalecat_2_paramvalue']").val(data.paramvalue);
                $('#InputDialogsalesscalecat').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/save')?>',
		'data':{
			'salesscaleid':$("input[name='salesscale_0_salesscaleid']").val(),
			'companyid':$("input[name='salesscale_0_companyid']").val(),
            'perioddate':$("input[name='salesscale_0_perioddate']").val(),
            'docdate':$("input[name='salesscale_0_docdate']").val(),
            'paramspv':$("input[name='salesscale_0_paramspv']").val(),
            'minscale':$("input[name='salesscale_0_minscale']").val(),
            'spvscale':$("input[name='salesscale_0_spvscale']").val(),
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

function savedatasalesscaledet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/savesalesscaledet')?>',
		'data':{
			'salesscaleid':$("input[name='salesscale_0_salesscaleid']").val(),
			'salesscaledetid':$("input[name='salesscaledet_1_salesscaledetid']").val(),
      'materialgroupid':$("input[name='salesscaledet_1_materialgroupid']").val(),
      'gt120':$("input[name='salesscaledet_1_gt120']").val(),
      'gt100':$("input[name='salesscaledet_1_gt100']").val(),
      'gt90':$("input[name='salesscaledet_1_gt90']").val(),
      'gt80':$("input[name='salesscaledet_1_gt80']").val(),
      'gt70':$("input[name='salesscaledet_1_gt70']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogsalesscaledet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("salesscaledetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
    
function savedatasalesscalecat()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/savesalesscalecat')?>',
		'data':{
            'salesscalecatid':$("input[name='salesscalecat_2_salesscalecatid']").val(),
            'salesscaleid':$("input[name='salesscale_0_salesscaleid']").val(),
            'custcategoryid':$("input[name='salesscalecat_2_custcategoryid']").val(),
            'paramvalue':$("input[name='salesscalecat_2_paramvalue']").val(),
        },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogsalesscalecat').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("salesscalecatList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/purge')?>','data':{'id':$id},
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
function purgedatasalesscaledet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesscale/purgesalesscaledet')?>','data':{'id':$.fn.yiiGridView.getSelection("salesscaledetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("salesscaledetList");
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

function copysalesscale($id=0)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'salesscale/copysalesscale','data':{'id':$id},
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
	var array = 'salesscale_0_salesscaleid='+$id;
	window.open('<?php echo Yii::app()->createUrl('order/salesscale/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'salesscale_0_salesscaleid='+$id;
	window.open('<?php echo Yii::app()->createUrl('order/salesscale/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salesscaleid='+$id
$.fn.yiiGridView.update("DetailsalesscaledetList",{data:array});
$.fn.yiiGridView.update("DetailsalesscalecatList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('salesscale') ?></h3>
<?php if ($this->checkAccess('salesscale','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesscale','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesscale','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesscale','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('salesscale','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('salesscale','iswrite')),							
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
								copysalesscale($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('salesscale','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('salesscale','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('salesscaleid'),
					'name'=>'salesscaleid',
					'value'=>'$data["salesscaleid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
                            array(
					'header'=>$this->getCatalog('docno'),
					'name'=>'docno',
					'value'=>'$data["docno"]'
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
					'header'=>$this->getCatalog('spvscale'),
					'name'=>'spvscale',
					'value'=>'Yii::app()->format->formatNumber($data["spvscale"])'
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
        <h4 class="modal-title"><?php echo $this->getCatalog('salesscale') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="salesscale_0_salesscaleid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesscale_0_companyid','ColField'=>'salesscale_0_companyname',
							'IDDialog'=>'salesscale_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'salesscale_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscale_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salesscale_0_docdate">
						</div>
					</div>
        
      <div class="row">
						<div class="col-md-4">
							<label for="salesscale_0_paramspv"><?php echo $this->getCatalog('paramspv')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscale_0_paramspv">
						</div>
					</div>
        
      <div class="row">
						<div class="col-md-4">
							<label for="salesscale_0_minscale"><?php echo $this->getCatalog('minscale')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscale_0_minscale">
						</div>
					</div>
          
      <div class="row">
						<div class="col-md-4">
							<label for="salesscale_0_spvscale"><?php echo $this->getCatalog('spvscale')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscale_0_spvscale">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscale_0_perioddate"><?php echo $this->getCatalog('perioddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salesscale_0_perioddate">
						</div>
					</div>
					
				<input type="hidden" class="form-control" name="salesscale_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#salesscaledet" onclick="checkdetail()"><?php echo $this->getCatalog("generate")?></a></li>

				</ul>
				<div class="tab-content">
                <div id="salesscaledet" class="tab-pane">
                    <div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo getCatalog("categoryscale")?></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body">
							<!--
                            <button name="CreateButton" type="button" class="btn btn-primary" onclick="newdatasodetail()"><?php echo $this->getCatalog('new')?></button>
							<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedatasodetail($.fn.yiiGridView.getSelection('SodetailList'))"><?php echo $this->getCatalog('purge')?></button>
						    -->
                            <?php
								$this->widget('zii.widgets.grid.CGridView', array(
							    'dataProvider'=>$dataProvidersalesscalecat,
									'id'=>'salesscalecatList',
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
											'htmlOptions' => array('style'=>'width:80px'),
											'buttons'=>array
											(
												'edit' => array
												(
														'label'=>$this->getCatalog('edit'),
														'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
														'visible'=>'true',							
														'url'=>'"#"',
														'click'=>"function() { 
															updatedatasalesscalecat($(this).parent().parent().children(':nth-child(3)').text());
														}",
												),
												'purge' => array
												(
														'label'=>$this->getCatalog('purge'),
														'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
														'visible'=>'false',							
														'url'=>'"#"',
														'click'=>"function() { 
															purgedatasodetail($(this).parent().parent().children(':nth-child(3)').text());
														}",
												),
											),
										),
										array(
											'header'=>$this->getCatalog('salesscalecatid'),
											'name'=>'salesscalecatid',
											'value'=>'$data["salesscalecatid"]'
										),
										array(
											'header'=>$this->getCatalog('custcategory'),
											'name'=>'custcategoryid',
											'value'=>'($data["custcategoryname"])'
										),
                                        array(
											'header'=>$this->getCatalog('paramvalue'),
											'name'=>'paramvalue',
											'value'=>'($data["paramvalue"])'
										),
									)
							));
							?>
                    </div>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo GetCatalog('salesscaledet')?></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body">
                            <!--
							<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdatasodisc()"><?php echo $this->getCatalog('new')?></button>
							<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedatasodisc($.fn.yiiGridView.getSelection('SodiscList'))"><?php echo $this->getCatalog('purge')?></button>
                            -->
							<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidersalesscaledet,
		'id'=>'salesscaledetList',
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
							'visible'=>$this->booltostr($this->checkAccess('salesscale','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatasalesscaledet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'false',
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatasalesscaledet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('salesscaledetid'),
					'name'=>'salesscaledetid',
					'value'=>'$data["salesscaledetid"]'
				),
							array(
					'header'=>$this->getCatalog('materialgroup'),
					'name'=>'materialgroupid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('gt120'),
					'name'=>'gt120',
					'value'=>'Yii::app()->format->formatNumber($data["gt120"])'
				),
							array(
					'header'=>$this->getCatalog('gt100'),
					'name'=>'gt100',
					'value'=>'Yii::app()->format->formatNumber($data["gt100"])'
				),
							array(
					'header'=>$this->getCatalog('gt90'),
					'name'=>'gt90',
					'value'=>'Yii::app()->format->formatNumber($data["gt90"])'
				),
							array(
					'header'=>$this->getCatalog('gt80'),
					'name'=>'gt80',
					'value'=>'Yii::app()->format->formatNumber($data["gt80"])'
				),
							array(
					'header'=>$this->getCatalog('gt70'),
					'name'=>'gt70',
					'value'=>'Yii::app()->format->formatNumber($data["gt70"])'
				),
							
		)
));
?>
						</div>
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
		<h3 class="box-title"><?php echo $this->getCatalog('salesscaledet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidersalesscaledet,
		'id'=>'DetailsalesscaledetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('salesscaledetid'),
					'name'=>'salesscaledetid',
					'value'=>'$data["salesscaledetid"]'
				),
							array(
					'header'=>$this->getCatalog('materialgroup'),
					'name'=>'materialgroupid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('gt120'),
					'name'=>'gt120',
					'value'=>'Yii::app()->format->formatNumber($data["gt120"])'
				),
							array(
					'header'=>$this->getCatalog('gt100'),
					'name'=>'gt100',
					'value'=>'Yii::app()->format->formatNumber($data["gt100"])'
				),
							array(
					'header'=>$this->getCatalog('gt90'),
					'name'=>'gt90',
					'value'=>'Yii::app()->format->formatNumber($data["gt90"])'
				),
							array(
					'header'=>$this->getCatalog('gt80'),
					'name'=>'gt80',
					'value'=>'Yii::app()->format->formatNumber($data["gt80"])'
				),
							array(
					'header'=>$this->getCatalog('gt70'),
					'name'=>'gt70',
					'value'=>'Yii::app()->format->formatNumber($data["gt70"])'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo getCatalog('custcategory')?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php
						$this->widget('zii.widgets.grid.CGridView', array(
					    'dataProvider'=>$dataProvidersalesscalecat,
							'id'=>'DetailsalesscalecatList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('custcategory'),
									'name'=>'custcategoryid',
									'value'=>'$data["custcategoryname"]'
								),
                                array(
									'header'=>$this->getCatalog('paramvalue'),
									'name'=>'paramvalue',
									'value'=>'Yii::app()->format->formatNumber($data["paramvalue"])'
								),
							)
					));
					?>
				</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogsalesscaledet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('salesscaledet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="salesscaledet_1_salesscaledetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesscaledet_1_materialgroupid','ColField'=>'salesscaledet_1_description',
							'IDDialog'=>'salesscaledet_1_materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupSalesPopUp','PopGrid'=>'salesscaledet_1_materialgroupidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscaledet_1_gt120"><?php echo $this->getCatalog('gt120')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscaledet_1_gt120">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscaledet_1_gt100"><?php echo $this->getCatalog('gt100')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscaledet_1_gt100">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscaledet_1_gt90"><?php echo $this->getCatalog('gt90')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscaledet_1_gt90">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscaledet_1_gt80"><?php echo $this->getCatalog('gt80')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscaledet_1_gt80">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscaledet_1_gt70"><?php echo $this->getCatalog('gt70')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscaledet_1_gt70">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasalesscaledet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			
        <div id="InputDialogsalesscalecat" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('salesscalecat') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="salesscalecat_2_salesscalecatid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesscalecat_2_custcategoryid','ColField'=>'salesscalecat_2_custcategoryname',
							'IDDialog'=>'salesscalecat_2_custcategoryid_dialog','titledialog'=>$this->getCatalog('custcategory'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustcategoryPopUp','PopGrid'=>'salesscalecat_2_custcategoryidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesscalecat_2_paramvalue"><?php echo $this->getCatalog('paramvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscalecat_2_paramvalue">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasalesscalecat()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>