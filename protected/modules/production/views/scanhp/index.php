<!--<script src="<?php echo Yii::app()->baseUrl;?>/js/productoutput.js"></script>-->
<script type="text/javascript">
if("undefined"==typeof jQuery)throw new Error("Goods Issue's JavaScript requires jQuery");
function savedata()
{

	jQuery.ajax({'url':'scanhp/scanbarcodeop',
		'data':{
			'productoutput_0_nobarcode':$("input[name='productoutput_0_nobarcode']").val(),
            'slocid' : $("input[name='slocid']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				//$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
                $("#ApproveButton").show();
			}
			else
			{
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function infodata($id)
{

    var array = 'id='+$id;
	window.open('scanhp/stockminus?'+array);
}
    function approvedata($id,$sloc)
{
    var i= $("input[name='slocid']").val();
    if(i==$sloc){
          $.msg.confirmation('Confirm','<?php echo $this->getCatalog("scannotrans");?>',function(){	
	jQuery.ajax({'url':'scanhp/ApproveScan',
		'data':{
            'productplanid': $(this).find(".IDCell").html(),
            'slocid' : $("input[name='slocid']").val(),
            'headernote' : $("textarea[name='headernote']").val(),
            'actiontype' : 0,
            'id' : $id,
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
		'cache':false});	});    
    }else{
          $.msg.confirmation('Confirm','<?php echo $this->getCatalog("scantransstock");?>',function(){	
	jQuery.ajax({'url':'scanhp/ApproveScan',
		'data':{
            'productplanid': $(this).find(".IDCell").html(),
            'slocid' : $("input[name='slocid']").val(),
            'headernote' : $("textarea[name='headernote']").val(),
            'actiontype' : 1,
            'id' : $id,
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
		'cache':false});	});
    }
    
	return false;
}
    function purgedata($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'scanhp/purge','data':{'id':$id},
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
<?php
    function getStat($data){
        if($data=='1'){
            $status = 'New Entry';
        }else if($data=='2'){
            $status = 'Approve By Admin';
        }else if($data=='3'){
            $status = 'Approve By SPV';
        }else{
            $status = 'Barcode tidak ter-record';
        }
        return $status; 
} ?>
<input type="hidden" name="companyid" value="<?php echo $companyid;?>" />
<h3><?php echo $this->getCatalog('scanhp') ?></h3>
<?php  if ($this->checkAccess('scanhp','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" id="ApproveButton" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'),'<?php echo $slocid;?>')"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php  if ($this->checkAccess('scanhp','ispost')) { ?>
<button name="InfoButton" type="button" class="btn btn-info" id="InfoButton" onclick="infodata($.fn.yiiGridView.getSelection('GridList'),'<?php echo $slocid;?>')"><?php echo $this->getCatalog('stockminus')?></button>
<?php } ?>
<p></p>
<div class="col-md-8">
    <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocid','ColField'=>'sloccode',
							'IDDialog'=>'slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'common.components.views.SloccomPopUp','PopGrid'=>'slocidgrid')); 
					?>
    <br />
    <div class="row">
    <div class="col-md-4">
    <label for="headernote" class="control-label">Keterangan</label>
    </div>
    <div class="col-md-8">
    <textarea name="headernote" id="headernote" required="required" class="form-control"></textarea>
    </div>
</div>
  <br />
    <div class="row">
    <div class="col-md-4">
    <label for="nobarcode" class="control-label">No Barcode:</label>
    </div>
    <div class="col-md-8">
    <input type="text" class="form-control" id="nobarcode" name="productoutput_0_nobarcode" autofocus="true" required="required" onchange="savedata()">
    </div>
	</div>
  <?php  if ($this->checkAccess('scanhp','ispost')) { ?>
  <button type="button" class="btn btn-default" onclick="savedata()">Submit</button>
  <?php } ?>
    <br />
    </div>
    <div class="col-md-4"></div>
    <div class="clearfix"></div>
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
			array(
				'header'=>$this->getCatalog('barcode'),
				'name'=>'barcode',
				'value'=>'$data["barcode"]'
                
			),
			array(
				'header'=>$this->getCatalog('productname'),
				'name'=>'productname',
				'value'=>'$data["productname"]'
			),
            array(
				'header'=>$this->getCatalog('productplanID'),
				'name'=>'productplanid',
				'value'=>'$data["productplanid"]',
			),
            array(
				'header'=>$this->getCatalog('productplanno'),
				'name'=>'productplanno',
				'value'=>'$data["productplanno"]',
			),
            array(
				'header'=>$this->getCatalog('recordstatus'),
				'name'=>'isapprovehp',
				'value'=>'getStat($data["isapprovehp"])'
			),
            
             array(
				'class'=>'CButtonColumn',
                'header'=>$this->getCatalog('purge'),
				'template'=>'{purge} ',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'url'=>'"#"',
							'visible'=>$this->booltostr($this->checkAccess('scanhp','isreject')),
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(2)').text());
							}",
					),
                ),
                ),
            
		)
));
?>
<?php		
/*
if(isset($_GET['message'])){
    if($_GET['message']=='isscan'){
        $alert = 'warning';
        $text = 'barcodescanned';
        $message = 'Warning!';
    }else if($_GET['message']=='isean'){
        $alert = 'warning';
        $text = 'barcodeean13';
        $message = 'Warning!';
    }else if($_GET['message']=='success'){
        $alert = 'success';
        $text = 'insertsuccess';
        $message = 'Success!';
    }else if($_GET['message']=='duplicatebarcode'){
        $alert = 'error';
        $text = 'duplicatebarcode';
        $message = 'Warning';
    }
    ?>
    <div class="alert alert-<?php echo $alert;?> fade in alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong><?php echo $message;?></strong> <?php echo $this->getCatalog($text); ?>
</div>
<?php }
*/
?>