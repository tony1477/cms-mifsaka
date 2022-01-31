<script type="text/javascript">

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'prheaderid='+$id
+ '&prno='+$("input[name='dlg_search_prno']").val()
+ '&deliveryadviceid='+$("input[name='dlg_search_deliveryadviceid']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'prheaderid='+$id
+ '&prno='+$("input[name='dlg_search_prno']").val()
+ '&deliveryadviceid='+$("input[name='dlg_search_deliveryadviceid']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/reportpr/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'prheaderid='+$id
+ '&prno='+$("input[name='dlg_search_prno']").val()
+ '&deliveryadviceid='+$("input[name='dlg_search_deliveryadviceid']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/reportpr/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'prheaderid='+$id
$.fn.yiiGridView.update("DetailprmaterialList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('reportpr') ?></h3>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('prheader','isdownload')) { ?>
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
				'template'=>'{select} {pdf}',
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
					
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('prheader','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('prheaderid'),
					'name'=>'prheaderid',
					'value'=>'$data["prheaderid"]'
				),
							array(
					'header'=>$this->getCatalog('prdate'),
					'name'=>'prdate',
					'value'=>'Yii::app()->format->formatDate($data["prdate"])'
				),
							array(
					'header'=>$this->getCatalog('prno'),
					'name'=>'prno',
					'value'=>'$data["prno"]'
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
						<label for="dlg_search_prno"><?php echo $this->getCatalog('prno')?></label>
						<input type="text" class="form-control" name="dlg_search_prno">
					</div>
          <div class="form-group">
						<label for="dlg_search_deliveryadviceid"><?php echo $this->getCatalog('deliveryadviceid')?></label>
						<input type="text" class="form-control" name="dlg_search_deliveryadviceid">
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
						<label for="dlg_search_requestedbycode"><?php echo $this->getCatalog('requestedbycode')?></label>
						<input type="text" class="form-control" name="dlg_search_requestedbycode">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('prheader') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="prheaderid">
        <div class="row">
						<div class="col-md-4">
							<label for="prdate"><?php echo $this->getCatalog('prdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="prdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#prmaterial"><?php echo $this->getCatalog("prmaterial")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="prmaterial" class="tab-pane">
	<?php if ($this->checkAccess('prheader','iswrite')) { ?>
<button name="CreateButtonprmaterial" type="button" class="btn btn-primary" onclick="newdataprmaterial()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('prheader','ispurge')) { ?>
<button name="PurgeButtonprmaterial" type="button" class="btn btn-danger" onclick="purgedataprmaterial()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderprmaterial,
		'id'=>'prmaterialList',
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
							'visible'=>$this->booltostr($this->checkAccess('prheader','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataprmaterial($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('prheader','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataprmaterial($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('prmaterialid'),
					'name'=>'prmaterialid',
					'value'=>'$data["prmaterialid"]'
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
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('requestedby'),
					'name'=>'requestedbyid',
					'value'=>'$data["requestedbycode"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('prmaterial')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderprmaterial,
		'id'=>'DetailprmaterialList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('prmaterialid'),
					'name'=>'prmaterialid',
					'value'=>'$data["prmaterialid"]'
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
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('requestedby'),
					'name'=>'requestedbyid',
					'value'=>'$data["requestedbycode"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogprmaterial" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('prmaterial') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="prmaterial_1_productid">
        <div class="row">
						<div class="col-md-4">
							<label for="prmaterial_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prmaterial_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prmaterial_1_unitofmeasureid','ColField'=>'prmaterial_1_uomcode',
							'IDDialog'=>'prmaterial_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'prmaterial_1_unitofmeasureidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prmaterial_1_requestedbyid','ColField'=>'prmaterial_1_requestedbycode',
							'IDDialog'=>'prmaterial_1_requestedbyid_dialog','titledialog'=>$this->getCatalog('requestedby'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.RequestedbyPopUp','PopGrid'=>'prmaterial_1_requestedbyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prmaterial_1_reqdate"><?php echo $this->getCatalog('reqdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="prmaterial_1_reqdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prmaterial_1_itemtext"><?php echo $this->getCatalog('itemtext')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="prmaterial_1_itemtext"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataprmaterial()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			