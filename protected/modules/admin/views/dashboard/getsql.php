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
                                                <td><?php echo '', empty($nilai1) ? '0' : $nilai1['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? '0' : $nilai1['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? '0' : $nilai1['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai1) ? '0' : $nilai1['kum_sal'.$i];?></td>
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
                                                <td><?php echo '', empty($nilai2) ? '0' : $nilai2['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? '0' : $nilai2['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? '0' : $nilai2['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai2) ? '0' : $nilai2['kum_sal'.$i];?></td>
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
                                                <td><?php echo '', empty($nilai3) ? '0' : $nilai3['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? '0' : $nilai3['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? '0' : $nilai3['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai3) ? '0' : $nilai3['kum_sal'.$i];?></td>
                                            </tr>
                                            <?php } ?>
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Kasur Busa</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>Produksi VS Penjualan</td>
                                                <td><?php echo '', empty($nilai4) ? '0' : $nilai4['day_prod1'];?></td>
                                                <td><?php echo '', empty($nilai4) ? '0' : $nilai4['kum_prod1'];?></td>
                                                <td><?php echo '', empty($nilai4) ? '0' : $nilai4['day_sal1'];?></td>
                                                <td><?php echo '', empty($nilai4) ? '0' : $nilai4['kum_sal1'];?></td>
                                            </tr>
                                             <thead>
                                            <tr>
                                                <th rowspan="2">Balokan</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>Produksi VS Penjualan</td>
                                                <td><?php echo '', empty($nilai5) ? '0' : $nilai5['day_prod1'];?></td>
                                                <td><?php echo '', empty($nilai5) ? '0' : $nilai5['kum_prod1'];?></td>
                                                <td><?php echo '', empty($nilai5) ? '0' : $nilai5['day_sal1'];?></td>
                                                <td><?php echo '', empty($nilai5) ? '0' : $nilai5['kum_sal1'];?></td>
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
                                                <td><?php echo '', empty($nilai6) ? '0' : $nilai6['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? '0' : $nilai6['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? '0' : $nilai6['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai6) ? '0' : $nilai6['kum_sal'.$i];?></td>
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
                                                <td><?php echo '', empty($nilai7) ? '0' : $nilai7['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? '0' : $nilai7['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? '0' : $nilai7['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai7) ? '0' : $nilai7['kum_sal'.$i];?></td>
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
                                                <td><?php echo '', empty($nilai12) ? '0' : $nilai12['day_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? '0' : $nilai12['kum_prod'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? '0' : $nilai12['day_sal'.$i];?></td>
                                                <td><?php echo '', empty($nilai12) ? '0' : $nilai12['kum_sal'.$i];?></td>
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
                                                <td><?php echo '', empty($nilai8) ? '0' : $nilai8['day_prod1'];?></td>
                                                <td><?php echo '', empty($nilai8) ? '0' : $nilai8['kum_prod1'];?></td>
                                                <td><?php echo '', empty($nilai8) ? '0' : $nilai8['day_sal1'];?></td>
                                                <td><?php echo '', empty($nilai8) ? '0' : $nilai8['kum_sal1'];?></td>
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
                                                <td class="text-right"><?php echo '', empty($nilai9) ? '0' : number_format($nilai9['day_prod'.$i],0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? '0' : number_format($nilai9['kum_prod'.$i],0,',','.');?></td>
                                            </tr>
                                            <?php 
                                                $totalhari += $nilai9['day_prod'.$i];
                                                $totalkum += $nilai9['kum_prod'.$i];
                                                } ?>
                                            <tr>
                                                <td class="text-left">Total Penjualan Toko</td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? '0' : number_format($totalhari,0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai9) ? '0' : number_format($totalkum,0,',','.');?></td>
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
                                                <td class="text-left"><?php echo '', empty($nilai10) ? '0' : $nilai10['name'.$i];?></td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? '0' : number_format($nilai10['day_prod'.$i],0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? '0' : number_format($nilai10['kum_prod'.$i],0,',','.');?></td>
                                            </tr>
                                            <?php 
                                                $totalhari += $nilai10['day_prod'.$i];
                                                $totalkum += $nilai10['kum_prod'.$i];
                                                } ?>
                                            <tr>
                                                <td class="text-left">Total Penjualan Toko</td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? '0' : number_format($totalhari,0,',','.');?></td>
                                                <td class="text-right"><?php echo '', empty($nilai10) ? '0' : number_format($totalkum,0,',','.');?></td>
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
                                                <td class="text-left"><?php echo '', empty($nilai11) ? '0' : $nilai11['name'.$i];?></td>
                                                <td class="text-right"><?php echo '', empty($nilai11) ? '0' : number_format($nilai11['jumlah'.$i],0,',','.');?></td>
                                            </tr>
                                            <?php 
                                                $total += $nilai11['jumlah'.$i];
                                                } ?>
                                            <tr>
                                                <td class="text-left">Total Piutang Dagang</td>
                                                <td class="text-right"><?php echo '', empty($nilai11) ? '0' : number_format($total,0,',','.');?></td>
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