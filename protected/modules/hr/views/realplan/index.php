<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/realplan/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='realplan_0_realplanid']").val(data.realplanid);
			$("input[name='realplan_0_empplanid']").val(data.empplanid);
            $("input[name='realplan_0_employeeid']").val(data.employeeid);
            $("textarea[name='realplan_0_description']").val(data.description);
            $("input[name='realplan_0_objvalue']").val(data.objvalue);
            $("input[name='realplan_0_empplanname']").val(data.empplanname);
            $("input[name='realplan_0_fullname']").val(data.fullname);
            $("input[name='realplan_0_realdate']").val(data.realdate);
            $("input[name='realplan_0_dateline']").val(data.dateline);
            $("textarea[name='realplan_0_hambatan']").val(data.hambatan);
            $("textarea[name='realplan_0_solusi']").val(data.solusi);
            $("input[name='realplan_0_foto']").val(data.foto);
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/realplan/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='realplan_0_realplanid']").val(data.realplanid);
			$("input[name='realplan_0_empplanid']").val(data.empplanid);
			$("input[name='realplan_0_empplandetailid']").val(data.empplandetailid);
			$("input[name='realplan_0_empplandetail']").val(data.empplandetail);
            $("input[name='realplan_0_employeeid']").val(data.employeeid);
            $("textarea[name='realplan_0_description']").val(data.description);
            $("input[name='realplan_0_objvalue']").val(data.objvalue);
            $("input[name='realplan_0_empplanname']").val(data.empplanname);
            $("input[name='realplan_0_fullname']").val(data.fullname);
            $("input[name='realplan_0_realdate']").val(data.realdate);
            $("input[name='realplan_0_dateline']").val(data.dateline);
            $("textarea[name='realplan_0_hambatan']").val(data.hambatan);
            $("textarea[name='realplan_0_solusi']").val(data.solusi);
            $("input[name='realplan_0_foto']").val(data.foto);
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/realplan/save')?>',
		'data':{
			'realplanid':$("input[name='realplan_0_realplanid']").val(),
			'empplanid':$("input[name='realplan_0_empplanid']").val(),
			'empplandetailid':$("input[name='realplan_0_empplandetailid']").val(),
            'employeeid':$("input[name='realplan_0_employeeid']").val(),
            'realdate':$("input[name='realplan_0_realdate']").val(),
            'dateline':$("input[name='realplan_0_dateline']").val(),
            'hambatan':$("textarea[name='realplan_0_hambatan']").val(),
            'solusi':$("textarea[name='realplan_0_solusi']").val(),
            'foto':$("input[name='realplan_0_foto']").val(),
            'description':$("textarea[name='realplan_0_description']").val(),
            'objvalue':$("input[name='realplan_0_objvalue']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/realplan/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/realplan/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/realplan/purge')?>','data':{'id':$id},
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
	var array = 'realplan_0_realplanid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'realplanid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/realplan/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'realplan_0_realplanid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/realplan/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'realplanid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('realplan') ?></h3>
<?php if ($this->checkAccess('realplan','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('realplan','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('realplan','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('realplan','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('realplan','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('realplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('realplan','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('realplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('realplan','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('realplan','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('realplanid'),
					'name'=>'realplanid',
					'value'=>'$data["realplanid"]'
				),
							array(
					'header'=>$this->getCatalog('empplanname'),
					'name'=>'empplanid',
					'value'=>'$data["empplanname"]'
				),
            
                            array(
					'header'=>$this->getCatalog('empplandetail'),
					'name'=>'empplandetail',
					'value'=>'$data["empplandetail"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
                            array(
					'header'=>$this->getCatalog('realdate'),
					'name'=>'realdate',
					'value'=>'$data["realdate"]'
				),
							array(
					'header'=>$this->getCatalog('realdesc'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('objvalue'),
					'name'=>'objvalue',
					'value'=>'Yii::app()->format->formatNumber($data["objvalue"])'
				),
                        	array(
					'header'=>$this->getCatalog('hambatan'),
					'name'=>'hambatan',
					'value'=>'$data["hambatan"]'
				),
                        	array(
					'header'=>$this->getCatalog('solusi'),
					'name'=>'solusi',
					'value'=>'$data["solusi"]'
				),
                          	array(
					'header'=>$this->getCatalog('dateline'),
					'name'=>'dateline',
					'value'=>'$data["dateline"]'
				),
                         array(
					'header'=>$this->getCatalog('foto'),
					'name'=>'foto',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/employee/".$data["foto"],$data["foto"],
					array("width"=>"100"))'
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

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('realplan') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="realplan_0_realplanid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'realplan_0_empplanid','ColField'=>'realplan_0_empplanname',
							'IDDialog'=>'realplan_0_empplanid_dialog','titledialog'=>$this->getCatalog('empplanname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePlanUserPopUp','PopGrid'=>'realplan_0_empplanidgrid')); 
					?>
          
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'realplan_0_empplandetailid','ColField'=>'realplan_0_description',
							'IDDialog'=>'realplan_0_empplandetailid_dialog','titledialog'=>$this->getCatalog('empplandetail'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'realplan_0_empplanid',
							'PopUpName'=>'hr.components.views.EmployeePlandetailPopUp','PopGrid'=>'realplan_0_empplandetailidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'realplan_0_employeeid','ColField'=>'realplan_0_fullname',
							'IDDialog'=>'realplan_0_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'realplan_0_employeeidgrid')); 
					?>
          <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_realdate"><?php echo $this->getCatalog('realdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="realplan_0_realdate">
						</div>
					</div>         
        <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_description"><?php echo $this->getCatalog('realdesc')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="realplan_0_description"></textarea>
						</div>
					</div>					
        <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_objvalue"><?php echo $this->getCatalog('objvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="realplan_0_objvalue">
						</div>
					</div>
           <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_hambatan"><?php echo $this->getCatalog('hambatan')?></label>
						</div>
						<div class="col-md-8">
							<textarea  class="form-control" rows="5" name="realplan_0_hambatan"></textarea>
						</div>
					</div>
           <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_solusi"><?php echo $this->getCatalog('solusi')?></label>
						</div>
						<div class="col-md-8">
							<textarea  class="form-control" rows="5" name="realplan_0_solusi"></textarea>
						</div>
					</div>
          <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_dateline"><?php echo $this->getCatalog('dateline')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="realplan_0_dateline">
						</div>
					</div>
           					
        <div class="row">
						<div class="col-md-4">
							<label for="realplan_0_foto"><?php echo $this->getCatalog('foto')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="realplan_0_foto">
						</div>
					</div>
          <script>
				function successUp(param,param2,param3)
				{
					$('input[name="realplan_0_foto"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('hr/realplan/upload'),
						'mimeTypes' => array('.jpg','.png','.jpeg'),		
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


