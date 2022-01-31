<script src="<?php echo Yii::app()->baseUrl;?>/js/repprodplan.js"></script>
<h3><?php echo $this->getCatalog('repprodplan') ?></h3>

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
          <div class="form-group">
						<label for="dlg_search_productplanfgid"><?php echo $this->getCatalog('productplanfgid')?></label>
						<input type="text" class="form-control" name="dlg_search_productplanfgid">
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
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_bomversion"><?php echo $this->getCatalog('bomversion')?></label>
						<input type="text" class="form-control" name="dlg_search_bomversion">
					</div>
          <div class="form-group">
						<label for="dlg_search_productplandetailid"><?php echo $this->getCatalog('productplandetailid')?></label>
						<input type="text" class="form-control" name="dlg_search_productplandetailid">
					</div>
          <div class="form-group">
						<label for="dlg_search_productplanid"><?php echo $this->getCatalog('productplanid')?></label>
						<input type="text" class="form-control" name="dlg_search_productplanid">
					</div>
          <div class="form-group">
						<label for="dlg_search_productplanfgid"><?php echo $this->getCatalog('productplanfgid')?></label>
						<input type="text" class="form-control" name="dlg_search_productplanfgid">
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
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
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
			<input type="hidden" class="form-control" name="productplanfg_1_productid">
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
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'productplanfg_1_uomidgrid')); 
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
			