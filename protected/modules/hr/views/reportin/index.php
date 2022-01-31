<script type="text/javascript">






function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'reportin_0_reportinid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&fulldivision='+$("input[name='dlg_search_fulldivision']").val()
+ '&month='+$("input[name='dlg_search_month']").val()
+ '&year='+$("input[name='dlg_search_year']").val()
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'reportin_0_reportinid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&fulldivision='+$("input[name='dlg_search_fulldivision']").val()
+ '&month='+$("input[name='dlg_search_month']").val()
+ '&year='+$("input[name='dlg_search_year']").val()

	window.open('<?php echo Yii::app()->createUrl('Hr/reportin/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'reportin_0_reportinid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&fulldivision='+$("input[name='dlg_search_fulldivision']").val()
+ '&month='+$("input[name='dlg_search_month']").val()
+ '&year='+$("input[name='dlg_search_year']").val()
	window.open('<?php echo Yii::app()->createUrl('Hr/reportin/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'reportinid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('reportin') ?></h3>


<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('reportin','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('reportin','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('reportin','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('reportinid'),
					'name'=>'reportinid',
					'value'=>'$data["reportinid"]'
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
					'header'=>$this->getCatalog('month'),
					'name'=>'month',
					'value'=>'$data["month"]'
				),
							array(
					'header'=>$this->getCatalog('year'),
					'name'=>'year',
					'value'=>'$data["year"]'
				),
							array(
					'header'=>$this->getCatalog('s1'),
					'name'=>'s1',
					'value'=>'$data["s1"]'
				),
							array(
					'header'=>$this->getCatalog('d1'),
					'name'=>'d1',
					'value'=>'$data["d1"]'
				),
							array(
					'header'=>$this->getCatalog('s2'),
					'name'=>'s2',
					'value'=>'$data["s2"]'
				),
							array(
					'header'=>$this->getCatalog('d2'),
					'name'=>'d2',
					'value'=>'$data["d2"]'
				),
							array(
					'header'=>$this->getCatalog('s3'),
					'name'=>'s3',
					'value'=>'$data["s3"]'
				),
							array(
					'header'=>$this->getCatalog('d3'),
					'name'=>'d3',
					'value'=>'$data["d3"]'
				),
							array(
					'header'=>$this->getCatalog('s4'),
					'name'=>'s4',
					'value'=>'$data["s4"]'
				),
							array(
					'header'=>$this->getCatalog('d4'),
					'name'=>'d4',
					'value'=>'$data["d4"]'
				),
							array(
					'header'=>$this->getCatalog('s5'),
					'name'=>'s5',
					'value'=>'$data["s5"]'
				),
							array(
					'header'=>$this->getCatalog('d5'),
					'name'=>'d5',
					'value'=>'$data["d5"]'
				),
							array(
					'header'=>$this->getCatalog('s6'),
					'name'=>'s6',
					'value'=>'$data["s6"]'
				),
							array(
					'header'=>$this->getCatalog('d6'),
					'name'=>'d6',
					'value'=>'$data["d6"]'
				),
							array(
					'header'=>$this->getCatalog('s7'),
					'name'=>'s7',
					'value'=>'$data["s7"]'
				),
							array(
					'header'=>$this->getCatalog('d7'),
					'name'=>'d7',
					'value'=>'$data["d7"]'
				),
							array(
					'header'=>$this->getCatalog('s8'),
					'name'=>'s8',
					'value'=>'$data["s8"]'
				),
							array(
					'header'=>$this->getCatalog('d8'),
					'name'=>'d8',
					'value'=>'$data["d8"]'
				),
							array(
					'header'=>$this->getCatalog('s9'),
					'name'=>'s9',
					'value'=>'$data["s9"]'
				),
							array(
					'header'=>$this->getCatalog('d9'),
					'name'=>'d9',
					'value'=>'$data["d9"]'
				),
							array(
					'header'=>$this->getCatalog('s10'),
					'name'=>'s10',
					'value'=>'$data["s10"]'
				),
							array(
					'header'=>$this->getCatalog('d10'),
					'name'=>'d10',
					'value'=>'$data["d10"]'
				),
							array(
					'header'=>$this->getCatalog('s11'),
					'name'=>'s11',
					'value'=>'$data["s11"]'
				),
							array(
					'header'=>$this->getCatalog('d11'),
					'name'=>'d11',
					'value'=>'$data["d11"]'
				),
							array(
					'header'=>$this->getCatalog('s12'),
					'name'=>'s12',
					'value'=>'$data["s12"]'
				),
							array(
					'header'=>$this->getCatalog('d12'),
					'name'=>'d12',
					'value'=>'$data["d12"]'
				),
							array(
					'header'=>$this->getCatalog('s13'),
					'name'=>'s13',
					'value'=>'$data["s13"]'
				),
							array(
					'header'=>$this->getCatalog('d13'),
					'name'=>'d13',
					'value'=>'$data["d13"]'
				),
							array(
					'header'=>$this->getCatalog('s14'),
					'name'=>'s14',
					'value'=>'$data["s14"]'
				),
							array(
					'header'=>$this->getCatalog('d14'),
					'name'=>'d14',
					'value'=>'$data["d14"]'
				),
							array(
					'header'=>$this->getCatalog('s15'),
					'name'=>'s15',
					'value'=>'$data["s15"]'
				),
							array(
					'header'=>$this->getCatalog('d15'),
					'name'=>'d15',
					'value'=>'$data["d15"]'
				),
							array(
					'header'=>$this->getCatalog('s16'),
					'name'=>'s16',
					'value'=>'$data["s16"]'
				),
							array(
					'header'=>$this->getCatalog('d16'),
					'name'=>'d16',
					'value'=>'$data["d16"]'
				),
							array(
					'header'=>$this->getCatalog('s17'),
					'name'=>'s17',
					'value'=>'$data["s17"]'
				),
							array(
					'header'=>$this->getCatalog('d17'),
					'name'=>'d17',
					'value'=>'$data["d17"]'
				),
							array(
					'header'=>$this->getCatalog('s18'),
					'name'=>'s18',
					'value'=>'$data["s18"]'
				),
							array(
					'header'=>$this->getCatalog('d18'),
					'name'=>'d18',
					'value'=>'$data["d18"]'
				),
							array(
					'header'=>$this->getCatalog('s19'),
					'name'=>'s19',
					'value'=>'$data["s19"]'
				),
							array(
					'header'=>$this->getCatalog('d19'),
					'name'=>'d19',
					'value'=>'$data["d19"]'
				),
							array(
					'header'=>$this->getCatalog('s20'),
					'name'=>'s20',
					'value'=>'$data["s20"]'
				),
							array(
					'header'=>$this->getCatalog('d20'),
					'name'=>'d20',
					'value'=>'$data["d20"]'
				),
							array(
					'header'=>$this->getCatalog('s21'),
					'name'=>'s21',
					'value'=>'$data["s21"]'
				),
							array(
					'header'=>$this->getCatalog('d21'),
					'name'=>'d21',
					'value'=>'$data["d21"]'
				),
							array(
					'header'=>$this->getCatalog('s22'),
					'name'=>'s22',
					'value'=>'$data["s22"]'
				),
							array(
					'header'=>$this->getCatalog('d22'),
					'name'=>'d22',
					'value'=>'$data["d22"]'
				),
							array(
					'header'=>$this->getCatalog('s23'),
					'name'=>'s23',
					'value'=>'$data["s23"]'
				),
							array(
					'header'=>$this->getCatalog('d23'),
					'name'=>'d23',
					'value'=>'$data["d23"]'
				),
							array(
					'header'=>$this->getCatalog('s24'),
					'name'=>'s24',
					'value'=>'$data["s24"]'
				),
							array(
					'header'=>$this->getCatalog('d24'),
					'name'=>'d24',
					'value'=>'$data["d24"]'
				),
							array(
					'header'=>$this->getCatalog('s25'),
					'name'=>'s25',
					'value'=>'$data["s25"]'
				),
							array(
					'header'=>$this->getCatalog('d25'),
					'name'=>'d25',
					'value'=>'$data["d25"]'
				),
							array(
					'header'=>$this->getCatalog('s26'),
					'name'=>'s26',
					'value'=>'$data["s26"]'
				),
							array(
					'header'=>$this->getCatalog('d26'),
					'name'=>'d26',
					'value'=>'$data["d26"]'
				),
							array(
					'header'=>$this->getCatalog('s27'),
					'name'=>'s27',
					'value'=>'$data["s27"]'
				),
							array(
					'header'=>$this->getCatalog('d27'),
					'name'=>'d27',
					'value'=>'$data["d27"]'
				),
							array(
					'header'=>$this->getCatalog('s28'),
					'name'=>'s28',
					'value'=>'$data["s28"]'
				),
							array(
					'header'=>$this->getCatalog('d28'),
					'name'=>'d28',
					'value'=>'$data["d28"]'
				),
							array(
					'header'=>$this->getCatalog('s29'),
					'name'=>'s29',
					'value'=>'$data["s29"]'
				),
							array(
					'header'=>$this->getCatalog('d29'),
					'name'=>'d29',
					'value'=>'$data["d29"]'
				),
							array(
					'header'=>$this->getCatalog('s30'),
					'name'=>'s30',
					'value'=>'$data["s30"]'
				),
							array(
					'header'=>$this->getCatalog('d30'),
					'name'=>'d30',
					'value'=>'$data["d30"]'
				),
							array(
					'header'=>$this->getCatalog('s31'),
					'name'=>'s31',
					'value'=>'$data["s31"]'
				),
							array(
					'header'=>$this->getCatalog('d31'),
					'name'=>'d31',
					'value'=>'$data["d31"]'
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
						<label for="dlg_search_month"><?php echo $this->getCatalog('month')?></label>
						<input type="text" class="form-control" name="dlg_search_month">
					</div>
            <div class="form-group">
						<label for="dlg_search_year"><?php echo $this->getCatalog('year')?></label>
						<input type="text" class="form-control" name="dlg_search_year">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('reportin') ?></h4>
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


