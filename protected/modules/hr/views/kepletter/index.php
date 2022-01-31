<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/kepletter/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='kepletter_0_kepletterid']").val(data.kepletterid);
			$("input[name='kepletter_0_nosuid']").val('');
      $("input[name='kepletter_0_kopletter']").val('');
      $("input[name='kepletter_0_companyname']").val('');
      $("input[name='kepletter_0_dateletter']").val(data.dateletter);
      $("input[name='kepletter_0_docupload']").val('');
			
			$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/kepletter/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='kepletter_0_kepletterid']").val(data.kepletterid);
				$("input[name='kepletter_0_nosuid']").val(data.nosuid);
      $("input[name='kepletter_0_kopletter']").val(data.kopletter);
      $("input[name='kepletter_0_companyname']").val(data.companyname);
      $("input[name='kepletter_0_dateletter']").val(data.dateletter);
      $("input[name='kepletter_0_docupload']").val(data.docupload);
				
				$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function savedata()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/kepletter/save')?>',
		'data':{
			'kepletterid':$("input[name='kepletter_0_kepletterid']").val(),
			'nosuid':$("input[name='kepletter_0_nosuid']").val(),
      'kopletter':$("input[name='kepletter_0_kopletter']").val(),
            'companyid':$("input[name='kepletter_0_companyid']").val(),
      'dateletter':$("input[name='kepletter_0_dateletter']").val(),
      'docupload':$("input[name='kepletter_0_docupload']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/kepletter/approve')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/kepletter/delete')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});});
	return false;
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/kepletter/purge')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	});
	return false;
}

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'kepletter_0_kepletterid='+$id
    + '&kopletter='+$("input[name='dlg_search_kopletter']").val()
 + '&nosuid='+$("input[name='dlg_search_nosuid']").val()    
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'kepletterid='+$id
+ '&kopletter='+$("input[name='dlg_search_kopletter']").val(); 
+ '&nosuid='+$("input[name='dlg_search_nosuid']").val();     
    
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('hr/kepletter/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'kepletterid='+$id
    + '&kopletter='+$("input[name='dlg_search_kopletter']").val(); 
+ '&nosuid='+$("input[name='dlg_search_nosuid']").val();  
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('hr/kepletter/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'kepletterid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('kepletter') ?></h3>
<?php if ($this->checkAccess('kepletter','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('kepletter','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('kepletter','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('kepletter','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('kepletter','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('kepletter','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('kepletter','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('kepletter','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('kepletter','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('kepletter','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('kepletterid'),
					'name'=>'kepletterid',
					'value'=>'$data["kepletterid"]'
				),
							array(
					'header'=>$this->getCatalog('nosuid'),
					'name'=>'nosuid',
					'value'=>'$data["nosuid"]'
				),
							array(
					'header'=>$this->getCatalog('kopletter'),
					'name'=>'kopletter',
					'value'=>'$data["kopletter"]'
				),
            
                array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('dateletter'),
					'name'=>'dateletter',
					'value'=>'Yii::app()->format->formatDate($data["dateletter"])'
				),
							array(
					'header'=>$this->getCatalog('docupload'),
					'name'=>'docupload',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/suratkeputusan/".$data["docupload"],$data["docupload"],
					array("width"=>"100"))'
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
						<label for="dlg_search_kopletter"><?php echo $this->getCatalog('kopletter')?></label>
						<input type="text" class="form-control" name="dlg_search_kopletter">
					</div>
                    <div class="form-group">
						<label for="dlg_search_nosuid"><?php echo $this->getCatalog('nosuid')?></label>
						<input type="text" class="form-control" name="dlg_search_nosuid">
					</div>
					<div class="form-group">
						<label for="dlg_search_docupload"><?php echo $this->getCatalog('docupload')?></label>
						<input type="text" class="form-control" name="dlg_search_docupload">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('kepletter') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="kepletter_0_kepletterid">
        <div class="row">
						<div class="col-md-4">
							<label for="kepletter_0_nosuid"><?php echo $this->getCatalog('nosuid')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="kepletter_0_nosuid">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="kepletter_0_kopletter"><?php echo $this->getCatalog('kopletter')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="kepletter_0_kopletter">
						</div>
					</div>
           <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'kepletter_0_companyid','ColField'=>'kepletter_0_companyname',
							'IDDialog'=>'kepletter_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'kepletter_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="kepletter_0_dateletter"><?php echo $this->getCatalog('dateletter')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="kepletter_0_dateletter">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="kepletter_0_docupload"><?php echo $this->getCatalog('docupload')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="kepletter_0_docupload">
						</div>
					</div>
							
				
      <script>
				function successUp(param,param2,param3)
				{
					$('input[name="kepletter_0_docupload"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('hr/kepletter/upload'),
						'mimeTypes' => array('.jpg','.png','.pdf'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


