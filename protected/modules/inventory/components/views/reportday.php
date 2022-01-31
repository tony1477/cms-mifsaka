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
  left:35%;
}
</style>
<script type="text/javascript">
function searchdata($id=0)
{
    $('#SearchDialog').modal('hide');
    $('.ajax-loader').css('visibility', 'visible');
	$.fn.yiiGridView.update("ProductStockList",{data:{
		'storagebin':$("input[name='dlg_search_storagebin']").val(),
		'productname':$("input[name='dlg_search_productname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val()
	},
         complete: function(jqXHR, status) {
            if (status=='success'){
                //console.log(jqXHR, status)
                $('.ajax-loader').css("visibility", "hidden");
            }                                           
    }});
	return false;
}

function val() {
       $('.ajax-loader').css('visibility', 'visible');
       d = document.getElementById("select_id").value;       
       $("#tab_1").load("dashboard/getSql", {'companyid': d}, function(){
            $('.ajax-loader').css('visibility', 'hidden');        
       });
}
    
function downpdf($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('<?php echo Yii::app()->createUrl('Stock/productstock/downpdf')?>?'+array);
}

function click($id=0){
    var e = document.getElementById("company");
    var strUser = e.options[e.selectedIndex].text;
    alert(strUser);
}
    
function downxls($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('<?php echo Yii::app()->createUrl('Stock/productstock/downxls')?>?'+array);
}
</script>
<?php
?>
<div class="ajax-loader">
  <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" class="img-responsive" />
</div>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><a href="<?php echo Yii::app()->createUrl('stock/productstock/')?>">Report Day</a></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
	 <!-- Row -->
        <!--<h4 style="font-weight: bold">Produksi VS Penjualan</h4>-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <select class="custom-select pull-right" id="select_id" onchange="val()">
                                    <option selected="">- Cabang -</option>
                                    <?php 
                                        foreach($company as $row){ ?>
                                    ?>
                                    <option value="<?php echo $row['companyid'];?>"> <?php echo $row['companycode'];?> </option>
                                    <?php } ?>
                                </select>
                                <div id="tab_1">
                                <div class="col-md-6">
                                <h4 class="card-title">Produksi VS Penjualan</h4>
                                <div class="table-responsive">
                                    <table class="table stylish-table" border="0">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Kangaroo Premium</th>
                                                <th colspan="2" class="text-center">Production</th>
                                                <th colspan="2" class="text-center">Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="text-center">Hari</td>
                                                <td class="text-center">Kumulatif</td>
                                                <td class="text-center">Hari</td>
                                                <td class="text-center">Kumulatif</td>
                                            </tr>
                                            <?php 
                                                for($i=1; $i<=4; $i++){
                                                ?>
                                            <tr>
                                                <td><?php echo '', empty($nilai1) ? '-' : $nilai1['name'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? 'undefined' : $nilai1['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? 'undefined' : $nilai1['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? 'undefined' : $nilai1['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? 'undefined' : $nilai1['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Kangaroo Regular</th>
                                            </tr>
                                            </thead>
                                            <?php 
                                                for($i=1; $i<=4; $i++){
                                                ?>
                                            <tr>
                                                <td><?php echo '', empty($nilai2) ? '-' : $nilai2['name'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? 'undefined' : $nilai2['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? 'undefined' : $nilai2['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? 'undefined' : $nilai2['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? 'undefined' : $nilai2['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Kangaroo Non Regular</th>
                                            </tr>
                                            </thead>
                                            <?php 
                                                for($i=1; $i<=4; $i++){
                                                ?>
                                            <tr>
                                                <td><?php echo '', empty($nilai3) ? '-' : $nilai3['name'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? 'undefined' : $nilai3['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? 'undefined' : $nilai3['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? 'undefined' : $nilai3['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? 'undefined' : $nilai3['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Kasur Busa</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>Produksi VS Penjualan</td>
                                                <td><?php echo '', empty($nilai4) ? 'undefined' : $nilai4['day_prod1'];?></td>
                                                <td><?php echo '', empty($nilai4) ? 'undefined' : $nilai4['kum_prod1'];?></td>
                                                <td><?php echo '', empty($nilai4) ? 'undefined' : $nilai4['day_sal1'];?></td>
                                                <td><?php echo '', empty($nilai4) ? 'undefined' : $nilai4['kum_sal1'];?></td>
                                            </tr>
                                             <thead>
                                            <tr>
                                                <th rowspan="2">Balokan</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>Produksi VS Penjualan</td>
                                                <td><?php echo '', empty($nilai5) ? 'undefined' : $nilai5['day_prod1'];?></td>
                                                <td><?php echo '', empty($nilai5) ? 'undefined' : $nilai5['kum_prod1'];?></td>
                                                <td><?php echo '', empty($nilai5) ? 'undefined' : $nilai5['day_sal1'];?></td>
                                                <td><?php echo '', empty($nilai5) ? 'undefined' : $nilai5['kum_sal1'];?></td>
                                            </tr>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">WIP Rangka</th>
                                            </tr>
                                            </thead>
                                            <?php 
                                                for($i=1; $i<=3; $i++){
                                                ?>
                                            <tr>
                                                <td><?php echo '', empty($nilai6) ? '-' : $nilai6['name'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? 'undefined' : $nilai6['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? 'undefined' : $nilai6['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? 'undefined' : $nilai6['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? 'undefined' : $nilai6['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">WIP Kain</th>
                                            </tr>
                                            </thead>
                                            <?php 
                                                for($i=1; $i<=6; $i++){
                                                ?>
                                            <tr>
                                                <td><?php echo '', empty($nilai7) ? '-' : $nilai7['name'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? 'undefined' : $nilai7['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? 'undefined' : $nilai7['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? 'undefined' : $nilai7['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? 'undefined' : $nilai7['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Panel</th>
                                            </tr>
                                            </thead>
                                            <?php 
                                                for($i=1; $i<=3; $i++){
                                                ?>
                                            <tr>
                                                <td><?php echo '', empty($nilai12) ? '-' : $nilai12['name'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? 'undefined' : $nilai12['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? 'undefined' : $nilai12['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? 'undefined' : $nilai12['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? 'undefined' : $nilai12['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td>LP 2 PK</td>
                                                <td>..</td>
                                            </tr>
                                            <tr>
                                                <td>MR</td>
                                                <td>..</td>
                                            </tr>
                                            <tr>
                                                <td>MT</td>
                                                <td>..</td>
                                            </tr>
                                            <tr>
                                                <td>LA</td>
                                                <td>..</td>
                                            </tr>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Plastik</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>LP</td>
                                                <td>9.000.000.000</td>
                                                <td>9.000.000.000</td>
                                                <td>9.000.000.000</td>
                                                <td>9.000.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>-</td>
                                                <td>..</td>
                                            </tr>
                                            <tr>
                                                <td>Kursi</td>
                                                <td>..</td>
                                            </tr>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Sofa</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>LP 3 PK</td>
                                                <td>9.000.000.000</td>
                                                <td>9.000.000.000</td>
                                                <td>9.000.000.000</td>
                                                <td>9.000.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>LP 2 PK</td>
                                                <td>..</td>
                                            </tr>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Centian</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>Produksi VS Penjualan</td>
                                                <td><?php echo '', empty($nilai8) ? 'undefined' : $nilai8['day_prod1'];?></td>
                                                <td><?php echo '', empty($nilai8) ? 'undefined' : $nilai8['kum_prod1'];?></td>
                                                <td><?php echo '', empty($nilai8) ? 'undefined' : $nilai8['day_sal1'];?></td>
                                                <td><?php echo '', empty($nilai8) ? 'undefined' : $nilai8['kum_sal1'];?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                <div class="col-md-6" >
                                    <h4 class="card-title">Penjualan Toko Rp.</h4>
                                    <div class="table-responsive">
                                    <table class="table stylish-table" border="0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">Hari</th>
                                                <th class="text-center">Kumulatif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $totalhari = 0;
                                                $totalkum = 0;
                                                for($i=1; $i<=11; $i++){
                                                ?>
                                            <tr>
                                                <td class="text-left"><?php echo '', empty($nilai9) ? '-' : $nilai9['name'.$i];?></td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? 'undefined' : number_format($nilai9['day_prod'.$i],0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? 'undefined' : number_format($nilai9['kum_prod'.$i],0,',','.');?></td>
                                            </tr>
                                            <?php 
																							if($nilai9 != null){
                                                $totalhari += $nilai9['day_prod'.$i];
                                                $totalkum += $nilai9['kum_prod'.$i];
																							}
																							else {
																								$totalhari = 'undefined';
                                                $totalkum = 'undefined';
																							}
                                                } ?>
                                            <tr>
                                                <td class="text-left">Total Penjualan Toko</td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? 'undefined' : number_format($totalhari,0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? 'undefined' : number_format($totalkum,0,',','.');?></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <h4 class="card-title">Penjualan Cabang Rp.</h4>
                                        <div class="table-responsive">
                                        <table class="table stylish-table" border="0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">Hari</th>
                                                <th class="text-center">Kumulatif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $totalhari = 0;
                                                $totalkum = 0;
                                                for($i=1; $i<=10; $i++){
                                                ?>
                                            <tr>
                                                <td class="text-left"><?php echo '', empty($nilai10) ? 'undefined' : $nilai10['name'.$i];?></td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? 'undefined' : number_format($nilai10['day_prod'.$i],0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? 'undefined' : number_format($nilai10['kum_prod'.$i],0,',','.');?></td>
                                            </tr>
                                            <?php 
																							if($nilai10 != null){
                                                $totalhari += $nilai10['day_prod'.$i];
                                                $totalkum += $nilai10['kum_prod'.$i];
																							}
																							else {
																								$totalhari = 'undefined';
                                                $totalkum = 'undefined';
																							}
                                                } ?>
                                            <tr>
                                                <td class="text-left">Total Penjualan Toko</td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? 'undefined' : number_format($totalhari,0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? 'undefined' : number_format($totalkum,0,',','.');?></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="table-responsive">
                                        <h4 class="card-title">Piutang Dagang Rp.</h4>
                                        <table class="table stylish-table" border="0">
                                        <thead>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $total=0;
                                                for($i=1; $i<=4; $i++){
                                                ?>
                                            <tr>
                                                <td class="text-left"><?php echo '', empty($nilai11) ? 'undefined' : $nilai11['name'.$i];?></td>
                                                <td class="text-right"><?php echo '', empty($nilai11) ? 'undefined' : number_format($nilai11['jumlah'.$i],0,',','.');?></td>
                                            </tr>
                                            <?php 
																							if($nilai11 != null){
                                                $total += $nilai11['jumlah'.$i];
																							}
																							else {
																								$total = 'undefined';
																							}
                                                } ?>
                                            <tr>
                                                <td class="text-left">Total Piutang Dagang</td>
                                                <td class="text-right"><?php echo '', empty($nilai11) ? 'undefined' : number_format($total,0,',','.');?></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="table-responsive">
                                        <h4 class="card-title">Piutang Cabang Rp.</h4>
                                        <table class="table stylish-table" border="0">
                                        <tbody>
                                        <?php
                                            $total=0;
                                            $getcompany = Yii::app()->db->createCommand("select menuvalueid
                                            from groupmenuauth a
                                            join menuauth b on b.menuauthid = a.menuauthid
                                            join groupaccess c on c.groupaccessid = a.groupaccessid
                                            join usergroup d on d.groupaccessid = c.groupaccessid 
                                            join useraccess e on e.useraccessid = d.useraccessid
                                            where username= '".Yii::app()->user->id."' and menuobject = 'company' limit 1 ")->queryScalar();
                
                                            $sqlcompany = "select companycode, companyid from company where companyid <> ".$getcompany;
                                            $company = Yii::app()->db->createCommand($sqlcompany)->queryAll();
                                            foreach($company as $row){
                                                $sqlaccrec = "select sum(amount-payamount) as sisa
                                                            from (select a.invoiceno,a.invoicedate,e.paydays,
                                                            date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
                                                            datediff(curdate(),a.invoicedate) as umur,
                                                            datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),curdate()) as umurtempo,a.amount,ff.fullname as sales,
                                                            ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                                                            from cutarinv f
                                                            join cutar g on g.cutarid=f.cutarid
                                                            where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
                                                            from invoice a
                                                            inner join giheader b on b.giheaderid = a.giheaderid
                                                            inner join soheader c on c.soheaderid = b.soheaderid
                                                            inner join addressbook d on d.addressbookid = c.addressbookid
                                                            inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
                                                            inner join employee ff on ff.employeeid = c.employeeid
                                                            where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$row['companyid']."
                                                            and a.invoicedate <= curdate())z";
                                                $rows = Yii::app()->db->createCommand($sqlaccrec)->queryRow();
                                        ?>
                                            <tr>
                                                <td class="text-left" width="60%"><?php echo $row['companycode'];?></td>
                                                <td class="text-right" ></td>
                                                <td class="text-right"><?php echo number_format($rows['sisa'],0,',','.');?></td>
                                            </tr>
                                        <?php 
                                            $total += $rows['sisa'];
                                            } ?>
                                            <tr>
                                                <td class="text-left">Total Piutang Cabang</td>
                                                <td class="text-right"></td>
                                                <td class="text-right"><?php echo number_format($total,0,',','.');?></td>
                                                
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="table-responsive">
                                        <table class="table stylish-table" border="0">
                                        <tbody>
                                            <tr>
                                                <td><h4 class="card-title">Tagihan Hari ini VS Kumulatif</h4></td>
                                                <td class="text-right">9.000.000.000</td>
                                                <td class="text-right">9.000.000.000</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
																	</div>
																</div>
                            </div>
                        </div>
                    </div>
                </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
