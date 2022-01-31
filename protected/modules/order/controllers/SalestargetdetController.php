<?php

class SalestargetController extends AdminController
{
	protected $menuname = 'salestarget';
	public $module = 'Order';
	protected $pageTitle = 'Target Penjualan';
	public $wfname = 'appst';
	protected $sqldata = "select a0.salestargetid,a0.perioddate,a0.employeeid,a0.recordstatus,a0.statusname,a0.companyid,a1.fullname as employeename,a2.companyname as companyname,getwfstatusbywfname('appst',a0.recordstatus) as statusname, a0.useraccessid, a3.username, a0.docdate, a0.docno
    from salestarget a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join company a2 on a2.companyid = a0.companyid
    left join useraccess a3 on a3.useraccessid = a0.useraccessid
  ";
	protected $sqldatasalestargetdet = "select a0.salestargetdetid,a0.salestargetid,a0.materialgroupid,a0.productid,a0.qty,a1.productname as productname, a2.description, a0.slocid, a0.unitofmeasureid, a3.sloccode, a4.uomcode, a0.custcategoryid, a5.custcategoryname,a0.price
    from salestargetdet a0 
    left join product a1 on a1.productid = a0.productid
    left join materialgroup a2 on a2.materialgroupid=a0.materialgroupid
    left join sloc a3 on a3.slocid = a0.slocid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
    left join custcategory a5 on a5.custcategoryid = a0.custcategoryid
  ";
  protected $sqlcount = "select count(1) 
    from salestarget a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join company a2 on a2.companyid = a0.companyid
  ";
	protected $sqlcountsalestargetdet = "select count(1) 
    from salestargetdet a0 
    left join product a1 on a1.productid = a0.productid
    left join materialgroup a2 on a2.materialgroupid=a0.materialgroupid
    left join sloc a3 on a3.slocid = a0.slocid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
    left join custcategory a5 on a5.custcategoryid = a0.custcategoryid
  ";
    
	protected $sqldetailfg = "select b.materialgroupid, b.productid, sum(b.qty) as totalfg, c.description
    from salestarget a
    join salestargetdet b on b.salestargetid = a.salestargetid
    join materialgroup c on c.materialgroupid = b.materialgroupid ";

	protected $countdetailfg = "select ifnull(count(1),0) 
    from salestarget a
    join salestargetdet b on b.salestargetid = a.salestargetid
    join materialgroup c on c.materialgroupid = b.materialgroupid ";
    
	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appst')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
        $user = "select useraccessid from useraccess where username = '".Yii::app()->user->id."'";
        $userid = Yii::app()->db->createCommand($user)->queryScalar();

