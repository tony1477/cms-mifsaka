<script type="text/javascript">






function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'reportperday_0_reportperdayid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&fulldivision='+$("input[name='dlg_search_fulldivision']").val()
+ '&absdate='+$("input[name='dlg_search_absdate']").val()
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'reportperday_0_reportperdayid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&fulldivision='+$("input[name='dlg_search_fulldivision']").val()
+ '&absdate='+$("input[name='dlg_search_absdate']").val()

	window.open('<?php echo Yii::app()->createUrl('Hr/reportperday/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'reportperday_0_reportperdayid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&fulldivision='+$("input[name='dlg_search_fulldivision']").val()
+ '&absdate='+$("input[name='dlg_search_absdate']").val()
	window.open('<?php echo Yii::app()->createUrl('Hr/reportperday/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'reportperdayid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('reportperday') ?></h3>


<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('reportperday','isdownload')) { ?>
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
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('reportperday','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('reportperday','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('reportperdayid'),
					'name'=>'reportperdayid',
					'value'=>'$data["reportperdayid"]'
				),
							array(
					'header'=>$this->getCatalog('employeeid'),
					'name'=>'employeeid',
					'value'=>'$data["employeeid"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'fullname',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('oldnik'),
					'name'=>'oldnik',
					'value'=>'$data["oldnik"]'
				),
							array(
					'header'=>$this->getCatalog('fulldivision'),
					'name'=>'fulldivision',
					'value'=>'$data["fulldivision"]'
				),
							array(
					'header'=>$this->getCatalog('absdate'),
					'name'=>'absdate',
					'value'=>'$data["absdate"]'
				),
							array(
					'header'=>$this->getCatalog('hourin'),
					'name'=>'hourin',
					'value'=>'$data["hourin"]'
				),
							array(
					'header'=>$this->getCatalog('hourout'),
					'name'=>'hourout',
					'value'=>'$data["hourout"]'
				),
							array(
					'header'=>$this->getCatalog('schedulename'),
					'name'=>'schedulename',
					'value'=>'$data["schedulename"]'
				),
							array(
					'header'=>$this->getCatalog('statusin'),
					'name'=>'statusin',
					'value'=>'$data["statusin"]'
				),
							array(
					'header'=>$this->getCatalog('statusout'),
					'name'=>'statusout',
					'value'=>'$data["statusout"]'
				),
							array(
					'header'=>$this->getCatalog('reason'),
					'name'=>'reason',
					'value'=>'$data["reason"]'
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
          <div class="form-group">
						<label for="dlg_search_oldnik"><?php echo $this->getCatalog('oldnik')?></label>
						<input type="text" class="form-control" name="dlg_search_oldnik">
					</div>
          <div class="form-group">
						<label for="dlg_search_fulldivision"><?php echo $this->getCatalog('fulldivision')?></label>
						<input type="text" class="form-control" name="dlg_search_fulldivision">
					</div>
            <div class="form-group">
						<label for="dlg_search_absdate"><?php echo $this->getCatalog('absdate')?></label>
						<input type="text" class="form-control" name="dlg_search_absdate">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('reportperday') ?></h4>
      </div>
      <div class="modal-body">
				
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


