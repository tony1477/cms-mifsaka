<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeeschedule/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeschedule_0_employeescheduleid']").val(data.employeescheduleid);
			$("input[name='employeeschedule_0_employeeid']").val('');
      $("input[name='employeeschedule_0_month']").val('');
      $("input[name='employeeschedule_0_year']").val('');
      $("input[name='employeeschedule_0_d1']").val('');
      $("input[name='employeeschedule_0_d2']").val('');
      $("input[name='employeeschedule_0_d3']").val('');
      $("input[name='employeeschedule_0_d4']").val('');
      $("input[name='employeeschedule_0_d5']").val('');
      $("input[name='employeeschedule_0_d6']").val('');
      $("input[name='employeeschedule_0_d7']").val('');
      $("input[name='employeeschedule_0_d8']").val('');
      $("input[name='employeeschedule_0_d9']").val('');
      $("input[name='employeeschedule_0_d10']").val('');
      $("input[name='employeeschedule_0_d11']").val('');
      $("input[name='employeeschedule_0_d12']").val('');
      $("input[name='employeeschedule_0_d13']").val('');
      $("input[name='employeeschedule_0_d14']").val('');
      $("input[name='employeeschedule_0_d15']").val('');
      $("input[name='employeeschedule_0_d16']").val('');
      $("input[name='employeeschedule_0_d17']").val('');
      $("input[name='employeeschedule_0_d18']").val('');
      $("input[name='employeeschedule_0_d19']").val('');
      $("input[name='employeeschedule_0_d20']").val('');
      $("input[name='employeeschedule_0_d21']").val('');
      $("input[name='employeeschedule_0_d22']").val('');
      $("input[name='employeeschedule_0_d23']").val('');
      $("input[name='employeeschedule_0_d24']").val('');
      $("input[name='employeeschedule_0_d25']").val('');
      $("input[name='employeeschedule_0_d26']").val('');
      $("input[name='employeeschedule_0_d27']").val('');
      $("input[name='employeeschedule_0_d28']").val('');
      $("input[name='employeeschedule_0_d29']").val('');
      $("input[name='employeeschedule_0_d30']").val('');
      $("input[name='employeeschedule_0_d31']").val('');
      $("input[name='employeeschedule_0_recordstatus']").val(data.recordstatus);
      $("input[name='employeeschedule_0_fullname']").val('');
      $("input[name='employeeschedule_0_d1name']").val('');
      $("input[name='employeeschedule_0_d2name']").val('');
      $("input[name='employeeschedule_0_d3name']").val('');
      $("input[name='employeeschedule_0_d4name']").val('');
      $("input[name='employeeschedule_0_d5name']").val('');
      $("input[name='employeeschedule_0_d6name']").val('');
      $("input[name='employeeschedule_0_d7name']").val('');
      $("input[name='employeeschedule_0_d8name']").val('');
      $("input[name='employeeschedule_0_d9name']").val('');
      $("input[name='employeeschedule_0_d10name']").val('');
      $("input[name='employeeschedule_0_d11name']").val('');
      $("input[name='employeeschedule_0_d12name']").val('');
      $("input[name='employeeschedule_0_d13name']").val('');
      $("input[name='employeeschedule_0_d14name']").val('');
      $("input[name='employeeschedule_0_d15name']").val('');
      $("input[name='employeeschedule_0_d16name']").val('');
      $("input[name='employeeschedule_0_d17name']").val('');
      $("input[name='employeeschedule_0_d18name']").val('');
      $("input[name='employeeschedule_0_d19name']").val('');
      $("input[name='employeeschedule_0_d20name']").val('');
      $("input[name='employeeschedule_0_d21name']").val('');
      $("input[name='employeeschedule_0_d22name']").val('');
      $("input[name='employeeschedule_0_d23name']").val('');
      $("input[name='employeeschedule_0_d24name']").val('');
      $("input[name='employeeschedule_0_d25name']").val('');
      $("input[name='employeeschedule_0_d26name']").val('');
      $("input[name='employeeschedule_0_d27name']").val('');
      $("input[name='employeeschedule_0_d28name']").val('');
      $("input[name='employeeschedule_0_d29name']").val('');
      $("input[name='employeeschedule_0_d30name']").val('');
      $("input[name='employeeschedule_0_d31name']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeeschedule/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeeschedule_0_employeescheduleid']").val(data.employeescheduleid);
				$("input[name='employeeschedule_0_employeeid']").val(data.employeeid);
      $("input[name='employeeschedule_0_month']").val(data.month);
      $("input[name='employeeschedule_0_year']").val(data.year);
      $("input[name='employeeschedule_0_d1']").val(data.d1);
      $("input[name='employeeschedule_0_d2']").val(data.d2);
      $("input[name='employeeschedule_0_d3']").val(data.d3);
      $("input[name='employeeschedule_0_d4']").val(data.d4);
      $("input[name='employeeschedule_0_d5']").val(data.d5);
      $("input[name='employeeschedule_0_d6']").val(data.d6);
      $("input[name='employeeschedule_0_d7']").val(data.d7);
      $("input[name='employeeschedule_0_d8']").val(data.d8);
      $("input[name='employeeschedule_0_d9']").val(data.d9);
      $("input[name='employeeschedule_0_d10']").val(data.d10);
      $("input[name='employeeschedule_0_d11']").val(data.d11);
      $("input[name='employeeschedule_0_d12']").val(data.d12);
      $("input[name='employeeschedule_0_d13']").val(data.d13);
      $("input[name='employeeschedule_0_d14']").val(data.d14);
      $("input[name='employeeschedule_0_d15']").val(data.d15);
      $("input[name='employeeschedule_0_d16']").val(data.d16);
      $("input[name='employeeschedule_0_d17']").val(data.d17);
      $("input[name='employeeschedule_0_d18']").val(data.d18);
      $("input[name='employeeschedule_0_d19']").val(data.d19);
      $("input[name='employeeschedule_0_d20']").val(data.d20);
      $("input[name='employeeschedule_0_d21']").val(data.d21);
      $("input[name='employeeschedule_0_d22']").val(data.d22);
      $("input[name='employeeschedule_0_d23']").val(data.d23);
      $("input[name='employeeschedule_0_d24']").val(data.d24);
      $("input[name='employeeschedule_0_d25']").val(data.d25);
      $("input[name='employeeschedule_0_d26']").val(data.d26);
      $("input[name='employeeschedule_0_d27']").val(data.d27);
      $("input[name='employeeschedule_0_d28']").val(data.d28);
      $("input[name='employeeschedule_0_d29']").val(data.d29);
      $("input[name='employeeschedule_0_d30']").val(data.d30);
      $("input[name='employeeschedule_0_d31']").val(data.d31);
      $("input[name='employeeschedule_0_recordstatus']").val(data.recordstatus);
      $("input[name='employeeschedule_0_fullname']").val(data.fullname);
      $("input[name='employeeschedule_0_d1name']").val(data.d1name);
      $("input[name='employeeschedule_0_d2name']").val(data.d2name)
      $("input[name='employeeschedule_0_d3name']").val(data.d3name)
      $("input[name='employeeschedule_0_d4name']").val(data.d4name)
      $("input[name='employeeschedule_0_d5name']").val(data.d5name)
      $("input[name='employeeschedule_0_d6name']").val(data.d6name)
      $("input[name='employeeschedule_0_d7name']").val(data.d7name)
      $("input[name='employeeschedule_0_d8name']").val(data.d8name)
      $("input[name='employeeschedule_0_d9name']").val(data.d9name)
      $("input[name='employeeschedule_0_d10name']").val(data.d10name)
      $("input[name='employeeschedule_0_d11name']").val(data.d11name)
      $("input[name='employeeschedule_0_d12name']").val(data.d12name)
      $("input[name='employeeschedule_0_d13name']").val(data.d13name)
      $("input[name='employeeschedule_0_d14name']").val(data.d14name)
      $("input[name='employeeschedule_0_d15name']").val(data.d15name)
      $("input[name='employeeschedule_0_d16name']").val(data.d16name)
      $("input[name='employeeschedule_0_d17name']").val(data.d17name)
      $("input[name='employeeschedule_0_d18name']").val(data.d18name)
      $("input[name='employeeschedule_0_d19name']").val(data.d19name)
      $("input[name='employeeschedule_0_d20name']").val(data.d20name)
      $("input[name='employeeschedule_0_d21name']").val(data.d21name)
      $("input[name='employeeschedule_0_d22name']").val(data.d22name)
      $("input[name='employeeschedule_0_d23name']").val(data.d23name)
      $("input[name='employeeschedule_0_d24name']").val(data.d24name)
      $("input[name='employeeschedule_0_d25name']").val(data.d25name)
      $("input[name='employeeschedule_0_d26name']").val(data.d26name)
      $("input[name='employeeschedule_0_d27name']").val(data.d27name)
      $("input[name='employeeschedule_0_d28name']").val(data.d28name)
      $("input[name='employeeschedule_0_d29name']").val(data.d29name)
      $("input[name='employeeschedule_0_d30name']").val(data.d30name)
      $("input[name='employeeschedule_0_d31name']").val(data.d31name)
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeeschedule/save')?>',
		'data':{
			'employeescheduleid':$("input[name='employeeschedule_0_employeescheduleid']").val(),
			'employeeid':$("input[name='employeeschedule_0_employeeid']").val(),
      'month':$("input[name='employeeschedule_0_month']").val(),
      'year':$("input[name='employeeschedule_0_year']").val(),
      'd1':$("input[name='employeeschedule_0_d1']").val(),
      'd2':$("input[name='employeeschedule_0_d2']").val(),
      'd3':$("input[name='employeeschedule_0_d3']").val(),
      'd4':$("input[name='employeeschedule_0_d4']").val(),
      'd5':$("input[name='employeeschedule_0_d5']").val(),
      'd6':$("input[name='employeeschedule_0_d6']").val(),
      'd7':$("input[name='employeeschedule_0_d7']").val(),
      'd8':$("input[name='employeeschedule_0_d8']").val(),
      'd9':$("input[name='employeeschedule_0_d9']").val(),
      'd10':$("input[name='employeeschedule_0_d10']").val(),
      'd11':$("input[name='employeeschedule_0_d11']").val(),
      'd12':$("input[name='employeeschedule_0_d12']").val(),
      'd13':$("input[name='employeeschedule_0_d13']").val(),
      'd14':$("input[name='employeeschedule_0_d14']").val(),
      'd15':$("input[name='employeeschedule_0_d15']").val(),
      'd16':$("input[name='employeeschedule_0_d16']").val(),
      'd17':$("input[name='employeeschedule_0_d17']").val(),
      'd18':$("input[name='employeeschedule_0_d18']").val(),
      'd19':$("input[name='employeeschedule_0_d19']").val(),
      'd20':$("input[name='employeeschedule_0_d20']").val(),
      'd21':$("input[name='employeeschedule_0_d21']").val(),
      'd22':$("input[name='employeeschedule_0_d22']").val(),
      'd23':$("input[name='employeeschedule_0_d23']").val(),
      'd24':$("input[name='employeeschedule_0_d24']").val(),
      'd25':$("input[name='employeeschedule_0_d25']").val(),
      'd26':$("input[name='employeeschedule_0_d26']").val(),
      'd27':$("input[name='employeeschedule_0_d27']").val(),
      'd28':$("input[name='employeeschedule_0_d28']").val(),
      'd29':$("input[name='employeeschedule_0_d29']").val(),
      'd30':$("input[name='employeeschedule_0_d30']").val(),
      'd31':$("input[name='employeeschedule_0_d31']").val(),
      'recordstatus':$("input[name='employeeschedule_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeeschedule/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeeschedule/delete')?>',
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


function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'employeescheduleid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'employeescheduleid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/employeeschedule/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'employeescheduleid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/employeeschedule/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'employeescheduleid='+$id
}
function running(id,param2)
{
	jQuery.ajax({'url':'employeeschedule/running',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.reload();
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
</script>
<h3><?php echo $this->getCatalog('employeeschedule') ?></h3>
<?php if ($this->checkAccess('employeeschedule','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('hr/employeeschedule/uploaddata'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('employeeschedule','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('employeeschedule','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('employeeschedule','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('employeeschedule','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('employeeschedule','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('employeeschedule','isreject')),							
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
							'visible'=>$this->booltostr($this->checkAccess('employeeschedule','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('employeeschedule','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('employeescheduleid'),
					'name'=>'employeescheduleid',
					'value'=>'$data["employeescheduleid"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
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
					'header'=>$this->getCatalog('d1'),
					'name'=>'d1',
					'value'=>'$data["d1name"]'
				),
							array(
					'header'=>$this->getCatalog('d2'),
					'name'=>'d2',
					'value'=>'$data["d2name"]'
				),
							array(
					'header'=>$this->getCatalog('d3'),
					'name'=>'d3',
					'value'=>'$data["d3name"]'
				),
							array(
					'header'=>$this->getCatalog('d4'),
					'name'=>'d4',
					'value'=>'$data["d4name"]'
				),
							array(
					'header'=>$this->getCatalog('d5'),
					'name'=>'d5',
					'value'=>'$data["d5name"]'
				),
							array(
					'header'=>$this->getCatalog('d6'),
					'name'=>'d6',
					'value'=>'$data["d6name"]'
				),
							array(
					'header'=>$this->getCatalog('d7'),
					'name'=>'d7',
					'value'=>'$data["d7name"]'
				),
							array(
					'header'=>$this->getCatalog('d8'),
					'name'=>'d8',
					'value'=>'$data["d8name"]'
				),
							array(
					'header'=>$this->getCatalog('d9'),
					'name'=>'d9',
					'value'=>'$data["d9name"]'
				),
							array(
					'header'=>$this->getCatalog('d10'),
					'name'=>'d10',
					'value'=>'$data["d10name"]'
				),
							array(
					'header'=>$this->getCatalog('d11'),
					'name'=>'d11',
					'value'=>'$data["d11name"]'
				),
							array(
					'header'=>$this->getCatalog('d12'),
					'name'=>'d12',
					'value'=>'$data["d12name"]'
				),
							array(
					'header'=>$this->getCatalog('d13'),
					'name'=>'d13',
					'value'=>'$data["d13name"]'
				),
							array(
					'header'=>$this->getCatalog('d14'),
					'name'=>'d14',
					'value'=>'$data["d14name"]'
				),
							array(
					'header'=>$this->getCatalog('d15'),
					'name'=>'d15',
					'value'=>'$data["d15name"]'
				),
							array(
					'header'=>$this->getCatalog('d16'),
					'name'=>'d16',
					'value'=>'$data["d16name"]'
				),
							array(
					'header'=>$this->getCatalog('d17'),
					'name'=>'d17',
					'value'=>'$data["d17name"]'
				),
							array(
					'header'=>$this->getCatalog('d18'),
					'name'=>'d18',
					'value'=>'$data["d18name"]'
				),
							array(
					'header'=>$this->getCatalog('d19'),
					'name'=>'d19',
					'value'=>'$data["d19name"]'
				),
							array(
					'header'=>$this->getCatalog('d20'),
					'name'=>'d20',
					'value'=>'$data["d20name"]'
				),
							array(
					'header'=>$this->getCatalog('d21'),
					'name'=>'d21',
					'value'=>'$data["d21name"]'
				),
							array(
					'header'=>$this->getCatalog('d22'),
					'name'=>'d22',
					'value'=>'$data["d22name"]'
				),
							array(
					'header'=>$this->getCatalog('d23'),
					'name'=>'d23',
					'value'=>'$data["d23name"]'
				),
							array(
					'header'=>$this->getCatalog('d24'),
					'name'=>'d24',
					'value'=>'$data["d24name"]'
				),
							array(
					'header'=>$this->getCatalog('d25'),
					'name'=>'d25',
					'value'=>'$data["d25name"]'
				),
							array(
					'header'=>$this->getCatalog('d26'),
					'name'=>'d26',
					'value'=>'$data["d26name"]'
				),
							array(
					'header'=>$this->getCatalog('d27'),
					'name'=>'d27',
					'value'=>'$data["d27name"]'
				),
							array(
					'header'=>$this->getCatalog('d28'),
					'name'=>'d28',
					'value'=>'$data["d28name"]'
				),
							array(
					'header'=>$this->getCatalog('d29'),
					'name'=>'d29',
					'value'=>'$data["d29name"]'
				),
							array(
					'header'=>$this->getCatalog('d30'),
					'name'=>'d30',
					'value'=>'$data["d30name"]'
				),
							array(
					'header'=>$this->getCatalog('d31'),
					'name'=>'d31',
					'value'=>'$data["d31name"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'statusname',
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
        <h4 class="modal-title"><?php echo $this->getCatalog('employeeschedule') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="employeeschedule_0_employeescheduleid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_employeeid','ColField'=>'employeeschedule_0_fullname',
							'IDDialog'=>'employeeschedule_0_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeecomPopUp','PopGrid'=>'employeeschedule_0_employeeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeschedule_0_month"><?php echo $this->getCatalog('month')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="employeeschedule_0_month">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeschedule_0_year"><?php echo $this->getCatalog('year')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="employeeschedule_0_year">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d1','ColField'=>'employeeschedule_0_d1name',
							'IDDialog'=>'employeeschedule_0_d1_dialog','titledialog'=>$this->getCatalog('d1'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d1grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d2','ColField'=>'employeeschedule_0_d2name',
							'IDDialog'=>'employeeschedule_0_d2_dialog','titledialog'=>$this->getCatalog('d2'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d2grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d3','ColField'=>'employeeschedule_0_d3name',
							'IDDialog'=>'employeeschedule_0_d3_dialog','titledialog'=>$this->getCatalog('d3'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d3grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d4','ColField'=>'employeeschedule_0_d4name',
							'IDDialog'=>'employeeschedule_0_d4_dialog','titledialog'=>$this->getCatalog('d4'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d4grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d5','ColField'=>'employeeschedule_0_d5name',
							'IDDialog'=>'employeeschedule_0_d5_dialog','titledialog'=>$this->getCatalog('d5'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d5grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d6','ColField'=>'employeeschedule_0_d6name',
							'IDDialog'=>'employeeschedule_0_d6_dialog','titledialog'=>$this->getCatalog('d6'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d6grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d7','ColField'=>'employeeschedule_0_d7name',
							'IDDialog'=>'employeeschedule_0_d7_dialog','titledialog'=>$this->getCatalog('d7'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d7grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d8','ColField'=>'employeeschedule_0_d8name',
							'IDDialog'=>'employeeschedule_0_d8_dialog','titledialog'=>$this->getCatalog('d8'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d8grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d9','ColField'=>'employeeschedule_0_d9name',
							'IDDialog'=>'employeeschedule_0_d9_dialog','titledialog'=>$this->getCatalog('d9'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d9grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d10','ColField'=>'employeeschedule_0_d10name',
							'IDDialog'=>'employeeschedule_0_d10_dialog','titledialog'=>$this->getCatalog('d10'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d10grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d11','ColField'=>'employeeschedule_0_d11name',
							'IDDialog'=>'employeeschedule_0_d11_dialog','titledialog'=>$this->getCatalog('d11'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d11grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d12','ColField'=>'employeeschedule_0_d12name',
							'IDDialog'=>'employeeschedule_0_d12_dialog','titledialog'=>$this->getCatalog('d12'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d12grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d13','ColField'=>'employeeschedule_0_d13name',
							'IDDialog'=>'employeeschedule_0_d13_dialog','titledialog'=>$this->getCatalog('d13'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d13grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d14','ColField'=>'employeeschedule_0_d14name',
							'IDDialog'=>'employeeschedule_0_d14_dialog','titledialog'=>$this->getCatalog('d14'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d14grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d15','ColField'=>'employeeschedule_0_d15name',
							'IDDialog'=>'employeeschedule_0_d15_dialog','titledialog'=>$this->getCatalog('d15'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d15grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d16','ColField'=>'employeeschedule_0_d16name',
							'IDDialog'=>'employeeschedule_0_d16_dialog','titledialog'=>$this->getCatalog('d16'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d16grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d17','ColField'=>'employeeschedule_0_d17name',
							'IDDialog'=>'employeeschedule_0_d17_dialog','titledialog'=>$this->getCatalog('d17'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d17grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d18','ColField'=>'employeeschedule_0_d18name',
							'IDDialog'=>'employeeschedule_0_d18_dialog','titledialog'=>$this->getCatalog('d18'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d18grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d19','ColField'=>'employeeschedule_0_d19name',
							'IDDialog'=>'employeeschedule_0_d19_dialog','titledialog'=>$this->getCatalog('d19'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d19grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d20','ColField'=>'employeeschedule_0_d20name',
							'IDDialog'=>'employeeschedule_0_d20_dialog','titledialog'=>$this->getCatalog('d20'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d20grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d21','ColField'=>'employeeschedule_0_d21name',
							'IDDialog'=>'employeeschedule_0_d21_dialog','titledialog'=>$this->getCatalog('d21'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d21grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d22','ColField'=>'employeeschedule_0_d22name',
							'IDDialog'=>'employeeschedule_0_d22_dialog','titledialog'=>$this->getCatalog('d22'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d22grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d23','ColField'=>'employeeschedule_0_d23name',
							'IDDialog'=>'employeeschedule_0_d23_dialog','titledialog'=>$this->getCatalog('d23'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d23grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d24','ColField'=>'employeeschedule_0_d24name',
							'IDDialog'=>'employeeschedule_0_d24_dialog','titledialog'=>$this->getCatalog('d24'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d24grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d25','ColField'=>'employeeschedule_0_d25name',
							'IDDialog'=>'employeeschedule_0_d25_dialog','titledialog'=>$this->getCatalog('d25'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d25grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d26','ColField'=>'employeeschedule_0_d26name',
							'IDDialog'=>'employeeschedule_0_d26_dialog','titledialog'=>$this->getCatalog('d26'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d26grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d27','ColField'=>'employeeschedule_0_d27name',
							'IDDialog'=>'employeeschedule_0_d27_dialog','titledialog'=>$this->getCatalog('d27'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d27grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d28','ColField'=>'employeeschedule_0_d28name',
							'IDDialog'=>'employeeschedule_0_d28_dialog','titledialog'=>$this->getCatalog('d28'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d28grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d29','ColField'=>'employeeschedule_0_d29name',
							'IDDialog'=>'employeeschedule_0_d29_dialog','titledialog'=>$this->getCatalog('d29'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d29grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d30','ColField'=>'employeeschedule_0_d30name',
							'IDDialog'=>'employeeschedule_0_d30_dialog','titledialog'=>$this->getCatalog('d30'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d30grid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeschedule_0_d31','ColField'=>'employeeschedule_0_d31name',
							'IDDialog'=>'employeeschedule_0_d31_dialog','titledialog'=>$this->getCatalog('d31'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'',
							'PopUpName'=>'hr.components.views.AbsschedulePopUp','PopGrid'=>'employeeschedule_0_d31grid')); 
					?>
							<input type="hidden" class="form-control" name="employeeschedule_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


