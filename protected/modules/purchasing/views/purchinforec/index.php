<script src="<?php echo Yii::app()->baseUrl;?>/js/purchinforec.js"></script>
<h3><?php echo $this->getCatalog('purchinforec') ?></h3>
<?php if ($this->checkAccess('purchinforec','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('purchinforec','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('purchinforec','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('purchinforec','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('purchinforec','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('purchinforec','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('purchinforec','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('purchinforec','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('purchinforec','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('purchinforecid'),
					'name'=>'purchinforecid',
					'value'=>'$data["purchinforecid"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('deliverytime'),
					'name'=>'deliverytime',
					'value'=>'$data["deliverytime"]'
				),
							array(
					'header'=>$this->getCatalog('purchasinggroupcode'),
					'name'=>'purchasinggroupid',
					'value'=>'$data["purchasinggroupcode"]'
				),
							array(
					'header'=>$this->getCatalog('underdelvtol'),
					'name'=>'underdelvtol',
					'value'=>'Yii::app()->format->formatNumber($data["underdelvtol"])'
				),
							array(
					'header'=>$this->getCatalog('overdelvtol'),
					'name'=>'overdelvtol',
					'value'=>'Yii::app()->format->formatNumber($data["overdelvtol"])'
				),
							array(
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatNumber($data["price"])'
				),
							array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('biddate'),
					'name'=>'biddate',
					'value'=>'Yii::app()->format->formatDate($data["biddate"])'
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
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('supplier')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
					</div>
					<div class="form-group">
						<label for="dlg_search_startdate"><?php echo $this->getCatalog('startdate')?></label>
						<input type="date" class="form-control" name="dlg_search_startdate">
					</div>
          <div class="form-group">
						<label for="dlg_search_enddate"><?php echo $this->getCatalog('enddate')?></label>
						<input type="date" class="form-control" name="dlg_search_enddate">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('purchinforec') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="purchinforec_0_purchinforecid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'purchinforec_0_addressbookid','ColField'=>'purchinforec_0_fullname',
							'IDDialog'=>'purchinforec_0_addressbookid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SupplierPopUp','PopGrid'=>'purchinforec_0_addressbookidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'purchinforec_0_productid','ColField'=>'purchinforec_0_productname',
							'IDDialog'=>'purchinforec_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'purchinforec_0_productidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="purchinforec_0_deliverytime"><?php echo $this->getCatalog('deliverytime')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="purchinforec_0_deliverytime">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'purchinforec_0_purchasinggroupid','ColField'=>'purchinforec_0_purchasinggroupcode',
							'IDDialog'=>'purchinforec_0_purchasinggroupid_dialog','titledialog'=>$this->getCatalog('purchasinggroupcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'purchasing.components.views.PurchasinggroupPopUp','PopGrid'=>'purchinforec_0_purchasinggroupidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="purchinforec_0_underdelvtol"><?php echo $this->getCatalog('underdelvtol')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="purchinforec_0_underdelvtol">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="purchinforec_0_overdelvtol"><?php echo $this->getCatalog('overdelvtol')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="purchinforec_0_overdelvtol">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="purchinforec_0_price"><?php echo $this->getCatalog('price')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="purchinforec_0_price">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'purchinforec_0_currencyid','ColField'=>'purchinforec_0_currencyname',
							'IDDialog'=>'purchinforec_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'purchinforec_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="purchinforec_0_biddate"><?php echo $this->getCatalog('biddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="purchinforec_0_biddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="purchinforec_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="purchinforec_0_recordstatus">
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


