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
<script src="<?php echo Yii::app()->baseUrl;?>/js/soheader.js"></script>
<script>
	function reRender() {
    console.log("re-rendered");
      $.fn.yiiGridView.update("GridList");
}
//autoRender = setInterval(reRender, 30000)
//autoRender = setInterval(reRender, 30000*60*60*60)

function infocust() {
  $("#CustomerinfoDialog").modal("show");
  var addressbookid = $("input[name='addressbookid']").val();
  var companyid = $("input[name='companyid']").val();
  var array = "addressbookid=" + addressbookid + "&companyid=" + companyid;
  $.fn.yiiGridView.update("CustomerinfoList", { data: array });
  $("#info").hide();
  jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('order/soheader/customerinfo')?>',
		'data': {
						'addressbookid':$("input[name='addressbookid']").val(),
						'companyid':$("input[name='companyid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
        //var sisa = data.plafon - data.pendinganso - data.piutang;
        //console.log(data);
        $("#info").show();
				$("span[id='plafon']").html(data.plafon);
				$("span[id='pendinganso']").html(data.pendinganso);
				$("span[id='piutang']").html(data.piutang);
				$("span[id='sisa']").html(data.sisa);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
  return false;
}
function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
						'productid':$("input[name='productid']").val(),
						'companyid':$("input[name='companyid']").val(),
						'currencyid':$("input[name='currencyid']").val(),
						'addressbookid':$("input[name='addressbookid']").val(),
                        'type':'soheader',
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='unitofmeasureid']").val(data.uomid);
				$("input[name='uomcode']").val(data.uomcode);
				$("input[name='slocid']").val(data.slocid);
				$("input[name='sloccode']").val(data.sloccode);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}
function getprice()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/productsales/getprice')?>',
		'data':{
			'productid':$("input[name='productid']").val(),
			'unitofmeasureid':$("input[name='unitofmeasureid']").val(),
			'addressbookid':$("input[name='addressbookid']").val(),
			'companyid':$("input[name='companyid']").val(),
			},
		'type':'post','dataType':'json',
		'success':function(data) {
				$("input[name='price']").val(data.currencyvalue)
		},
		'cache':false});
}
function getdatacustomer()
{
  $("#infobtn").hide();
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/customer/getdata')?>',
		'data':{'id':$("input[name='addressbookid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
        $("#infobtn").show();
				$("textarea[name='shipto']").val(data.shiptoname);
				$("textarea[name='billto']").val(data.billtoname);
				$("input[name='taxid']").val(data.taxid);
				$("input[name='taxcode']").val(data.taxcode);
				$("input[name='paymentmethodid']").val(data.paymentmethodid);
				$("input[name='paymentname']").val(data.paycode);

			}
		},
		'cache':false});
	return false;
}
function getdetailpackages(){
    /*
    console.log('Generate Detail');
    $('.ajax-loader').css('visibility', 'visible');
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/soheader/generatepackagedetail')?>',
		'data':{'packageid':$("input[name='packageid']").val(),
                'soheaderid':$("input[name='soheaderid']").val(),
                'companyid':$("input[name='companyid']").val()
               },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
                //$('.ajax-loader').css("visibility", "hidden");
                $.fn.yiiGridView.update("SodetailList");
                $.fn.yiiGridView.update("SodiscList");
			}
            else
            {
                toastr.error(data.div);   
            }
		},
		'cache':false});
	return false;
    */
    $('#qtypkggrid').show();
}
function setqty() {
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/soheader/generatepackagedetail')?>',
		'data':{'packageid':$("input[name='packageid']").val(),
                'soheaderid':$("input[name='soheaderid']").val(),
                'companyid':$("input[name='companyid']").val(),
                'qty':$("input[name='qtypkg']").val(),
                'addressbookid':$("input[name='addressbookid']").val()
               },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
                //$('.ajax-loader').css("visibility", "hidden");
                $("input[name='paymentmethodid']").val(data.paymentmethodid);
                $("input[name='paymentname']").val(data.paycode);
                $("input[name='price']").prop('readonly',true);                    
                $("input[name='discvalue']").prop('readonly',true);
                $.fn.yiiGridView.update("SodetailList");
                $.fn.yiiGridView.update("SodiscList");
			}
            else
            {
                toastr.error(data.div);   
            }
		},
		'cache':false});
	return false;
}
function setMaterialtype() {
    //console.log('setMaterialtype');    
    let materialtypeid = $("input[name='materialtypeid']").val();
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/soheader/checkMaterialtype')?>',
                 'data':{
                     'materialtypeid':materialtypeid,
                     'addressbookid':$("input[name='addressbookid']").val(),
                     'soheaderid':$("input[name='soheaderid']").val()
                    },
                 'type':'post',
                 'dataType':'json',
                 success:function(data) {
                     if (data.status != "success") {
                         $("input[name='materialtypeid']").val('');
                         $("input[name='description']").val('');
                     }
                     toastr.info(data.div);
                    if(data.iseditpriceso  == 0) {
                        $("input[name='price']").prop('readonly',true);                        
                    }
                    else {
                        console.log('1');
                        $("input[name='price']").prop('readonly',false);
                    }
                    if(data.iseditdiscso  == 0) {
                        $("input[name='discvalue']").prop('readonly',true);                        
                    }
                    else {
                        console.log('1');
                        $("input[name='discvalue']").prop('readonly',false);
                    }
                    if(data.isedittop  == 0) {
                        DisableButtonHeader();
                    }
                    else {
                        EnableButtonHeader();
                    }
                    $("input[name='paymentmethodid']").val(data.paymentmethodid);
			        $("input[name='paymentname']").val(data.paycode);
                    $.fn.yiiGridView.update("SodetailList");
                    $.fn.yiiGridView.update("SodiscList");
                 },
        'chache':false});
    return false;
}

