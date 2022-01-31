<script type="text/javascript">
function checkdetail()
{
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/checkdetail')?>','data':{'id':$("input[name='scale_0_scaleid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                toastr.success(data.div);
				$.fn.yiiGridView.update("scaledetList");
                $.fn.yiiGridView.update("scalecatList");
			}
			else
			{
				toastr.info(data.div);
                $.fn.yiiGridView.update("scaledetList");
                $.fn.yiiGridView.update("scalecatList");
			}
		},
		'cache':false});
	return false;
}
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='scale_0_scaleid']").val(data.scaleid);
      $("input[name='scale_0_startdate']").val('');
      $("input[name='scale_0_docdate']").val('');
      $("input[name='scale_0_recordstatus']").val(data.recordstatus);
      $("input[name='scale_0_spvscale']").val('');
			$.fn.yiiGridView.update('scaledetList',{data:{'scaleid':data.scaleid}});

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
function newdatascaledet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/createscaledet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='scaledet_1_scaledetid']").val('');
                $("input[name='scaledet_1_materialgroupid']").val('');
                $("input[name='scaledet_1_description']").val('');
                $("input[name='salesscaledet_1_value']").val('');
                $('#InputDialogscaledet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='scale_0_scaleid']").val(data.scaleid);
                $("input[name='scale_0_startdate']").val(data.startdate);
                $("input[name='scale_0_docdate']").val(data.docdate);
                $("input[name='scale_0_spvscale']").val(data.spvscale);
				$.fn.yiiGridView.update('scaledetList',{data:{'scaleid':data.scaleid}});
                $.fn.yiiGridView.update('scalecatList',{data:{'scaleid':data.scaleid}});

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
function updatedatascaledet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/updatescaledet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='scaledet_1_scaledetid']").val(data.scaledetid);
                $("input[name='scaledet_1_materialgroupid']").val(data.materialgroupid);
                $("input[name='scaledet_1_description']").val(data.description);
                $("input[name='salesscaledet_1_value']").val(data.value);
                $('#InputDialogscaledet').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatascalecat($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/updatescalecat')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='scalecat_2_scalecatid']").val(data.scalecatid);
                $("input[name='scalecat_2_custcategoryid']").val(data.custcategoryid);
                $("input[name='scalecat_2_custcategoryname']").val(data.custcategoryname);
                $("input[name='scalecat_2_value']").val(data.value);
                $('#InputDialogscalecat').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/save')?>',
		'data':{
			'scaleid':$("input[name='scale_0_scaleid']").val(),
            'startdate':$("input[name='scale_0_startdate']").val(),
            'docdate':$("input[name='scale_0_docdate']").val(),
            'spvscale':$("input[name='scale_0_spvscale']").val(),
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

function savedatascaledet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/savescaledet')?>',
		'data':{
			'scaleid':$("input[name='scale_0_scaleid']").val(),
			'scaledetid':$("input[name='scaledet_1_scaledetid']").val(),
            'materialgroupid':$("input[name='scaledet_1_materialgroupid']").val(),
            'value':$("input[name='salesscaledet_1_value']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogscaledet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("scaledetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
    
function savedatascalecat()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/savescalecat')?>',
		'data':{
            'scalecatid':$("input[name='scalecat_2_scalecatid']").val(),
            'scaleid':$("input[name='scale_0_scaleid']").val(),
            'custcategoryid':$("input[name='scalecat_2_custcategoryid']").val(),
            'value':$("input[name='scalecat_2_value']").val(),
        },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogscalecat').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("scalecatList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/purge')?>','data':{'id':$id},
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
function purgedatascaledet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/scale/purgescaledet')?>','data':{'id':$.fn.yiiGridView.getSelection("scaledetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("scaledetList");
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

function copyscale($id=0)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'scale/copyscale','data':{'id':$id},
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
    + '&startdate='+$("input[name='dlg_search_startdate']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'scale_0_scaleid='+$id;
	window.open('<?php echo Yii::app()->createUrl('order/scale/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'scale_0_scaleid='+$id;
	window.open('<?php echo Yii::app()->createUrl('order/scale/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'scaleid='+$id
$.fn.yiiGridView.update("DetailscaledetList",{data:array});
$.fn.yiiGridView.update("DetailscalecatList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('scale') ?></h3>
<?php if ($this->checkAccess('scale','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('scale','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('scale','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('scale','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('scale','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('scale','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
                    'copy' => array
					(
							'label'=>$this->getCatalog('copy'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/copy.png',
							'visible'=>$this->booltostr($this->checkAccess('scale','iswrite')),
							'url'=>'"#"',
							'click'=>"function() { 
								copyscale($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('scale','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('scale','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('scaleid'),
					'name'=>'scaleid',
					'value'=>'$data["scaleid"]'
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
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'Yii::app()->format->formatDate($data["startdate"])'
				),
                            array(
					'header'=>$this->getCatalog('spvscale'),
					'name'=>'spvscale',
					'value'=>'Yii::app()->format->formatNumber($data["spvscale"])'
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
						<label for="dlg_search_startdate"><?php echo $this->getCatalog('startdate')?></label>
						<input type="date" class="form-control" name="dlg_search_startdate">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('scale') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="scale_0_scaleid">
							
        <div class="row">
						<div class="col-md-4">
							<label for="scale_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="scale_0_docdate">
						</div>
					</div>
        
      <div class="row">
						<div class="col-md-4">
							<label for="scale_0_spvscale"><?php echo $this->getCatalog('spvscale')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="scale_0_spvscale">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="scale_0_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="scale_0_startdate">
						</div>
					</div>
					
				<input type="hidden" class="form-control" name="scale_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#scaledet" onclick="checkdetail()"><?php echo $this->getCatalog("generate")?></a></li>

				</ul>
				<div class="tab-content">
                <div id="scaledet" class="tab-pane">
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
							    'dataProvider'=>$dataProviderscalecat,
									'id'=>'scalecatList',
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
															updatedatascalecat($(this).parent().parent().children(':nth-child(3)').text());
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
											'header'=>$this->getCatalog('scalecatid'),
											'name'=>'scalecatid',
											'value'=>'$data["scalecatid"]'
										),
										array(
											'header'=>$this->getCatalog('custcategory'),
											'name'=>'custcategoryid',
											'value'=>'($data["custcategoryname"])'
										),
                                        array(
											'header'=>$this->getCatalog('value'),
											'name'=>'value',
											'value'=>'($data["value"])'
										),
									)
							));
							?>
                    </div>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo GetCatalog('scaledet')?></h3>
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
    'dataProvider'=>$dataProviderscaledet,
		'id'=>'scaledetList',
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
							'visible'=>$this->booltostr($this->checkAccess('scale','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatascaledet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'false',
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatascaledet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('scaledetid'),
					'name'=>'scaledetid',
					'value'=>'$data["scaledetid"]'
				),
							array(
					'header'=>$this->getCatalog('materialgroup'),
					'name'=>'materialgroupid',
					'value'=>'$data["description"]'
				),
                          array(
					'header'=>$this->getCatalog('percent'),
					'name'=>'value',
					'value'=>'Yii::app()->format->formatNumber($data["value"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('scaledet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderscaledet,
		'id'=>'DetailscaledetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
							array(
					'header'=>$this->getCatalog('materialgroup'),
					'name'=>'materialgroupid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('percent'),
					'name'=>'value',
					'value'=>'Yii::app()->format->formatNumber($data["value"])'
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
					    'dataProvider'=>$dataProviderscalecat,
							'id'=>'DetailscalecatList',
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
									'header'=>$this->getCatalog('value'),
									'name'=>'value',
									'value'=>'Yii::app()->format->formatNumber($data["value"])'
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
			
<div id="InputDialogscaledet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('scaledet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="scaledet_1_scaledetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'scaledet_1_materialgroupid','ColField'=>'scaledet_1_description',
							'IDDialog'=>'scaledet_1_materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupSalesPopUp','PopGrid'=>'scaledet_1_materialgroupidgrid')); 
					?>
              <div class="row">
						<div class="col-md-4">
							<label for="salesscaledet_1_value"><?php echo $this->getCatalog('percent')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesscaledet_1_value">
						</div>
					</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatascaledet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			
        <div id="InputDialogscalecat" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('scalecat') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="scalecat_2_scalecatid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'scalecat_2_custcategoryid','ColField'=>'scalecat_2_custcategoryname',
							'IDDialog'=>'scalecat_2_custcategoryid_dialog','titledialog'=>$this->getCatalog('custcategory'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustcategoryPopUp','PopGrid'=>'scalecat_2_custcategoryidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="scalecat_2_value"><?php echo $this->getCatalog('value')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="scalecat_2_value">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatascalecat()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>