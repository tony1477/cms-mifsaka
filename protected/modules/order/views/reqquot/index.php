<table id="dg-reqquot"  style="width:900px;height:400px">
</table>
<div id="tb-reqquot">
	<?php





 

 if ($this->CheckAccess($this->menuname, $this->iswrite) == 1) {  ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addReqquot()"></a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editReqquot()"></a>
	<?php }?>
	<?php if ($this->CheckAccess($this->menuname, $this->ispurge) == 1) {  ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-purge" plain="true" onclick="javascript:$('#dg-reqquot').edatagrid('destroyRow')"></a>
<?php }?>
	<?php if ($this->CheckAccess($this->menuname, $this->isdownload) == 1) {  ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="downpdfreqquot()"></a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-xls" plain="true" onclick="downxlsreqquot()"></a>
<?php }?>
	<input class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:searchreqquot" style="width:150px">
</div>

<div id="dlg-reqquot" class="easyui-dialog" title="Reqquot" style="width:auto;height:400px" 
	closed="true" data-options="
	resizable:true,
	modal:true,
	toolbar: [
		{
			text:'<?php echo Catalogsys::model()->getCatalog('save')?>',
			iconCls:'icon-save',
			handler:function(){
					submitFormReqquot();
			}
		},
		{
			text:'<?php echo Catalogsys::model()->getCatalog('cancel')?>',
			iconCls:'icon-cancel',
			handler:function(){
					$('#dlg-reqquot').dialog('close');
			}
		},
	]	
	">
	<form id="ff-reqquot-modif" method="post" data-options="novalidate:true">
	<input type="hidden" name="reqquotid"></input>
		<table cellpadding="5">
		<tr>
				<td><?php echo Catalogsys::model()->getCatalog('company')?></td>
				<td><select id="companyid" name="companyid" class="easyui-combogrid" style="width:250px" data-options="
							panelWidth: 500,
							idField: 'companyid',
							textField: 'companyname',
							pagination:true,
							required:true,
							queryParams:{
								combo:true
							},
							url: '<?php echo Yii::app()->createUrl('admin/company/index',array('grid'=>true)) ?>',
							method: 'get',
							columns: [[
									{field:'companyid',title:'<?php echo Catalogsys::model()->getCatalog('companyid')?>',width:80},
									{field:'companyname',title:'<?php echo Catalogsys::model()->getCatalog('companyname')?>',width:120},
							]],
							fitColumns: true
						">
          </select></td>
			</tr>
			<tr>
				<td><?php echo Catalogsys::model()->getCatalog('customer')?></td>
				<td><select id="addressbookid" name="addressbookid" class="easyui-combogrid" style="width:250px" data-options="
                                panelWidth: 500,
                                idField: 'addressbookid',
                                textField: 'fullname',
																pagination:true,
																required:true,
																queryParams: {
																	combo: true
																},
                                url: '<?php echo Yii::app()->createUrl('common/customer/index',array('grid'=>true)) ?>',
                                method: 'get',
                                columns: [[
                                    {field:'addressbookid',title:'<?php echo Catalogsys::model()->getCatalog('addressbookid')?>',width:80},
                                    {field:'fullname',title:'<?php echo Catalogsys::model()->getCatalog('fullname')?>',width:120},
																		{field:'currentlimit',title:'<?php echo Catalogsys::model()->getCatalog('currentlimit')?>',width:120},
																		{field:'creditlimit',title:'<?php echo Catalogsys::model()->getCatalog('creditlimit')?>',width:120}
                                ]],
                                fitColumns: true
                            ">
                                    </select></td>
			</tr>
			<tr>
				<td><?php echo Catalogsys::model()->getCatalog('tax')?></td>
				<td><select id="taxid" name="taxid" class="easyui-combogrid" style="width:250px" data-options="
							panelWidth: 500,
							idField: 'taxid',
							textField: 'taxcode',
							pagination:true,
							required:true,
							queryParams: {
								combo: true
							},
							url: '<?php echo Yii::app()->createUrl('accounting/tax/index',array('grid'=>true)) ?>',
							method: 'get',
							columns: [[
									{field:'taxid',title:'<?php echo Catalogsys::model()->getCatalog('taxid')?>',width:80},
									{field:'taxcode',title:'<?php echo Catalogsys::model()->getCatalog('taxcode')?>',width:120},
									{field:'taxvalue',title:'<?php echo Catalogsys::model()->getCatalog('taxvalue')?>',width:120},
							]],
							fitColumns: true
						">
          </select></td>
			</tr>
			<tr>
				<td><?php echo Catalogsys::model()->getCatalog('custreqno')?></td>
				<td><input name="custreqno" type="text"></input></td>
			</tr>
			<tr>
				<td><?php echo Catalogsys::model()->getCatalog('quotno')?></td>
				<td><input name="quotno" type="text" data-options="required:true"></input></td>
			</tr>
			<tr>
				<td><?php echo Catalogsys::model()->getCatalog('headernote')?></td>
				<td><input name="headernote" class="easyui-textbox" data-options="multiline:true,required:true" style="width:300px;height:100px"></input></td>
			</tr>
			<tr>
				<td><?php echo Catalogsys::model()->getCatalog('recordstatus')?></td>
				<td><input id="recordstatusreqquot" name="recordstatusreqquot" type="checkbox"></input></td>
			</tr>
		</table>
	</form>
	<div class="easyui-tabs" style="width:auto;height:400px">
		<div title="Detail" style="padding:5px">
			<table id="dg-reqquotdetail"  style="width:auto;height:200px">
			</table>
			<div id="tb-reqquotdetail">
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg-reqquotdetail').edatagrid('addRow')"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="javascript:$('#dg-reqquotdetail').edatagrid('saveRow')"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg-reqquotdetail').edatagrid('cancelRow')"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-purge" plain="true" onclick="javascript:$('#dg-reqquotdetail').edatagrid('destroyRow')"></a>
			</div>
			<table id="dg-reqquotdisc"  style="width:auto;height:200px">
			</table>
			<div id="tb-reqquotdisc">
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg-reqquotdisc').edatagrid('addRow')"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="javascript:$('#dg-reqquotdisc').edatagrid('saveRow')"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg-reqquotdisc').edatagrid('cancelRow')"></a>
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-purge" plain="true" onclick="javascript:$('#dg-reqquotdisc').edatagrid('destroyRow')"></a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('#dg-reqquot').edatagrid({
		iconCls: 'icon-edit',	
		singleSelect: false,
		toolbar:'#tb-reqquot',
		pagination: true,
		fitColumns:true,
		ctrlSelect:true,
		autoRowHeight:true,
		showFooter: true,
		onDblClickRow: function (index,row) {
			editReqquot(index);
		},
		rowStyler: function(index,row){
			if (row.count >= 1){
					return 'background-color:blue;color:#fff;font-weight:bold;';
			}
		},
		view: detailview,
		detailFormatter:function(index,row){
				return '<div style="padding:2px"><table class="ddv-reqquotdetail"></table><table class="ddv-reqquotdisc"></table></div>';
		},
		onExpandRow: function(index,row){
			var ddvdetail = $(this).datagrid('getRowDetail',index).find('table.ddv-reqquotdetail');
			var ddvdisc = $(this).datagrid('getRowDetail',index).find('table.ddv-reqquotdisc');
			ddvdetail.datagrid({
				url:'<?php echo $this->createUrl('reqquot/indexdetail',array('grid'=>true)) ?>?id='+row.reqquotid,
				fitColumns:true,
				singleSelect:true,
				rownumbers:true,
				loadMsg:'',
				height:'auto',
				showFooter: true,
				columns:[[
					{field:'productname',title:'<?php echo Catalogsys::model()->getCatalog('productname') ?>'},
					{field:'qty',title:'<?php echo Catalogsys::model()->getCatalog('qty') ?>'},
					{field:'uomcode',title:'<?php echo Catalogsys::model()->getCatalog('uomcode') ?>'},
					{field:'price',title:'<?php echo Catalogsys::model()->getCatalog('price') ?>'},
					{field:'currencyname',title:'<?php echo Catalogsys::model()->getCatalog('currency') ?>'},
					{field:'currencyrate',title:'<?php echo Catalogsys::model()->getCatalog('rate') ?>'},
					{field:'total',title:'<?php echo Catalogsys::model()->getCatalog('total') ?>'},
					{field:'description',title:'<?php echo Catalogsys::model()->getCatalog('description') ?>'},
				]],
				onResize:function(){
						$('#dg-reqquot').datagrid('fixDetailRowHeight',index);
				},
				onLoadSuccess:function(){
						setTimeout(function(){
								$('#dg-reqquot').datagrid('fixDetailRowHeight',index);
						},0);
				}
			});
			ddvdisc.datagrid({
				url:'<?php echo $this->createUrl('reqquot/indexdisc',array('grid'=>true)) ?>?id='+row.reqquotid,
				fitColumns:true,
				singleSelect:true,
				rownumbers:true,
				loadMsg:'',
				height:'auto',
				columns:[[
					{field:'discvalue',title:'<?php echo Catalogsys::model()->getCatalog('discvalue') ?>'},
				]],
				onResize:function(){
						$('#dg-reqquot').datagrid('fixDetailRowHeight',index);
				},
				onLoadSuccess:function(){
						setTimeout(function(){
								$('#dg-reqquot').datagrid('fixDetailRowHeight',index);
						},0);
				}
			});
			$('#dg-reqquot').datagrid('fixDetailRowHeight',index);
		},
    url: '<?php echo $this->createUrl('reqquot/index',array('grid'=>true)) ?>',
		destroyUrl: '<?php echo $this->createUrl('reqquot/purge',array('grid'=>true)) ?>',
		onSuccess: function(index,row){
			show('Message',row.msg);
			$('#dg-reqquot').edatagrid('reload');
		},
		onError: function(index,row){
			show('Message',row.msg);
		},
		idField:'reqquotid',
		editing: false,
		columns:[[
{
field:'reqquotid',
title:'<?php echo Catalogsys::model()->getCatalog('reqquotid') ?>',
sortable: true,
formatter: function(value,row,index){
					return value;
		}},
{
field:'companyid',
title:'<?php echo Catalogsys::model()->getCatalog('company') ?>',
sortable: true,
width:'200',
formatter: function(value,row,index){
						return row.companyname;
					}},
{
field:'customerid',
title:'<?php echo Catalogsys::model()->getCatalog('customer') ?>',
sortable: true,
width:'200',
formatter: function(value,row,index){
						return row.customername;
					}},
					{
field:'custreqno',
title:'<?php echo Catalogsys::model()->getCatalog('custreqno') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
{
field:'quotno',
title:'<?php echo Catalogsys::model()->getCatalog('quotno') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
{
field:'taxid',
title:'<?php echo Catalogsys::model()->getCatalog('tax') ?>',
sortable: true,
formatter: function(value,row,index){
						return row.taxcode;
					}},
					{
field:'headernote',
title:'<?php echo Catalogsys::model()->getCatalog('headernote') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
{
field:'recordstatusreqquot',
title:'<?php echo Catalogsys::model()->getCatalog('recordstatus') ?>',
align:'center',
sortable: true,
formatter: function(value,row,index){
						if (value == 1){
							return '<img src="<?php echo Yii::app()->request->baseUrl?>/images/ok.png"></img>';
						} else {
							return '';
						}
					}},
		]]
});

function searchreqquot(value){
	$('#dg-reqquot').edatagrid('load',{
	reqquotid:value,
        companyid:value,
        addressbookid:value,
        custreqno:value,
        quotno:value,
        headernote:value,
        recordstatus:value,
	});
};

function downpdfreqquot() {
	var ss = [];
	var rows = $('#dg-reqquot').edatagrid('getSelections');
	for(var i=0; i<rows.length; i++){
			var row = rows[i];
			ss.push(row.detailbookid);
	}
	window.open('<?php echo $this->createUrl('reqquot/downpdf') ?>?id='+ss);
};

function downxlsreqquot() {
	var ss = [];
	var rows = $('#dg-reqquot').edatagrid('getSelections');
	for(var i=0; i<rows.length; i++){
			var row = rows[i];
			ss.push(row.detailbookid);
	}
	window.open('<?php echo $this->createUrl('reqquot/downxls') ?>?id='+ss);
}

function addReqquot() {
		$('#dlg-reqquot').dialog('open');
		$('#ff-reqquot-modif').form('clear');
		$('#ff-reqquot-modif').form('load','<?php echo $this->createUrl('reqquot/GetData') ?>');
};

function editReqquot($i) {
	var row = $('#dg-reqquot').datagrid('getSelected');
	if(row) {
		$('#dlg-reqquot').dialog('open');
		$('#ff-reqquot-modif').form('load',row);
		$('#dg-reqquotdetail').datagrid({
			queryParams: {
				id: row.reqquotid,
			}
		});
		$('#dg-reqquotdisc').datagrid({
			queryParams: {
				id: row.reqquotid,
			}
		});
	}
	else {
		show('Message','chooseone');
	}
};

function submitFormReqquot(){
	$('#ff-reqquot-modif').form('submit',{
		url:'<?php echo $this->createUrl('reqquot/save') ?>',
		onSubmit:function(){
				return $(this).form('enableValidation').form('validate');
		},
		success:function(data){
			var data = eval('(' + data + ')');  // change the JSON string to javascript object
			show('Pesan',data.message)
			if (data.success == true){
        $('#dg-reqquot').datagrid('reload');
        $('#dlg-reqquot').dialog('close');
			}
    }
	});	
};

function clearFormReqquot(){
		$('#ff-reqquot-modif').form('clear');
};

function cancelFormReqquot(){
		$('#dlg-reqquot').dialog('close');
};

$('#ff-reqquot-modif').form({
	onLoadSuccess: function(data) {
		$('#companyid').combogrid('setValue', data.companyid);
		$('#addressbookid').combogrid('setValue', data.addressbookid);
		$('#taxid').combogrid('setValue', data.taxid);
		if (data.recordstatusreqquot == 1)
		{
				$('#recordstatusreqquot').prop('checked', true);
		} else
		{
				$('#recordstatusreqquot').prop('checked', false);
		};
	}
});

$('#dg-reqquotdetail').edatagrid({
	iconCls: 'icon-edit',	
	singleSelect: true,
	idField:'detailid',
	editing: true,
	toolbar:'#tb-reqquotdetail',
	fitColumn: true,
	pagination: true,
	showFooter: true,
	url: '<?php echo $this->createUrl('reqquot/searchdetail',array('grid'=>true)) ?>',
	saveUrl: '<?php echo $this->createUrl('reqquot/savedetail',array('grid'=>true))?>',
	updateUrl: '<?php echo $this->createUrl('reqquot/savedetail',array('grid'=>true))?>',
	destroyUrl: '<?php echo $this->createUrl('reqquot/purgedetail',array('grid'=>true))?>',
	onSuccess: function(index,row){
		show('Pesan',row.msg);
		$('#dg-reqquotdetail').edatagrid('reload');
	},
	onError: function(index,row){
		show('Pesan',row.msg);
		$('#dg-reqquotdetail').edatagrid('reload');
	},
	onBeforeSave: function(index){
		 var ixs = $('#dg-reqquot').edatagrid('getSelected');
		var row = $('#dg-reqquotdetail').edatagrid('getSelected');
		if (ixs)
		{
			row.reqquotid = ixs.reqquotid;
		}
	},
	columns:[[
	{
		field:'reqquotid',
		title:'<?php echo Catalogsys::model()->getCatalog('reqquotid') ?>',
		hidden:true,
		sortable: true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'reqquotdetailid',
		title:'<?php echo Catalogsys::model()->getCatalog('reqquotdetailid') ?>',
		sortable: true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'productid',
		title:'<?php echo Catalogsys::model()->getCatalog('product') ?>',
		editor:{
			type:'combogrid',
			options:{
				mode : 'remote',
				method:'get',
				idField:'productid',
				textField:'productname',
				required:true,
				url:'<?php echo Yii::app()->createUrl('common/product/index',array('grid'=>true)) ?>',
				fitColumns:true,
				queryParams: {
					combo: true
				},
				pagination:true,
				loadMsg: '<?php echo Catalogsys::model()->getCatalog('pleasewait')?>',
				columns:[[
					{field:'productid',title:'<?php echo Catalogsys::model()->getCatalog('productid')?>',width:50},
					{field:'productname',title:'<?php echo Catalogsys::model()->getCatalog('productname')?>',width:200},
				]]
			}	
		},
		sortable: true,
		formatter: function(value,row,index){
							return row.productname;
		}
	},
	{
		field:'qty',
		title:'<?php echo Catalogsys::model()->getCatalog('qty') ?>',
		editor: 'numberbox',
		sortable: true,
		required:true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'uomid',
		title:'<?php echo Catalogsys::model()->getCatalog('uom') ?>',
		required:true,
		editor:{
				type:'combogrid',
				options:{
						mode : 'remote',
						method:'get',
						idField:'unitofmeasureid',
						textField:'uomcode',
						queryParams: {
							combo: true
						},
						pagination:true,
						url:'<?php echo Yii::app()->createUrl('common/unitofmeasure/index',array('grid'=>true)) ?>',
						fitColumns:true,
						loadMsg: '<?php echo Catalogsys::model()->getCatalog('pleasewait')?>',
						columns:[[
							{field:'unitofmeasureid',title:'<?php echo Catalogsys::model()->getCatalog('unitofmeasureid')?>',width:50},
							{field:'uomcode',title:'<?php echo Catalogsys::model()->getCatalog('uomcode')?>',width:100},
							{field:'description',title:'<?php echo Catalogsys::model()->getCatalog('uomcode')?>',width:200},
						]]
				}	
			},
		sortable: true,
		formatter: function(value,row,index){
							return row.uomcode;
		}
	},
	{
		field:'price',
		title:'<?php echo Catalogsys::model()->getCatalog('price') ?>',
		editor: 'numberbox',
		required:true,
		sortable: true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'currencyid',
		title:'<?php echo Catalogsys::model()->getCatalog('currency') ?>',
		required:true,
		editor:{
				type:'combogrid',
				options:{
						mode : 'remote',
						method:'get',
						idField:'currencyid',
						textField:'currencyname',
						url:'<?php echo Yii::app()->createUrl('admin/currency/index',array('grid'=>true)) ?>',
						fitColumns:true,
						pagination:true,
						queryParams:{
							combo:true
						},
						loadMsg: '<?php echo Catalogsys::model()->getCatalog('pleasewait')?>',
						columns:[[
							{field:'currencyid',title:'<?php echo Catalogsys::model()->getCatalog('currencyid')?>',width:50},
							{field:'currencyname',title:'<?php echo Catalogsys::model()->getCatalog('currencyname')?>',width:100},
							{field:'symbol',title:'<?php echo Catalogsys::model()->getCatalog('symbol')?>',width:200},
						]]
				}	
			},
		sortable: true,
		formatter: function(value,row,index){
							return row.currencyname;
		}
	},
	{
		field:'currencyrate',
		title:'<?php echo Catalogsys::model()->getCatalog('currencyrate') ?>',
		editor: 'numberbox',
		sortable: true,
		required:true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'total',
		title:'<?php echo Catalogsys::model()->getCatalog('total') ?>',
		editor: 'numberbox',
		required:true,
		sortable: true,
		formatter: function(value,row,index){
							return row.total;
		}
	},
	{
		field:'description',
		title:'<?php echo Catalogsys::model()->getCatalog('description') ?>',
		editor: 'text',
		sortable: true,
		required:true,
		formatter: function(value,row,index){
							return value;
		}
	},
	]]
});

$('#dg-reqquotdisc').edatagrid({
	iconCls: 'icon-edit',	
	singleSelect: true,
	idField:'detailid',
	editing: true,
	toolbar:'#tb-reqquotdisc',
	fitColumn: true,
	pagination: true,
	url: '<?php echo $this->createUrl('reqquot/searchdisc',array('grid'=>true)) ?>',
	saveUrl: '<?php echo $this->createUrl('reqquot/savedisc',array('grid'=>true))?>',
	updateUrl: '<?php echo $this->createUrl('reqquot/savedisc',array('grid'=>true))?>',
	destroyUrl: '<?php echo $this->createUrl('reqquot/purgedisc',array('grid'=>true))?>',
	onSuccess: function(index,row){
		show('Pesan',row.msg);
		$('#dg-reqquotdisc').edatagrid('reload');
	},
	onError: function(index,row){
		show('Pesan',row.msg);
		$('#dg-reqquotdisc').edatagrid('reload');
	},
	onBeforeSave: function(index){
		var ixs = $('#dg-reqquot').edatagrid('getSelected');
		var row = $('#dg-reqquotdisc').edatagrid('getSelected');
		if (ixs)
		{
			row.reqquotid = ixs.reqquotid;
		}
	},
	columns:[[
	{
		field:'reqquotid',
		title:'<?php echo Catalogsys::model()->getCatalog('reqquotid') ?>',
		hidden:true,
		sortable: true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'reqquotdiscid',
		title:'<?php echo Catalogsys::model()->getCatalog('reqquotdiscid') ?>',
		sortable: true,
		formatter: function(value,row,index){
							return value;
		}
	},
	{
		field:'discvalue',
		title:'<?php echo Catalogsys::model()->getCatalog('discvalue') 

?>',
		editor: 'numberbox',
		sortable: true,
		formatter: function(value,row,index){
							return value;
		}
	},
	]]
});
</script>