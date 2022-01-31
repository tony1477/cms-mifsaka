<script src="<?php echo Yii::app()->baseUrl;?>/js/productplant.js"></script>
<h3><?php echo $this->getCatalog('productplant') ?></h3>
<?php if ($this->checkAccess('productplant','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('productplant','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('productplant','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('productplant','isdownload')) { ?>
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
				'template'=>'{edit} {delete} {purge} {pdf} {xls}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('productplant','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('productplant','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productplant','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('productplant','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('productplant','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('productplantid'),
					'name'=>'productplantid',
					'value'=>'$data["productplantid"]'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'unitofissue',
					'value'=>'$data["uomcode"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isautolot',
					'header'=>$this->getCatalog('isautolot'),
					'selectableRows'=>'0',
					'checked'=>'$data["isautolot"]',
				),array(
					'header'=>$this->getCatalog('sled'),
					'name'=>'sled',
					'value'=>'$data["sled"]'
				),
							array(
					'header'=>$this->getCatalog('snro'),
					'name'=>'snroid',
					'value'=>'$data["snro"]'
				),
							array(
					'header'=>$this->getCatalog('materialgroupcode'),
					'name'=>'materialgroupid',
					'value'=>'$data["materialgroupcode"]'
				),
							array(
					'header'=>$this->getCatalog('mgprocess'),
					'name'=>'mgprocessid',
					'value'=>'$data["mgprocess"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'issource',
					'header'=>$this->getCatalog('issource'),
					'selectableRows'=>'0',
					'checked'=>'$data["issource"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
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
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_materialgroupcode"><?php echo $this->getCatalog('materialgroupcode')?></label>
						<input type="text" class="form-control" name="dlg_search_materialgroupcode">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('productplant') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="productplant_0_productplantid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplant_0_productid','ColField'=>'productplant_0_productname',
							'IDDialog'=>'productplant_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productplant_0_productidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplant_0_slocid','ColField'=>'productplant_0_sloccode',
							'IDDialog'=>'productplant_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'productplant_0_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplant_0_unitofissue','ColField'=>'productplant_0_uomcode',
							'IDDialog'=>'productplant_0_unitofissue_dialog','titledialog'=>$this->getCatalog('uomcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'productplant_0_unitofissuegrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplant_0_isautolot"><?php echo $this->getCatalog('isautolot')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="productplant_0_isautolot">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplant_0_sled"><?php echo $this->getCatalog('sled')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productplant_0_sled">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplant_0_snroid','ColField'=>'productplant_0_snro',
							'IDDialog'=>'productplant_0_snroid_dialog','titledialog'=>$this->getCatalog('snro'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.SnroPopUp','PopGrid'=>'productplant_0_snroidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplant_0_materialgroupid','ColField'=>'productplant_0_materialgroupcode',
							'IDDialog'=>'productplant_0_materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroupcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgrouptrxPopUp','PopGrid'=>'productplant_0_materialgroupidgrid')); 
					?>
        
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productplant_0_mgprocessid','ColField'=>'productplant_0_mgprocess',
							'IDDialog'=>'productplant_0_mgprocessid_dialog','titledialog'=>$this->getCatalog('mgprocess'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MgprocessPopUp','PopGrid'=>'productplant_0_mgprocessbidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplant_0_issource"><?php echo $this->getCatalog('issource')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="productplant_0_issource">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productplant_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="productplant_0_recordstatus">
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


