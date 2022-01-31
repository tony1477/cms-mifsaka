<script src="<?php echo Yii::app()->baseUrl;?>/js/wfgroup.js"></script>
<h3><?php echo $this->getCatalog('wfgroup') ?></h3>
<?php if ($this->checkAccess('wfgroup','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?> 
<?php if ($this->checkAccess('wfgroup','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('wfgroup','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('wfgroup','isdownload')) { ?>
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
							'label'=>$this->getCatalog('Ubah'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('wfgroup','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('wfgroup','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('wfgroup','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('wfgroup','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('wfgroup','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('wfgroupid'),
					'name'=>'wfgroupid',
					'value'=>'$data["wfgroupid"]'
				),
							array(
					'header'=>$this->getCatalog('wfname'),
					'name'=>'wfdesc',
					'value'=>'$data["wfdesc"]'
				),
							array(
					'header'=>$this->getCatalog('groupaccess'),
					'name'=>'groupname',
					'value'=>'$data["groupname"]'
				),

							array(
					'header'=>$this->getCatalog('wfbefstat'),
					'name'=>'wfbefstat',
					'value'=>'$data["wfbefstat"]'
				),

							array(
					'header'=>$this->getCatalog('wfrecstat'),
					'name'=>'wfrecstat',
					'value'=>'$data["wfrecstat"]'
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
						<label for="dlg_search_wfdesc"><?php echo $this->getCatalog('wfdesc')?></label>
						<input type="text" class="form-control" name="dlg_search_wfdesc">
					</div>
					<div class="form-group">
						<label for="dlg_search_groupname"><?php echo $this->getCatalog('groupname')?></label>
						<input type="text" class="form-control" name="dlg_search_groupname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('wfgroup') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="wfgroupid">
		<?php $this->widget('DataPopUp',
			array('id'=>'Widget','IDField'=>'workflowid','ColField'=>'wfdesc',
				'IDDialog'=>'workflowid_dialog','titledialog'=>$this->getCatalog('workflow'),'classtype'=>'col-md-4',
				'classtypebox'=>'col-md-8',
				'PopUpName'=>'admin.components.views.WorkflowPopUp','PopGrid'=>'workflowidgrid')); 
		?>
		<?php $this->widget('DataPopUp',
			array('id'=>'Widget','IDField'=>'groupaccessid','ColField'=>'groupname',
				'IDDialog'=>'moduleid_dialog','titledialog'=>$this->getCatalog('groupaccess'),'classtype'=>'col-md-4',
				'classtypebox'=>'col-md-8',
				'PopUpName'=>'admin.components.views.GroupaccessPopUp','PopGrid'=>'groupaccessidgrid')); 
		?>
		<div class="row">
			<div class="col-md-4">
				<label for="wfbefstat"><?php echo $this->getCatalog('wfbefstat')?></label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" name="wfbefstat">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="wfrecstat"><?php echo $this->getCatalog('wfrecstat')?></label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" name="wfrecstat">
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


