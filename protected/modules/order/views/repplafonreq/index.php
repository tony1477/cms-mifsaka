<script type="text/javascript">
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
<h3><?php echo $this->getCatalog('repplafonreq') ?></h3>
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
				'template'=>'{pdf} {xls}',
				'htmlOptions' => array('style'=>'width:70px'),
				'buttons'=>array
				(
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