<script src="<?php echo Yii::app()->baseUrl;?>/js/addressbook.js"></script>
<h3><?php echo $this->getCatalog('addressbook') ?></h3>
<?php if ($this->checkAccess('addressbook','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('addressbook','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('addressbook','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('addressbook','isdownload')) { ?>
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
						'visible'=>$this->booltostr($this->checkAccess('addressbook','iswrite')),							
						'url'=>'"#"',
						'click'=>"function() { 
							updatedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'delete' => array
					(
						'label'=>$this->getCatalog('delete'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
						'visible'=>$this->booltostr($this->checkAccess('addressbook','isreject')),							
						'url'=>'"#"',
						'click'=>"function() { 
							deletedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'purge' => array
					(
						'label'=>$this->getCatalog('purge'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
						'visible'=>$this->booltostr($this->checkAccess('addressbook','ispurge')),							
						'url'=>'"#"',
						'click'=>"function() { 
							purgedata($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'pdf' => array
					(
						'label'=>$this->getCatalog('downpdf'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
						'visible'=>$this->booltostr($this->checkAccess('addressbook','isdownload')),
						'url'=>'"#"',
						'click'=>"function() { 
							downpdf($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
					'xls' => array
					(
						'label'=>$this->getCatalog('downxls'),
						'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
						'visible'=>$this->booltostr($this->checkAccess('addressbook','isdownload')),
						'url'=>'"#"',
						'click'=>"function() { 
							downxls($(this).parent().parent().children(':nth-child(3)').text());
						}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('addressbookid'),
				'name'=>'addressbookid',
				'value'=>'$data["addressbookid"]'
			),
			array(
				'header'=>$this->getCatalog('fullname'),
				'name'=>'fullname',
				'value'=>'$data["fullname"]'
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'iscustomer',
				'header'=>$this->getCatalog('iscustomer'),
				'selectableRows'=>'0',
				'checked'=>'$data["iscustomer"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isemployee',
				'header'=>$this->getCatalog('isemployee'),
				'selectableRows'=>'0',
				'checked'=>'$data["isemployee"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isvendor',
				'header'=>$this->getCatalog('isvendor'),
				'selectableRows'=>'0',
				'checked'=>'$data["isvendor"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'ishospital',
				'header'=>$this->getCatalog('ishospital'),
				'selectableRows'=>'0',
				'checked'=>'$data["ishospital"]',
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
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('addressbook') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
				<input type="hidden" class="form-control" name="addressbookid">
        <div class="row">
					<div class="col-md-4">
						<label for="fullname"><?php echo $this->getCatalog('fullname')?></label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" name="fullname">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="iscustomer"><?php echo $this->getCatalog('iscustomer')?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="iscustomer">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="isemployee"><?php echo $this->getCatalog('isemployee')?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="isemployee">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="isvendor"><?php echo $this->getCatalog('isvendor')?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="isvendor">
					</div>
				</div>
        <div class="row">
					<div class="col-md-4">
						<label for="ishospital"><?php echo $this->getCatalog('ishospital')?></label>
					</div>
					<div class="col-md-8">
						<input type="checkbox" name="ishospital">
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