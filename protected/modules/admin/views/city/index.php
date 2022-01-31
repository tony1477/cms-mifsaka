<script src="<?php echo Yii::app()->baseUrl;?>/js/city.js"></script>
<h3><?php echo $this->getCatalog('city') ?></h3>
<?php if ($this->checkAccess('city','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('city','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('city','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('city','isdownload')) { ?>
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
		'columns'=>array
		(
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
							'visible'=>$this->booltostr($this->checkAccess('city','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('city','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('city','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('city','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('city','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('cityid'),
				'name'=>'cityid',
				'value'=>'$data["cityid"]'
				),
			array(
				'header'=>$this->getCatalog('provincename'),
				'name'=>'provinceid',
				'value'=>'$data["provincename"]'
				),
			array(
				'header'=>$this->getCatalog('citycode'),
				'name'=>'citycode',
				'value'=>'$data["citycode"]'
				),
			array(
				'header'=>$this->getCatalog('cityname'),
				'name'=>'cityname',
				'value'=>'$data["cityname"]'
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
					<label for="dlg_search_provincename"><?php echo $this->getCatalog('provincename')?></label>
					<input type="text" class="form-control" name="dlg_search_provincename">
				</div>
      			<div class="form-group">
					<label for="dlg_search_citycode"><?php echo $this->getCatalog('citycode')?></label>
					<input type="text" class="form-control" name="dlg_search_citycode">
				</div>
				<div class="form-group">
					<label for="dlg_search_cityname"><?php echo $this->getCatalog('cityname')?></label>
					<input type="text" class="form-control" name="dlg_search_cityname">
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
				<h4 class="modal-title"><?php echo $this->getCatalog('city') ?></h4>
			</div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="cityid">

		        <?php $this->widget('DataPopUp',
					array('id'=>'Widget','IDField'=>'provinceid','ColField'=>'provincename',
						'IDDialog'=>'provinceid_dialog','titledialog'=>$this->getCatalog('provincename'),'classtype'=>'col-md-4',
						'classtypebox'=>'col-md-8',
						'PopUpName'=>'admin.components.views.ProvincePopUp','PopGrid'=>'provinceidgrid')); 
				?>
								
				<div class="row">
					<div class="col-md-4">
						<label for="citycode"><?php echo $this->getCatalog('citycode')?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="citycode">
					</div>
				</div>
								
	        	<div class="row">
					<div class="col-md-4">
						<label for="cityname"><?php echo $this->getCatalog('cityname')?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="cityname">
					</div>
				</div>
								
	        	<div class="row">
					<div class="col-md-4">
						<label for="recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="recordstatus">
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


