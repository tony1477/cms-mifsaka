<script src="<?php echo Yii::app()->baseUrl;?>/js/menuaccess.js"></script>
<h3><?php echo $this->getCatalog('menuaccess') ?></h3>
<?php if ($this->checkAccess('menuaccess','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('menuaccess','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('menuaccess','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('menuaccess','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('menuaccess','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('menuaccess','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('menuaccess','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('menuaccess','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('menuaccess','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('menuaccessid'),
					'name'=>'menuaccessid',
					'value'=>'$data["menuaccessid"]'
				),
							array(
					'header'=>$this->getCatalog('menuname'),
					'name'=>'menuname',
					'value'=>'$data["menuname"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('menuurl'),
					'name'=>'menuurl',
					'value'=>'$data["menuurl"]'
				),
							array(
					'header'=>$this->getCatalog('menuicon'),
					'name'=>'menuicon',
					'value'=>'$data["menuicon"]'
				),
							array(
					'header'=>$this->getCatalog('parentid'),
					'name'=>'parentid',
					'value'=>'$data["parentid"]'
				),
							array(
					'header'=>$this->getCatalog('modulename'),
					'name'=>'moduleid',
					'value'=>'$data["modulename"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'sortorder',
					'header'=>$this->getCatalog('sortorder'),
					'selectableRows'=>'0',
					'checked'=>'$data["sortorder"]',
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
						<label for="dlg_search_menuname"><?php echo $this->getCatalog('menuname')?></label>
						<input type="text" class="form-control" name="dlg_search_menuname">
					</div>
          <div class="form-group">
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
					</div>
          <div class="form-group">
						<label for="dlg_search_menuurl"><?php echo $this->getCatalog('menuurl')?></label>
						<input type="text" class="form-control" name="dlg_search_menuurl">
					</div>
          <div class="form-group">
						<label for="dlg_search_menuicon"><?php echo $this->getCatalog('menuicon')?></label>
						<input type="text" class="form-control" name="dlg_search_menuicon">
					</div>
          <div class="form-group">
						<label for="dlg_search_modulename"><?php echo $this->getCatalog('modulename')?></label>
						<input type="text" class="form-control" name="dlg_search_modulename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('menuaccess') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="menuaccess_0_menuaccessid">
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_menuname"><?php echo $this->getCatalog('menuname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="menuaccess_0_menuname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="menuaccess_0_description">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_menuurl"><?php echo $this->getCatalog('menuurl')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="menuaccess_0_menuurl">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_menuicon"><?php echo $this->getCatalog('menuicon')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="menuaccess_0_menuicon">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_parentid"><?php echo $this->getCatalog('parentid')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="menuaccess_0_parentid">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'menuaccess_0_moduleid','ColField'=>'menuaccess_0_modulename',
							'IDDialog'=>'menuaccess_0_moduleid_dialog','titledialog'=>$this->getCatalog('modulename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.ModulesPopUp','PopGrid'=>'menuaccess_0_moduleidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_sortorder"><?php echo $this->getCatalog('sortorder')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="menuaccess_0_sortorder">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuaccess_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="menuaccess_0_recordstatus">
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


