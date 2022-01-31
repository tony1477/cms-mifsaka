<?php

class ScanhpController extends AdminController
{
	protected $menuname = 'scanhp';
	public $module = 'Production';
	protected $pageTitle = 'Scan Hasil Produksi';
	public $wfname = '';
	
    protected $sqldata = "SELECT a.tempscanid, a.barcode, a.companyid, a.productplanid, a.productplanfgid, b.productid, b.productname, a.isapprovehp, c.productplanno
                        FROM tempscan a 
                        join product b ON a.productid=b.productid 
                        join productplan c on c.productplanid = a.productplanid ";
    
    /*protected $sqldata = "SELECT a.productoutputid, a.productoutputdate, a.productplanid, a.description, a.recordstatus, a.statusname, b.companyid, d.productname, b.barcode FROM productoutput a INNER JOIN tempscan b INNER JOIN product d ON a.productplanid=b.productplanid AND d.productid = b.productid WHERE b.isscan='1' AND a.recordstatus='1'*/
    /*
    protected $sqldata = "SELECT a.productoutputid, a.productoutputdate, a.productplanid, a.description, a.recordstatus, a.statusname, b.companyid,  d.productname, b.barcode FROM productoutput a INNER JOIN tempscan b INNER JOIN productoutputfg c INNER JOIN product d ON a.productplanid=b.productplanid AND c.productoutputfgid=b.productoutputfgid AND c.productoutputid=a.productoutputid AND d.productid = b.productid WHERE b.isscanhp='1' AND a.recordstatus<'3' AND isapprovehp<'3' ORDER BY productoutputid DESC
  ";
  */
    
    protected $sqlcompany = "SELECT f.menuvalueid 
			from groupaccess c inner join usergroup d on d.groupaccessid = c.groupaccessid inner join useraccess e on e.useraccessid = d.useraccessid
			INNER JOIN groupmenuauth f ON f.groupaccessid = c.groupaccessid INNER JOIN menuauth g ON g.menuauthid=f.menuauthid ";