function cleardatatype() {
    console.log('clear');
    //alert('test');
    $("input[name='materialtypeid']").val('');
    $("input[name='description']").val('');
}
</script>
<h3><?php echo $this->getCatalog('soheader') ?></h3>
<?php if ($this->checkAccess('soheader','isupload')) { ?>
<?php }?>
<?php if ($this->checkAccess('soheader','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('soheader','ispost')) { ?>
<button name="CreateButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('soheader','isreject')) { ?>
<button name="CreateButton" type="button" class="btn btn-warning" onclick="rejectdata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('soheader','ispurge')) { ?>
<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('soheader','isdownload')) { ?>
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
		'rowCssClassExpression'=>'
			($data["warna"] == "1")?"bg-red":(($data["warna"] == "2")?"bg-orange":(($data["warna"] == "3")?"bg-yellow":"bg-white"))
		',
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{select} {edit} {purge} {pdf} {pdf1}',
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('select'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('soheader','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('soheader','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('soheader','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf1' => array
					(
							'label'=>$this->getCatalog('Info Customer'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/accounting1.png',
							'visible'=>$this->booltostr($this->checkAccess('soheader','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdfcustomer($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('soheaderid'),
				'name'=>'soheaderid',
				'value'=>'$data["soheaderid"]'
			),
			array(
				'header'=>$this->getCatalog('sodate'),
				'name'=>'sodate',
				'value'=>'Yii::app()->format->formatDate($data["sodate"])'
			),
			array(
				'header'=>$this->getCatalog('company'),
				'name'=>'companyid',
				'value'=>'$data["companyname"]'
			),
            array(
				'header'=>$this->getCatalog('pono'),
				'name'=>'poheaderid',
				'value'=>'$data["pono"]'
			),
			array(
				'header'=>$this->getCatalog('docno'),
				'name'=>'sono',
				'value'=>'$data["sono"]'
			),
			array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdisplay',
					'header'=>$this->getCatalog('isdisplay'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdisplay"]',                
			),
            array(
				'header'=>$this->getCatalog('sotype'),
				'name'=>'sotype',
				'value'=>'$data["sotypename"]'
			),
            array(
				'header'=>$this->getCatalog('materialtype'),
				'name'=>'materialtypeid',
				'value'=>'$data["description"]'
			),
            array(
				'header'=>$this->getCatalog('package'),
				'name'=>'packageid',
				'value'=>'$data["packagename"]'
			),
            array(
				'header'=>$this->getCatalog('qty'),
				'name'=>'qtypackage',
				'value'=>'Yii::app()->format->formatNumber($data["qtypackage"])'
			),
			array(
				'header'=>$this->getCatalog('customer'),
				'name'=>'addressbookid',
				'value'=>'$data["fullname"]'
			),
			array(
				'header'=>$this->getCatalog('pocustno'),
				'name'=>'pocustno',
				'value'=>'$data["pocustno"]'
			),
			array(
				'header'=>$this->getCatalog('sales'),
				'name'=>'employeeid',
				'value'=>'$data["salesname"]'
			),
			array(
				'header'=>$this->getCatalog('currentlimit'),
				'name'=>'currentlimit',
				'value'=>'Yii::app()->format->formatCurrency($data["currentlimit"])'
			),
			array(
				'header'=>$this->getCatalog('creditlimit'),
				'name'=>'creditlimit',
				'value'=>'Yii::app()->format->formatCurrency($data["creditlimit"])'
			),
			array(
				'header'=>$this->getCatalog('top'),
				'name'=>'top',
				'value'=>'$data["top"]'
			),			
			array(
				'header'=>$this->getCatalog('paycode'),
				'name'=>'paycode',
				'value'=>'$data["paycode"]'
			),
			array(
				'header'=>$this->getCatalog('pendinganso'),
				'name'=>'pendinganso',
				'value'=>'Yii::app()->format->formatCurrency($data["pendinganso"])'
			),
			array(
				'header'=>$this->getCatalog('totalaftdisc'),
				'name'=>'totalaftdisc',
				'value'=>'Yii::app()->format->formatCurrency($data["totalaftdisc"])'
			),
			array(
				'header'=>$this->getCatalog('recordstatus'),
				'name'=>'recordstatus',
				'value'=>'$data["statusname"]'
			),
			array(
				'header'=>$this->getCatalog('createddate'),
				'name'=>'createddate',
				'value'=>'$data["createddate"]'
			),
			array(
				'header'=>$this->getCatalog('updatedate'),
				'name'=>'updatedate',
				'value'=>'$data["updatedate"]'
			),
		)
));
?>
<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
		<div class="modal-body">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Detail</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php
						$this->widget('zii.widgets.grid.CGridView', array(
					    'dataProvider'=>$dataProvidersodetail,
							'id'=>'DetailSodetailList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('product'),
									'name'=>'productid',
									'value'=>'$data["productname"]'
								),
								array(
									'header'=>$this->getCatalog('qty'),
									'name'=>'qty',
									'value'=>'Yii::app()->format->formatNumber($data["qty"])'
								),
								array(
									'header'=>$this->getCatalog('giqty'),
									'name'=>'giqty',
									'type'=>'raw',
									'value'=>'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["giqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
									array("width"=>"30")) .Yii::app()->format->formatNumber($data["giqty"])'
								),
								array(
									'header'=>$this->getCatalog('qtystock'),
									'name'=>'qtystock',
									'type'=>'raw',
									'value'=>'CHtml::image(Yii::app()->baseUrl.(($data["qtystock"] <= 0)?"/images/empty.png":"/images/full.png"),"",
									array("width"=>"30")) . Yii::app()->format->formatNumber($data["qtystock"])'
								),
								array(
									'header'=>$this->getCatalog('unitofmeasure'),
									'name'=>'unitofmeasureid',
									'value'=>'$data["uomcode"]'
								),
								array(
									'header'=>$this->getCatalog('sloc'),
									'name'=>'slocid',
									'value'=>'$data["sloccode"]'
								),
								array(
									'header'=>$this->getCatalog('price'),
									'name'=>'price',
									'value'=>'Yii::app()->format->formatCurrency($data["price"])',
                  'footer'=> 'number_format($this->sumTotal("price"))',
								),
								array(
									'header'=>$this->getCatalog('currencyrate'),
									'name'=>'currencyrate',
									'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
								),
								array(
									'header'=>$this->getCatalog('total'),
									'name'=>'total',
									'type'=>'raw',
									'value'=>'Yii::app()->format->formatCurrency($data["total"])'
								),
								array(
										'header'=>$this->getCatalog('delvdate'),
										'name'=>'delvdate',
										'value'=>'Yii::app()->format->formatDate($data["delvdate"])'
									),
								array(
									'header'=>$this->getCatalog('itemnote'),
									'name'=>'itemnote',
									'value'=>'$data["itemnote"]'
								),
								array(
									'class'=>'CCheckBoxColumn',
									'name'=>'isbonus',
									'header'=>$this->getCatalog('isbonus'),
									'selectableRows'=>'0',
									'checked'=>'$data["isbonus"]',
										),
							)
					));
					?>
				</div>
			</div>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Discount</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php
						$this->widget('zii.widgets.grid.CGridView', array(
					    'dataProvider'=>$dataProvidersodisc,
							'id'=>'DetailSodiscList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('discvalue'),
									'name'=>'discvalue',
									'value'=>'Yii::app()->format->formatNumber($data["discvalue"])'
								),
							)
					));
					?>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
		    </div>
			<div class="modal-body">
				<div class="form-group">
					<label for="dlg_search_fullname"><?php echo $this->getCatalog('customer')?></label>
					<input type="text" class="form-control" name="dlg_search_fullname">
				</div>
				<div class="form-group">
					<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
					<input type="text" class="form-control" name="dlg_search_companyname">
				</div>
				<div class="form-group">
					<label for="dlg_search_salesname"><?php echo $this->getCatalog('sales')?></label>
					<input type="text" class="form-control" name="dlg_search_salesname">
				</div>
				<div class="form-group">
					<label for="dlg_search_pocustno"><?php echo $this->getCatalog('pocustno')?></label>
					<input type="text" class="form-control" name="dlg_search_pocustno">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search') ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>

