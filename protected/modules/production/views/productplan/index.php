<script src="<?php echo Yii::app()->baseUrl;?>/js/productplan.js"></script>
<script type="text/javascript">
function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
			'productid':$("input[name='productplanfg_1_productid']").val(),
			'companyid':$("input[name='productplan_0_companyid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='productplanfg_1_unitofmeasureid']").val(data.uomid);
				$("input[name='productplanfg_1_uomcode']").val(data.uomcode);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}
</script>
<h3><?php echo $this->getCatalog('productplan') ?></h3>
<?php if ($this->checkAccess('productplan','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productplan','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('productplan','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('productplan','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('productplan','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('productplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('productplan','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('productplanid'),
					'name'=>'productplanid',
					'value'=>'$data["productplanid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('sono'),
					'name'=>'soheaderid',
					'value'=>'$data["sono"]'
				),
							array(
					'header'=>$this->getCatalog('productplanno'),
					'name'=>'productplanno',
					'value'=>'$data["productplanno"]'
				),
							array(
					'header'=>$this->getCatalog('productplandate'),
					'name'=>'productplandate',
					'value'=>'Yii::app()->format->formatDate($data["productplandate"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
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
						<label for="dlg_search_sono"><?php echo $this->getCatalog('sono')?></label>
						<input type="text" class="form-control" name="dlg_search_sono">
					</div>
          <div class="form-group">
						<label for="dlg_search_productplanno"><?php echo $this->getCatalog('productplanno')?></label>
						<input type="text" class="form-control" name="dlg_search_productplanno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('productplan') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="productplan_0_productplanid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplan_0_companyid','ColField'=>'productplan_0_companyname',
							'IDDialog'=>'productplan_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'productplan_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplan_0_soheaderid','ColField'=>'productplan_0_sono',
							'IDDialog'=>'productplan_0_soheaderid_dialog','titledialog'=>$this->getCatalog('sono'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.SoUserPopUp','PopGrid'=>'productplan_0_soheaderidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplan_0_productplandate"><?php echo $this->getCatalog('productplandate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="productplan_0_productplandate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplan_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="productplan_0_description"></textarea>
						</div>
					</div>
							<input type="hidden" class="form-control" name="productplan_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#productplanfg"><?php echo $this->getCatalog("productplanfg")?></a></li>
<li><a data-toggle="tab" href="#productplandetail"><?php echo $this->getCatalog("productplandetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="productplanfg" class="tab-pane">
	<?php if ($this->checkAccess('productplan','iswrite')) { ?>
<button name="CreateButtonproductplanfg" type="button" class="btn btn-primary" onclick="newdataproductplanfg()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productplan','ispurge')) { ?>
<button name="PurgeButtonproductplanfg" type="button" class="btn btn-danger" onclick="purgedataproductplanfg()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductplanfg,
		'id'=>'productplanfgList',
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
							'visible'=>$this->booltostr($this->checkAccess('productplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataproductplanfg($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataproductplanfg($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('productplanfgid'),
					'name'=>'productplanfgid',
					'value'=>'$data["productplanfgid"]'
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
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('bom'),
					'name'=>'bomid',
					'value'=>'$data["bomversion"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'Yii::app()->format->formatDate($data["startdate"])'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'Yii::app()->format->formatDate($data["enddate"])'
				),
							array(
					'header'=>$this->getCatalog('qtyres'),
					'name'=>'qtyres',
					'value'=>'Yii::app()->format->formatNumber($data["qtyres"])'
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
<div id="productplandetail" class="tab-pane">
	<?php if ($this->checkAccess('productplan','iswrite')) { ?>
<button name="CreateButtonproductplandetail" type="button" class="btn btn-primary" onclick="newdataproductplandetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productplan','ispurge')) { ?>
<button name="PurgeButtonproductplandetail" type="button" class="btn btn-danger" onclick="purgedataproductplandetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductplandetail,
		'id'=>'productplandetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('productplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataproductplandetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataproductplandetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('productplandetailid'),
					'name'=>'productplandetailid',
					'value'=>'$data["productplandetailid"]'
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
					'header'=>$this->getCatalog('fromsloc'),
					'name'=>'fromslocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('tosloc'),
					'name'=>'toslocid',
					'value'=>'$data["toslocid"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('qtyres'),
					'name'=>'qtyres',
					'value'=>'Yii::app()->format->formatNumber($data["qtyres"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('productplanfg')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductplanfg,
		'id'=>'DetailproductplanfgList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('productplanfgid'),
					'name'=>'productplanfgid',
					'value'=>'$data["productplanfgid"]'
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
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('bom'),
					'name'=>'bomid',
					'value'=>'$data["bomversion"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'Yii::app()->format->formatDate($data["startdate"])'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'Yii::app()->format->formatDate($data["enddate"])'
				),
							array(
					'header'=>$this->getCatalog('qtyres'),
					'name'=>'qtyres',
					'value'=>'Yii::app()->format->formatNumber($data["qtyres"])'
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
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('productplandetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductplandetail,
		'id'=>'DetailproductplandetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('productplandetailid'),
					'name'=>'productplandetailid',
					'value'=>'$data["productplandetailid"]'
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
					'header'=>$this->getCatalog('fromsloc'),
					'name'=>'fromslocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('tosloc'),
					'name'=>'toslocid',
					'value'=>'$data["toslocid"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('qtyres'),
					'name'=>'qtyres',
					'value'=>'Yii::app()->format->formatNumber($data["qtyres"])'
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
			
<div id="InputDialogproductplanfg" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('productplanfg') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="productplanfg_1_productplanfgid">
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplanfg_1_productid','ColField'=>'productplanfg_1_productname',
							'IDDialog'=>'productplanfg_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productplanfg_1_productidgrid',
							'onaftersign'=>'getproductdata();')); 
					?>
        <div class="row">
						<div class="col-md-4">
							<label for="productplanfg_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productplanfg_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplanfg_1_uomid','ColField'=>'productplanfg_1_uomcode',
							'IDDialog'=>'productplanfg_1_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'productplanfg_1_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'productplanfg_1_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplanfg_1_slocid','ColField'=>'productplanfg_1_sloccode',
							'IDDialog'=>'productplanfg_1_slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'productplanfg_1_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplanfg_1_bomid','ColField'=>'productplanfg_1_bomversion',
							'IDDialog'=>'productplanfg_1_bomid_dialog','titledialog'=>$this->getCatalog('bom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'production.components.views.ProductbomPopUp','PopGrid'=>'productplanfg_1_bomidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplanfg_1_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="productplanfg_1_startdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplanfg_1_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="productplanfg_1_enddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplanfg_1_qtyres"><?php echo $this->getCatalog('qtyres')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productplanfg_1_qtyres">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplanfg_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="productplanfg_1_description"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductplanfg()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogproductplandetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('productplandetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="productplandetail_2_productid">
        <div class="row">
						<div class="col-md-4">
							<label for="productplandetail_2_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productplandetail_2_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplandetail_2_uomid','ColField'=>'productplandetail_2_uomcode',
							'IDDialog'=>'productplandetail_2_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'productplandetail_2_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplandetail_2_fromslocid','ColField'=>'productplandetail_2_sloccode',
							'IDDialog'=>'productplandetail_2_fromslocid_dialog','titledialog'=>$this->getCatalog('fromsloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'productplandetail_2_fromslocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplandetail_2_toslocid','ColField'=>'productplandetail_2_toslocid',
							'IDDialog'=>'productplandetail_2_toslocid_dialog','titledialog'=>$this->getCatalog('tosloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'productplandetail_2_toslocidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplandetail_2_reqdate"><?php echo $this->getCatalog('reqdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="productplandetail_2_reqdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplandetail_2_qtyres"><?php echo $this->getCatalog('qtyres')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productplandetail_2_qtyres">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplandetail_2_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="productplandetail_2_description"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductplandetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			