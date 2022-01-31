<script src="<?php echo Yii::app()->baseUrl;?>/js/translog.js"></script>
<h3><?php echo $this->getCatalog('translog') ?></h3>
<?php if ($this->checkAccess('translog','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('translog','isdownload')) { ?>
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
							'visible'=>'false',							
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
							'visible'=>$this->booltostr($this->checkAccess('translog','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('translog','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('translog','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('translogid'),
					'name'=>'translogid',
					'value'=>'$data["translogid"]'
				),
							array(
					'header'=>$this->getCatalog('username'),
					'name'=>'username',
					'value'=>'$data["username"]'
				),
							array(
					'header'=>$this->getCatalog('createddate'),
					'name'=>'createddate',
					'value'=>'$data["createddate"]'
				),
							array(
					'header'=>$this->getCatalog('useraction'),
					'name'=>'useraction',
					'value'=>'$data["useraction"]'
				),
							array(
					'header'=>$this->getCatalog('newdata'),
					'name'=>'newdata',
					'value'=>'$data["newdata"]'
				),
							array(
					'header'=>$this->getCatalog('menuname'),
					'name'=>'menuname',
					'value'=>'$data["menuname"]'
				),
							array(
					'header'=>$this->getCatalog('tableid'),
					'name'=>'tableid',
					'value'=>'$data["tableid"]'
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
						<label for="dlg_search_username"><?php echo $this->getCatalog('username')?></label>
						<input type="text" class="form-control" name="dlg_search_username">
					</div>
          <div class="form-group">
						<label for="dlg_search_useraction"><?php echo $this->getCatalog('useraction')?></label>
						<input type="text" class="form-control" name="dlg_search_useraction">
					</div>
          <div class="form-group">
						<label for="dlg_search_menuname"><?php echo $this->getCatalog('menuname')?></label>
						<input type="text" class="form-control" name="dlg_search_menuname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('translog') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="translogid">
        <div class="row">
						<div class="col-md-4">
							<label for="username"><?php echo $this->getCatalog('username')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="username">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="useraction"><?php echo $this->getCatalog('useraction')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="useraction">
						</div>
					</div>

							
        <div class="row">
						<div class="col-md-4">
							<label for="createddate"><?php echo $this->getCatalog('createddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="createddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="newdata"><?php echo $this->getCatalog('newdata')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="newdata"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="menuname"><?php echo $this->getCatalog('menuname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="menuname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="tableid"><?php echo $this->getCatalog('tableid')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="tableid">
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