<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
		<div class="modal-header">
        	<h4 class="modal-title"><?php echo $this->getCatalog('soheader') ?></h4>
		</div>
		<div class="modal-body">
			<input type="hidden" class="form-control" name="actiontype">
			<input type="hidden" class="form-control" name="soheaderid">
			<input type="hidden" class="form-control" name="recordstatus">
			<div class="row">
				<div class="col-md-4">
					<label for="sodate"><?php echo $this->getCatalog('docdate')?></label>
				</div>
				<div class="col-md-8">
					<input type="date" class="form-control" name="sodate" readonly="readonly">
				</div>
			</div>
			<?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
					'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companygrid')); 
			?>
            <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'poheaderid','ColField'=>'pono',
					'IDDialog'=>'po_dialog','titledialog'=>$this->getCatalog('poplant'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'purchasing.components.views.PoPlantPopUp','PopGrid'=>'poheaderidgrid','RelationID'=>'companyid')); 
			?>
			<?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'fullname',
					'IDDialog'=>'customer_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.CustomercompanyPopUp','PopGrid'=>'customergrid','RelationID'=>'companyid',
					'onaftersign'=>'getdatacustomer(),cleardatatype()')); 
			?>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8">
          <span class="input-group-btn">
              <button name="InfoCustButton" type="button" id="infobtn" class="btn btn-success" onclick="infocust()" style="display:none"> Info Customer <span class=" glyphicon glyphicon-list-alt"></span></button>
          </span>
        </div>
      </div>
            <div class="row">
		 	<div class="col-md-4">
				<label for="sotype"><?php echo $this->getCatalog('sotype')?></label> 
		 	</div>
			 <div class="col-md-8">
				<select class="form-control" id="sotype" name="sotype">
				  <option><?php echo getCatalog('sotype')?></option>
					<?php $i=1; foreach($sotype as $row) : ?>
						<option value=<?= $i;?> ><?= $row;?></option>
					<?php $i++; endforeach; ?>
				</select>
			 </div>
		 </div>
            
        <div id="packagegrid" style="display:none">
		 
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'packageid','ColField'=>'packagename',
							'IDDialog'=>'packages_dialog','titledialog'=>$this->getCatalog('packages'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.PackagesPopUp','PopGrid'=>'packagesgrid','RelationID'=>'companyid',
                            'RelationID2'=>'addressbookid','onaftersign'=>'getdetailpackages();')); 
					?>
		
		</div>
        <div id="qtypkggrid" style="display:none">
            <div class="row">
					<div class="col-md-4">
						<label for="qty"><?php echo $this->getCatalog('qty').' '.$this->getCatalog('packages')?></label>
					</div>
					<div class="col-md-8">
                        <div class="input-group">
						<input type="number" class="form-control" name="qtypkg">
                        <span class="input-group-btn">
                            <button name="SetButton" type="button" class="btn btn-success" onclick="setqty()"> Set Qty <span class="glyphicon glyphicon-inbox"></span></button>
                        </span>
					</div>
                    </div>
            </div>
        </div>
        <div id="materialtypesgrid" style="display:none">
            <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'materialtypeid','ColField'=>'description',
					'IDDialog'=>'materialtype_dialog','titledialog'=>$this->getCatalog('materialtype'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.MaterialtypePopUp','PopGrid'=>'materialtypegrid',
					'onaftersign'=>'setMaterialtype()')); 
			 ?>
        </div>
			<div class="row">
				<div class="col-md-4">
					<label for="pocustno"><?php echo $this->getCatalog('pocustno')?></label>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" name="pocustno">
				</div>
			</div>
            <div id="isdisplaygrid">
			<div class="row">
						<div class="col-md-4">
							<label for="isdisplay"><?php echo $this->getCatalog('isdisplay')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isdisplay" id="isdisplay">
						</div>
					</div>
            </div>
			<?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'salesname',
					'IDDialog'=>'sales_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'salesgrid')); 
			?>
			<?php 
                $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'paymentmethodid','ColField'=>'paymentname',
					'IDDialog'=>'paymentmethod_dialog','titledialog'=>$this->getCatalog('paymentmethod'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'paymentmethodgrid')); 
                
			?>
			<?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'taxid','ColField'=>'taxcode',
					'IDDialog'=>'tax_dialog','titledialog'=>$this->getCatalog('tax'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.TaxPopUp','PopGrid'=>'taxgrid')); 
			?>
			<div class="row">
				<div class="col-md-4">
					<label for="shipto"><?php echo $this->getCatalog('shipto')?></label>
				</div>
				<div class="col-md-8">
					<textarea type="text" class="form-control" name="shipto" rows="5"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="billto"><?php echo $this->getCatalog('billto')?></label>
				</div>
				<div class="col-md-8">
					<textarea type="text" class="form-control" name="billto" rows="5"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="headernote"><?php echo $this->getCatalog('headernote')?></label>
				</div>
				<div class="col-md-8">
					<textarea type="text" class="form-control" name="headernote" rows="5"></textarea>
				</div>
			</div>
			<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#sodetail">Detail</a></li>
			</ul>
			<div class="tab-content">
				<div id="sodetail" class="tab-pane">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Detail</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body">
							<button name="CreateButtonSoDetail" id="CreateButtonAddSoDetail" type="button" class="btn btn-primary" onclick="newdatasodetail()"><?php echo $this->getCatalog('new')?></button>
							<button name="CreateButtonSoDetail" id="CreateButtonDelSoDetail" type="button" class="btn btn-danger" onclick="purgedatasodetail($.fn.yiiGridView.getSelection('SodetailList'))"><?php echo $this->getCatalog('purge')?></button>
						    <?php
							$this->widget('zii.widgets.grid.CGridView', array(
						    'dataProvider'=>$dataProvidersodetail,
								'id'=>'SodetailList',
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
										'htmlOptions' => array('style'=>'width:80px'),
										'buttons'=>array
										(
											'edit' => array
											(
													'label'=>$this->getCatalog('edit'),
													'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
													'visible'=>'true',							
													'url'=>'"#"',
													'click'=>"function() { 
														updatedatasodetail($(this).parent().parent().children(':nth-child(3)').text());
													}",
											),
											'purge' => array
											(
													'label'=>$this->getCatalog('purge'),
													'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
													'visible'=>'true',							
													'url'=>'"#"',
													'click'=>"function() { 
														purgedatasodetail($(this).parent().parent().children(':nth-child(3)').text());
													}",
											),
										),
									),
									array(
										'header'=>$this->getCatalog('sodetailid'),
										'name'=>'sodetailid',
										'value'=>'$data["sodetailid"]'
									),
									array(
										'header'=>$this->getCatalog('product'),
										'name'=>'productid',
										'value'=>'$data["productname"]'
									),
									array(
										'header'=>$this->getCatalog('qty'),
										'name'=>'qty',
										'value'=>'Yii::app()->format->formatNumber($data["qty"])'
									),
									array(
										'header'=>$this->getCatalog('qtystock'),
										'name'=>'qtystock',
										'type'=>'raw',
										'value'=>'CHtml::image(Yii::app()->baseUrl.(($data["qtystock"] <= 0)?"/images/empty.png":"/images/full.png"),"",
										array("width"=>"30")) . Yii::app()->format->formatNumber($data["qtystock"])'
									),
									array(
										'header'=>$this->getCatalog('unitofmeasure'),
										'name'=>'unitofmeasureid',
										'value'=>'$data["uomcode"]'
									),
									array(
										'header'=>$this->getCatalog('sloc'),
										'name'=>'slocid',
										'value'=>'$data["sloccode"]'
									),
									array(
										'header'=>$this->getCatalog('price'),
										'name'=>'price',
										'value'=>'Yii::app()->format->formatCurrency($data["price"])'
									),
									array(
										'header'=>$this->getCatalog('currencyrate'),
										'name'=>'currencyrate',
										'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
									),
									array(
										'header'=>$this->getCatalog('total'),
										'name'=>'total',
										'value'=>'Yii::app()->format->formatCurrency($data["total"])'
									),
									array(
										'header'=>$this->getCatalog('delvdate'),
										'name'=>'delvdate',
										'value'=>'Yii::app()->format->formatDate($data["delvdate"])'
									),
									array(
										'header'=>$this->getCatalog('itemnote'),
										'name'=>'itemnote',
										'value'=>'$data["itemnote"]'
									),
									array(
										'class'=>'CCheckBoxColumn',
										'name'=>'isbonus',
										'header'=>$this->getCatalog('isbonus'),
										'selectableRows'=>'0',
										'checked'=>'$data["isbonus"]',
											),
								)
							));
							?>
						</div>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Multi Discount</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body">
							<button name="CreateButtonSoDisc" style="display:none" id="CreateButtonAddSoDisc" type="button" class="btn btn-primary" onclick="newdatasodisc()" ><?php echo $this->getCatalog('new')?></button>
							<button name="CreateButtonSoDisc" style="display:none" id="CreateButtonDelSoDisc" type="button" class="btn btn-danger" onclick="purgedatasodisc($.fn.yiiGridView.getSelection('SodiscList'))"><?php echo $this->getCatalog('purge')?></button>
							<?php
								$this->widget('zii.widgets.grid.CGridView', array(
							    'dataProvider'=>$dataProvidersodisc,
									'id'=>'SodiscList',
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
											'htmlOptions' => array('style'=>'width:80px'),
											'buttons'=>array
											(
												'edit' => array
												(
														'label'=>$this->getCatalog('edit'),
														'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
														'visible'=>'true',							
														'url'=>'"#"',
														'click'=>"function() { 
															updatedatasodisc($(this).parent().parent().children(':nth-child(3)').text());
														}",
												),
												'purge' => array
												(
														'label'=>$this->getCatalog('purge'),
														'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
														'visible'=>'false',							
														'url'=>'"#"',
														'click'=>"function() { 
															purgedatasodisc($(this).parent().parent().children(':nth-child(3)').text());
														}",
												),
											),
										),
										array(
											'header'=>$this->getCatalog('sodiscid'),
											'name'=>'sodiscid',
											'value'=>'$data["sodiscid"]'
										),
										array(
											'header'=>$this->getCatalog('discvalue'),
											'name'=>'discvalue',
											'value'=>'Yii::app()->format->formatNumber($data["discvalue"])'
										),
									)
							));
							?>
						</div>
					</div>  
					</div>
				</div>
      		</div>
			<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save') ?></button>
					<button type="button" class="btn btn-default" onclick="closedata()"><?php echo $this->getCatalog('close') ?></button>
			</div>
    </div>
  </div>
