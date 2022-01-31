<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl."/bootstrap/js/jquery.bootstrap.wizard.min.js"); ?>
<script src="<?php echo Yii::app()->baseUrl;?>/js/menugenerator.js"></script>
<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Menu Generator</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
<form class="form-horizontal" role="form" id="konfigform">
<div id="rootwizard">
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<ul>
					<li><a href="#tab1" data-toggle="tab">Perkenalan</a></li>
					<li><a href="#tab2" data-toggle="tab">Konfigurasi</a></li>
					<li><a href="#tab3" data-toggle="tab">View</a></li>
					<li><a href="#tab4" data-toggle="tab">Instalasi</a></li>
					<li><a href="#tab5" data-toggle="tab">Selesai</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
    <div class="progress">
  <div id="wizprogress" class="progress-bar progress-bar-striped active" role="progressbar"
  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
    0%
  </div>
</div>
</div>
	<div class="tab-content">
		<div class="tab-pane" id="tab1">
			<div class="container">
				<h1>Menu Generator</h1>
				<p>Modul ini akan melakukan pembuatan code secara otomatis sesuai data yang dimasukkan</p> 
			</div>
		</div>
		<div class="tab-pane" id="tab2">
			<div class="form-group">
				<label class="control-label col-sm-2" for="menuname"><?php echo $this->getCatalog('menuname')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="menuname" placeholder="Menu Name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="tablename"><?php echo $this->getCatalog('tablename')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="tablename" placeholder="Table Name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="controller"><?php echo $this->getCatalog('controllername')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="controller" placeholder="Controller Name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="module"><?php echo $this->getCatalog('modulename')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="module" placeholder="Module Name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="updateheadersp"><?php echo $this->getCatalog('updateheadersp')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="updateheadersp" placeholder="Update Header SP">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="appwf"><?php echo $this->getCatalog('approvewf')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="appwf" placeholder="Approval Workflow">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="rejwf"><?php echo $this->getCatalog('rejectwf')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="rejwf" placeholder="Reject Workflow">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="inswf"><?php echo $this->getCatalog('insertwf')?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="inswf" placeholder="Insert Workflow">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="addonwhere"><?php echo $this->getCatalog('addonwhere')?></label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" rows="5" name="addonwhere" placeholder="Add On Where"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="iswrite"><?php echo $this->getCatalog('iswrite')?></label>
				<div class="col-sm-8">
					<input type="checkbox" name="iswrite">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="ispurge"><?php echo $this->getCatalog('ispurge')?></label>
				<div class="col-sm-8">
					<input type="checkbox" name="ispurge">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="isreject"><?php echo $this->getCatalog('isreject')?></label>
				<div class="col-sm-8">
					<input type="checkbox" name="isreject">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="ispost"><?php echo $this->getCatalog('ispost')?></label>
				<div class="col-sm-8">
					<input type="checkbox" name="ispost">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="isdownload"><?php echo $this->getCatalog('isdownload')?></label>
				<div class="col-sm-8">
					<input type="checkbox" name="isdownload">
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab3">
			<button name="GenerateButton" type="button" class="btn btn-primary" onclick="readfield()"><?php echo $this->getCatalog('gettable')?></button>
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>1,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'rowCssClassExpression'=>'
			($data["tablerelation"] !== "")?"warning":"success"
		',
		'columns'=>array(
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:80px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>'true',
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(2)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(2)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('menugenid'),
				'name'=>'menugenid',
				'value'=>'$data["menugenid"]'
			),
			array(
				'header'=>$this->getCatalog('tablename'),
				'name'=>'tablename',
				'value'=>'$data["tablename"]'
			),
			array(
				'header'=>$this->getCatalog('namafield'),
				'name'=>'namafield',
				'value'=>'$data["namafield"]'
			),
			array(
				'header'=>$this->getCatalog('defaultvalue'),
				'name'=>'defaultvalue',
				'value'=>'$data["defaultvalue"]'
			),
			array(
				'header'=>$this->getCatalog('tipefield'),
				'name'=>'tipefield',
				'value'=>'$data["tipefield"]'
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isview',
				'header'=>$this->getCatalog('isview'),
				'selectableRows'=>'0',
				'checked'=>'$data["isview"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'issearch',
				'header'=>$this->getCatalog('issearch'),
				'selectableRows'=>'0',
				'checked'=>'$data["issearch"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isinput',
				'header'=>$this->getCatalog('isinput'),
				'selectableRows'=>'0',
				'checked'=>'$data["isinput"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isvalidate',
				'header'=>$this->getCatalog('isvalidate'),
				'selectableRows'=>'0',
				'checked'=>'$data["isvalidate"]',
			),
			array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isprint',
				'header'=>$this->getCatalog('isprint'),
				'selectableRows'=>'0',
				'checked'=>'$data["isprint"]',
			),
			array(
				'header'=>$this->getCatalog('widgetrelation'),
				'name'=>'widgetrelation',
				'value'=>'$data["widgetrelation"]'
			),
			array(
				'header'=>$this->getCatalog('tablerelation'),
				'name'=>'tablerelation',
				'value'=>'$data["tablerelation"]'
			),
			array(
				'header'=>$this->getCatalog('tablefkname'),
				'name'=>'tablefkname',
				'value'=>'$data["tablefkname"]'
			),
			array(
				'header'=>$this->getCatalog('relationname'),
				'name'=>'relationname',
				'value'=>'$data["relationname"]'
			),
		)
));
?>
		</div>
		<div class="tab-pane" id="tab4">
			<div class="container">
				<div class="jumbotron">
					<h1>Hampir Selesai .... </h1> 
					<p>Klik tombol Generate untuk melakukan generator code</p> 
				</div>
				<a class="btn btn-info" href="#" onclick="install()">Generate</a>
			</div>
		</div>
		<div class="tab-pane" id="tab5">
			<div class="container">
				<div class="jumbotron">
					<h1>Selesai .... </h1> 
					<p>Silahkan klik menu hasil generate</p>
				</div>
			</div>
		</div>
		<ul class="pager wizard">
			<li class="previous first" style="display:none;"><a href="javascript:;">First</a></li>
			<li class="previous"><a href="javascript:;">Previous</a></li>
			<li class="next last" style="display:none;"><a href="javascript:;">Last</a></li>
				<li class="next"><a href="javascript:;">Next</a></li>
				<li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li>
		</ul>
	</div>
	</div>
			</form>
			                </div><!-- /.box-body -->
              </div><!-- /.box -->
			
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('menugenerator') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="menugenid">
				<div class="row">
					<div class="col-md-2">
						<label for="namafield"><?php echo $this->getCatalog('namafield')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="namafield">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="defaultvalue"><?php echo $this->getCatalog('defaultvalue')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="defaultvalue">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="tipefield"><?php echo $this->getCatalog('tipefield')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="tipefield">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="isview"><?php echo $this->getCatalog('isview')?></label>
					</div>
					<div class="col-md-10">
						<input type="checkbox" name="isview">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="issearch"><?php echo $this->getCatalog('issearch')?></label>
					</div>
					<div class="col-md-10">
						<input type="checkbox" name="issearch">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="isinput"><?php echo $this->getCatalog('isinput')?></label>
					</div>
					<div class="col-md-10">
						<input type="checkbox" name="isinput">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="isvalidate"><?php echo $this->getCatalog('isvalidate')?></label>
					</div>
					<div class="col-md-10">
						<input type="checkbox" name="isvalidate">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="isprint"><?php echo $this->getCatalog('isprint')?></label>
					</div>
					<div class="col-md-10">
						<input type="checkbox" name="isprint">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="widgetrelation"><?php echo $this->getCatalog('widgetrelation')?></label>
					</div>
					<div class="col-md-10">
						<select class="form-control" name="widgetrelation">
						<option value=""></option>
						<?php 
						foreach (glob(Yii::getPathOfAlias('webroot').'/protected/modules/*', GLOB_BRACE) as $moduleDirectory) {
							foreach (glob($moduleDirectory.'/components/views/*') as $popfile) {
								if (strpos($popfile,'PopUp') > 0)
								{
									$s = str_replace(Yii::getPathOfAlias('webroot').'/protected/modules/','',$popfile);
									$s = str_replace('.php','',$s);
									$s = str_replace('/','.',$s);
									$s = str_replace(' ','.',$s);
						echo "<option value=\"".$s."\">".$s."</option>";
								}
							}
		}?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="tablerelation"><?php echo $this->getCatalog('tablerelation')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="tablerelation">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="tablefkname"><?php echo $this->getCatalog('tablefkname')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="tablefkname">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="relationname"><?php echo $this->getCatalog('relationname')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="relationname">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="popupname"><?php echo $this->getCatalog('popupname')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="popupname">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="wirelsource"><?php echo $this->getCatalog('wirelsource')?></label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control" name="wirelsource">
					</div>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">File Manager</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <?php
$this->widget('ext.elFinder.ElFinderWidget', array(
	'connectorRoute' => 'admin/menugenerator/connector',
	)
);
?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
