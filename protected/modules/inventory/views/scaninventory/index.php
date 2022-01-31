<!--<script src="<?php echo Yii::app()->baseUrl;?>/js/productoutput.js"></script>-->
<script type="text/javascript">
if("undefined"==typeof jQuery)throw new Error("Goods Issue's JavaScript requires jQuery");
function savedata()
{

	jQuery.ajax({'url':'scaninventory/scanbarcode',
		'data':{
			'productoutput_0_nobarcode':$("input[name='productoutput_0_nobarcode']").val(),
            'slocid' : $("input[name='slocid']").val(),
            'storagebinid' : $("input[name='storagebinid']").val(),
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
    function approvedata($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'scaninventory/ApproveScan',
		'data':{
            'productplanid': $(this).find(".IDCell").html(),
            'slocid' : $("input[name='slocid']").val(),
            'storagebinid' : $("input[name='storagebinid']").val(),
            //'id':$id
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
<h3><?php echo $this->getCatalog('scaninventory') ?></h3>
<?php  if ($this->checkAccess('scanhp','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" id="ApproveButton" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
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
    
    <p></p>
    <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'storagebinid','ColField'=>'description',
							'IDDialog'=>'storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocid',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'storagebingrid')); 
					?>
  <br />
    <div class="row">
      <div class="col-md-4">
    <label for="nobarcode" class="control-label">No Barcode:</label>
      </div>
        
      <div class="col-md-8">
    <input type="text" class="form-control" id="nobarcode" name="productoutput_0_nobarcode" autofocus="true" required="required" onchange="savedata()">
      </div>
  </div>
  <?php  if ($this->checkAccess('scaninventory','ispost')) { ?>
  <button type="button" class="btn btn-default" onclick="savedata()">Submit</button>
  <?php } ?>
<br />
<div class="progress progress-striped active" style="display: none;">
    <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
</div>
</div>
<div class="col-md-4"></div>
<?php
    $html = array('type'=>'hidden');
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
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
                //'id' => 'productplanid'
			),
            array(
				'header'=>$this->getCatalog('recordstatus'),
				'name'=>'isapprovehp',
				'value'=>'getStat($data["isscan"])'
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