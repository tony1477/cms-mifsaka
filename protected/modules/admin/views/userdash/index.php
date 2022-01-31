<script src="<?php echo Yii::app()->baseUrl;?>/js/userdash.js"></script>
<h3><?php echo $this->getCatalog('userdash') ?></h3>
<?php if ($this->checkAccess('userdash','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('userdash','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('userdash','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('userdash','iswrite')),							
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
							'visible'=>$this->booltostr($this->checkAccess('userdash','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('userdash','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('userdash','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('userdashid'),
					'name'=>'userdashid',
					'value'=>'$data["userdashid"]'
				),
							array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupaccessid',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('widgetname'),
					'name'=>'widgetid',
					'value'=>'$data["widgetname"]'
				),
							array(
					'header'=>$this->getCatalog('menuname'),
					'name'=>'menuaccessid',
					'value'=>'$data["menuname"]'
				),
							array(
					'header'=>$this->getCatalog('position'),
					'name'=>'position',
					'value'=>'$data["position"]'
				),
							array(
					'header'=>$this->getCatalog('webformat'),
					'name'=>'webformat',
					'value'=>'$data["webformat"]'
				),
							array(
					'header'=>$this->getCatalog('dashgroup'),
					'name'=>'dashgroup',
					'value'=>'$data["dashgroup"]'
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
						<label for="dlg_search_groupname"><?php echo $this->getCatalog('groupname')?></label>
						<input type="text" class="form-control" name="dlg_search_groupname">
					</div>
          <div class="form-group">
						<label for="dlg_search_widgetname"><?php echo $this->getCatalog('widgetname')?></label>
						<input type="text" class="form-control" name="dlg_search_widgetname">
					</div>
          <div class="form-group">
						<label for="dlg_search_menuname"><?php echo $this->getCatalog('menuname')?></label>
						<input type="text" class="form-control" name="dlg_search_menuname">
					</div>
          <div class="form-group">
						<label for="dlg_search_webformat"><?php echo $this->getCatalog('webformat')?></label>
						<input type="text" class="form-control" name="dlg_search_webformat">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('userdash') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="userdashid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'groupaccessid','ColField'=>'groupname',
							'IDDialog'=>'groupaccessid_dialog','titledialog'=>$this->getCatalog('groupname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.GroupaccessPopUp','PopGrid'=>'groupaccessidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'widgetid','ColField'=>'widgetname',
							'IDDialog'=>'widgetid_dialog','titledialog'=>$this->getCatalog('widgetname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.WidgetPopUp','PopGrid'=>'widgetidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'menuaccessid','ColField'=>'menuname',
							'IDDialog'=>'menuaccessid_dialog','titledialog'=>$this->getCatalog('menuname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.MenuaccessPopUp','PopGrid'=>'menuaccessidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="position"><?php echo $this->getCatalog('position')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="position">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="webformat"><?php echo $this->getCatalog('webformat')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="webformat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="dashgroup"><?php echo $this->getCatalog('dashgroup')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="dashgroup">
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


