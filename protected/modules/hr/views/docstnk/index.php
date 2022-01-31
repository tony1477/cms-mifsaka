<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/docstnk/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='docstnk_0_docid']").val(data.docid);
			$("input[name='docstnk_0_namedoc']").val('');
      $("input[name='docstnk_0_nodoc']").val('');
      $("input[name='docstnk_0_exdate']").val(data.exdate);
      $("input[name='docstnk_0_cost']").val('');
      $("input[name='docstnk_0_docupload']").val('');
      $("input[name='docstnk_0_companyname']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/docstnk/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='docstnk_0_docid']").val(data.docid);
				$("input[name='docstnk_0_namedoc']").val(data.namedoc);
      $("input[name='docstnk_0_nodoc']").val(data.nodoc);
      $("input[name='docstnk_0_exdate']").val(data.exdate);
      $("input[name='docstnk_0_cost']").val(data.cost);
      $("input[name='docstnk_0_docupload']").val(data.docupload);
      $("input[name='docstnk_0_companyname']").val(data.companyname);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/docstnk/save')?>',
		'data':{
			'docid':$("input[name='docstnk_0_docid']").val(),
			'namedoc':$("input[name='docstnk_0_namedoc']").val(),
      'nodoc':$("input[name='docstnk_0_nodoc']").val(),
      'exdate':$("input[name='docstnk_0_exdate']").val(),
      'cost':$("input[name='docstnk_0_cost']").val(),
      'docupload':$("input[name='docstnk_0_docupload']").val(),
      'companyid':$("input[name='docstnk_0_companyid']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/docstnk/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/docstnk/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/docstnk/purge')?>','data':{'id':$id},
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
	var array = 'docstnk_0_docid='+$id
+ '&namedoc='+$("input[name='dlg_search_namedoc']").val()
+ '&nodoc='+$("input[name='dlg_search_nodoc']").val()
+ '&cost='+$("input[name='dlg_search_cost']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'docstnk_0_docid='+$id
+ '&namedoc='+$("input[name='dlg_search_namedoc']").val();
+ '&nodoc='+$("input[name='dlg_search_nodoc']").val();
+ '&cost='+$("input[name='dlg_search_cost']").val();
+ '&docupload='+$("input[name='dlg_search_docupload']").val();

	window.open('<?php echo Yii::app()->createUrl('hr/docstnk/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'docstnk_0_docid='+$id
+ '&namedoc='+$("input[name='dlg_search_namedoc']").val();
+ '&nodoc='+$("input[name='dlg_search_nodoc']").val();
+ '&cost='+$("input[name='dlg_search_cost']").val();
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('hr/docstnk/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'docid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('docstnk') ?></h3>
<?php if ($this->checkAccess('docstnk','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('docstnk','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('docstnk','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('docstnk','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('docstnk','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('Docstnk','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('Docstnk','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('Docstnk','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('Docstnk','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('Docstnk','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('docid'),
					'name'=>'docid',
					'value'=>'$data["docid"]'
				),
							array(
					'header'=>$this->getCatalog('namedoc'),
					'name'=>'namedoc',
					'value'=>'$data["namedoc"]'
				),
							array(
					'header'=>$this->getCatalog('nodoc'),
					'name'=>'nodoc',
					'value'=>'$data["nodoc"]'
				),
							array(
					'header'=>$this->getCatalog('exdate'),
					'name'=>'exdate',
					'value'=>'Yii::app()->format->formatDate($data["exdate"])'
				),
							array(
					'header'=>$this->getCatalog('cost'),
					'name'=>'cost',
					'value'=>'$data["cost"]'
				),
						array(
					'header'=>$this->getCatalog('docupload'),
					'name'=>'docupload',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/dokumenstnk/".$data["docupload"],$data["docupload"],
					array("width"=>"100"))'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
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
						<label for="dlg_search_namedoc"><?php echo $this->getCatalog('namedoc')?></label>
						<input type="text" class="form-control" name="dlg_search_namedoc">
					</div>
          <div class="form-group">
						<label for="dlg_search_nodoc"><?php echo $this->getCatalog('nodoc')?></label>
						<input type="text" class="form-control" name="dlg_search_nodoc">
					</div>
          <div class="form-group">
						<label for="dlg_search_cost"><?php echo $this->getCatalog('cost')?></label>
						<input type="text" class="form-control" name="dlg_search_cost">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('Docstnk') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="docstnk_0_docid">
           <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'docstnk_0_companyid','ColField'=>'docstnk_0_companyname',
							'IDDialog'=>'docstnk_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'docstnk_0_companyidgrid')); 
					?>
        <div class="row">
						<div class="col-md-4">
							<label for="docstnk_0_namedoc"><?php echo $this->getCatalog('namedoc')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="docstnk_0_namedoc">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="docstnk_0_nodoc"><?php echo $this->getCatalog('nodoc')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="docstnk_0_nodoc">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="docstnk_0_exdate"><?php echo $this->getCatalog('exdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="docstnk_0_exdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="docstnk_0_cost"><?php echo $this->getCatalog('cost')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="docstnk_0_cost">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="docstnk_0_docupload"><?php echo $this->getCatalog('docupload')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="docstnk_0_docupload">
						</div>
					</div>
           <script>
				function successUp(param,param2,param3)
				{
					$('input[name="docstnk_0_docupload"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('hr/docstnk/upload'),
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


