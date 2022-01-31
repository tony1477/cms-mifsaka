<style type="text/css">
.ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +1000 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:10%;
  left:10%;
}
</style>
<div class="ajax-loader">
  <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" class="img-responsive" />
</div>
<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='repprofitloss_0_repprofitlossid']").val(data.repprofitlossid);
			$("input[name='repprofitloss_0_companyid']").val('');
      $("input[name='repprofitloss_0_accountid']").val('');
      $("input[name='repprofitloss_0_isdebet']").prop('checked',true);
      $("input[name='repprofitloss_0_accformula']").val('');
      $("input[name='repprofitloss_0_performula']").val('');
      $("input[name='repprofitloss_0_aftacc']").val('');
      $("input[name='repprofitloss_0_nourut']").val('');
      $("input[name='repprofitloss_0_recordstatus']").prop('checked',true);
      $("input[name='repprofitloss_0_companyname']").val('');
      $("input[name='repprofitloss_0_accountname']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='repprofitloss_0_repprofitlossid']").val(data.repprofitlossid);
				$("input[name='repprofitloss_0_companyid']").val(data.companyid);
      $("input[name='repprofitloss_0_accountid']").val(data.accountid);
      if (data.isdebet == 1)
			{
				$("input[name='repprofitloss_0_isdebet']").prop('checked',true);
			}
			else
			{
				$("input[name='repprofitloss_0_isdebet']").prop('checked',false)
			}
      $("input[name='repprofitloss_0_accformula']").val(data.accformula);
      $("input[name='repprofitloss_0_performula']").val(data.performula);
      $("input[name='repprofitloss_0_aftacc']").val(data.aftacc);
      $("input[name='repprofitloss_0_nourut']").val(data.nourut);
      if (data.recordstatus == 1)
			{
				$("input[name='repprofitloss_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='repprofitloss_0_recordstatus']").prop('checked',false)
			}
      $("input[name='repprofitloss_0_companyname']").val(data.companyname);
      $("input[name='repprofitloss_0_accountname']").val(data.accountname);
				
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
var isdebet = 0;
	if ($("input[name='repprofitloss_0_isdebet']").prop('checked'))
	{
		isdebet = 1;
	}
	else
	{
		isdebet = 0;
	}
