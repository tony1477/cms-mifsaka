<script src="<?php echo Yii::app()->baseUrl;?>/js/widget.js"></script>
<h3><?php echo $this->getCatalog('widget') ?></h3>
<?php if ($this->checkAccess('widget','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('widget','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('widget','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('widget','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('widget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('widget','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('widget','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('widget','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('widget','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('widgetid'),
					'name'=>'widgetid',
					'value'=>'$data["widgetid"]'
				),
							array(
					'header'=>$this->getCatalog('widgetname'),
					'name'=>'widgetname',
					'value'=>'$data["widgetname"]'
				),
							array(
					'header'=>$this->getCatalog('widgettitle'),
					'name'=>'widgettitle',
					'value'=>'$data["widgettitle"]'
				),
							array(
					'header'=>$this->getCatalog('widgetversion'),
					'name'=>'widgetversion',
					'value'=>'$data["widgetversion"]'
				),
							array(
					'header'=>$this->getCatalog('widgetby'),
					'name'=>'widgetby',
					'value'=>'$data["widgetby"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('widgeturl'),
					'name'=>'widgeturl',
					'value'=>'$data["widgeturl"]'
				),
							array(
					'header'=>$this->getCatalog('modulename'),
					'name'=>'moduleid',
					'value'=>'$data["modulename"]'
				),
							array(
					'header'=>$this->getCatalog('installdate'),
					'name'=>'installdate',
					'value'=>'Yii::app()->format->formatDateTime($data["installdate"])'
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
						<label for="dlg_search_widgetname"><?php echo $this->getCatalog('widgetname')?></label>
						<input type="text" class="form-control" name="dlg_search_widgetname">
					</div>
          <div class="form-group">
						<label for="dlg_search_widgettitle"><?php echo $this->getCatalog('widgettitle')?></label>
						<input type="text" class="form-control" name="dlg_search_widgettitle">
					</div>
          <div class="form-group">
						<label for="dlg_search_widgetversion"><?php echo $this->getCatalog('widgetversion')?></label>
						<input type="text" class="form-control" name="dlg_search_widgetversion">
					</div>
          <div class="form-group">
						<label for="dlg_search_widgetby"><?php echo $this->getCatalog('widgetby')?></label>
						<input type="text" class="form-control" name="dlg_search_widgetby">
					</div>
          <div class="form-group">
						<label for="dlg_search_widgeturl"><?php echo $this->getCatalog('widgeturl')?></label>
						<input type="text" class="form-control" name="dlg_search_widgeturl">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('widget') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="widgetid">
        <div class="row">
						<div class="col-md-4">
							<label for="widgetname"><?php echo $this->getCatalog('widgetname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="widgetname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="widgettitle"><?php echo $this->getCatalog('widgettitle')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="widgettitle">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="widgetversion"><?php echo $this->getCatalog('widgetversion')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="widgetversion">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="widgetby"><?php echo $this->getCatalog('widgetby')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="widgetby">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="description"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="widgeturl"><?php echo $this->getCatalog('widgeturl')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="widgeturl">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'moduleid','ColField'=>'modulename',
							'IDDialog'=>'moduleid_dialog','titledialog'=>$this->getCatalog('modulename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.ModulesPopUp','PopGrid'=>'moduleidgrid')); 
					?>
							
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


