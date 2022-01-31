<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/addressaccount/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addressaccount_0_addressaccountid']").val(data.addressaccountid);
			$("input[name='addressaccount_0_companyid']").val(data.companyid);
      $("input[name='addressaccount_0_addressbookid']").val('');
      $("input[name='addressaccount_0_accpiutangid']").val('');
      $("input[name='addressaccount_0_acchutangid']").val('');
      $("input[name='addressaccount_0_recordstatus']").prop('checked',true);
      $("input[name='addressaccount_0_companyname']").val(data.companyname);
      $("input[name='addressaccount_0_fullname']").val('');
      $("input[name='addressaccount_0_accpiutang']").val('');
      $("input[name='addressaccount_0_acchutang']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/addressaccount/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addressaccount_0_addressaccountid']").val(data.addressaccountid);
				$("input[name='addressaccount_0_companyid']").val(data.companyid);
      $("input[name='addressaccount_0_addressbookid']").val(data.addressbookid);
      $("input[name='addressaccount_0_accpiutangid']").val(data.accpiutangid);
      $("input[name='addressaccount_0_acchutangid']").val(data.acchutangid);
      if (data.recordstatus == 1)
			{
				$("input[name='addressaccount_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='addressaccount_0_recordstatus']").prop('checked',false)
			}
      $("input[name='addressaccount_0_companyname']").val(data.companyname);
      $("input[name='addressaccount_0_fullname']").val(data.fullname);
      $("input[name='addressaccount_0_accpiutang']").val(data.accpiutang);
      $("input[name='addressaccount_0_acchutang']").val(data.acchutang);
				
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
var recordstatus = 0;
	if ($("input[name='addressaccount_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/addressaccount/save')?>',
		'data':{
			'addressaccountid':$("input[name='addressaccount_0_addressaccountid']").val(),
			'companyid':$("input[name='addressaccount_0_companyid']").val(),
      'addressbookid':$("input[name='addressaccount_0_addressbookid']").val(),
      'accpiutangid':$("input[name='addressaccount_0_accpiutangid']").val(),
      'acchutangid':$("input[name='addressaccount_0_acchutangid']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/addressaccount/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/addressaccount/purge')?>','data':{'id':$id},
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
	var array = 'addressaccountid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&accpiutang='+$("input[name='dlg_search_accpiutang']").val()
+ '&acchutang='+$("input[name='dlg_search_acchutang']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'addressaccountid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&accpiutang='+$("input[name='dlg_search_accpiutang']").val()
+ '&acchutang='+$("input[name='dlg_search_acchutang']").val();
	window.open('<?php echo Yii::app()->createUrl('Common/addressaccount/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'addressaccountid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&accpiutang='+$("input[name='dlg_search_accpiutang']").val()
+ '&acchutang='+$("input[name='dlg_search_acchutang']").val();
	window.open('<?php echo Yii::app()->createUrl('Common/addressaccount/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'addressaccountid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('addressaccount') ?></h3>
<?php if ($this->checkAccess('addressaccount','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('addressaccount','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('addressaccount','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('addressaccount','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('addressaccount','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('addressaccount','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('addressaccount','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('addressaccount','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('addressaccount','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('addressaccountid'),
					'name'=>'addressaccountid',
					'value'=>'$data["addressaccountid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('accpiutang'),
					'name'=>'accpiutangid',
					'value'=>'$data["accpiutang"]'
				),
							array(
					'header'=>$this->getCatalog('acchutang'),
					'name'=>'acchutangid',
					'value'=>'$data["acchutang"]'
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
					<div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('customer')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_accpiutang"><?php echo $this->getCatalog('accpiutang')?></label>
						<input type="text" class="form-control" name="dlg_search_accpiutang">
					</div>
          <div class="form-group">
						<label for="dlg_search_acchutang"><?php echo $this->getCatalog('acchutang')?></label>
						<input type="text" class="form-control" name="dlg_search_acchutang">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('addressaccount') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="addressaccount_0_addressaccountid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressaccount_0_companyid','ColField'=>'addressaccount_0_companyname',
							'IDDialog'=>'addressaccount_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'addressaccount_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressaccount_0_addressbookid','ColField'=>'addressaccount_0_fullname',
							'IDDialog'=>'addressaccount_0_addressbookid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddressbookPopUp','PopGrid'=>'addressaccount_0_addressbookidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressaccount_0_accpiutangid','ColField'=>'addressaccount_0_accpiutang',
							'IDDialog'=>'addressaccount_0_accpiutangid_dialog','titledialog'=>$this->getCatalog('accpiutang'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'addressaccount_0_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomdetPopUp','PopGrid'=>'addressaccount_0_accpiutangidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'addressaccount_0_acchutangid','ColField'=>'addressaccount_0_acchutang',
							'IDDialog'=>'addressaccount_0_acchutangid_dialog','titledialog'=>$this->getCatalog('acchutang'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'addressaccount_0_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomdetPopUp','PopGrid'=>'addressaccount_0_acchutangidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="addressaccount_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="addressaccount_0_recordstatus">
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


