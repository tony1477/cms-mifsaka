<table id="dg-reportpo" style="width:auto;height:400px">
</table>
<div id="tb-reportpo">
	<?php





 if ($this->CheckAccess($this->menuname, $this->isdownload) == 1) {  ?>
		<a href="javascript:void(0)" title="Export Ke PDF"class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="downpdfpoheader()"></a>
<?php }?>
	<input class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:searchpoheader" style="width:150px">
</div>

<script type="text/javascript">
$('#dg-reportpo').edatagrid({
		iconCls: 'icon-edit',	
		singleSelect: false,
		toolbar:'#tb-reportpo',
		pagination: true,
		fitColumns:true,
		ctrlSelect:true,
		autoRowHeight:true,
		view: detailview,
                detailFormatter:function(index,row){
				return '<div style="padding:2px"><table class="ddv-podetail"></table></div>';
		},
                onExpandRow: function(index,row){
			var ddvpodetail = $(this).datagrid('getRowDetail',index).find('table.ddv-podetail');
			ddvpodetail.datagrid({
				url:'<?php echo $this->createUrl('poheader/indexdetail',array('grid'=>true)) ?>?id='+row.poheaderid,
				fitColumns:true,
				singleSelect:true,
				rownumbers:true,
				loadMsg:'',
				height:'auto',
				width:'auto',
				showFooter:true,
				columns:[[
					{field:'prno',title:'<?php echo Catalogsys::model()->getCatalog('prno') ?>'},
          {field:'productname',title:'<?php echo Catalogsys::model()->getCatalog('productname') ?>'},
					{field:'poqty',title:'<?php echo Catalogsys::model()->getCatalog('poqty') ?>'},
					{field:'qtyres',title:'<?php echo Catalogsys::model()->getCatalog('qtysend') ?>'},
					{field:'saldoqty',title:'<?php echo Catalogsys::model()->getCatalog('saldoqty') ?>'},
					{field:'uomcode',title:'<?php echo Catalogsys::model()->getCatalog('uomcode') ?>'},
					{field:'netprice',title:'<?php echo Catalogsys::model()->getCatalog('netprice') ?>'},
					{field:'total',title:'<?php echo Catalogsys::model()->getCatalog('total') ?>'},
					{field:'currencyname',title:'<?php echo Catalogsys::model()->getCatalog('currency') ?>'},
					{field:'delvdate',title:'<?php echo Catalogsys::model()->getCatalog('delvdate') ?>'},
					{field:'itemtext',title:'<?php echo Catalogsys::model()->getCatalog('itemtext') ?>'},
				]],
				onResize:function(){
						$('#dg-reportpo').datagrid('fixDetailRowHeight',index);
				},
				onLoadSuccess:function(){
						setTimeout(function(){
								$('#dg-reportpo').datagrid('fixDetailRowHeight',index);
						},0);
				}
			});
			$('#dg-reportpo').datagrid('fixDetailRowHeight',index);
                },
                url: '<?php echo $this->createUrl('reportpo/index',array('grid'=>true)) ?>',
		onSuccess: function(index,row){
			show('Message',row.msg);
			$('#dg-reportpo').edatagrid('reload');
		},
		onError: function(index,row){
			show('Message',row.msg);
		},
		idField:'poheaderid',
		editing: false,
		columns:[[
		{
field:'poheaderid',
title:'<?php echo Catalogsys::model()->getCatalog('poheaderid') ?>',
sortable: true,
formatter: function(value,row,index){
					return value;
					}},
					{
field:'companyid',
title:'<?php echo Catalogsys::model()->getCatalog('company') ?>',
sortable: true,
formatter: function(value,row,index){
						return row.companyname;
					}},
{
field:'pono',
title:'<?php echo Catalogsys::model()->getCatalog('pono') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
{
field:'docdate',
title:'<?php echo Catalogsys::model()->getCatalog('docdate') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
{
field:'purchasinggroupid',
title:'<?php echo Catalogsys::model()->getCatalog('purchasinggroup') ?>',
sortable: true,
formatter: function(value,row,index){
						return row.purchasinggroupcode;
					}},
{
field:'addressbookid',
title:'<?php echo Catalogsys::model()->getCatalog('supplier') ?>',
sortable: true,
formatter: function(value,row,index){
						return row.fullname;
					}},
{
field:'paymentmethodid',
title:'<?php echo Catalogsys::model()->getCatalog('paymentmethod') ?>',
sortable: true,
formatter: function(value,row,index){
						return row.paycode;
					}},
										{
field:'shipto',
title:'<?php echo Catalogsys::model()->getCatalog('shipto') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
					{
field:'billto',
title:'<?php echo Catalogsys::model()->getCatalog('billto') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
					{
field:'headernote',
title:'<?php echo Catalogsys::model()->getCatalog('headernote') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
{
field:'recordstatuspoheader',
title:'<?php echo Catalogsys::model()->getCatalog('recordstatus') ?>',
sortable: true,
formatter: function(value,row,index){
						return value;
					}},
		]]
});
function searchpoheader(value){
	$('#dg-reportpo').edatagrid('load',{
	poheaderid:value,
        purchasinggroupid:value,
        docdate:value,
        addressbookid:value,
        headernote:value,
        pono:value,
        paymentmethodid:value,
        printke:value,
        shipto:value,
        billto:value,
        companyid:value,
        recordstatus:value,
	});
}
function downpdfpoheader() {
	var ss = [];
	var rows = $('#dg-reportpo').edatagrid('getSelections');
	for(var i=0; i<rows.length; i++){
			var row = rows[i];
			ss.push(row.poheaderid);
	}
	window.open('<?php echo $this->createUrl('poheader/downpdf') ?>?id='+ss);
}

function dateformatter(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
}

function dateparser(s){
	if (!s) return new Date();
		var ss = (s.split('-'));
		var y = parseInt(ss[2],10);
		var m = parseInt(ss[1],10);
		var d = parseInt(ss[0],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
				return new Date(y,m-1,d);
		} else {
				return new Date();
		}
}
</script>