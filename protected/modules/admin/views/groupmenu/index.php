<script src="<?php echo Yii::app()->baseUrl;?>/js/groupmenu.js"></script>
<h3><?php echo $this->getCatalog('groupmenu') ?></h3>
<?php if ($this->checkAccess('groupmenu','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?> 
<?php if ($this->checkAccess('groupmenu','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('groupmenu','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('groupmenu','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('groupmenu','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('groupmenu','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('groupmenu','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('groupmenu','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('groupmenu','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('groupmenuid'),
					'name'=>'groupmenuid',
					'value'=>'$data["groupmenuid"]'
				),
							array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupname',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('isread'),
					'selectableRows'=>'0',
					'checked'=>'$data["isread"]',
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('iswrite'),
					'selectableRows'=>'0',
					'checked'=>'$data["iswrite"]',
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('ispost'),
					'selectableRows'=>'0',
					'checked'=>'$data["ispost"]',
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('isreject'),
					'selectableRows'=>'0',
					'checked'=>'$data["isreject"]',
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('isupload'),
					'selectableRows'=>'0',
					'checked'=>'$data["isupload"]',
				),

							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('isdownload'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdownload"]',
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('ispurge'),
					'selectableRows'=>'0',
					'checked'=>'$data["ispurge"]',
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
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('groupmenu') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="groupmenuid">						
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'groupaccessid','ColField'=>'groupname',
							'IDDialog'=>'moduleid_dialog','titledialog'=>$this->getCatalog('groupaccess'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.GroupaccessPopUp','PopGrid'=>'groupaccessidgrid')); 
					?>

		<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'menuaccessid','ColField'=>'description',
							'IDDialog'=>'parentid_dialog','titledialog'=>$this->getCatalog('menuaccess'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.MenuaccessPopUp','PopGrid'=>'menuaccessidgrid')); 
					?>		
							
        <div class="row">
						<div class="col-md-4">
							<label for="isread"><?php echo $this->getCatalog('isread')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isread">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="iswrite"><?php echo $this->getCatalog('iswrite')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="iswrite">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="ispost"><?php echo $this->getCatalog('ispost')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="ispost">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isreject"><?php echo $this->getCatalog('isreject')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isreject">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isupload"><?php echo $this->getCatalog('isupload')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isupload">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isdownload"><?php echo $this->getCatalog('isdownload')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isdownload">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="ispurge"><?php echo $this->getCatalog('ispurge')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="ispurge">
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