var recordstatus = 0;
	if ($("input[name='repprofitloss_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/save')?>',
		'data':{
			'repprofitlossid':$("input[name='repprofitloss_0_repprofitlossid']").val(),
			'companyid':$("input[name='repprofitloss_0_companyid']").val(),
      'accountid':$("input[name='repprofitloss_0_accountid']").val(),
      'isdebet':isdebet,
      'accformula':$("input[name='repprofitloss_0_accformula']").val(),
      'performula':$("input[name='repprofitloss_0_performula']").val(),
      'aftacc':$("input[name='repprofitloss_0_aftacc']").val(),
      'nourut':$("input[name='repprofitloss_0_nourut']").val(),
      'recordstatus':recordstatus,
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

function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/purge')?>','data':{'id':$id},
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

function generatedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
  $('.ajax-loader').css('visibility', 'visible');
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/generate')?>','data':{'companyname':$("input[name='dlg_search_companyid']").val(),'date':$("input[name='dlg_search_date']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
				$('.ajax-loader').css("visibility", "hidden");
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

function generatedata1($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
  $('.ajax-loader').css('visibility', 'visible');
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/profitloss/generate1')?>','data':{'companyname':$("input[name='dlg_search_companyid']").val(),'date':$("input[name='dlg_search_date']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
				$('.ajax-loader').css("visibility", "hidden");
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
	var array = 'repprofitlossid='+$id
+ '&companyid='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&accformula='+$("input[name='dlg_search_accformula']").val()
+ '&performula='+$("input[name='dlg_search_performula']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'repprofitlossid='+$id
+ '&companyid='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&accformula='+$("input[name='dlg_search_accformula']").val()
+ '&performula='+$("input[name='dlg_search_performula']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('Accounting/profitloss/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'repprofitlossid='+$id
+ '&companyid='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&accformula='+$("input[name='dlg_search_accformula']").val()
+ '&performula='+$("input[name='dlg_search_performula']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('Accounting/profitloss/downxls')?>?'+array);
}

function downpdf1($id=0) {
	var array = 'repprofitlossid='+$id
+ '&companyid='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&accformula='+$("input[name='dlg_search_accformula']").val()
+ '&performula='+$("input[name='dlg_search_performula']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('Accounting/profitloss/downpdf1')?>?'+array);
}

function downxls1($id=0) {
	var array = 'repprofitlossid='+$id
+ '&companyid='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&accformula='+$("input[name='dlg_search_accformula']").val()
+ '&performula='+$("input[name='dlg_search_performula']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('Accounting/profitloss/downxls1')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'repprofitlossid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('profitloss') ?></h3>
<?php if ($this->checkAccess('profitloss','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('profitloss','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('profitloss','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('profitloss','isdownload')) { ?>
	<button name="GenerateButton" type="button" class="btn btn-generate" onclick="generatedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('generate')?></button>
	<button name="GenerateButton" type="button" class="btn btn-generate" onclick="generatedata1($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('generatepltahun')?></button>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
      <li><a onclick="downpdf1($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdfpltahun')?></a></li>
      <li><a onclick="downxls1($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxlspltahun')?></a></li>
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
							'visible'=>$this->booltostr($this->checkAccess('profitloss','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('profitloss','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('profitloss','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'generate' => array
					(
							'label'=>$this->getCatalog('generate'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/generate.png',
							'visible'=>$this->booltostr($this->checkAccess('profitloss','isdownload')),							
							'url'=>'"#"',
							'click'=>"function() { 
								generatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('profitloss','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('profitloss','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('repprofitlossid'),
					'name'=>'repprofitlossid',
					'value'=>'$data["repprofitlossid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('accountname'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdebet',
					'header'=>$this->getCatalog('isdebet'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdebet"]',
				),array(
					'header'=>$this->getCatalog('accformula'),
					'name'=>'accformula',
					'value'=>'$data["accformula"]'
				),
							array(
					'header'=>$this->getCatalog('performula'),
					'name'=>'performula',
					'value'=>'$data["performula"]'
				),
							array(
					'header'=>$this->getCatalog('aftacc'),
					'name'=>'aftacc',
					'value'=>'$data["aftacc"]'
				),
							array(
					'header'=>$this->getCatalog('nourut'),
					'name'=>'nourut',
					'value'=>'$data["nourut"]'
				),
							array(
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
				<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'dlg_search_companyid','ColField'=>'dlg_search_companyname',
							'IDDialog'=>'dlg_search_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'dlg_search_companyidgrid')); 
					?>
          <div class="form-group">
						<label for="dlg_search_accountname"><?php echo $this->getCatalog('accountname')?></label>
						<input type="text" class="form-control" name="dlg_search_accountname">
					</div>
          <div class="form-group">
						<label for="dlg_search_accformula"><?php echo $this->getCatalog('accformula')?></label>
						<input type="text" class="form-control" name="dlg_search_accformula">
					</div>
          <div class="form-group">
						<label for="dlg_search_performula"><?php echo $this->getCatalog('performula')?></label>
						<input type="text" class="form-control" name="dlg_search_performula">
					</div>
					<div class="form-group">
						<label for="dlg_search_date"><?php echo $this->getCatalog('date')?></label>
						<input type="date" class="form-control" name="dlg_search_date">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('profitloss') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="repprofitloss_0_repprofitlossid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'repprofitloss_0_companyid','ColField'=>'repprofitloss_0_companyname',
							'IDDialog'=>'repprofitloss_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'repprofitloss_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'repprofitloss_0_accountid','ColField'=>'repprofitloss_0_accountname',
							'IDDialog'=>'repprofitloss_0_accountid_dialog','titledialog'=>$this->getCatalog('accountname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.AccountcomPopUp','PopGrid'=>'repprofitloss_0_accountidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repprofitloss_0_isdebet"><?php echo $this->getCatalog('isdebet')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="repprofitloss_0_isdebet">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repprofitloss_0_accformula"><?php echo $this->getCatalog('accformula')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="repprofitloss_0_accformula">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repprofitloss_0_performula"><?php echo $this->getCatalog('performula')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="repprofitloss_0_performula">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repprofitloss_0_aftacc"><?php echo $this->getCatalog('aftacc')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="repprofitloss_0_aftacc">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repprofitloss_0_nourut"><?php echo $this->getCatalog('nourut')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="repprofitloss_0_nourut">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repprofitloss_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="repprofitloss_0_recordstatus">
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


