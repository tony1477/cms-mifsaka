<script src="<?php echo Yii::app()->baseUrl;?>/js/catalogsys.js"></script>
<h3><?php echo $this->getCatalog('catalogsys') ?></h3>
<?php if ($this->checkAccess('catalogsys','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('catalogsys','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('catalogsys','isdownload')) { ?>
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
						'visible'=>$this->booltostr($this->checkAccess('catalogsys','iswrite')),
						'url'=>'"#"',
						'click'=>"function() { 
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'delete' => array
					(
						'label'=>$this->getCatalog('delete'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
						'visible'=>'false',							
						'url'=>'"#"',
						'click'=>"function() { 
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'purge' => array
					(
						'label'=>$this->getCatalog('purge'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
						'visible'=>$this->booltostr($this->checkAccess('catalogsys','ispurge')),							
						'url'=>'"#"',
						'click'=>"function() { 
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'pdf' => array
					(
						'label'=>$this->getCatalog('downpdf'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
						'visible'=>$this->booltostr($this->checkAccess('catalogsys','isdownload')),
						'url'=>'"#"',
						'click'=>"function() { 
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'xls' => array
					(
						'label'=>$this->getCatalog('downxls'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
						'visible'=>$this->booltostr($this->checkAccess('catalogsys','isdownload')),
						'url'=>'"#"',
						'click'=>"function() { 
							downxls($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('catalogsysid'),
				'name'=>'catalogsysid',
				'value'=>'$data["catalogsysid"]'
			),
						array(
				'header'=>$this->getCatalog('languagename'),
				'name'=>'languageid',
				'value'=>'$data["languagename"]'
			),
						array(
				'header'=>$this->getCatalog('catalogname'),
				'name'=>'catalogname',
				'value'=>'$data["catalogname"]'
			),
			
						array(
				'header'=>$this->getCatalog('catalogval'),
				'name'=>'catalogval',
				'value'=>'$data["catalogval"]'
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
						<label for="dlg_search_languagename"><?php echo $this->getCatalog('languagename')?></label>
						<input type="text" class="form-control" name="dlg_search_languagename">
					</div>
          <div class="form-group">
						<label for="dlg_search_catalogname"><?php echo $this->getCatalog('catalogname')?></label>
						<input type="text" class="form-control" name="dlg_search_catalogname">
					</div>
          <div class="form-group">
						<label for="dlg_search_catalogval"><?php echo $this->getCatalog('catalogval')?></label>
						<input type="text" class="form-control" name="dlg_search_catalogval">
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
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('catalogsys') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="catalogsysid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'languageid','ColField'=>'languagename',
							'IDDialog'=>'languageid_dialog','titledialog'=>$this->getCatalog('languagename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.LanguagePopUp','PopGrid'=>'languageidgrid')); 
					?>
        <div class="row">
					<div class="col-md-4">
						<label for="catalogname"><?php echo $this->getCatalog('catalogname')?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="catalogname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="catalogval"><?php echo $this->getCatalog('catalogval')?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="catalogval">
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