<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transdoc_0_transdocid']").val(data.transdocid);
			$("input[name='transdoc_0_transdate']").val(data.transdate);
            $("input[name='transdoc_0_fromemployeeid']").val('');
            $("input[name='transdoc_0_toemployeeid']").val('');
            $("input[name='transdoc_0_docupload']").val('');
            $("input[name='transdoc_0_fullname']").val('');
            $("input[name='transdoc_0_fullname']").val('');
			$.fn.yiiGridView.update('transdocdetList',{data:{'transdocid':data.transdocid}});

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
function newdatatransdocdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/createtransdocdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transdocdet_1_transdocdetid']").val('');
            $("input[name='transdocdet_1_legaldocid']").val('');
            $("input[name='transdocdet_1_storagedocid']").val('');
            $("input[name='transdocdet_1_docname']").val('');
            $("input[name='transdocdet_1_storagedocname']").val('');
			$('#InputDialogtransdocdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transdoc_0_transdocid']").val(data.transdocid);
				$("input[name='transdoc_0_transdate']").val(data.transdate);
                $("input[name='transdoc_0_fromemployeeid']").val(data.fromemployeeid);
                $("input[name='transdoc_0_toemployeeid']").val(data.toemployeeid);
                $("input[name='transdoc_0_docupload']").val(data.docupload);
                $("input[name='transdoc_0_fromfullname']").val(data.fromfullname);
                $("input[name='transdoc_0_tofullname']").val(data.tofullname);
				$.fn.yiiGridView.update('transdocdetList',{data:{'transdocid':data.transdocid}});

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
function updatedatatransdocdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/updatetransdocdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transdocdet_1_transdocdetid']").val(data.transdocdetid);
            $("input[name='transdocdet_1_legaldocid']").val(data.legaldocid);
            $("input[name='transdocdet_1_storagedocid']").val(data.storagedocid);
            $("input[name='transdocdet_1_docname']").val(data.docname);
            $("input[name='transdocdet_1_storagedocname']").val(data.storagedocname);
			$('#InputDialogtransdocdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/save')?>',
		'data':{
			'transdocid':$("input[name='transdoc_0_transdocid']").val(),
			'transdate':$("input[name='transdoc_0_transdate']").val(),
            'fromemployeeid':$("input[name='transdoc_0_fromemployeeid']").val(),
            'toemployeeid':$("input[name='transdoc_0_toemployeeid']").val(),
            'docupload':$("input[name='transdoc_0_docupload']").val(),
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

function savedatatransdocdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/savetransdocdet')?>',
		'data':{
			'transdocid':$("input[name='transdoc_0_transdocid']").val(),
			'transdocdetid':$("input[name='transdocdet_1_transdocdetid']").val(),
            'legaldocid':$("input[name='transdocdet_1_legaldocid']").val(),
            'storagedocid':$("input[name='transdocdet_1_storagedocid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogtransdocdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("transdocdetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/purge')?>','data':{'id':$id},
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
function purgedatatransdocdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transdoc/purgetransdocdet')?>','data':{'id':$.fn.yiiGridView.getSelection("transdocdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("transdocdetList");
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
	var array = 'transdoc_0_transdocid='+$id
+ '&transdocno='+$("input[name='dlg_search_transdocno']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'transdoc_0_transdocid='+$id
+ '&transdocno='+$("input[name='dlg_search_transdocno']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('HR/transdoc/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'transdoc_0_transdocid='+$id
+ '&transdocno='+$("input[name='dlg_search_transdocno']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('HR/transdoc/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'transdocid='+$id
$.fn.yiiGridView.update("DetailtransdocdetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('transdoc') ?></h3>
<?php if ($this->checkAccess('transdoc','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('transdoc','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('transdoc','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('transdoc','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('transdoc','isdownload')) { ?>
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
				'template'=>'{select} {edit} {purge} {pdf}',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('detail'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'url'=>'"#"',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('transdoc','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('transdoc','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('transdoc','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('transdocid'),
					'name'=>'transdocid',
					'value'=>'$data["transdocid"]'
				),
							array(
					'header'=>$this->getCatalog('docno'),
					'name'=>'transdocno',
					'value'=>'$data["transdocno"]'
				),
							array(
					'header'=>$this->getCatalog('transdate'),
					'name'=>'transdate',
					'value'=>'Yii::app()->format->formatDate($data["transdate"])'
				),
							array(
					'header'=>$this->getCatalog('fromemployee'),
					'name'=>'fromemployeeid',
					'value'=>'$data["fromfullname"]'
				),
							array(
					'header'=>$this->getCatalog('toemployee'),
					'name'=>'toemployeeid',
					'value'=>'$data["tofullname"]'
				),
							array(
					'header'=>$this->getCatalog('docupload'),
					'name'=>'docupload',
					'value'=>'$data["docupload"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'recordstatus',
					'value'=>'$data["statusname"]'
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
						<label for="dlg_search_transdocno"><?php echo $this->getCatalog('transdocno')?></label>
						<input type="text" class="form-control" name="dlg_search_transdocno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('transdoc') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="transdoc_0_transdocid">
        <div class="row">
						<div class="col-md-4">
							<label for="transdoc_0_transdate"><?php echo $this->getCatalog('transdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="transdoc_0_transdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transdoc_0_fromemployeeid','ColField'=>'transdoc_0_fromfullname',
							'IDDialog'=>'transdoc_0_fromemployeeid_dialog','titledialog'=>$this->getCatalog('fromemployee'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'transdoc_0_fromemployeeidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transdoc_0_toemployeeid','ColField'=>'transdoc_0_tofullname',
							'IDDialog'=>'transdoc_0_toemployeeid_dialog','titledialog'=>$this->getCatalog('toemployee'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'transdoc_0_toemployeeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transdoc_0_docupload"><?php echo $this->getCatalog('docupload')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="transdoc_0_docupload" readonly="readonly">
						</div>
					</div>
           <script>
				function successUp(param,param2,param3)
				{
					$('input[name="transdoc_0_docupload"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('hr/transdoc/upload'),
						'mimeTypes' => array('.jpg','.png','.pdf'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#transdocdet"><?php echo $this->getCatalog("transdocdet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="transdocdet" class="tab-pane">
	<?php if ($this->checkAccess('transdoc','iswrite')) { ?>
<button name="CreateButtontransdocdet" type="button" class="btn btn-primary" onclick="newdatatransdocdet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('transdoc','ispurge')) { ?>
<button name="PurgeButtontransdocdet" type="button" class="btn btn-danger" onclick="purgedatatransdocdet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidertransdocdet,
		'id'=>'transdocdetList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('transdoc','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatatransdocdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('transdoc','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatatransdocdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('transdocdetid'),
					'name'=>'transdocdetid',
					'value'=>'$data["transdocdetid"]'
				),
							array(
					'header'=>$this->getCatalog('legaldoc'),
					'name'=>'legaldocid',
					'value'=>'$data["docname"]'
				),
							array(
					'header'=>$this->getCatalog('storagedoc'),
					'name'=>'storagedocid',
					'value'=>'$data["storagedocname"]'
				),
							
		)
));
?>
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

<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
				<div class="modal-body">
			<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('transdocdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidertransdocdet,
		'id'=>'DetailtransdocdetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('transdocdetid'),
					'name'=>'transdocdetid',
					'value'=>'$data["transdocdetid"]'
				),
							array(
					'header'=>$this->getCatalog('legaldoc'),
					'name'=>'legaldocid',
					'value'=>'$data["docname"]'
				),
							array(
					'header'=>$this->getCatalog('storagedoc'),
					'name'=>'storagedocid',
					'value'=>'$data["storagedocname"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogtransdocdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('transdocdet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="transdocdet_1_transdocdetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transdocdet_1_legaldocid','ColField'=>'transdocdet_1_docname',
							'IDDialog'=>'transdocdet_1_legaldocid_dialog','titledialog'=>$this->getCatalog('legaldoc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.LegaldocPopUp','PopGrid'=>'transdocdet_1_legaldocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transdocdet_1_storagedocid','ColField'=>'transdocdet_1_storagedocname',
							'IDDialog'=>'transdocdet_1_storagedocid_dialog','titledialog'=>$this->getCatalog('storagedoc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.StoragedocPopUp','PopGrid'=>'transdocdet_1_storagedocidgrid')); 
					?>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatatransdocdet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			