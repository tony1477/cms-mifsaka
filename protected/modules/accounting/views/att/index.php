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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='att_0_attid']").val(data.attid);
			$("input[name='att_0_companyid']").val('');
            $("input[name='att_0_accheaderid']").val('');
            $("input[name='att_0_recordstatus']").prop('checked',true);
            $("input[name='att_0_companyname']").val('');
            $("input[name='att_0_accountname']").val('');
			
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

function newdataattdetail()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/createattdetail')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='attdetail_1_accountid']").val('');
                $("input[name='attdetail_1_accountcode']").val('');
                $("input[name='attdetail_1_accountname']").val('');
                $("input[name='attdetail_1_accformula']").val('');
                $("input[name='attdetail_1_isbold']").val('');
                $("input[name='attdetail_1_nourut']").val('');
                $("input[name='attdetail_1_isview']").val('');
                $("input[name='attdetail_1_istotal']").val('');
                
                $('#InputDialogattdetail').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='att_0_attid']").val(data.attid);
				$("input[name='att_0_companyid']").val(data.companyid);
                $("input[name='att_0_accheaderid']").val(data.accheaderid);
                $("input[name='att_0_nourut']").val(data.nourut);
                $("input[name='att_0_companyname']").val(data.companyname);
                $("input[name='att_0_accountname']").val(data.accountname);
                if (data.isneraca == 1)
                {
                    $("input[name='att_0_isneraca']").prop('checked',true);
                }
                else
                {
                    $("input[name='att_0_isneraca']").prop('checked',false)
                }
                if (data.recordstatus == 1)
                {
                    $("input[name='att_0_recordstatus']").prop('checked',true);
                }
                else
                {
                    $("input[name='att_0_recordstatus']").prop('checked',false)
                }
                $.fn.yiiGridView.update('attdetailList',{data:{'attid':data.attid}});
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

