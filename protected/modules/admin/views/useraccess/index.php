<script src="<?php echo Yii::app()->baseUrl;?>/js/useraccess.js"></script>
<h3><?php echo $this->getCatalog('useraccess') ?></h3>
<?php if ($this->checkAccess('useraccess','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('useraccess','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('useraccess','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('useraccess','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('useraccess','iswrite')),
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('useraccess','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('useraccess','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('useraccess','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('useraccess','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('useraccessid'),
					'name'=>'useraccessid',
					'value'=>'$data["useraccessid"]'
				),
							array(
					'header'=>$this->getCatalog('username'),
					'name'=>'username',
					'value'=>'$data["username"]'
				),
							array(
					'header'=>$this->getCatalog('realname'),
					'name'=>'realname',
					'value'=>'$data["realname"]'
				),
							array(
					'header'=>$this->getCatalog('email'),
					'name'=>'email',
					'value'=>'$data["email"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('languagename'),
					'name'=>'languageid',
					'value'=>'$data["languagename"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isonline',
					'header'=>$this->getCatalog('isonline'),
					'selectableRows'=>'0',
					'checked'=>'$data["isonline"]',
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
						<label for="dlg_search_username"><?php echo $this->getCatalog('username')?></label>
						<input type="text" class="form-control" name="dlg_search_username">
					</div>
          <div class="form-group">
						<label for="dlg_search_realname"><?php echo $this->getCatalog('realname')?></label>
						<input type="text" class="form-control" name="dlg_search_realname">
					</div>
          <div class="form-group">
						<label for="dlg_search_password"><?php echo $this->getCatalog('password')?></label>
						<input type="text" class="form-control" name="dlg_search_password">
					</div>
          <div class="form-group">
						<label for="dlg_search_email"><?php echo $this->getCatalog('email')?></label>
						<input type="text" class="form-control" name="dlg_search_email">
					</div>
          <div class="form-group">
						<label for="dlg_search_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						<input type="text" class="form-control" name="dlg_search_phoneno">
					</div>
          <div class="form-group">
						<label for="dlg_search_languagename"><?php echo $this->getCatalog('languagename')?></label>
						<input type="text" class="form-control" name="dlg_search_languagename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('useraccess') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="useraccessid">
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
							<label for="realname"><?php echo $this->getCatalog('realname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="realname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="password"><?php echo $this->getCatalog('password')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="password">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="email"><?php echo $this->getCatalog('email')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="email">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="phoneno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'languageid','ColField'=>'languagename',
							'IDDialog'=>'languageid_dialog','titledialog'=>$this->getCatalog('languagename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.LanguagePopUp','PopGrid'=>'languageidgrid')); 
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