		$where = " where a0.recordstatus in (".getUserRecordStatus('listst').")
								and a0.recordstatus < {$maxstat}
                and a0.companyid in (".getUserObjectValues('company').")
                and a0.employeeid in (".getUserObjectValues('employee').")
            ";
		if ((isset($_REQUEST['fullname'])))
		{				
			$where .= " and a1.fullname like '%". $_REQUEST['fullname']."%'"; 
		}
        if ((isset($_REQUEST['companyname'])))
		{				
			$where .= " and a2.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
		if (isset($_REQUEST['salestargetid']))
			{
                $groupby = " where a.salestargetid = ". $_REQUEST['salestargetid']." ";
				if (($_REQUEST['salestargetid'] !== '0') && ($_REQUEST['salestargetid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " and a0.salestargetid in (".$_REQUEST['salestargetid'].")";
					}
					else
					{
						$where .= " and a0.salestargetid in (".$_REQUEST['salestargetid'].")";
					}
				}
			}
        else
        {
            $groupby = " where a.salestargetid = 0 ";
        }
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
        $this->sqldetailfg = $this->sqldetailfg.$groupby;
        $this->countdetailfg = $this->countdetailfg.$groupby;
	}
 	public function actionGeneratedetail()
	{
        
        $companyid = $_REQUEST['companyid'];
        $employeeid = $_REQUEST['employeeid'];
        $salestargetid = $_REQUEST['salestargetid'];        
        $perioddate = $_REQUEST['perioddate'];
        
        $month = date('m',strtotime($perioddate));
        $year = date('Y',strtotime($perioddate));
        
        $prev_month_ts = strtotime(''.$year.'-'.$month.'-01 -4 month');
        $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -2 month');
        
        $lastmonth1 = date('Y-m-d', $prev_month_ts);
        $lastmonth2 = date('Y-m-t', $prev_month_ts2);
        
        try
			{
            $connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
            $del = "delete from salestargetdet where salestargetid = ".$salestargetid;
            $cmd = Yii::app()->db->createCommand($del)->execute();
            
        
            $sql = "replace into salestargetdet(salestargetid,materialgroupid,productid,slocid,unitofmeasureid,qty,price,custcategoryid)
                    select {$salestargetid},matgroupid,productid,slocid,unitofmeasureid,sum(qty) as qty,
                    ifnull((select sum(getamountdiscso(zzd.soheaderid,zza.sodetailid,zzb.qty))/sum(zzb.qty)
                        from invoice xx                                
                        join giheader zzc on zzc.giheaderid = xx.giheaderid
                        join gidetail zzb on zzb.giheaderid = zzc.giheaderid
                        join sodetail zza on zza.sodetailid = zzb.sodetailid
                        join soheader zzd on zzd.soheaderid = zzc.soheaderid
                        join product zze on zze.productid = zzb.productid
                        join productplant zzf on zzf.productid = zze.productid and zzf.unitofissue = zzb.unitofmeasureid
                        and zzf.slocid = zzb.slocid
                        where zzf.productid = zz.productid and zzb.slocid = zz.slocid
                        and xx.invoicedate between '{$lastmonth1}' and '{$lastmonth2}' and xx.recordstatus = 3),0) as harga,custcategoryid from 
                            (select matgroupid,slocid,unitofmeasureid,productname,productid,sum(qty) as qty,0 as harga,custcategoryid from
                            (select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,l.materialgroupid as matgroupid, ss.slocid,ss.unitofmeasureid,m.custcategoryid
                            from invoice a 
                            join giheader b on b.giheaderid = a.giheaderid
                            join soheader c on c.soheaderid = b.soheaderid
                            join addressbook d on d.addressbookid = c.addressbookid
                            join employee e on e.employeeid = c.employeeid
                            join salesarea f on f.salesareaid = d.salesareaid
                            join sodetail g on g.soheaderid = b.soheaderid
                            join gidetail ss on ss.giheaderid = b.giheaderid
                            join sloc h on h.slocid = ss.slocid
                            join product i on i.productid = ss.productid
                            join productplant j on j.productid = i.productid and j.slocid=g.slocid
                            join materialgroup l on l.materialgroupid = j.materialgroupid
                            join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
                            left join custcategory m on m.custcategoryid = d.custcategoryid
                            where a.recordstatus = 3 and a.invoiceno is not null and
                            c.companyid = {$companyid} and i.isstock = 1
                            and a.invoiceno is not null and e.employeeid = {$employeeid} 
                            and month(a.invoicedate) = month(date_add('{$perioddate}',interval -2 month)) 
                            and year(a.invoicedate) = year(date_add('{$perioddate}',interval -2 month))
                            and l.parentmatgroupid in (select materialgroupid from materialgroup x where x.isfg=1)
                            )z group by productname,custcategoryid
                            union
                            select materialgroupid,slocid,unitofmeasureid,productname,productid,-1*sum(qty) as qty,0 as harga,custcategoryid from
                            (select distinct a.notagirproid,i.productname,a.qty, o.materialgroupid,e.slocid,e.unitofmeasureid,a.productid,p.custcategoryid
                            from notagirpro a
                            join notagir b on b.notagirid=a.notagirid
                            join gireturdetail c on c.gireturdetailid=a.gireturdetailid
                            join giretur d on d.gireturid=b.gireturid
                            join gidetail e on e.gidetailid=c.gidetailid
                            join giheader f on f.giheaderid=d.giheaderid
                            join sodetail g on g.sodetailid=e.sodetailid
                            join soheader h on h.soheaderid=f.soheaderid
                            join product i on i.productid = a.productid
                            join sloc j on j.slocid = a.slocid
                            join addressbook k on k.addressbookid = h.addressbookid
                            join employee l on l.employeeid = h.employeeid
                            join salesarea m on m.salesareaid = k.salesareaid
                            join productplant n on n.productid=a.productid and n.slocid=a.slocid
                            join materialgroup o on o.materialgroupid = n.materialgroupid
                            left join custcategory p on p.custcategoryid = k.custcategoryid
                            where h.companyid = {$companyid} and b.recordstatus = 3
                            and i.isstock = 1 and l.employeeid = {$employeeid} 
                            and month(d.gireturdate) = month(date_add('{$perioddate}',interval -2 month))
                            and year(d.gireturdate) = year(date_add('{$perioddate}',interval -2 month))
                            and o.parentmatgroupid in (select materialgroupid from materialgroup x where x.isfg=1)
                            )z group by productname,custcategoryid )zz 
                            group by productname,custcategoryid order by productname";

            $exec = $connection->createCommand($sql)->execute();
            
            $transaction->commit();
            $this->getMessage('success','alreadysaved');
            }
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
    }
  public function actionGenerateproduct()
	{
        $companyid = $_REQUEST['companyid'];
        $productid = $_REQUEST['productid'];
        
        $sql = "select a.slocid, c.unitofmeasureid, b.sloccode, c.uomcode, a.materialgroupid, d.materialgroupcode
                from productplant a 
                join sloc b on b.slocid = a.slocid
                join plant t on t.plantid = b.plantid
                join unitofmeasure c on c.unitofmeasureid = a.unitofissue
                join materialgroup d on d.materialgroupid = a.materialgroupid
				where a.recordstatus = 1 and a.productid = {$productid} 
                and b.slocid in (select  gm.menuvalueid
                from usergroup ug
                join useraccess u on ug.useraccessid = u.useraccessid
                join groupmenuauth gm on gm.groupaccessid = ug.groupaccessid
                join menuauth m on m.menuauthid = gm.menuauthid
                where username = '".Yii::app()->user->id."' and m.menuobject = 'sloc')
                and t.companyid = ".$companyid;
        $res = Yii::app()->db->createCommand($sql)->queryRow();
        echo CJSON::encode(array(
                        'status'=>'success',
                        'materialgroupid' => $res['materialgroupid'],
                        'materialgroupcode' => $res['materialgroupcode'],
                        'slocid'=>$res['slocid'],
                        'sloccode'=>$res['sloccode'],
                        'unitofmeasureid'=>$res['unitofmeasureid'],
                        'uomcode'=>$res['uomcode'],
					));
					Yii::app()->end();
    }
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'salestargetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'salestargetid','perioddate','docdate','employeeid','recordstatus','useraccessid','companyid','docno'
				),
				'defaultOrder' => array( 
					'salestargetid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['salestargetid']))
		{
			$this->sqlcountsalestargetdet .= ' where a0.salestargetid = '.$_REQUEST['salestargetid'];
			$this->sqldatasalestargetdet .= ' where a0.salestargetid = '.$_REQUEST['salestargetid'];
            //$this->countdetailfg .= ' where a.salestargetid = '.$_REQUEST['salestargetid'].' group by b.materialgroupid';
            //$this->sqldetailfg .= ' where a.salestargetid = '.$_REQUEST['salestargetid'].' group by b.materialgroupid';
		}
        
		$countsalestargetdet = Yii::app()->db->createCommand($this->sqlcountsalestargetdet)->queryScalar();
    $dataProvidersalestargetdet=new CSqlDataProvider($this->sqldatasalestargetdet,array(
					'totalItemCount'=>$countsalestargetdet,
					'keyField'=>'salestargetdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'salestargetdetid' => CSort::SORT_DESC
						),
					),
					));
      
        
        $countdetailfg = Yii::app()->db->createCommand($this->countdetailfg)->queryScalar();
    $dataProviderFG=new CSqlDataProvider($this->sqldetailfg,array(
					'totalItemCount'=>'10',
					'keyField'=>'materialgroupid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'materialgroupid' => CSort::SORT_DESC
						),
					),
					));
        
        $getFG = 'select materialgroupid, description, materialgroupcode
                from materialgroup
                where isfg = 1 order by materialgroupcode asc';
        $dataFG = Yii::app()->db->createCommand($getFG)->queryAll();
        //$i=1;
        foreach($dataFG as $row)
        {
            /*$dataProvider1['data'.$row['materialgroupcode']]['count'] = $this->sqldetailfg.' and materialgroupid = '.$row['materialgroupid'];
            $dataProvider1['data'.$row['materialgroupcode']]['data'] = $this->countdetailfg. ' and materialgroupid = '.$row['materialgroupid'];*/
        }
        
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersalestargetdet'=>$dataProvidersalestargetdet,'dataFG'=>$dataFG));
	}
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into salestarget (perioddate,recordstatus) values (curdate(),".$this->findstatusbyuser('insst').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
			'status'=>'success',
			'salestargetid'=>$id,
			"perioddate" =>date("Y-m-d"),
            "recordstatus" =>$this->findstatusbyuser("insst")
		));
	}
  public function actionCreatesalestargetdet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.salestargetid = '.$id)->queryRow();
			if ($this->CheckDoc($this->wfname))
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
                        'status'=>'success',
                        'salestargetid'=>$model['salestargetid'],
                        'perioddate'=>$model['perioddate'],
                        'docdate'=>$model['docdate'],
                        'employeeid'=>$model['employeeid'],
                        'recordstatus'=>$model['recordstatus'],
                        'companyid'=>$model['companyid'],
                        'employeename'=>$model['employeename'],
                        'companyname'=>$model['companyname'],
					));
					Yii::app()->end();
				}
			}
			else
			{
				$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			}
		}
	}
  public function actionUpdatesalestargetdet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatasalestargetdet.' where salestargetdetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
                    'status'=>'success',
                    'salestargetdetid'=>$model['salestargetdetid'],
                    'salestargetid'=>$model['salestargetid'],
                    'custcategoryid'=>$model['custcategoryid'],
                    'custcategoryname'=>$model['custcategoryname'],
                    'materialgroupid'=>$model['materialgroupid'],
                    'materialgroupcode'=>$model['description'],
                    'productid'=>$model['productid'],
                    'qty'=>$model['qty'],
                    'productname'=>$model['productname'],
                    'slocid'=>$model['slocid'],
                    'unitofmeasureid'=>$model['unitofmeasureid'],
                    'sloccode'=>$model['sloccode'],
                    'uomcode'=>$model['uomcode'],
                    'price'=>$model['price'],
				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('docdate','string','emptydocdate'),
			array('perioddate','string','emptyperioddate'),
			array('companyid','string','emptycompanyid'),
			array('employeeid','string','emptyemployeeid'),
            array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['salestargetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateSalestarget(:salestargetid,:docdate,:perioddate,:employeeid,:companyid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':salestargetid',$_POST['salestargetid'],PDO::PARAM_STR);
				$command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
				$command->bindvalue(':perioddate',(($_POST['perioddate']!=='')?$_POST['perioddate']:null),PDO::PARAM_STR);
                $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
	public function actionSavesalestargetdet()
    {
        parent::actionSave();
        $error = $this->ValidateData(array(
            array('salestargetid','string','emptysalestargetid'),
            array('materialgroupid','string','emptymaterialgroupid'),
            array('productid','string','emptyproductid'),
            array('slocid','string','emptyslocid'),
            array('unitofmeasureid','string','emptyunitofmeasureid'),
            array('price','string','emptyprice'),
    ));
        if ($error == false)
        {
            $id = $_POST['salestargetdetid'];
            $connection=Yii::app()->db;
            $transaction=$connection->beginTransaction();
            try
            {
                $perioddate = $_REQUEST['perioddate'];
                $matgroupid = $_POST['materialgroupid'];
                $month = date('m',strtotime($perioddate));
                $year = date('Y',strtotime($perioddate));

                $prev_month_ts = strtotime(''.$year.'-'.$month.'-01 -4 month');
                $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -2 month');

                $lastmonth1 = date('Y-m-d', $prev_month_ts);
                $lastmonth2 = date('Y-m-t', $prev_month_ts2);
                
                if ($id !== '')
                {
                    
                    $sql = 'call Updatesalestargetdetail(:vid,:vsalestargetid,:vcustcategoryid,:vmatgroupid,:vproductid,:vqty,:vslocid,:vuomid,:vprice,:vcreatedby)';
                    
                    /*
                    $sql = "update salestargetdet set salestargetid = :vsalestargetid, custcategoryid = :vcustcategoryid, materialgroupid = :vmatgroupid, productid = :vproductid, qty = :vqty, slocid = :vslocid, unitofmeasureid = :vuomid, price = :vprice
                    where salestargetdetid = :vid";
                    */
                }
                else
                {
                    $sql = 'call Insertsalestargetdetail(:vsalestargetid,:vcustcategoryid,:vmatgroupid,:vproductid,:vqty,:vslocid,:vuomid,:vprice,:vcreatedby)';
                }
                $command = $connection->createCommand($sql);
                if ($id !== '')
                {
                    $command->bindvalue(':vid',$_POST['salestargetdetid'],PDO::PARAM_STR);
                }
                $command->bindvalue(':vsalestargetid',(($_POST['salestargetid']!=='')?$_POST['salestargetid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustcategoryid',(($_POST['custcategoryid']!=='')?$_POST['custcategoryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmatgroupid',(($_POST['materialgroupid']!=='')?$_POST['materialgroupid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vproductid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vqty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
                $command->bindvalue(':vslocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vuomid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vprice',$_POST['price'],PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
                $command->execute();
                $transaction->commit();
                $this->getMessage('success','alreadysaved');
            }
            catch (CDbException $e)
            {
                $transaction->rollBack();
                $this->getMessage('error',$e->getMessage());
            }
        }
    }
	public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Approvesalestarget(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	public function actionDelete()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Deletesalestarget(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	public function actionPurge()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from salestarget where salestargetid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			else
			{
				$this->getMessage('success','chooseone');
			}
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	public function actionPurgesalestargetdet()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from salestargetdet where salestargetdetid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	public function actionDownPDF1()
	{
		parent::actionDownPDF();
		//$this->getSQL();
		//$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
        
		$sql = "select a.docdate,a.perioddate, d.fullname, a.employeeid, a.companyid, a.salestargetid
						from salestarget a
						join employee d on d.employeeid = a.employeeid ";
        
        if ($_GET['salestargetid'] !== '') 
		{
				$sql = $sql . "where a.salestargetid in (".$_GET['salestargetid'].")";
		}
						
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        
        foreach($result as $row)
        {
            $totalqty2 = 0;
            $totalharga2 = 0;
		
            $datetime = new DateTime($row['perioddate']);
            //masukkan judul
            $this->pdf->title=$this->getCatalog('salestarget');
            $this->pdf->AddPage('P','A4');

            $this->pdf->setFont('Arial','B',11);
            $this->pdf->text(10,15,'Tanggal ');
            $this->pdf->text(10,20,'Nama Sales ');
            $this->pdf->text(10,25,'Periode ');
            //$this->pdf->text(10,25,'Total Target ');
            $this->pdf->text(45,15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
            $this->pdf->text(45,20,': '.$row['fullname']);
            $this->pdf->text(45,25,': '.$datetime->format('F').' '.$datetime->format('Y'));
            //$this->pdf->text(45,25,': 999999999999');

            $month = date('m',strtotime($row['perioddate']));
            $year = date('Y',strtotime($row['perioddate']));

            $prev_month_ts1 = strtotime(''.$year.'-'.$month.'-01 -4 month');
            $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -2 month');

            $lastmonth1 = date('Y-m-d', $prev_month_ts1);
            $lastmonth2 = date('Y-m-t', $prev_month_ts2);

            $sql1 = "select b.materialgroupid, c.description, b.productid, b.slocid, b.unitofmeasureid, a.salestargetid
                             from salestarget a
                             left join salestargetdet b on a.salestargetid = b.salestargetid
                             left join materialgroup c on c.materialgroupid = b.materialgroupid ";
                             //where a.salestargetid = ".$_REQUEST['salestargetid']." 
                             //group by b.materialgroupid";
            $sql1 = $sql1 . " where a.salestargetid = ".$row['salestargetid']." group by b.materialgroupid ";
            $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();

            $this->pdf->setFont('Arial','',11);
            $this->pdf->setY($this->pdf->getY()+13);
            $this->pdf->colalign = array('C','C','C','C','C','C');
            $this->pdf->colheader = array($this->getCatalog('NO'),$this->getCatalog('productname'),$this->getCatalog('targetqty'),$this->getCatalog('targetharga'));
            $this->pdf->setwidths(array(10,120,25,35));
            $this->pdf->Rowheader();        

            foreach($dataReader1 as $row1)
            {
                //masukkan baris untuk cetak
                $totalqty = 0;
                $totalharga = 0;

                $i=1;
                //$this->pdf->text(20,$this->pdf->getY()+10,'Group Material :');
                $this->pdf->setFont('Arial','B',10);
                $this->pdf->setwidths(array(10,200));
                $this->pdf->coldetailalign = array('L','L');
                $this->pdf->row(array('','MATERIAL GROUP : '.$row1['description']));
                $this->pdf->setwidths(array(10,120,25,35,));
                $this->pdf->coldetailalign = array('C','L','R','R');
                $this->pdf->setFont('Arial','',9);
                $sql2 = "
                            select sum(b.qty) as qty, d.productname,b.productid,b.unitofmeasureid, sum(qty)*price as targetharga
                            from salestarget a
                            join salestargetdet b on a.salestargetid = b.salestargetid
                            join product d on d.productid = b.productid
                            join productplant e on e.productid = d.productid and e.slocid = b.slocid and e.unitofissue = b.unitofmeasureid
                            join materialgroup f on f.materialgroupid = e.materialgroupid
                            where a.salestargetid = {$row['salestargetid']} and a.companyid = {$row['companyid']} and  b.materialgroupid = {$row1['materialgroupid']} group by productid";
                $dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
                $j=1;
                foreach($dataReader2 as $row2)
                {
                    $this->pdf->row(array($j,
                        $row2['productname'],
                        Yii::app()->format->formatNumber($row2['qty']),
                        Yii::app()->format->formatCurrency($row2['targetharga']),
                    ));
                    $totalqty += $row2['qty'];
                    $totalharga += $row2['targetharga'];
                    //$totalkumqty += $row2['kumqty'];
                    //$totalkumharga += $row2['kumharga'];

                    $j++;
                }
                $this->pdf->setFont('Arial','B',10);
                $this->pdf->coldetailalign = array('L','R','R','R');
                $this->pdf->row(array('','JUMLAH '.$row1['description'],
                    Yii::app()->format->formatNumber($totalqty),
                    Yii::app()->format->formatCurrency($totalharga),
                ));			
                $totalqty2 += $totalqty;
                $totalharga2 += $totalharga;
            }
            $this->pdf->setY($this->pdf->getY()+5);
            $this->pdf->setFont('Arial','B',10);
            $this->pdf->coldetailalign = array('L','R','R','R');
            $this->pdf->row(array('','TOTAL TARGET SALES '.$row['fullname'],
                Yii::app()->format->formatNumber($totalqty2),
                Yii::app()->format->formatCurrency($totalharga2),
            ));
        }
		// me-render ke browser
		$this->pdf->Output();
	}
  public function actionDownPDF()
	{
		parent::actionDownPDF();
		//$this->getSQL();
		//$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
        
		$sql = "select a.docdate,a.perioddate, d.fullname, a.employeeid, a.companyid, a.salestargetid
						from salestarget a
						join employee d on d.employeeid = a.employeeid ";
        
        if ($_GET['salestargetid'] !== '') 
		{
				$sql = $sql . "where a.salestargetid in (".$_GET['salestargetid'].")";
		}
						
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        
        foreach($result as $row)
        {
            $totalqty2 = 0;
            $totalharga2 = 0;
		
            $datetime = new DateTime($row['perioddate']);
            //masukkan judul
            $this->pdf->title=$this->getCatalog('salestarget');
            $this->pdf->AddPage('P','A4');

            $this->pdf->setFont('Arial','B',11);
            $this->pdf->text(10,15,'Tanggal ');
            $this->pdf->text(10,20,'Nama Sales ');
            $this->pdf->text(10,25,'Periode ');
            //$this->pdf->text(10,25,'Total Target ');
            $this->pdf->text(45,15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
            $this->pdf->text(45,20,': '.$row['fullname']);
            $this->pdf->text(45,25,': '.$datetime->format('F').' '.$datetime->format('Y'));
            //$this->pdf->text(45,25,': 999999999999');

            $month = date('m',strtotime($row['perioddate']));
            $year = date('Y',strtotime($row['perioddate']));

            $prev_month_ts1 = strtotime(''.$year.'-'.$month.'-01 -4 month');
            $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -2 month');

            $lastmonth1 = date('Y-m-d', $prev_month_ts1);
            $lastmonth2 = date('Y-m-t', $prev_month_ts2);
            
            $sql1 = "select a.custcategoryid,b.custcategoryname
                             from salestargetdet a
                             left join custcategory b on a.custcategoryid = b.custcategoryid 
                             where a.salestargetid = ".$_REQUEST['salestargetid']." group by b.custcategoryid";
            
            $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
            $this->pdf->setY($this->pdf->getY()+13);
            foreach($dataReader1 as $row1)
            {
                $qtycustomercat = 0;
                $hargacustomercat = 0;
                $this->pdf->text(10,$this->pdf->getY()+5,getCatalog('custcategory').' : '.$row1['custcategoryname']);
                
                $sql2 = "select b.materialgroupid, c.description, b.productid, b.slocid, b.unitofmeasureid, b.salestargetid
                             from salestargetdet b 
                             left join materialgroup c on c.materialgroupid = b.materialgroupid ";
                             //where a.salestargetid = ".$_REQUEST['salestargetid']." 
                             //group by b.materialgroupid";
                $sql2 = $sql2 . " where b.salestargetid = ".$row['salestargetid']." and b.custcategoryid = ".$row1['custcategoryid']." group by b.materialgroupid ";
                $dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
                $this->pdf->setFont('Arial','',11);
                $this->pdf->setY($this->pdf->getY()+8);
                $this->pdf->colalign = array('C','C','C','C','C','C');
                $this->pdf->colheader = array($this->getCatalog('NO'),$this->getCatalog('productname'),$this->getCatalog('targetqty'),$this->getCatalog('targetharga'));
                $this->pdf->setwidths(array(10,120,25,35));
                $this->pdf->Rowheader();        

                foreach($dataReader2 as $row2)
                {
                    //masukkan baris untuk cetak
                    $totalqty = 0;
                    $totalharga = 0;

                    $i=1;
                    //$this->pdf->text(20,$this->pdf->getY()+10,'Group Material :');
                    $this->pdf->setFont('Arial','B',10);
                    $this->pdf->setwidths(array(10,200));
                    $this->pdf->coldetailalign = array('L','L');
                    $this->pdf->row(array('','MATERIAL GROUP : '.$row2['description']));
                    $this->pdf->setwidths(array(10,120,25,35,));
                    $this->pdf->coldetailalign = array('C','L','R','R');
                    $this->pdf->setFont('Arial','',9);
                    $sql3 = "
                                select sum(b.qty) as qty, d.productname,b.productid,b.unitofmeasureid, sum(qty)*price as targetharga
                                from salestarget a
                                join salestargetdet b on a.salestargetid = b.salestargetid
                                join product d on d.productid = b.productid
                                join productplant e on e.productid = d.productid and e.slocid = b.slocid and e.unitofissue = b.unitofmeasureid
                                join materialgroup f on f.materialgroupid = e.materialgroupid
                                where a.salestargetid = {$row['salestargetid']} and a.companyid = {$row['companyid']} and  b.materialgroupid = {$row2['materialgroupid']} and b.custcategoryid = ".$row1['custcategoryid']." group by productid";
                    $dataReader3 = Yii::app()->db->createCommand($sql3)->queryAll();
                    $j=1;
                    foreach($dataReader3 as $row3)
                    {
                        $this->pdf->row(array($j,
                            $row3['productname'],
                            Yii::app()->format->formatNumber($row3['qty']),
                            Yii::app()->format->formatCurrency($row3['targetharga']),
                        ));
                        $totalqty += $row3['qty'];
                        $totalharga += $row3['targetharga'];
                        //$totalkumqty += $row2['kumqty'];
                        //$totalkumharga += $row2['kumharga'];

                        $j++;
                    }
                    $this->pdf->setFont('Arial','B',10);
                    $this->pdf->coldetailalign = array('L','R','R','R');
                    $this->pdf->row(array('','JUMLAH '.$row2['description'],
                        Yii::app()->format->formatNumber($totalqty),
                        Yii::app()->format->formatCurrency($totalharga),
                    ));
                    $this->pdf->setY($this->pdf->getY()+5);
                    $totalqty2 += $totalqty;
                    $totalharga2 += $totalharga;
                    
                    $qtycustomercat += $totalqty;
                    $hargacustomercat += $totalharga;
                }
                $this->pdf->row(array('','JUMLAH '.$row1['custcategoryname'],
                    Yii::app()->format->formatNumber($qtycustomercat),
                    Yii::app()->format->formatCurrency($hargacustomercat),
                ));
            }
            $this->pdf->setY($this->pdf->getY()+5);
            $this->pdf->setFont('Arial','B',10);
            $this->pdf->coldetailalign = array('L','R','R','R');
            $this->pdf->row(array('','TOTAL TARGET SALES '.$row['fullname'],
                Yii::app()->format->formatNumber($totalqty2),
                Yii::app()->format->formatCurrency($totalharga2),
            ));
        }
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('salestargetid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('perioddate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('statusname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('companyname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['salestargetid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['perioddate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['statusname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['companyname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}