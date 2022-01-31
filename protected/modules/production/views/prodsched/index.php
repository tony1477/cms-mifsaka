<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/prodsched/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='prodsched_0_prodschedid']").val(data.prodschedid);
			$("input[name='prodsched_0_companyid']").val('');
      $("input[name='prodsched_0_bulan']").val('');
      $("input[name='prodsched_0_tahun']").val('');
      $("input[name='prodsched_0_productid']").val('');
      $("input[name='prodsched_0_uomid']").val('');
      $("input[name='prodsched_0_slocid']").val('');
      $("input[name='prodsched_0_dh1']").val(data.dh1);
      $("input[name='prodsched_0_dh2']").val(data.dh2);
      $("input[name='prodsched_0_d1']").val(data.d1);
      $("input[name='prodsched_0_d2']").val(data.d2);
      $("input[name='prodsched_0_d3']").val(data.d3);
      $("input[name='prodsched_0_d4']").val(data.d4);
      $("input[name='prodsched_0_d5']").val(data.d5);
      $("input[name='prodsched_0_d6']").val(data.d6);
      $("input[name='prodsched_0_d7']").val(data.d7);
      $("input[name='prodsched_0_d8']").val(data.d8);
      $("input[name='prodsched_0_d9']").val(data.d9);
      $("input[name='prodsched_0_d10']").val(data.d10);
      $("input[name='prodsched_0_d11']").val(data.d11);
      $("input[name='prodsched_0_d12']").val(data.d12);
      $("input[name='prodsched_0_d13']").val(data.d13);
      $("input[name='prodsched_0_d14']").val(data.d14);
      $("input[name='prodsched_0_d15']").val(data.d15);
      $("input[name='prodsched_0_d16']").val(data.d16);
      $("input[name='prodsched_0_d17']").val(data.d17);
      $("input[name='prodsched_0_d18']").val(data.d18);
      $("input[name='prodsched_0_d19']").val(data.d19);
      $("input[name='prodsched_0_d20']").val(data.d20);
      $("input[name='prodsched_0_d21']").val(data.d21);
      $("input[name='prodsched_0_d22']").val(data.d22);
      $("input[name='prodsched_0_d23']").val(data.d23);
      $("input[name='prodsched_0_d24']").val(data.d24);
      $("input[name='prodsched_0_d25']").val(data.d25);
      $("input[name='prodsched_0_d26']").val(data.d26);
      $("input[name='prodsched_0_d27']").val(data.d27);
      $("input[name='prodsched_0_d28']").val(data.d28);
      $("input[name='prodsched_0_d29']").val(data.d29);
      $("input[name='prodsched_0_d30']").val(data.d30);
      $("input[name='prodsched_0_d31']").val(data.d31);
      $("input[name='prodsched_0_companyname']").val('');
      $("input[name='prodsched_0_productname']").val('');
      $("input[name='prodsched_0_uomcode']").val('');
      $("input[name='prodsched_0_sloccode']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/prodsched/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='prodsched_0_prodschedid']").val(data.prodschedid);
				$("input[name='prodsched_0_companyid']").val(data.companyid);
      $("input[name='prodsched_0_bulan']").val(data.bulan);
      $("input[name='prodsched_0_tahun']").val(data.tahun);
      $("input[name='prodsched_0_productid']").val(data.productid);
      $("input[name='prodsched_0_uomid']").val(data.uomid);
      $("input[name='prodsched_0_slocid']").val(data.slocid);
      $("input[name='prodsched_0_dh1']").val(data.dh1);
      $("input[name='prodsched_0_dh2']").val(data.dh2);
      $("input[name='prodsched_0_d1']").val(data.d1);
      $("input[name='prodsched_0_d2']").val(data.d2);
      $("input[name='prodsched_0_d3']").val(data.d3);
      $("input[name='prodsched_0_d4']").val(data.d4);
      $("input[name='prodsched_0_d5']").val(data.d5);
      $("input[name='prodsched_0_d6']").val(data.d6);
      $("input[name='prodsched_0_d7']").val(data.d7);
      $("input[name='prodsched_0_d8']").val(data.d8);
      $("input[name='prodsched_0_d9']").val(data.d9);
      $("input[name='prodsched_0_d10']").val(data.d10);
      $("input[name='prodsched_0_d11']").val(data.d11);
      $("input[name='prodsched_0_d12']").val(data.d12);
      $("input[name='prodsched_0_d13']").val(data.d13);
      $("input[name='prodsched_0_d14']").val(data.d14);
      $("input[name='prodsched_0_d15']").val(data.d15);
      $("input[name='prodsched_0_d16']").val(data.d16);
      $("input[name='prodsched_0_d17']").val(data.d17);
      $("input[name='prodsched_0_d18']").val(data.d18);
      $("input[name='prodsched_0_d19']").val(data.d19);
      $("input[name='prodsched_0_d20']").val(data.d20);
      $("input[name='prodsched_0_d21']").val(data.d21);
      $("input[name='prodsched_0_d22']").val(data.d22);
      $("input[name='prodsched_0_d23']").val(data.d23);
      $("input[name='prodsched_0_d24']").val(data.d24);
      $("input[name='prodsched_0_d25']").val(data.d25);
      $("input[name='prodsched_0_d26']").val(data.d26);
      $("input[name='prodsched_0_d27']").val(data.d27);
      $("input[name='prodsched_0_d28']").val(data.d28);
      $("input[name='prodsched_0_d29']").val(data.d29);
      $("input[name='prodsched_0_d30']").val(data.d30);
      $("input[name='prodsched_0_d31']").val(data.d31);
      $("input[name='prodsched_0_companyname']").val(data.companyname);
      $("input[name='prodsched_0_productname']").val(data.productname);
      $("input[name='prodsched_0_uomcode']").val(data.uomcode);
      $("input[name='prodsched_0_sloccode']").val(data.sloccode);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/prodsched/save')?>',
		'data':{
			'prodschedid':$("input[name='prodsched_0_prodschedid']").val(),
			'companyid':$("input[name='prodsched_0_companyid']").val(),
      'bulan':$("input[name='prodsched_0_bulan']").val(),
      'tahun':$("input[name='prodsched_0_tahun']").val(),
      'productid':$("input[name='prodsched_0_productid']").val(),
      'uomid':$("input[name='prodsched_0_uomid']").val(),
      'slocid':$("input[name='prodsched_0_slocid']").val(),
      'd1':$("input[name='prodsched_0_dh1']").val(),
      'd1':$("input[name='prodsched_0_dh2']").val(),
      'd1':$("input[name='prodsched_0_d1']").val(),
      'd2':$("input[name='prodsched_0_d2']").val(),
      'd3':$("input[name='prodsched_0_d3']").val(),
      'd4':$("input[name='prodsched_0_d4']").val(),
      'd5':$("input[name='prodsched_0_d5']").val(),
      'd6':$("input[name='prodsched_0_d6']").val(),
      'd7':$("input[name='prodsched_0_d7']").val(),
      'd8':$("input[name='prodsched_0_d8']").val(),
      'd9':$("input[name='prodsched_0_d9']").val(),
      'd10':$("input[name='prodsched_0_d10']").val(),
      'd11':$("input[name='prodsched_0_d11']").val(),
      'd12':$("input[name='prodsched_0_d12']").val(),
      'd13':$("input[name='prodsched_0_d13']").val(),
      'd14':$("input[name='prodsched_0_d14']").val(),
      'd15':$("input[name='prodsched_0_d15']").val(),
      'd16':$("input[name='prodsched_0_d16']").val(),
      'd17':$("input[name='prodsched_0_d17']").val(),
      'd18':$("input[name='prodsched_0_d18']").val(),
      'd19':$("input[name='prodsched_0_d19']").val(),
      'd20':$("input[name='prodsched_0_d20']").val(),
      'd21':$("input[name='prodsched_0_d21']").val(),
      'd22':$("input[name='prodsched_0_d22']").val(),
      'd23':$("input[name='prodsched_0_d23']").val(),
      'd24':$("input[name='prodsched_0_d24']").val(),
      'd25':$("input[name='prodsched_0_d25']").val(),
      'd26':$("input[name='prodsched_0_d26']").val(),
      'd27':$("input[name='prodsched_0_d27']").val(),
      'd28':$("input[name='prodsched_0_d28']").val(),
      'd29':$("input[name='prodsched_0_d29']").val(),
      'd30':$("input[name='prodsched_0_d30']").val(),
      'd31':$("input[name='prodsched_0_d31']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/prodsched/approve')?>',
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

function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/prodsched/purge')?>','data':{'id':$id},
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
	$.fn.yiiGridView.update("GridList",{data:{
		'prodschedid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'bulan':$("input[name='dlg_search_bulan']").val(),
		'tahun':$("input[name='dlg_search_tahun']").val(),
		'productname':$("input[name='dlg_search_productname']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'prodschedid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&bulan='+$("input[name='dlg_search_bulan']").val()
+ '&tahun='+$("input[name='dlg_search_tahun']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('<?php echo Yii::app()->createUrl('Production/prodsched/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'prodschedid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&bulan='+$("input[name='dlg_search_bulan']").val()
+ '&tahun='+$("input[name='dlg_search_tahun']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('<?php echo Yii::app()->createUrl('Production/prodsched/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'prodschedid='+$id
} 

function running(id,param2)
{
	jQuery.ajax({'url':'prodsched/running',
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

function generatespp()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'prodsched/generatespp','data':
		{
			'companyname':$("input[name='dlg_search_companyname']").val(),
			'bulan':$("input[name='dlg_search_bulan']").val(),
			'tahun':$("input[name='dlg_search_tahun']").val(),
		},
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

</script>
<h3><?php echo $this->getCatalog('prodsched') ?></h3>
<?php if ($this->checkAccess('forecast','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('production/prodsched/uploaddata'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('prodsched','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="generatespp()"><?php echo $this->getCatalog('generate')?></button>
<?php } ?>
<?php if ($this->checkAccess('prodsched','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('prodsched','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
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
				'template'=>'{edit} {delete} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('prodsched','iswrite')),							
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
							'visible'=>$this->booltostr($this->checkAccess('prodsched','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('prodschedid'),
					'name'=>'prodschedid',
					'value'=>'$data["prodschedid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('bulan'),
					'name'=>'bulan',
					'value'=>'$data["bulan"]'
				),
							array(
					'header'=>$this->getCatalog('tahun'),
					'name'=>'tahun',
					'value'=>'$data["tahun"]'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('d1'),
					'name'=>'d1',
					'value'=>'Yii::app()->format->formatNumber($data["d1"])'
				),
							array(
					'header'=>$this->getCatalog('d2'),
					'name'=>'d2',
					'value'=>'Yii::app()->format->formatNumber($data["d2"])'
				),
							array(
					'header'=>$this->getCatalog('d3'),
					'name'=>'d3',
					'value'=>'Yii::app()->format->formatNumber($data["d3"])'
				),
							array(
					'header'=>$this->getCatalog('d4'),
					'name'=>'d4',
					'value'=>'Yii::app()->format->formatNumber($data["d4"])'
				),
							array(
					'header'=>$this->getCatalog('d5'),
					'name'=>'d5',
					'value'=>'Yii::app()->format->formatNumber($data["d5"])'
				),
							array(
					'header'=>$this->getCatalog('d6'),
					'name'=>'d6',
					'value'=>'Yii::app()->format->formatNumber($data["d6"])'
				),
							array(
					'header'=>$this->getCatalog('d7'),
					'name'=>'d7',
					'value'=>'Yii::app()->format->formatNumber($data["d7"])'
				),
							array(
					'header'=>$this->getCatalog('d8'),
					'name'=>'d8',
					'value'=>'Yii::app()->format->formatNumber($data["d8"])'
				),
							array(
					'header'=>$this->getCatalog('d9'),
					'name'=>'d9',
					'value'=>'Yii::app()->format->formatNumber($data["d9"])'
				),
							array(
					'header'=>$this->getCatalog('d10'),
					'name'=>'d10',
					'value'=>'Yii::app()->format->formatNumber($data["d10"])'
				),
							array(
					'header'=>$this->getCatalog('d11'),
					'name'=>'d11',
					'value'=>'Yii::app()->format->formatNumber($data["d11"])'
				),
							array(
					'header'=>$this->getCatalog('d12'),
					'name'=>'d12',
					'value'=>'Yii::app()->format->formatNumber($data["d12"])'
				),
							array(
					'header'=>$this->getCatalog('d13'),
					'name'=>'d13',
					'value'=>'Yii::app()->format->formatNumber($data["d13"])'
				),
							array(
					'header'=>$this->getCatalog('d14'),
					'name'=>'d14',
					'value'=>'Yii::app()->format->formatNumber($data["d14"])'
				),
							array(
					'header'=>$this->getCatalog('d15'),
					'name'=>'d15',
					'value'=>'Yii::app()->format->formatNumber($data["d15"])'
				),
							array(
					'header'=>$this->getCatalog('d16'),
					'name'=>'d16',
					'value'=>'Yii::app()->format->formatNumber($data["d16"])'
				),
							array(
					'header'=>$this->getCatalog('d17'),
					'name'=>'d17',
					'value'=>'Yii::app()->format->formatNumber($data["d17"])'
				),
							array(
					'header'=>$this->getCatalog('d18'),
					'name'=>'d18',
					'value'=>'Yii::app()->format->formatNumber($data["d18"])'
				),
							array(
					'header'=>$this->getCatalog('d19'),
					'name'=>'d19',
					'value'=>'Yii::app()->format->formatNumber($data["d19"])'
				),
							array(
					'header'=>$this->getCatalog('d20'),
					'name'=>'d20',
					'value'=>'Yii::app()->format->formatNumber($data["d20"])'
				),
							array(
					'header'=>$this->getCatalog('d21'),
					'name'=>'d21',
					'value'=>'Yii::app()->format->formatNumber($data["d21"])'
				),
							array(
					'header'=>$this->getCatalog('d22'),
					'name'=>'d22',
					'value'=>'Yii::app()->format->formatNumber($data["d22"])'
				),
							array(
					'header'=>$this->getCatalog('d23'),
					'name'=>'d23',
					'value'=>'Yii::app()->format->formatNumber($data["d23"])'
				),
							array(
					'header'=>$this->getCatalog('d24'),
					'name'=>'d24',
					'value'=>'Yii::app()->format->formatNumber($data["d24"])'
				),
							array(
					'header'=>$this->getCatalog('d25'),
					'name'=>'d25',
					'value'=>'Yii::app()->format->formatNumber($data["d25"])'
				),
							array(
					'header'=>$this->getCatalog('d26'),
					'name'=>'d26',
					'value'=>'Yii::app()->format->formatNumber($data["d26"])'
				),
							array(
					'header'=>$this->getCatalog('d27'),
					'name'=>'d27',
					'value'=>'Yii::app()->format->formatNumber($data["d27"])'
				),
							array(
					'header'=>$this->getCatalog('d28'),
					'name'=>'d28',
					'value'=>'Yii::app()->format->formatNumber($data["d28"])'
				),
							array(
					'header'=>$this->getCatalog('d29'),
					'name'=>'d29',
					'value'=>'Yii::app()->format->formatNumber($data["d29"])'
				),
							array(
					'header'=>$this->getCatalog('d30'),
					'name'=>'d30',
					'value'=>'Yii::app()->format->formatNumber($data["d30"])'
				),
							array(
					'header'=>$this->getCatalog('d31'),
					'name'=>'d31',
					'value'=>'Yii::app()->format->formatNumber($data["d31"])'
				),array(
					'header'=>$this->getCatalog('total'),
					'name'=>'total',
					'value'=>'Yii::app()->format->formatNumber($data["total"])'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_bulan"><?php echo $this->getCatalog('bulan')?></label>
						<input type="text" class="form-control" name="dlg_search_bulan">
					</div>
          <div class="form-group">
						<label for="dlg_search_tahun"><?php echo $this->getCatalog('tahun')?></label>
						<input type="text" class="form-control" name="dlg_search_tahun">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('prodsched') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="prodsched_0_prodschedid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prodsched_0_companyid','ColField'=>'prodsched_0_companyname',
							'IDDialog'=>'prodsched_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'prodsched_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_bulan"><?php echo $this->getCatalog('bulan')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_bulan">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_tahun"><?php echo $this->getCatalog('tahun')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_tahun">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prodsched_0_productid','ColField'=>'prodsched_0_productname',
							'IDDialog'=>'prodsched_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'prodsched_0_productidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prodsched_0_uomid','ColField'=>'prodsched_0_uomcode',
							'IDDialog'=>'prodsched_0_uomid_dialog','titledialog'=>$this->getCatalog('uomcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'prodsched_0_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'prodsched_0_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prodsched_0_slocid','ColField'=>'prodsched_0_sloccode',
							'IDDialog'=>'prodsched_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'prodsched_0_slocidgrid')); 
					?>
					
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'prodsched_0_bomid','ColField'=>'prodsched_0_bomversion',
							'IDDialog'=>'prodsched_0_bomid_dialog','titledialog'=>$this->getCatalog('bom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'prodsched_0_productid',
							'PopUpName'=>'production.components.views.ProductbomPopUp','PopGrid'=>'prodsched_0_bomidgrid')); 
					?>
					
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_dh2"><?php echo $this->getCatalog('dh2')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_dh2">
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_dh1"><?php echo $this->getCatalog('dh1')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_dh1">
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d1"><?php echo $this->getCatalog('d1')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d1">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d2"><?php echo $this->getCatalog('d2')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d2">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d3"><?php echo $this->getCatalog('d3')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d3">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d4"><?php echo $this->getCatalog('d4')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d4">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d5"><?php echo $this->getCatalog('d5')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d5">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d6"><?php echo $this->getCatalog('d6')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d6">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d7"><?php echo $this->getCatalog('d7')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d7">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d8"><?php echo $this->getCatalog('d8')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d8">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d9"><?php echo $this->getCatalog('d9')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d9">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d10"><?php echo $this->getCatalog('d10')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d10">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d11"><?php echo $this->getCatalog('d11')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d11">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d12"><?php echo $this->getCatalog('d12')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d12">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d13"><?php echo $this->getCatalog('d13')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d13">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d14"><?php echo $this->getCatalog('d14')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d14">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d15"><?php echo $this->getCatalog('d15')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d15">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d16"><?php echo $this->getCatalog('d16')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d16">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d17"><?php echo $this->getCatalog('d17')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d17">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d18"><?php echo $this->getCatalog('d18')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d18">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d19"><?php echo $this->getCatalog('d19')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d19">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d20"><?php echo $this->getCatalog('d20')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d20">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d21"><?php echo $this->getCatalog('d21')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d21">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d22"><?php echo $this->getCatalog('d22')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d22">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d23"><?php echo $this->getCatalog('d23')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d23">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d24"><?php echo $this->getCatalog('d24')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d24">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d25"><?php echo $this->getCatalog('d25')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d25">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d26"><?php echo $this->getCatalog('d26')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d26">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d27"><?php echo $this->getCatalog('d27')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d27">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d28"><?php echo $this->getCatalog('d28')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d28">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d29"><?php echo $this->getCatalog('d29')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d29">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d30"><?php echo $this->getCatalog('d30')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d30">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="prodsched_0_d31"><?php echo $this->getCatalog('d31')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="prodsched_0_d31">
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