</div>

<div id="SodetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
			<input type="hidden" class="form-control" name="sodetailid">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('sodetail') ?></h4>
      </div>
			<div class="modal-body">
				<?php $this->widget('DataPopUp',
					array('id'=>'Widget','IDField'=>'productid','ColField'=>'productname',
						'IDDialog'=>'product_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
						'classtypebox'=>'col-md-8',
						'PopUpName'=>'common.components.views.ProductTrxPlantPopUp','PopGrid'=>'productgrid','RelationID'=>'materialtypeid',
                        'RelationID2'=>'soheader',
						'onaftersign'=>'getproductdata(),getprice();')); 
				?>
				<div class="row">
					<div class="col-md-4">
						<label for="qty"><?php echo $this->getCatalog('qty')?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="qty">
						<input type="hidden" name="soheader" id="soheader" value="1">
					</div>
				</div>
				<?php $this->widget('DataPopUp',
					array('id'=>'Widget','IDField'=>'unitofmeasureid','ColField'=>'uomcode',
						'IDDialog'=>'uom_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
						'classtypebox'=>'col-md-8','RelationID'=>'productid',
						'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'uomgrid','onaftersign'=>'getprice();')); 
				?>
				<?php $this->widget('DataPopUp',
					array('id'=>'Widget','IDField'=>'slocid','ColField'=>'sloccode',
						'IDDialog'=>'sloc_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
						'classtypebox'=>'col-md-8','RelationID'=>'productid',
						'PopUpName'=>'common.components.views.SlocUserPopUp','PopGrid'=>'slocgrid')); 
				?>
								<?php $this->widget('DataPopUp',
					array('id'=>'Widget','IDField'=>'currencyid','ColField'=>'currencyname',
						'IDDialog'=>'currency_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
						'classtypebox'=>'col-md-8',
						'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'currencygrid')); 
				?>
				<div class="row">
					<div class="col-md-4">
						<label for="price"><?php echo $this->getCatalog('price')?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="price" readonly>
					</div>
				</div>
								<div class="row">
					<div class="col-md-4">
						<label for="currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="currencyrate">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="delvdate"><?php echo $this->getCatalog('delvdate')?></label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" name="delvdate">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="itemnote"><?php echo $this->getCatalog('itemnote')?></label>
					</div>
					<div class="col-md-8">
						<textarea type="text" class="form-control" name="itemnote"></textarea>
					</div>
				</div>
				<div class="row">
						<div class="col-md-4">
							<label for="isbonus"><?php echo $this->getCatalog('isbonus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isbonus">
						</div>
					</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasodetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>

<div id="SodiscDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('sodisc') ?></h4>
      </div>
			<div class="modal-body">
				<input type="hidden" class="form-control" name="sodiscid">
				<div class="row">
					<div class="col-md-4">
						<label for="discvalue"><?php echo $this->getCatalog('discvalue')?></label>
					</div>
					<div class="col-md-8">
						<input type="number" class="form-control" name="discvalue">
					</div>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasodisc()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
    </div>
  </div>
</div>

<div id="CustomerinfoDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
		<div class="modal-body">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Customer Info</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div><!-- /.box-header -->
        <div class="row" id="info" style="display:none">
          <div class="col-xs-6 col-sm-3">
            <div class="media-left">
              <a href="#">
                <span class=" glyphicon glyphicon-eur" style=" font-size: 40px;"></span> 
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Plafon</h4><span id="plafon"></span>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3">
            <div class="media-left">
              <a href="#">
                <span class="glyphicon glyphicon-shopping-cart" style=" font-size: 40px;"></span> 
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Pendingan SO</h4><span id="pendinganso"></span>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3">
            <div class="media-left">
              <a href="#">
                <span class="glyphicon glyphicon-credit-card" style=" font-size: 40px;"></span> 
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Piutang</h4><span id="piutang"></span>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3">
            <div class="media-left">
              <a href="#">
                <span class="glyphicon glyphicon-retweet" style=" font-size: 40px;"></span> 
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Sisa (Kurang)</h4><span id="sisa"></span>
            </div>
          </div>
        </div>
				<div class="box-body">
					<?php
						$this->widget('zii.widgets.grid.CGridView', array(
					    'dataProvider'=>$dataProviderCustomerinfo,
							'id'=>'CustomerinfoList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('invoiceno'),
									'name'=>'invoiceno',
									'value'=>'$data["invoiceno"]'
								),
								array(
									'header'=>$this->getCatalog('amount'),
									'name'=>'amount',
									//'value'=>'$data["fullname"]',
									'value'=>'Yii::app()->format->formatCurrency($data["amount"])'
								),
                
								array(
									'header'=>$this->getCatalog('payamount'),
									'name'=>'payamount',
									'value'=>'Yii::app()->format->formatCurrency($data["payamount"])'
								),
								array(
									'header'=>$this->getCatalog('umur'),
									'name'=>'umur',
									'value'=>'Yii::app()->format->formatNumber($data["umur"])',
                  'footer'=>'Total',
                  'footerHtmlOptions'=>array('class'=>'grid-footer'),
								),
								
							)
					));
					?>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>