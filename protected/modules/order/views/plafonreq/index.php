<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/plafonreq/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='plafonreq_0_plafonreqid']").val(data.plafonreqid);
			$("input[name='plafonreq_0_plafonreqdate']").val('');
      $("input[name='plafonreq_0_addressbookid']").val('');
      $("input[name='plafonreq_0_reqlimit']").val(data.reqlimit);
      $("input[name='plafonreq_0_reqsalesid']").val('');
      $("input[name='plafonreq_0_recordstatus']").val(data.recordstatus);
      $("input[name='plafonreq_0_fullname']").val('');
      $("input[name='plafonreq_0_salesname']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/plafonreq/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='plafonreq_0_plafonreqid']").val(data.plafonreqid);
				$("input[name='plafonreq_0_plafonreqdate']").val(data.plafonreqdate);
      $("input[name='plafonreq_0_addressbookid']").val(data.addressbookid);
      $("input[name='plafonreq_0_reqlimit']").val(data.reqlimit);
      $("input[name='plafonreq_0_reqsalesid']").val(data.reqsalesid);
      $("input[name='plafonreq_0_recordstatus']").val(data.recordstatus);
      $("input[name='plafonreq_0_fullname']").val(data.fullname);
      $("input[name='plafonreq_0_salesname']").val(data.salesname);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/plafonreq/save')?>',
		'data':{
			'plafonreqid':$("input[name='plafonreq_0_plafonreqid']").val(),
			'plafonreqdate':$("input[name='plafonreq_0_plafonreqdate']").val(),
      'addressbookid':$("input[name='plafonreq_0_addressbookid']").val(),
      'reqlimit':$("input[name='plafonreq_0_reqlimit']").val(),
      'reqsalesid':$("input[name='plafonreq_0_reqsalesid']").val(),
      'recordstatus':$("input[name='plafonreq_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/plafonreq/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/plafonreq/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/plafonreq/purge')?>','data':{'id':$id},
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

    function infodata($id){
	
    var nilai; 
    var thun_skr = new Date();
    var thun_lalu = new Date();
    thun_skr = thun_skr.getFullYear();
    thun_lalu = thun_lalu.getFullYear()-1;
    
    
    jQuery.ajax({'url':'plafonreq/getinfocust',
		'data':{'id': $id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{   
                fullname = data.fullname;
                addressbookid = data.addressbookid;
                window.open('<?php echo Yii::app()->createUrl('reportgroup/repaccrec/downpdf')?>?lro=19&company=&sloc=&materialgroup=&customer='+fullname+'&product=&sales=&salesarea=&umurpiutang=&startdate=01/01/'+thun_lalu+'&enddate=12/31/'+thun_lalu+'&per=10');
                window.open('<?php echo Yii::app()->createUrl('reportgroup/repaccrec/downpdf')?>?lro=19&company=&sloc=&materialgroup=&customer='+fullname+'&product=&sales=&salesarea=&umurpiutang=&startdate=01/01/'+thun_skr+'&enddate=12/31/'+thun_skr+'&per=10');
                
			}
			else
			{
			    //alert('error');
                toastr.error(data.div);
			}
		},
		'cache':false});	
    
	return false;
}
    
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'plafonreq_0_plafonreqid='+$id
+ '&fullname='+$("input[name='dlg_search_customer']").val()
+ '&plafonreqno='+$("input[name='dlg_search_plafonreqno']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'plafonreq_0_plafonreqid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/plafonreq/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'plafonreq_0_plafonreqid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/plafonreq/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'plafonreqid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('plafonreq') ?></h3>
<?php if ($this->checkAccess('plafonreq','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('plafonreq','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('plafonreq','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('plafonreq','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('plafonreq','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
    </ul>
  </div>
<button name="InfoButton" type="button" class="btn btn-info" onclick="infodata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('Info Customer')?></button>
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
							'visible'=>$this->booltostr($this->checkAccess('plafonreq','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('plafonreq','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('plafonreq','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('plafonreq','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('plafonreq','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('plafonreqid'),
					'name'=>'plafonreqid',
					'value'=>'$data["plafonreqid"]'
				),
				array(
					'header'=>$this->getCatalog('plafonreqno'),
					'name'=>'plafonreqno',
					'value'=>'$data["plafonreqno"]'
				),
							array(
					'header'=>$this->getCatalog('plafonreqdate'),
					'name'=>'plafonreqdate',
					'value'=>'Yii::app()->format->formatDateTime($data["plafonreqdate"])'
				),
							array(
					'header'=>$this->getCatalog('customer'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('reqlimit'),
					'name'=>'reqlimit',
					'value'=>'Yii::app()->format->formatNumber($data["reqlimit"])'
				),
							array(
					'header'=>$this->getCatalog('averagepayment'),
					'name'=>'averagepayment',
					'value'=>'Yii::app()->format->formatNumber($data["averagepayment"])'
				),
							array(
					'header'=>$this->getCatalog('piutangreqplafon'),
					'name'=>'piutangreqplafon',
					'value'=>'Yii::app()->format->formatNumber($data["piutangreqplafon"])'
				),
							array(
					'header'=>$this->getCatalog('topreqplafon'),
					'name'=>'topreqplafon',
					'value'=>'Yii::app()->format->formatNumber($data["topreqplafon"])'
				),
							array(
					'header'=>$this->getCatalog('salesname'),
					'name'=>'reqsalesid',
					'value'=>'$data["salesname"]'
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
						<label for="dlg_search_plafonreqno"><?php echo $this->getCatalog('plafonreqno')?></label>
						<input type="text" class="form-control" name="dlg_search_plafonreqno">
					</div>
					<div class="form-group">
						<label for="dlg_search_customer"><?php echo $this->getCatalog('customer')?></label>
						<input type="text" class="form-control" name="dlg_search_customer">
					</div>
          <div class="form-group">
						<label for="dlg_search_salesname"><?php echo $this->getCatalog('sales')?></label>
						<input type="text" class="form-control" name="dlg_search_salesname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('plafonreq') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="plafonreq_0_plafonreqid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'plafonreq_0_addressbookid','ColField'=>'plafonreq_0_fullname',
							'IDDialog'=>'plafonreq_0_addressbookid_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'plafonreq_0_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="plafonreq_0_reqlimit"><?php echo $this->getCatalog('reqlimit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="plafonreq_0_reqlimit">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'plafonreq_0_reqsalesid','ColField'=>'plafonreq_0_salesname',
							'IDDialog'=>'plafonreq_0_reqsalesid_dialog','titledialog'=>$this->getCatalog('salesname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'plafonreq_0_reqsalesidgrid')); 
					?>
							<input type="hidden" class="form-control" name="plafonreq_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


