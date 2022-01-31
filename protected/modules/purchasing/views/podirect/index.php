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
function tampil_loading() {
	$(".ajax-loader").css("visibility", "visible");
}

function tutup_loading() {
	$(".ajax-loader").css("visibility", "hidden");
}
function generateproduct()
{
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/generateproduct')?>','data':{'productid':$("input[name='podetail_1_productid']").val()},
        'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='podetail_1_slocid']").val(data.slocid);
                $("input[name='podetail_1_sloccode']").val(data.sloccode);
                $("input[name='podetail_1_unitofmeasureid']").val(data.uomid);
                $("input[name='podetail_1_uomcode']").val(data.uomcode);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='podirect_0_poheaderid']").val(data.poheaderid);
                $("input[name='podirect_0_companyid']").val('');      
                $("input[name='podirect_0_docdate']").val(data.docdate);
                $("input[name='podirect_0_purchasinggroupid']").val('');
                $("input[name='podirect_0_description']").val('');
                $("input[name='podirect_0_addressbookid']").val('');
                $("input[name='podirect_0_paymentmethodid']").val('');
                $("input[name='podirect_0_paycode']").val('');
                $("input[name='podirect_0_taxid']").val('');
                $("textarea[name='podirect_0_shipto']").val('');
                $("textarea[name='podirect_0_billto']").val('');
                $("input[name='podirect_0_headernote']").val('');
                $("input[name='podirect_0_companyname']").val('');
                $("input[name='podirect_0_fullname']").val('');
                $("input[name='podirect_0_taxcode']").val('');
			$.fn.yiiGridView.update('podetailList',{data:{'poheaderid':data.poheaderid}});

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
function newdatapodetail()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/createpodetail')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='podetail_1_podetailid']").val('');
                $("input[name='podetail_1_productid']").val('');
                $("input[name='podetail_1_poqty']").val('');
                $("input[name='podetail_1_delvdate']").val('');
                $("input[name='podetail_1_netprice']").val('');
                $("input[name='podetail_1_currencyid']").val(data.currencyid);
                $("input[name='podetail_1_currencyname']").val('');
                $("input[name='podetail_1_ratevalue']").val('');
                $("input[name='podetail_1_diskon']").val('');
                $("input[name='podetail_1_underdelvtol']").val('');
                $("input[name='podetail_1_overdelvtol']").val('');
                $("input[name='podetail_1_itemtext']").val('');
                $("input[name='podetail_1_productname']").val('');
                $("input[name='podetail_1_unitofmeasureid']").val('');
                $("input[name='podetail_1_uomcode']").val('');
                $("input[name='podetail_1_slocid']").val('');
                $("input[name='podetail_1_sloccode']").val('');
                $('#InputDialogpodetail').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='podirect_0_poheaderid']").val(data.poheaderid);
				$("input[name='podirect_0_companyid']").val(data.companyid);
                $("input[name='podirect_0_docdate']").val(data.docdate);
                $("input[name='podirect_0_purchasinggroupid']").val(data.purchasinggroupid);
                $("input[name='podirect_0_description']").val(data.purchasinggroupid);
                $("input[name='podirect_0_addressbookid']").val(data.addressbookid);
                $("input[name='podirect_0_paymentmethodid']").val(data.paymentmethodid);
                $("input[name='podirect_0_paycode']").val(data.paycode);
                $("input[name='podirect_0_taxid']").val(data.taxid);
                $("input[name='podirect_0_payamount']").val(data.payamount);
                $("textarea[name='podirect_0_shipto']").val(data.shipto);
                $("textarea[name='podirect_0_billto']").val(data.billto);
                $("input[name='podirect_0_headernote']").val(data.headernote);
                $("input[name='podirect_0_companyname']").val(data.companyname);
                $("input[name='podirect_0_fullname']").val(data.fullname);
                $("input[name='podirect_0_taxcode']").val(data.taxcode);
				$.fn.yiiGridView.update('podetailList',{data:{'poheaderid':data.poheaderid}});

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
function updatedatapodetail($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/updatepodetail')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='podetail_1_podetailid']").val(data.podetailid);
                $("input[name='podetail_1_productid']").val(data.productid);
                $("input[name='podetail_1_poqty']").val(data.poqty);
                $("input[name='podetail_1_delvdate']").val(data.delvdate);
                $("input[name='podetail_1_netprice']").val(data.netprice);
                $("input[name='podetail_1_currencyid']").val(data.currencyid);
                $("input[name='podetail_1_currencyname']").val(data.currencyname);
                $("input[name='podetail_1_ratevalue']").val(data.ratevalue);
                $("input[name='podetail_1_diskon']").val(data.diskon);
                $("input[name='podetail_1_underdelvtol']").val(data.underdelvtol);
                $("input[name='podetail_1_overdelvtol']").val(data.overdelvtol);
                $("input[name='podetail_1_itemtext']").val(data.itemtext);
                $("input[name='podetail_1_productname']").val(data.productname);
                $("input[name='podetail_1_unitofmeasureid']").val(data.unitofmeasureid);
                $("input[name='podetail_1_uomcode']").val(data.uomcode);
                $("input[name='podetail_1_slocid']").val(data.slocid);
                $("input[name='podetail_1_sloccode']").val(data.sloccode);
                $('#InputDialogpodetail').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/save')?>',
		'data':{
			'poheaderid':$("input[name='podirect_0_poheaderid']").val(),
			'companyid':$("input[name='podirect_0_companyid']").val(),
            'docdate':$("input[name='podirect_0_docdate']").val(),
            'purchasinggroupid':$("input[name='podirect_0_purchasinggroupid']").val(),
            'addressbookid':$("input[name='podirect_0_addressbookid']").val(),
            'paymentmethodid':$("input[name='podirect_0_paymentmethodid']").val(),
            'taxid':$("input[name='podirect_0_taxid']").val(),
            'payamount':$("input[name='podirect_0_payamount']").val(),
            'shipto':$("textarea[name='podirect_0_shipto']").val(),
            'billto':$("textarea[name='podirect_0_billto']").val(),
            'headernote':$("input[name='podirect_0_headernote']").val(),
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

function savedatapodetail()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/savepodetail')?>',
		'data':{
            'poheaderid':$("input[name='podirect_0_poheaderid']").val(),
            'podetailid':$("input[name='podetail_1_podetailid']").val(),
            'productid':$("input[name='podetail_1_productid']").val(),
            'poqty':$("input[name='podetail_1_poqty']").val(),
            'delvdate':$("input[name='podetail_1_delvdate']").val(),
            'netprice':$("input[name='podetail_1_netprice']").val(),
            'currencyid':$("input[name='podetail_1_currencyid']").val(),
            'ratevalue':$("input[name='podetail_1_ratevalue']").val(),
            'diskon':$("input[name='podetail_1_diskon']").val(),
            'underdelvtol':$("input[name='podetail_1_underdelvtol']").val(),
            'overdelvtol':$("input[name='podetail_1_overdelvtol']").val(),
            'itemtext':$("input[name='podetail_1_itemtext']").val(),
            'slocid':$("input[name='podetail_1_slocid']").val(),
            'unitofmeasureid':$("input[name='podetail_1_unitofmeasureid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogpodetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("podetailList");
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
    tampil_loading();
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/approve')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
        tutup_loading();
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
        tutup_loading();
				toastr.error(data.div);
			}
		},
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
    tampil_loading();
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/delete')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
        tutup_loading();
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
        tutup_loading();
				toastr.error(data.div);
			}
		},
	'cache':false});});
	return false;
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/purge')?>','data':{'id':$id},
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
function purgedatapodetail()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('purchasing/podirect/purgepodetail')?>','data':{'id':$.fn.yiiGridView.getSelection("podetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("podetailList");
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
	var array = 'podirect_0_poheaderid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'poheaderid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('<?php echo Yii::app()->createUrl('Purchasing/podirect/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'poheaderid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('<?php echo Yii::app()->createUrl('Purchasing/podirect/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'poheaderid='+$id
$.fn.yiiGridView.update("DetailpodetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('podirect') ?></h3>
<?php if ($this->checkAccess('podirect','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('podirect','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('podirect','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('podirect','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('podirect','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('podirect','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('podirect','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('podirect','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('poheaderid'),
					'name'=>'poheaderid',
					'value'=>'$data["poheaderid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('pono'),
					'name'=>'pono',
					'value'=>'$data["pono"]'
				),
							array(
					'header'=>$this->getCatalog('supplier'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
                            array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('paymentmethod'),
					'name'=>'paymentmethodid',
					'value'=>'$data["paycode"]'
				),
                            array(
					'header'=>$this->getCatalog('shipto'),
					'name'=>'shipto',
					'value'=>'$data["shipto"]'
				),
                            array(
					'header'=>$this->getCatalog('billto'),
					'name'=>'billto',
					'value'=>'$data["billto"]'
				),							
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_pono"><?php echo $this->getCatalog('pono')?></label>
						<input type="text" class="form-control" name="dlg_search_pono">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('supplier')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_headernote"><?php echo $this->getCatalog('headernote')?></label>
						<input type="text" class="form-control" name="dlg_search_headernote">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('podirect') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="podirect_0_poheaderid">
        <div class="row">
						<div class="col-md-4">
							<label for="podirect_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="podirect_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podirect_0_companyid','ColField'=>'podirect_0_companyname',
							'IDDialog'=>'podirect_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'podirect_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podirect_0_purchasinggroupid','ColField'=>'podirect_0_description',
							'IDDialog'=>'podirect_0_purchasinggroupid_dialog','titledialog'=>$this->getCatalog('purchasinggroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'purchasing.components.views.PurchasinggroupPopUp','PopGrid'=>'podirect_0_purchasinggroupgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podirect_0_addressbookid','ColField'=>'podirect_0_fullname',
							'IDDialog'=>'podirect_0_addressbookid_dialog','titledialog'=>$this->getCatalog('supplier'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddressbookPopUp','PopGrid'=>'podirect_0_addressbookidgrid')); 
					?>
          
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podirect_0_taxid','ColField'=>'podirect_0_taxcode',
							'IDDialog'=>'podirect_0_taxid_dialog','titledialog'=>$this->getCatalog('taxcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'accounting.components.views.TaxPopUp','PopGrid'=>'podirect_0_taxidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podirect_0_paymentmethodid','ColField'=>'podirect_0_paycode',
							'IDDialog'=>'podirect_0_paymentmethodid_dialog','titledialog'=>$this->getCatalog('paycode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'podirect_0_paymentmethodidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podirect_0_shipto"><?php echo $this->getCatalog('shipto')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="podirect_0_shipto"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podirect_0_billto"><?php echo $this->getCatalog('billto')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="podirect_0_billto"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podirect_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="podirect_0_headernote">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#podetail"><?php echo $this->getCatalog("podetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="podetail" class="tab-pane">
	<?php if ($this->checkAccess('podirect','iswrite')) { ?>
<button name="CreateButtonpodetail" type="button" class="btn btn-primary" onclick="newdatapodetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('podirect','ispurge')) { ?>
<button name="PurgeButtonpodetail" type="button" class="btn btn-danger" onclick="purgedatapodetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpodetail,
		'id'=>'podetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('podirect','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatapodetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('podirect','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatapodetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('podetailid'),
					'name'=>'podetailid',
					'value'=>'$data["podetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
				            array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
                            array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
                            array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('delvdate'),
					'name'=>'delvdate',
					'value'=>'Yii::app()->format->formatDate($data["delvdate"])'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('ratevalue'),
					'name'=>'ratevalue',
					'value'=>'Yii::app()->format->formatNumber($data["ratevalue"])'
				),
							array(
					'header'=>$this->getCatalog('diskon'),
					'name'=>'diskon',
					'value'=>'Yii::app()->format->formatNumber($data["diskon"])'
				),
							array(
					'header'=>$this->getCatalog('underdelvtol'),
					'name'=>'underdelvtol',
					'value'=>'$data["underdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('overdelvtol'),
					'name'=>'overdelvtol',
					'value'=>'$data["overdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('podetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderpodetail,
		'id'=>'DetailpodetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('podetailid'),
					'name'=>'podetailid',
					'value'=>'$data["podetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
                            array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
                            array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
				),
                            array(
					'header'=>$this->getCatalog('qtysend'),
					'name'=>'qtyres',
					'value'=>'Yii::app()->format->formatNumber($data["qtyres"])'
				),
                            array(
					'header'=>$this->getCatalog('saldoqty'),
					'name'=>'qtyres',
					'value'=>'Yii::app()->format->formatNumber($data["saldoqty"])'
				),
                            array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
                            array(
					'header'=>$this->getCatalog('total'),
					'name'=>'total',
					'value'=>'Yii::app()->format->formatNumber($data["total"])'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
                            array(
					'header'=>$this->getCatalog('delvdate'),
					'name'=>'delvdate',
					'value'=>'Yii::app()->format->formatDate($data["delvdate"])'
				),
							array(
					'header'=>$this->getCatalog('underdelvtol'),
					'name'=>'underdelvtol',
					'value'=>'$data["underdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('overdelvtol'),
					'name'=>'overdelvtol',
					'value'=>'$data["overdelvtol"]'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogpodetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('podetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="podetail_1_podetailid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_productid','ColField'=>'podetail_1_productname',
							'IDDialog'=>'podetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'podetail_1_productidgrid','onaftersign'=>'generateproduct()')); 
					?>
                
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_slocid','ColField'=>'podetail_1_sloccode',
							'IDDialog'=>'podetail_1_slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocProductPopUp','PopGrid'=>'podetail_1_slocidgrid')); 
					?>
                
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_unitofmeasureid','ColField'=>'podetail_1_uomcode',
							'IDDialog'=>'podetail_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'podetail_1_unitofmeasureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_poqty"><?php echo $this->getCatalog('poqty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_poqty">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_delvdate"><?php echo $this->getCatalog('delvdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="podetail_1_delvdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_netprice"><?php echo $this->getCatalog('netprice')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_netprice">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'podetail_1_currencyid','ColField'=>'podetail_1_currencyname',
							'IDDialog'=>'podetail_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'podetail_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_ratevalue"><?php echo $this->getCatalog('ratevalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_ratevalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_diskon"><?php echo $this->getCatalog('diskon')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_diskon">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_underdelvtol"><?php echo $this->getCatalog('underdelvtol')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_underdelvtol">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_overdelvtol"><?php echo $this->getCatalog('overdelvtol')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="podetail_1_overdelvtol">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="podetail_1_itemtext"><?php echo $this->getCatalog('itemtext')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="podetail_1_itemtext">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatapodetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			