    protected $sqlcount = "SELECT COUNT(1)
                        FROM tempscan a 
                        join product b ON a.productid=b.productid 
                        join productplan c on c.productplanid = a.productplanid ";
    /*
  protected $sqlcount = "SELECT COUNT(1) FROM productoutput a INNER JOIN tempscan b INNER JOIN productoutputfg c ON a.productplanid=b.productplanid AND b.productoutputfgid=c.productoutputfgid AND c.productoutputid=a.productoutputid WHERE b.isscanhp='1' AND recordstatus<'3' AND isapprovehp<'3'
  ";
  */

    
protected $updateproductouputid = "UPDATE productoutputfg SET qtyoutput";
	protected function getSQL()
	{
        $where = "where isscanhp='1' and slocid in (".getUserObjectValues('sloc').")";
		
        $where .= " and a.isapprovehp in (".getUserRecordStatus('listscanhp').")
				and a.companyid in (".getUserObjectValues('company').") 
				and c.employeeid in (".getUserObjectValues('employee').")";
		/*
        if ((isset($_REQUEST['productoutputno'])) && (isset($_REQUEST['productplanno'])))
		{				
			$where .=  " 
and a0.productoutputno like '%". $_REQUEST['productoutputno']."%' 
and a1.productplanno like '%". $_REQUEST['productplanno']."%'"; 
		}
		if (isset($_REQUEST['productoutputid']))
			{
				if (($_REQUEST['productoutputid'] !== '0') && ($_REQUEST['productoutputid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productoutputid in (".$_REQUEST['productoutputid'].")";
					}
					else
					{
						$where .= " and a0.productoutputid in (".$_REQUEST['productoutputid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
        */
        $this->sqldata = $this->sqldata.$where;
				$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
    public function getname(){
        return Yii::app()->user->name;
    }
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
                'keyField'=>'tempscanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'tempscanid','barcode','productname','productplanid','productplanno','isapprovehp'
				),
                
			),
		));
		
        $wherecompany = " where e.username='".Yii::app()->user->name."' and g.menuobject = 'company'";
        $wheresloc = " where e.username='".Yii::app()->user->name."' and g.menuobject = 'sloc'";
        $getcompany = $this->sqlcompany.$wherecompany;
        $companyid = Yii::app()->db->createCommand($getcompany)->queryScalar();
        $slocid = Yii::app()->db->createCommand($this->sqlcompany.$wheresloc)->queryScalar();
		$this->render('index',array('dataProvider'=>$dataProvider,'companyid'=>$companyid,'slocid'=>$slocid));
	}

	
    public function actionApproveScan(){
        parent::actionPost();
        #$id = $_POST['productplanid'];
        $slocid = $_POST['slocid'];
        $headernote = $_POST['headernote'];
        $actiontype = $_POST['actiontype'];
        date_default_timezone_set('Asia/Jakarta');
        $connection = Yii::app()->db;
        
        $userid = $connection->createCommand("select useraccessid from useraccess where username = '".Yii::app()->user->id."'")->queryScalar();
        
        if(!isset($_POST['id']))
        {
            $getproductplanid = "select productplanid, datehp 
                        from tempscan b where isscanhp=1 and isapprovehp<3 and useraccessid =".$userid." and slocid in (
                        select a.menuvalueid 
                        from groupmenuauth a
                        join groupaccess b on b.groupaccessid = a.groupaccessid
                        join usergroup c on c.groupaccessid = b.groupaccessid
                        join useraccess d on d.useraccessid = c.useraccessid
                        join menuauth e on e.menuauthid = a.menuauthid
                        where d.useraccessid = {$userid} and upper(e.menuobject) = upper('sloc')) group by productplanid order by datehp asc";
            $run = $connection->createCommand($getproductplanid)->queryAll();
            $i=1;

            foreach($run as $row){
                //echo($row);
                #echo $row['productplanid']."<br /> ->".$i;
                #$i++;
                # run SP
                if($row['productplanid']>0 && $row['productplanid']!='') {
                    $transaction=$connection->beginTransaction();
                    try {
                        $sql = 'CALL approveScanOP(:vproductplanid,:vproductoutputdate,:vcreatedby,:vtoslocid,:vheadernote,:vactiontype)';
                        $cmd = $connection->createCommand($sql);
                        $cmd->bindvalue(':vproductplanid',$row['productplanid'],PDO::PARAM_STR);
                        $cmd->bindvalue(':vproductoutputdate',$row['datehp'],PDO::PARAM_STR);
                        $cmd->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
                        $cmd->bindvalue(':vtoslocid',$slocid,PDO::PARAM_STR);
                        $cmd->bindvalue(':vheadernote',$headernote,PDO::PARAM_STR);
                        $cmd->bindvalue(':vactiontype',$actiontype,PDO::PARAM_INT);
                        $cmd->execute();
                        $transaction->commit();
                    } catch(Exception $e){
                        $transaction->rollback();
                        $this->getMessage('error',$e->getMessage(),1);
                    }
                }
            }
        }
        else
        { 
            $id=$_POST['id'];
            if (!is_array($id))
            {
                $ids[] = $id; 
                $id = $ids;
            }
            $all = implode(',', $id);
                        
            $getproductplanid = "select productplanid, datehp, group_concat(tempscanid) as tempscanid
                        from tempscan b where isscanhp=1 and isapprovehp<3 and useraccessid =  {$userid} and slocid in (
                        select a.menuvalueid 
                        from groupmenuauth a
                        join groupaccess b on b.groupaccessid = a.groupaccessid
                        join usergroup c on c.groupaccessid = b.groupaccessid
                        join useraccess d on d.useraccessid = c.useraccessid
                        join menuauth e on e.menuauthid = a.menuauthid
                        where d.useraccessid={$userid} and upper(e.menuobject) = upper('sloc')) and tempscanid in($all) group by productplanid order by datehp asc";
            $run = $connection->createCommand($getproductplanid)->queryAll();
            $i=1;

            foreach($run as $row){
                //echo($row);
                #echo $row['productplanid']."<br /> ->".$i;
                #$i++;
                # run SP
                if($row['productplanid']>0 && $row['productplanid']!='') {
                    $transaction=$connection->beginTransaction();
                    try {
                        $sql = 'call approveScanOPSelect(:vtempscanid,:vproductplanid,:vproductoutputdate,:vcreatedby,:vtoslocid,:vheadernote,:vactiontype)';
                        $cmd = $connection->createCommand($sql);
                        $cmd->bindvalue(':vtempscanid',$row['tempscanid'],PDO::PARAM_STR);
                        $cmd->bindvalue(':vproductplanid',$row['productplanid'],PDO::PARAM_STR);
                        $cmd->bindvalue(':vproductoutputdate',$row['datehp'],PDO::PARAM_STR);
                        $cmd->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
                        $cmd->bindvalue(':vtoslocid',$slocid,PDO::PARAM_STR);
                        $cmd->bindvalue(':vheadernote',$headernote,PDO::PARAM_STR);
                        $cmd->bindvalue(':vactiontype',$actiontype,PDO::PARAM_INT);
                        $cmd->execute();
                        $transaction->commit();
                    } catch(Exception $e){
                        $transaction->rollback();
                        $this->getMessage('error',$e->getMessage(),1);
                    }
                }
            }
        }
        $this->getMessage('success','alreadysaved',1);
    }
    
