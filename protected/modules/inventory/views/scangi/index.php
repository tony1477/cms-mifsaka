<?php
$sqldata="select a.sono, a.soheaderid, a.addressbookid, sum(b.qty) as qtyso, sum(b.giqty) as giqty, c.companyname, d.fullname
        from soheader a
        join sodetail b on a.soheaderid = b.soheaderid
        join company c on c.companyid = a.companyid
        join addressbook d on d.addressbookid = a.addressbookid
        where b.qty > b.giqty 
        and c.companyname like '%".(isset($_REQUEST['companyname'])?$_REQUEST['companyname']:'')."%' 
		and d.fullname like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
		and a.sono like '%".(isset($_REQUEST['sono'])?$_REQUEST['sono']:'')."%'
        and a.recordstatus in (
			select xb.wfbefstat
			from workflow xa
			inner join wfgroup xb on xb.workflowid = xa.workflowid
			inner join groupaccess xc on xc.groupaccessid = xb.groupaccessid
			inner join usergroup xd on xd.groupaccessid = xc.groupaccessid
			inner join useraccess xe on xe.useraccessid = xd.useraccessid
			where (xa.wfname) = ('listso') and (xe.username) = ('".Yii::app()->user->name."') and
			a.companyid in (select gm.menuvalueid from groupmenuauth gm
			inner join menuauth ma on ma.menuauthid = gm.menuauthid
			where (ma.menuobject) = ('company') and gm.groupaccessid = xc.groupaccessid))
        group by a.soheaderid
        order by soheaderid desc";

	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());

        $product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'soheaderid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'soheaderid', 'sono'
        ),
				'defaultOrder' => array( 
					'a.soheaderid' => CSort::SORT_DESC
				),
			),
		));
?>
<script src="<?php echo Yii::app()->baseUrl;?>/js/scangi.js" type="text/javascript"></script>
<h3><?php echo $this->getCatalog('scangi') ?></h3>
<?php  if ($this->checkAccess('scangi','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" id="ApproveButton" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<button name="DeleteButton" type="button" class="btn btn-danger" id="DeleteButton" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><span id="text"><?php echo $this->getCatalog('purge')?></span></button>
<button name="RefreshButton" type="button" class="btn btn-info" id="RefreshButton" onclick="refresh()"><span id="text"><?php echo $this->getCatalog('Refresh')?></span></button>
<?php } ?>
<p></p>
<form class="form-inline" method="post">
  <div class="form-group">
    <label for="giheader_soheaderid">Nomor SO :&nbsp;</label>
    <input name="giheader_0_soheaderid" type="hidden" value="">
		<div class="input-group">
			<input type="text" name="giheader_0_sono" readonly class="form-control">
			<span class="input-group-btn">
				<button name="giheader_0_soheaderidShowButton" type="button" class="btn btn-primary" onclick="giheader_0_soheaderidShowButtonClick()"><span class="glyphicon glyphicon-modal-window"></span></button>
				<button name="giheader_0_soheaderidClearButton" type="button" class="btn btn-danger" onclick="giheader_0_soheaderidClearButtonClick()"><span class="glyphicon glyphicon-remove"></span></button>
			</span>
		</div>
  </div><p></p>
    <div class="form-group">
    <label for="giheader_0_note">Keterangan:</label>
        <textarea class="form-control" id="giheader_0_note" name="giheader_0_note" cols="40"></textarea>
  </div><p></p>
  <div class="form-group">
    <label for="nobarcode">No Barcode:</label>
    <input type="hidden" id="action" name="action" value="add" />
    <input type="text" class="form-control" id="nobarcode" name="giheader_0_nobarcode" autofocus="true" required="required" onchange="savedata()">
  </div>
  <button type="button" class="btn btn-default" onclick="savedata()">Submit</button>
</form><br />
<div class="progress progress-striped active" style="display: none;">
    <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
</div>

<br />

<div class="form-group" id="custname">
    <label for="custname">Nama Customer: <span id="custname"></span></label>
  </div>
<div class="form-group" id="salesname">
    <label for="salesname">Nama Sales: <span id="salesname"></span></label>
  </div>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>1,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productname',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qtyso'),
					'name'=>'qty',
					'value'=>'$data["qty"]'
				),
							array(
					'header'=>$this->getCatalog('giqty'),
					'name'=>'giqty',
					'value'=>'$data["giqty"]'
				),
                            array(
					'header'=>$this->getCatalog('qtyscangi'),
					'name'=>'qtyscan',
					'value'=>'$data["qtyscan"]'
				),
		)
));
?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider1,
		'id'=>'GridList1',
		'selectableRows'=>1,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:50px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
                                updatedata($(this).parent().parent().children(':nth-child(2)').text());
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
					'header'=>$this->getCatalog('productname'),
					'name'=>'productname',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qtyso'),
					'name'=>'qty',
					'value'=>'$data["qty"]'
				),
							array(
					'header'=>$this->getCatalog('giqty'),
					'name'=>'giqty',
					'value'=>'$data["giqty"]'
				),
                            array(
					'header'=>$this->getCatalog('qtyscangi'),
					'name'=>'qtyscan',
					'value'=>'$data["qtyscan"]'
				),
							
		)
));
?>

<div id="giheader_0_soheaderid_dialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">	
	 <div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" href="#giheader_0_soheaderid_dialog">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('sono');?></h4>
      </div>
      <div class="modal-body">
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="giheader_0_sono_search_companyname"><?php echo $this->getCatalog('companyname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="giheader_0_sono_search_companyname" class="form-control">
					<span class="input-group-btn">
						<button name="giheader_0_soheaderidSearchButton" type="button" class="btn btn-primary" onclick="giheader_0_soheaderidsearchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="giheader_0_sono_search_fullname"><?php echo $this->getCatalog('customer') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="giheader_0_sono_search_fullname" class="form-control">
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="giheader_0_sono_search_sono"><?php echo $this->getCatalog('docno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="giheader_0_sono_search_sono" class="form-control">
				</div>
			</div>
			</div>
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'giheader_0_soheaderidgrid',
				'selectableRows'=>1,
				'dataProvider'=>$product,
				'selectionChanged'=>'function(id){giheader_0_soheaderidgridonSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('soheaderid'),
						'name'=>'soheaderid', 
						'value'=>'$data["soheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('docno'),
						'name'=>'sono', 
						'value'=>'$data["sono"]',
					),
                    array(
						'header'=>$this->getCatalog('company'),
						'name'=>'companyname', 
						'value'=>'$data["companyname"]',
					),
					array(
						'header'=>$this->getCatalog('customer'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>

<div id="InputDialogScanGI" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('transstockdet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="scangi_1_sodetailid">
            <div class="row">
						<div class="col-md-4">
							<label for="scangi_1_qtyscan"><?php echo $this->getCatalog('qtyscangi')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="scangi_1_qtyscan">
						</div>
            </div>
							
        <div class="modal-footer">
		<button type="submit" class="btn btn-success" onclick="savedatascangi()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
</div>