function updatedataattdetail($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/updateattdetail')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='attdetail_1_attdetid']").val(data.attdetid);
				$("input[name='attdetail_1_accountid']").val(data.accountid);
				$("input[name='attdetail_1_accountcode']").val(data.accountcode);
                $("input[name='attdetail_1_accountname']").val(data.accountname);
                $("input[name='attdetail_1_accformula']").val(data.accformula);
                $("input[name='attdetail_1_nourut']").val(data.nourut);
                
                if (data.isbold == 1)
                {
                    $("input[name='attdetail_1_isbold']").prop('checked',true);
                }
                else
                {
                    $("input[name='attdetail_1_isbold']").prop('checked',false)
                }
                if (data.isview == 1)
                {
                    $("input[name='attdetail_1_isview']").prop('checked',true);
                }
                else
                {
                    $("input[name='attdetail_1_isview']").prop('checked',false)
                }
                if (data.istotal == 1)
                {
                    $("input[name='attdetail_1_istotal']").prop('checked',true);
                }
                else
                {
                    $("input[name='attdetail_1_istotal']").prop('checked',false)
                }

                $('#InputDialogattdetail').modal();
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
    var isneraca = 0;
	if ($("input[name='att_0_isneraca']").prop('checked'))
	{
		isneraca = 1;
	}
	else
	{
		isneraca = 0;
	}
    var recordstatus = 0;
	if ($("input[name='att_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/save')?>',
		'data':{
			'attid':$("input[name='att_0_attid']").val(),
			'companyid':$("input[name='att_0_companyid']").val(),
            'accheaderid':$("input[name='att_0_accheaderid']").val(),
            'isneraca':isneraca,
            'nourut':$("input[name='att_0_nourut']").val(),
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
    
function savedataattdetail()
{
    var isbold = 0;
	if ($("input[name='attdetail_1_isneraca']").prop('checked'))
	{
		isbold = 1;
	}
	else
	{
		isbold = 0;
	}
    var isview = 0;
	if ($("input[name='attdetail_1_isview']").prop('checked'))
	{
		isview = 1;
	}
	else
	{
		isview = 0;
	}
    var istotal = 0;
	if ($("input[name='attdetail_1_istotal']").prop('checked'))
	{
		istotal = 1;
	}
	else
	{
		istotal = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/saveattdetail')?>',
		'data':{
			'attid':$("input[name='att_0_attid']").val(),
			'attdetid':$("input[name='attdetail_1_attdetid']").val(),
			'accountid':$("input[name='attdetail_1_accountid']").val(),
            'accountname':$("input[name='attdetail_1_accountname']").val(),
            'accformula':$("input[name='attdetail_1_accformula']").val(),
            'isbold':isbold,
            'nourut':$("input[name='attdetail_1_nourut']").val(),
            'isview':isview,
            'istotal':istotal,
        },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogattdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("attdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
    
function purgedataattdetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/att/purgeattdetail')?>','data':{'id':$.fn.yiiGridView.getSelection("attdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("attdetailList");
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
    var isneraca = 0;
    if ($("input[name='dlg_search_isneraca']").prop('checked'))
	{
		isneraca = 1;
	}
	else
	{
		isneraca = 0;
	}
    
	$('#SearchDialog').modal('hide');
	var array = 'attid='+$id
+ '&companyid='+$("input[name='dlg_search_companyid']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&isneraca='+isneraca;
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdfneraca($id) {
	var array = 'attid='+$id
+ '&company='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('accounting/att/downpdfneraca')?>?'+array);
}

function downpdfpl($id) {
	var array = 'attid='+$id
+ '&company='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('accounting/att/downpdfpl')?>?'+array);
}

function downxlsneraca($id) {
	var array = 'attid='+$id
+ '&company='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('accounting/att/downxlsneraca')?>?'+array);
}
function downxlspl($id) {
	var array = 'attid='+$id
+ '&company='+$("input[name='dlg_search_companyid']").val()
+ '&date='+$("input[name='dlg_search_date']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&per='+10;
	window.open('<?php echo Yii::app()->createUrl('accounting/att/downxlspl')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'attid='+$id
$.fn.yiiGridView.update("DetailattdetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('att') ?></h3>
<?php if ($this->checkAccess('att','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('att','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    Lampiran Neraca <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdfneraca($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxlsneraca($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
    </ul>
  </div>
<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    Lampiran Laba / Rugi <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdfpll($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxlspl($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
    </ul>
  </div>
<?php } ?>
<!--
<p></p>
<div class="btn btn-primary">
<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'att_companyid','ColField'=>'att_companyname',
							'IDDialog'=>'att_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'att_companyidgrid')); 
?>
<div class="row">
						<div class="col-md-4">
							<label for="att_date"><?php echo $this->getCatalog('date')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="att_date">
						</div>
					</div>
</div>
<p></p>
-->
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
				'template'=>'{select} {edit}',
				'htmlOptions' => array('style'=>'width:160px'),
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
							'visible'=>$this->booltostr($this->checkAccess('att','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('attid'),
					'name'=>'attid',
					'value'=>'$data["attid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('reportplaccount'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isneraca',
					'header'=>$this->getCatalog('isneraca'),
					'selectableRows'=>'0',
					'checked'=>'$data["isneraca"]',
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
						<label for="dlg_search_date"><?php echo $this->getCatalog('date')?></label>
						<input type="date" class="form-control" name="dlg_search_date">
					</div>
				</div>
                <div class="row">
						<div class="col-md-4">
							<label for="attdetail_1_isbold"><?php echo $this->getCatalog('isbold')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="attdetail_1_isbold">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('att') ?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" name="att_0_attid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'att_0_companyid','ColField'=>'att_0_companyname',
							'IDDialog'=>'att_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'att_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'att_0_accheaderid','ColField'=>'att_0_accountname',
							'IDDialog'=>'att_0_accountid_dialog','titledialog'=>$this->getCatalog('reportplaccount'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'att_0_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomPopUp','PopGrid'=>'att_0_accountidgrid')); 
					?>
							
                    <div class="row">
						<div class="col-md-4">
							<label for="att_0_isneraca"><?php echo $this->getCatalog('isneraca')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="att_0_isneraca">
						</div>
					</div>
							
                    <div class="row">
						<div class="col-md-4">
							<label for="att_0_nourut"><?php echo $this->getCatalog('nourut')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="att_0_nourut">
						</div>
					</div>
							
                    <div class="row">
						<div class="col-md-4">
							<label for="att_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="att_0_recordstatus">
						</div>
					</div>
        
        <ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#attdetail"><?php echo $this->getCatalog("attdetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="attdetail" class="tab-pane">
<button name="CreateButtonattdetail" type="button" class="btn btn-primary" onclick="newdataattdetail()"><?php echo $this->getCatalog('new')?></button>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderattdetail,
		'id'=>'attdetailList',
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
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataattdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('attdetailid'),
					'name'=>'attdetalid',
					'value'=>'$data["attdetid"]'
				),
							array(
					'header'=>$this->getCatalog('accountcode'),
					'name'=>'accountcode',
					'value'=>'$data["accountcode"]'
				),
							array(
					'header'=>$this->getCatalog('accountname'),
					'name'=>'accountname',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('accformula'),
					'name'=>'accformula',
					'value'=>'$data["accformula"]'
				),
							array(
					'header'=>$this->getCatalog('nourut'),
					'name'=>'nourut',
					'value'=>'$data["nourut"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isbold',
					'header'=>$this->getCatalog('isbold'),
					'selectableRows'=>'0',
					'checked'=>'$data["isbold"]',
				),          
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isview',
					'header'=>$this->getCatalog('isview'),
					'selectableRows'=>'0',
					'checked'=>'$data["isview"]',
				),
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'istotal',
					'header'=>$this->getCatalog('istotal'),
					'selectableRows'=>'0',
					'checked'=>'$data["istotal"]',
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
		<h3 class="box-title"><?php echo $this->getCatalog('attdetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderattdetail,
		'id'=>'DetailattdetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('attdetailid'),
					'name'=>'attdetid',
					'value'=>'$data["attdetid"]'
				),
							array(
					'header'=>$this->getCatalog('accountcode'),
					'name'=>'accountcode',
					'value'=>'$data["accountcode"]'
				),
							array(
					'header'=>$this->getCatalog('accountname'),
					'name'=>'accountname',
					'value'=>'$data["accountname"]'
				),
							array(
					'header'=>$this->getCatalog('accformula'),
					'name'=>'accformula',
					'value'=>'$data["accformula"]'
				),
							array(
					'header'=>$this->getCatalog('nourut'),
					'name'=>'nourut',
					'value'=>'$data["nourut"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isbold',
					'header'=>$this->getCatalog('isbold'),
					'selectableRows'=>'0',
					'checked'=>'$data["isbold"]',
				),          
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isview',
					'header'=>$this->getCatalog('isview'),
					'selectableRows'=>'0',
					'checked'=>'$data["isview"]',
				),
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'istotal',
					'header'=>$this->getCatalog('istotal'),
					'selectableRows'=>'0',
					'checked'=>'$data["istotal"]',
				),
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogattdetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('attdetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="attdetail_1_attdetid">
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'attdetail_1_accountid','ColField'=>'attdetail_1_accountcode',
							'IDDialog'=>'attdetail_1_accountid_dialog','titledialog'=>$this->getCatalog('accountcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'att_0_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomPopUp','PopGrid'=>'attdetail_1_accountidgrid')); 
					?>
                    <div class="row">
						<div class="col-md-4">
							<label for="attdetail_1_accountname"><?php echo $this->getCatalog('accountname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="attdetail_1_accountname">
						</div>
					</div>
                
                    <div class="row">
						<div class="col-md-4">
							<label for="attdetail_1_accformula"><?php echo $this->getCatalog('accformula')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="attdetail_1_accformula">
						</div>
					</div>
					
                    <div class="row">
                            <div class="col-md-4">
                                <label for="attdetail_1_nourut"><?php echo $this->getCatalog('nourut')?></label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="attdetail_1_nourut">
                            </div>
                    </div>
                
                    <div class="row">
						<div class="col-md-4">
							<label for="attdetail_1_isbold"><?php echo $this->getCatalog('isbold')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="attdetail_1_isbold">
						</div>
					</div>
                
                    <div class="row">
						<div class="col-md-4">
							<label for="attdetail_1_isview"><?php echo $this->getCatalog('isview')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="attdetail_1_isview">
						</div>
					</div>
                
                    <div class="row">
						<div class="col-md-4">
							<label for="attdetail_1_istotal"><?php echo $this->getCatalog('istotal')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="attdetail_1_istotal">
						</div>
					</div>
         </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" onclick="savedataattdetail()"><?php echo $this->getCatalog('save') ?></button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
        </div>
    </div>
</div>
</div>