public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; 
            //$barcodedate = $_POST['barcodedate']; 
            if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			foreach($id as $ids)
			{
                $connection=Yii::app()->db;
                //echo $barcodedate;
				//$sql = "select getrunopno(:vid,:vcreatedby)";
                //$sql = "SELECT getrunopno('".$ids."','".Yii::app()->user->name."')";
				$run = $connection->createCommand($sql)->queryScalar();
				if ($run !== -1)
				{
					$connection=Yii::app()->db;
					$transaction=$connection->beginTransaction();
					try
					{
                        echo $ids;
                        /*
						$sql = 'call ApproveOP(:vid,:vcreatedby)';
						$command=$connection->createCommand($sql);
						$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
						//$command->bindvalue(':vrunop',$run,PDO::PARAM_STR);
						$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
						$command->execute();
						$transaction->commit();
						$this->GetMessage('success','alreadysaved',1);
                        */
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						$this->GetMessage('error',$e->getMessage(),1);
					}
				}
			}
		}
		else
		{
			$this->GetMessage('error','chooseone',1);
		}
	}
    
    public function actionPurge()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Deletebarcodeop(:vid,:vcreatedby)';
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
	
    public function actionScanbarcodeop(){
        date_default_timezone_set('Asia/Jakarta');
        parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$nobarcode = $_POST['productoutput_0_nobarcode'];
            //$slocid = $_POST['slocid'];
			//$id = $_POST['giheader_0_soheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				#$sql = 'call scanhp(:barcode,:scandate,:vcreatedby)';
                $sql =  'call scanbarcodeop(:barcode,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':barcode',$nobarcode,PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
				//$command->bindvalue(':slocid',$slocid,PDO::PARAM_STR);
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
    
    public function actionScanbarcode1(){
        parent::actionSave();
        date_default_timezone_set('Asia/Jakarta');
        //$description = $_POST['productoutput_0_description'];
        $nobarcode = $_POST['productoutput_0_nobarcode'];
        // check apakah sudah pernah di scan atau belum
        
        $check = "SELECT isscanhp FROM tempscan WHERE barcode='".$nobarcode."'";
        $run = Yii::app()->db->createCommand($check)->queryScalar();
        try {
        if($run==0){
            // check apakah yang dibarcode isean13 atau code128
            $isean = "SELECT IFNULL(isean,0) FROM tempscan WHERE barcode='".$nobarcode."'";
            $query = Yii::app()->db->createCommand($isean)->queryScalar();
            try {
            if($query==0){
                    $getstoragebinid = "SELECT f.menuvalueid from groupaccess c inner join usergroup d on d.groupaccessid = c.groupaccessid inner join useraccess e on e.useraccessid = d.useraccessid
                    INNER JOIN groupmenuauth f ON f.groupaccessid = c.groupaccessid INNER JOIN menuauth g ON g.menuauthid=f.menuauthid where upper(e.username)=upper('".Yii::app()->user->name."')
                    and upper(g.menuobject) = upper('storagebin')";
                    $storagebinid = Yii::app()->db->createCommand($getstoragebinid)->queryScalar();
                
                    $getTemp = "SELECT IFNULL(COUNT(1),0) as count, productplanid, companyid, productplanfgid, productid, slocid, unitofmeasureid FROM tempscan WHERE barcode='".$nobarcode."' AND isean<>1";
                    $row = Yii::app()->db->createCommand($getTemp)->queryRow();
                    //foreach($queryTemp as $row){
                    if($row['count']>1){
                        header('Location: http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/production/scanhp?message=duplicatebarcode'); exit();
                    }else{
                        // get NO SPP
                        $getSPP = "SELECT a.*, b.bomid, b.qty FROM productplan a INNER JOIN productplanfg b ON a.productplanid=b.productplanid WHERE a.productplanid='".$row['productplanid']."' AND a.companyid='".$row['companyid']."' AND productid='".$row['productid']."'";
                        $querySPP = Yii::app()->db->createCommand($getSPP)->queryAll();
                        //if($querySPP)
                        // simpan di table-productoutput
                        foreach($querySPP as $row1){
                        $connection=Yii::app()->db;
                        //$transaction=$connection->beginTransaction();
                        try{
                            // check apakah sudah pernah diinput pada tanggal yang sama dengan productplanid yang sama
                            // jika sudah ada, maka update qty saja productoutfg dan detail +1
                            
                            $sqlcheckstatus = "SELECT productoutputdate, productoutputid, productplanid, IFNULL(COUNT(1),0) as status FROM productoutput  WHERE productoutputdate='".date('Y-m-d')."' AND productplanid='".$row['productplanid']."' AND recordstatus='1'";
                            $checkstatus = $connection->createCommand($sqlcheckstatus)->queryRow();
                            
                             
                            if($checkstatus['productoutputdate']==date('Y-m-d') && $row['productplanid']==$checkstatus['productplanid'] && $checkstatus['status']=='1'){
                                // check productplanfgid FROM productoutputfgid
                                $sqlproductfgid = "SELECT b.productplanfgid FROM productoutputfg b WHERE b.productplanfgid='".$row['productplanfgid']."'";
                                $productfgid = $connection->createCommand($sqlproductfgid)->queryScalar();
                                if($productfgid==''){
                                    // buat baru
                                    
                                    $sql1 = "INSERT INTO productoutputfg (productoutputid,productplanfgid,productid,qtyoutput,uomid,slocid,bomid,storagebinid,outputdate) VALUES(:productoutputid,:productplanfgid,:productid,:qty,:uomid,:slocid,:bomid,:storagebinid,:outputdate)";
                                    $command1 = $connection->createCommand($sql1);
                                    $command1->bindvalue(':productoutputid',$checkstatus['productoutputid'],PDO::PARAM_STR);
                                    $command1->bindvalue(':productplanfgid',$row['productplanfgid'],PDO::PARAM_STR);
                                    $command1->bindvalue(':productid',$row['productid'],PDO::PARAM_STR);
                                    $command1->bindvalue(':qty','1',PDO::PARAM_STR);
                                    $command1->bindvalue(':uomid',$row['unitofmeasureid'],PDO::PARAM_STR);
                                    $command1->bindvalue(':slocid',$row['slocid'],PDO::PARAM_STR);
                                    $command1->bindvalue(':bomid',$row1['bomid'],PDO::PARAM_STR);
                                    $command1->bindvalue(':storagebinid',$storagebinid,PDO::PARAM_STR);
                                    $command1->bindvalue(':outputdate',date('Y-m-d'),PDO::PARAM_STR);
                                    $command1->execute();

                                    $sqlLast1 = "select last_insert_id() as productoutputfgid";
                                    $productoutputfgid = Yii::app()->db->createCommand($sqlLast1)->queryScalar();
                                    //$transaction->commit();

                                    // simpan di table-productoutputdetail
                                    // dengan mengambil nilai di table-productplandetail 
                                    $sql2 = "SELECT * FROM productplandetail a INNER JOIN product b ON a.productid = b.productid WHERE productplanid='".$row['productplanid']."' AND productplanfgid='".$row['productplanfgid']."' AND b.isstock=1";
                                    $query2 = $connection->createCommand($sql2)->queryAll();
                                    foreach($query2 as $row2){
                                        // insert to table-productoutputdetail
                                        $qtydetail = $row2['qty']/$row1['qty'];
                                        $insert_output = "INSERT INTO productoutputdetail 
                                        (productoutputid,productoutputfgid,productid,qty,uomid,fromslocid,toslocid,storagebinid,productplandetailid,productplanfgid,outputdate,bomid,description) VALUES   ('".$checkstatus['productoutputid']."','".$productoutputfgid."','".$row2['productid']."','".$qtydetail."','".$row2['uomid']."','".$row2['fromslocid']."','".$row2['toslocid']."','".$storagebinid."', '".$row2['productplandetailid']."','".$row2['productplanfgid']."','".date('Y-m-d')."','".$row2['bomid']."','".$row2['description']."')";
                                        $command2 = $connection->createCommand($insert_output)->execute();
                                        $this->getMessage('success','alreadysaved');
                                    }
                                    
                                    # tambahan insert into transstock, transstockdetail
                                    
                                    
                                }else{
                                    // update
                                    //updateproductouputid();
                                $sqloutputfg = "UPDATE productoutputfg SET qtyoutput=qtyoutput+1 WHERE productoutputid='".$checkstatus['productoutputid']."' AND outputdate='".date('Y-m-d')."' AND productplanfgid='".$row['productplanfgid']."'";
                                $updateoutputfg = $connection->createCommand($sqloutputfg)->execute();
                                
                                // update di tabel-productoutputdetail dengan data existing berdasarkan tangal,no_productoutputfg, dan no_productoutputid
                                // get productoutputfgid
                                $getoutputfgid = "SELECT productoutputfgid FROM productoutputfg WHERE outputdate='".date('Y-m-d')."' AND productoutputid='".$checkstatus['productoutputid']."' AND productplanfgid='".$row['productplanfgid']."'";
                                $productoutputfgid = $connection->createCommand($getoutputfgid)->queryScalar();
                                $getoutputdetail = "SELECT a.*, b.qty as qtydetail FROM productoutputdetail a INNER JOIN productplandetail b ON a.productplandetailid=b.productplandetailid AND a.productid=b.productid AND a.productplanfgid = b.productplanfgid AND productoutputid='".$checkstatus['productoutputid']."' AND productoutputfgid='".$productoutputfgid."' AND outputdate='".date('Y-m-d')."'";
                                
                                $queryoutputdetail = $connection->createCommand($getoutputdetail)->queryAll();
                                // run update detail
                                foreach($queryoutputdetail as $rows){
                                    $sqloutputdetail = "UPDATE productoutputdetail SET qty=qty+(".$rows['qtydetail']/$row1['qty'].") WHERE productoutputdetailid='".$rows['productoutputdetailid']."'";
                                    $updateoutputdetail = $connection->createCommand($sqloutputdetail)->execute();
                                }
                                // update productoutputfgid
                                $sqlupdatefgid = "UPDATE tempscan SET productoutputfgid='".$productoutputfgid."' WHERE barcode='".$nobarcode."'";
                                $queryupdatefgid = $connection->createCommand($sqlupdatefgid)->execute();
                                }
                                
                            }else{
                                // get sloc name as description in productoutput
                                $getsloc = "SELECT description FROM sloc WHERE slocid='".$row['slocid']."'";
                                $description = $connection->createCommand($getsloc)->queryScalar();
                                $sql = "INSERT INTO productoutput (productoutputdate,productplanid,recordstatus,description)VALUES(:productoutputdate,:productplanid,:recordstatus,:description)";
                                $command = $connection->createCommand($sql);    
                                $command->bindvalue(':productoutputdate',date('Y-m-d'),PDO::PARAM_STR);
                                $command->bindvalue(':productplanid',$row1['productplanid'],PDO::PARAM_STR);
                                $command->bindvalue(':recordstatus','1',PDO::PARAM_STR);
                                $command->bindvalue(':description',$description,PDO::PARAM_STR);
                                //$command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
                                $command->execute();
                                //$transaction->commit();
                                // get last input outputid
                                $sqlLast = "select last_insert_id() as productoutputid";
                                //$sql = "SELECT MAX(productoutputid) FROM productoutput; "
                                $productoutputid = Yii::app()->db->createCommand($sqlLast)->queryScalar();
                                
                                //insertproductoutputid();
                            
                            // jika sudah ada data, maka update 
                            // jika belum maka safe
                           
                            $sql1 = "INSERT INTO productoutputfg (productoutputid,productplanfgid,productid,qtyoutput,uomid,slocid,bomid,storagebinid,outputdate) VALUES(:productoutputid,:productplanfgid,:productid,:qty,:uomid,:slocid,:bomid,:storagebinid,:outputdate)";
                            $command1 = $connection->createCommand($sql1);
                            $command1->bindvalue(':productoutputid',$productoutputid,PDO::PARAM_STR);
                            $command1->bindvalue(':productplanfgid',$row['productplanfgid'],PDO::PARAM_STR);
                            $command1->bindvalue(':productid',$row['productid'],PDO::PARAM_STR);
                            $command1->bindvalue(':qty','1',PDO::PARAM_STR);
                            $command1->bindvalue(':uomid',$row['unitofmeasureid'],PDO::PARAM_STR);
                            $command1->bindvalue(':slocid',$row['slocid'],PDO::PARAM_STR);
                            $command1->bindvalue(':bomid',$row1['bomid'],PDO::PARAM_STR);
                            $command1->bindvalue(':storagebinid',$storagebinid,PDO::PARAM_STR);
                            $command1->bindvalue(':outputdate',date('Y-m-d'),PDO::PARAM_STR);
                            $command1->execute();
                            
                            $sqlLast1 = "select last_insert_id() as productoutputfgid";
                            $productoutputfgid = Yii::app()->db->createCommand($sqlLast1)->queryScalar();
                            //$transaction->commit();
                            
                            // simpan di table-productoutputdetail
                            // dengan mengambil nilai di table-productplandetail 
                            $sql2 = "SELECT * FROM productplandetail a INNER JOIN product b ON a.productid = b.productid WHERE productplanid='".$row['productplanid']."' AND productplanfgid='".$row['productplanfgid']."' AND b.isstock=1";
                            $query2 = $connection->createCommand($sql2)->queryAll();
                            foreach($query2 as $row2){
                                // insert to table-productoutputdetail
                                
                                //echo $row2['productid'].'<br />';
                                $qtydetail = $row2['qty']/$row1['qty'];
                                $insert_output = "INSERT INTO productoutputdetail 
                                (productoutputid,productoutputfgid,productid,qty,uomid,fromslocid,toslocid,storagebinid,productplandetailid,productplanfgid,outputdate,bomid,description) VALUES   ('".$productoutputid."','".$productoutputfgid."','".$row2['productid']."','".$qtydetail."','".$row2['uomid']."','".$row2['fromslocid']."','".$row2['toslocid']."','".$storagebinid."', '".$row2['productplandetailid']."','".$row2['productplanfgid']."','".date('Y-m-d')."','".$row2['bomid']."','".$row2['description']."')";
                                $command2 = $connection->createCommand($insert_output)->execute();
                                
                                /*
                                    "(':productoutputid',':productoutputfgid',':productid',':qty',':uomid',':fromslocid',':toslocid',':storagebinid',':productplandetailid',':productplanfgid',
                                    ':outputdate',':bomid',':description')";
                                $command2 = $connection->createCommand($insert_output);
                                $command2->bindvalue(':productoutputid',$productoutputid,PDO::PARAM_STR);
                                $command2->bindvalue(':productoutputfgid',$productoutputfgid,PDO::PARAM_STR);
                                $command2->bindvalue(':productid',$row2['productid'],PDO::PARAM_STR);
                                $command2->bindvalue(':qty',$qtydetail,PDO::PARAM_STR);
                                $command2->bindvalue(':uomid',$row2['uomid'],PDO::PARAM_STR);
                                $command2->bindvalue(':fromslocid',$row2['fromslocid'],PDO::PARAM_STR);
                                $command2->bindvalue(':toslocid',$row2['toslocid'],PDO::PARAM_STR);
                                $command2->bindvalue(':storagebinid',$storagebinid,PDO::PARAM_STR);
                                $command2->bindvalue(':productplandetailid',$row2['productplandetailid'],PDO::PARAM_STR);
                                $command2->bindvalue(':productplanfgid',$row2['productplanfgid'],PDO::PARAM_STR);
                                $command2->bindvalue(':outputdate',date('Y-m-d'),PDO::PARAM_STR);
                                $command2->bindvalue(':bomid',$row2['bomid'],PDO::PARAM_STR);
                                $command2->bindvalue(':description',$row2['description'],PDO::PARAM_STR);
                                $command2->execute();
                                */
                                //$transaction->commit();
                                $this->getMessage('success','alreadysaved');
                                //echo $row2['productid'].'<br />';
                            }
                                /*
                                # call inserttransstock   
                                $sql3 = "INSERT INTO transstock(slocfromid,sloctoid,headernote,recordstatus)VALUES(:slocfromid,:sloctoid,:headernote,:recordstatus)";
                                $command3 = $connection->createCommand($sql3);
                                $command3->bindvalue(':slocfromid',$slocfromid,PDO::PARAM_STR);
                                $command3->bindvalue(':sloctoid',$sloctoid,PDO::PARAM_STR);
                                $command3->bindvalue(':headernote',$description,PDO::PARAM_STR);
                                $command3->bindvalue(':recordstatus','1',PDO::PARAM_STR);
                                $command3->execute();
                                
                                $sqltransstock = "SLECT last_insert_id() as transstockid";
                                $transstockid = Yii::app()->db->createCommand($sqltransstock)->queryScalar();
                                # insert into transstockdet
                                */
                        }
                            $sqlisscan = "UPDATE tempscan SET isscanhp=1, productoutputfgid='".$productoutputfgid."' WHERE barcode='".$nobarcode."'";
                            $updateisscan = Yii::app()->db->createCommand($sqlisscan)->execute();
                            header('Location: http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/production/scanhp?message=success');
                            exit();
                           
                        }
                        catch(Exception $e){
                            //$transaction->rollBack();
                            $this->getMessage('error',$e->getMessage());
                            
                            //break;
                        }
                        }
                    //}
            } 
            }header('Location: http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/production/scanhp?message=isean'); exit();}
            catch(Exception $e){
            //$this->getMessage('error','iseanbarcode');
            $this->getMessage('error',$e->getMessage());
            //header('Location: http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/production/scanhp?message=isean');
            //break;
        }
        } header('Location: http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/production/scanhp?message=isscan'); exit();
        } catch(Exception $e){
            //$this->getMessage('error','datascanned');
            $this->getMessage('error',$e->getMessage());
            //print 'print here';
            //header('Location: http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/production/scanhp?message=isscanhp');
            //break;
        }
        // update iscan=1
        //$message = 'success';
        //echo $_SERVER['HTTP_HOST'].'mis/production/scanhp';
        
    }
	public function actionStockminus()
	{
			parent::actionDownPDF();
			$id=$_GET['id'];
			if (!is_array($id))
			{
					$ids[] = $id; 
					$id = $ids;
			}
			$all = implode(',', $id);
			$sql = "select group_concat(distinct z.productplanid) as productplanid
							from tempscan z 
							join productplan a on a.productplanid = z.productplanid 
							join productplanfg b on b.productplanid = a.productplanid 
							where z.tempscanid in ($all)";
			$productplanid = Yii::app()->db->createCommand($sql)->queryScalar();
			
			$this->pdf->title = "Stok Tidak Mencukupi";
			$this->pdf->AddPage('P',array(230,260));
			$this->pdf->AliasNBPages();
			//foreach ($dataReader as $row) {
			$this->pdf->setFont('Arial', 'B', 10);
			$i           = 0;
			$totalqty    = 0;
			$totaljumlah = 0;

			$this->pdf->sety($this->pdf->gety() + 5);
			$this->pdf->colalign = array(
				'C',
				'C',
				'C',
				'C',
				'C',
				'C',
				'C'
			);
			$this->pdf->setFont('Arial', 'B', 8);
			$this->pdf->setwidths(array(
				7,
				80,
				25,
				25,
				25,
				25,
				25
			));
			$this->pdf->colheader = array(
				'No',
				'Nama Barang',
				'Qty Pemakaian',
				'Qty Sumber',
				'Qty Tujuan',
				'Qty Lain',
				'NO SPP'
			);
			$this->pdf->RowHeader();
			$this->pdf->setFont('Arial', '', 8);
			$this->pdf->coldetailalign = array(
				'R',
				'L',
				'R',
				'R',
				'R',
				'R',
				'R'
			);

			$sql1 = "select * from (select a.productplanid, c.productid, d.productname, (sum(c.qty)/b.qty) as qtyspp, e.productplanno,
							(select sum(qty) from productstock x where x.productid = c.productid and x.unitofmeasureid = c.uomid and x.slocid = c.fromslocid) as stocksumber,
							(select sum(qty) from productstock x where x.productid = c.productid and x.unitofmeasureid = c.uomid and x.slocid = c.toslocid and x.storagebinid = ".getUserObjectValues('storagebin').") as stocktujuan,
							(select sum(qty) from productstock x where x.productid = c.productid and x.unitofmeasureid = c.uomid and x.slocid in(".getUserObjectValues('sloc').") and x.slocid not in(c.fromslocid,c.toslocid)) as stockgudanglain
							from tempscan a
							join productplan e on e.productplanid = a.productplanid
							join productplanfg b on b.productplanfgid = a.productplanfgid
							join productplandetail c on c.productplanfgid = b.productplanfgid
							join product d on d.productid = c.productid
							where a.tempscanid in ($all) and a.isscanhp=1 and isapprovehp=1
							group by c.productid
							order by productplanno,productname) z
							where z.qtyspp > z.stocktujuan order by productname";
			/*
			select a.productplanid, c.productid, d.productname, sum(c.qty) as qtyspp, e.productplanno,
							(select sum(qty) from productstock x where x.productid = c.productid and x.unitofmeasureid = c.uomid and x.slocid = c.fromslocid) as stocksumber,
							(select sum(qty) from productstock x where x.productid = c.productid and x.unitofmeasureid = c.uomid and x.slocid = c.toslocid) as stocktujuan,
							(select sum(qty) from productstock x where x.productid = c.productid and x.unitofmeasureid = c.uomid and x.slocid in(".getUserObjectValues('sloc').") and x.slocid not in(c.fromslocid,c.toslocid)) as stockgudanglain
							from tempscan a
							join productplan e on e.productplanid = a.productplanid
							join productplanfg b on b.productplanfgid = a.productplanfgid
							join productplandetail c on c.productplanfgid = b.productplanfgid
							join product d on d.productid = c.productid
							where a.productplanid in (".$productplanid.") and a.isscanhp=1 and isapprovehp=1
							group by c.productid
							order by productplanno,productname";
*/
			$command1= Yii::app()->db->createCommand($sql1);
			$dataReader1= $command1->queryAll();
			foreach ($dataReader1 as $row1) {
					$i= $i + 1;
					$this->pdf->row(array(
						$i,
						$row1['productname'],
						Yii::app()->format->formatNumber($row1['qtyspp']),
						Yii::app()->format->formatNumber($row1['stocksumber']),
						Yii::app()->format->formatNumber($row1['stocktujuan']),
						Yii::app()->format->formatNumber($row1['stockgudanglain']),
						($row1['productplanno'])
					));
					
			}
			
			$this->pdf->Output();
	}
}