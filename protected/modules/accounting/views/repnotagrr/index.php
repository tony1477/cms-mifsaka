<script src="<?php echo Yii::app()->baseUrl;?>/js/repnotagrr.js"></script>
<h3><?php echo $this->getCatalog('repnotagrr') ?></h3>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('notagrretur','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('notagrreturid'),
					'name'=>'notagrreturid',
					'value'=>'$data["notagrreturid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('notagrreturno'),
					'name'=>'notagrreturno',
					'value'=>'$data["notagrreturno"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('grreturno'),
					'name'=>'grreturid',
					'value'=>'$data["grreturno"]'
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
						<label for="dlg_search_notagrreturno"><?php echo $this->getCatalog('notagrreturno')?></label>
						<input type="text" class="form-control" name="dlg_search_notagrreturno">
					</div>
          <div class="form-group">
						<label for="dlg_search_grreturno"><?php echo $this->getCatalog('grreturno')?></label>
						<input type="text" class="form-control" name="dlg_search_grreturno">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('notagrretur') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="notagrretur_0_notagrreturid">
        <div class="row">
						<div class="col-md-4">
							<label for="notagrretur_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="notagrretur_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'notagrretur_0_grreturid','ColField'=>'notagrretur_0_grreturno',
							'IDDialog'=>'notagrretur_0_grreturid_dialog','titledialog'=>$this->getCatalog('grreturno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GrreturPopUp','PopGrid'=>'notagrretur_0_grreturidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="notagrretur_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="notagrretur_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#notagrrpro"><?php echo $this->getCatalog("notagrrpro")?></a></li>
<li><a data-toggle="tab" href="#notagrracc"><?php echo $this->getCatalog("notagrracc")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="notagrrpro" class="tab-pane">
	<?php if ($this->checkAccess('notagrretur','iswrite')) { ?>
<button name="CreateButtonnotagrrpro" type="button" class="btn btn-primary" onclick="newdatanotagrrpro()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','ispurge')) { ?>
<button name="PurgeButtonnotagrrpro" type="button" class="btn btn-danger" onclick="purgedatanotagrrpro()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrrpro,
		'id'=>'notagrrproList',
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
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatanotagrrpro($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatanotagrrpro($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('notagrrproid'),
					'name'=>'notagrrproid',
					'value'=>'$data["notagrrproid"]'
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
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatNumber($data["price"])'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
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
							
		)
));
?>
  </div>
<div id="notagrracc" class="tab-pane">
	<?php if ($this->checkAccess('notagrretur','iswrite')) { ?>
<button name="CreateButtonnotagrracc" type="button" class="btn btn-primary" onclick="newdatanotagrracc()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','ispurge')) { ?>
<button name="PurgeButtonnotagrracc" type="button" class="btn btn-danger" onclick="purgedatanotagrracc()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrracc,
		'id'=>'notagrraccList',
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
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatanotagrracc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatanotagrracc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('notagrraccid'),
					'name'=>'notagrraccid',
					'value'=>'$data["notagrraccid"]'
				),
							array(
					'header'=>$this->getCatalog('accountid'),
					'name'=>'accountid',
					'value'=>'$data["accountid"]'
				),
							array(
					'header'=>$this->getCatalog('debet'),
					'name'=>'debet',
					'value'=>'Yii::app()->format->formatNumber($data["debet"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('currencyid'),
					'name'=>'currencyid',
					'value'=>'$data["currencyid"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('notagrrpro')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrrpro,
		'id'=>'DetailnotagrrproList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('notagrrproid'),
					'name'=>'notagrrproid',
					'value'=>'$data["notagrrproid"]'
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
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatNumber($data["price"])'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
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
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('notagrracc')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrracc,
		'id'=>'DetailnotagrraccList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('notagrraccid'),
					'name'=>'notagrraccid',
					'value'=>'$data["notagrraccid"]'
				),
							array(
					'header'=>$this->getCatalog('accountid'),
					'name'=>'accountid',
					'value'=>'$data["accountid"]'
				),
							array(
					'header'=>$this->getCatalog('debet'),
					'name'=>'debet',
					'value'=>'Yii::app()->format->formatNumber($data["debet"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('currencyid'),
					'name'=>'currencyid',
					'value'=>'$data["currencyid"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
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
			
<div id="InputDialognotagrrpro" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('notagrrpro') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="notagrrpro_1_price">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'notagrrpro_1_currencyid','ColField'=>'notagrrpro_1_currencyname',
							'IDDialog'=>'notagrrpro_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'notagrrpro_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="notagrrpro_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="notagrrpro_1_currencyrate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatanotagrrpro()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialognotagrracc" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('notagrracc') ?></h4>
      </div>
			<div class="modal-body">
			
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatanotagrracc()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			