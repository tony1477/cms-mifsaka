<?php

class ScangiController extends AdminController
{
	protected $menuname = 'scangi';
	public $module = 'Inventory';
	protected $pageTitle = 'Scan Surat Jalan';
	public $wfname = 'appgi';
    // $soheaderid = '';
	
    /*
    protected $sqldata = "SELECT DISTINCT a.sodetailid, b.productname, c.description as uomcode, a.qty, IF(a.qty-a.giqty=0,'Stock Terpenuhi',a.qty-a.giqty) as sisa, e.recordstatus, e.statusname, e.giheaderid
FROM sodetail a 
LEFT JOIN product b ON a.productid=b.productid 
LEFT JOIN unitofmeasure c ON c.unitofmeasureid=a.unitofmeasureid
LEFT JOIN tempscan d ON a.productid = d.productid 
LEFT JOIN giheader e ON e.soheaderid = a.soheaderid 
LEFT JOIN soheader f ON f.soheaderid = a.soheaderid AND f.soheaderid = e.soheaderid
WHERE e.recordstatus NOT IN ('3','0') AND a.giqty<>0 ";
*/
    
    /*
    protected $sqldata = "select p.productname, u.description as uomcode, s.qty-s.giqty as qty, IF(s.qty-s.giqty=0,'Stock Terpenuhi', IF(s.giqty=0,'Belum discan',s.qty-s.giqty)) as sisa, IFNULL((select c.qty from gidetail c join giheader d on d.giheaderid=c.giheaderid where d.recordstatus=1 and c.sodetailid=s.sodetailid),0), IFNULL(t.giheaderid,'New Entry') as giheaderid,t.gino,t.gidate,t.soheaderid,a.sono,a.pocustno,b.fullname,a.shipto,t.headernote,IFNULL(t.statusname,'New Entry') as statusname,t.recordstatus
    from soheader a 
			left join giheader t on a.soheaderid = t.soheaderid  
			left join addressbook b on b.addressbookid = a.addressbookid
            left join sodetail s on s.soheaderid = a.soheaderid
            left join unitofmeasure u on u.unitofmeasureid = s.unitofmeasureid
            left join product p on p.productid = s.productid ";
    */
    
    /*
    protected $sqldata = "SELECT p.productname, u.description as uomcode, a.soheaderid, s.sodetailid, FORMAT(s.giqty,0) as giqty, s.qty, IF(giqty=0,'New Entry',g.giheaderid) as giheaderid, t.gidetailid, (s.qty-s.giqty) as sisa, t.qty as qtyapprove, IF(giqty=0,NULL,gino) as gino, IF(giqty=0,NULL,g.recordstatus) as recordstatus, IF(s.giqty=0,'New Entry',g.statusname) as statusname
FROM soheader a 
LEFT JOIN giheader g ON g.soheaderid = a.soheaderid 
JOIN sodetail s ON a.soheaderid = s.soheaderid 
LEFT JOIN gidetail t ON t.giheaderid = g.giheaderid AND t.sodetailid = s.sodetailid
left join product p on p.productid = s.productid
left join unitofmeasure u on u.unitofmeasureid = s.unitofmeasureid ";
    */
    
    protected $sqldata;

    protected $sqldata1 = 'select c.productname, b.qty, b.sodetailid, 
                        ifnull((select sum(qty) from gidetail x where x.sodetailid = b.sodetailid and x.productid = c.productid),0) as giqty,d.uomcode, b.vrqty as qtyscan
                        from soheader a
                        join sodetail b on b.soheaderid = a.soheaderid
                        join product c on c.productid = b.productid
                        join unitofmeasure d on d.unitofmeasureid = b.unitofmeasureid
                        where c.isstock = 0 and b.qty>b.giqty';
    
    protected $sqlcount1 = 'select ifnull(count(1),0)
                        from soheader a
                        join sodetail b on b.soheaderid = a.soheaderid
                        join product c on c.productid = b.productid
                        where c.isstock = 0 and b.qty>b.giqty';
    
   /*
    protected $sqldata = "select p.productname, u.description as uomcode, s.qty, IF(s.qty-s.giqty=0,'Stock Terpenuhi',IF(s.giqty=0,'Belum discan',s.qty-s.giqty)) as sisa, a.sono,a.pocustno,b.fullname,a.shipto
    from  soheader a   
			left join addressbook b on b.addressbookid = a.addressbookid
            left join sodetail s on s.soheaderid = a.soheaderid
            left join unitofmeasure u on u.unitofmeasureid = s.unitofmeasureid
            left join product p on p.productid = s.productid ";
    */
  protected $sqlcount = "select count(1) 
                        from sodetail s 
												inner join soheader a on a.soheaderid = s.soheaderid
												inner join product p ON p.productid = s.productid 
												inner join unitofmeasure u ON u.unitofmeasureid = s.unitofmeasureid ";
 
  protected function getuseraccessid($username){
      
        $sql = "select useraccessid from useraccess where username = '{$username}'";
        $q = Yii::app()->db->createCommand($sql)->queryScalar();
        return $q;
    } 
    
	public function actionGetdataso(){
			$soheaderid = $_REQUEST['soheaderid'];
			$sql = "select a.fullname as salesname, b.fullname as custname
							from soheader z
							join employee a on a.employeeid = z.employeeid
							join addressbook b on b.addressbookid = z.addressbookid
							where z.soheaderid = {$soheaderid}";
			$q = Yii::app()->db->createCommand($sql)->queryRow();
			echo CJSON::encode(array(
			'status'=>'success',
			'salesname'=>$q['salesname'],
							'custname'=>$q['custname'])
					);
	}
		
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		if (isset($_REQUEST['soheaderid']))
		{	
             
            if($_REQUEST['soheaderid']!='' ){
                //$where = " WHERE a.sono like '%".$_REQUEST['sono']."%' GROUP BY sodetailid "; 
                //$this->soheaderid = $_REQUEST['soheaderid'];
                //$cmd = Yii::app()->db->createCommand()->bindvalue(':soheaderid',$_REQUEST['soheaderid'],PDO::PARAM_STR);
                $new = $_REQUEST['soheaderid'];
                $c = " where a.soheaderid ={$_REQUEST['soheaderid']}";
                $where = " where p.isstock = 1 and s.soheaderid = {$new}) z
            group by sodetailid
            order by sodetailid ";
                
                $wherenotstock = " and a.soheaderid = {$new}";
                
            }else{
                $new = 0;
                $c = " where a.soheaderid =0";
                $where = " where p.isstock = 1 and s.soheaderid = {$new}) z
            group by sodetailid
            order by sodetailid ";
                $wherenotstock = " and a.soheaderid = 0 ";
            }
                
		}else{
                $new = 0;
                $c = " where a.soheaderid =0";
                $where = " where p.isstock = 1 and s.soheaderid = {$new}) z
            group by sodetailid
            order by sodetailid ";
            $wherenotstock = " and a.soheaderid = 0";
            
        }
		$this->sqldata = $this->sqldata.$where;
		$this->sqlcount1 = Yii::app()->db->createCommand($this->sqlcount1.$wherenotstock)->queryScalar();
        $this->sqldata1 = $this->sqldata1.$wherenotstock;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$c)->queryScalar();
	}
             
  public function actionGetdatagi(){
        parent::actionUpdate();
        
        $nobarcode = $_POST['giheader_0_nobarcode'];
        $id = $_POST['giheader_0_soheaderid'];
        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try
        {
            $sql = 'call getdatagi(:barcode,:vdate,:vid,@output)';
            $command = $connection->createCommand($sql);
            $command->bindvalue(':barcode',$nobarcode,PDO::PARAM_STR);
            $command->bindvalue(':vdate',date('Y-m-d'),PDO::PARAM_STR);
            $command->bindvalue(':vid',$id,PDO::PARAM_STR);
            $command->execute();
            
            $select = 'select @output';
            $data = Yii::app()->db->createCommand($select)->queryScalar();
            //$transaction->commit();
            //$this->getMessage('success','alreadysaved');
        }
        catch (CDbException $e)
        {
            $transaction->rollBack();
            $this->getMessage('error',$e->getMessage());
        }
       echo CJSON::encode(array(
            'status'=>'success',
            'output'=>$data,
        ));
        Yii::app()->end();
    }
    
	public function actionIndex()
	{
		parent::actionIndex();
		$this->sqldata = "select qty, sodetailid, giqty, productname, uomcode, case when sum(qtyori) = qty then cast('Stock Terpenuhi' as char) else sum(qtyori) end as qtyscan
									from (select qty,giqty, s.productid, p.productname, u.description as uomcode, sodetailid,
									(select ifnull(sum(t.qtyori),0)
									from tempscan t
									where t.sodetailid=s.sodetailid and isscangi = 1 and isapprovegi = 1 and t.useraccessid = '{$this->getuseraccessid(Yii::app()->user->id)}') as qtyori
									from sodetail s 
									inner join soheader a on a.soheaderid = s.soheaderid
									inner join product p ON p.productid = s.productid 
									inner join unitofmeasure u ON u.unitofmeasureid = s.unitofmeasureid ";
        $connection = Yii::app()->db;
		$this->getSQL();
        //$command = $connection->createCommand($this->sqldata);
        
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'sodetailid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productname','unitofmeasureid','qty','giqty','qtyscan'
				),
				'defaultOrder' => array( 
					'productname' => CSort::SORT_DESC
				),
			),
		));
        
        $dataProvider1=new CSqlDataProvider($this->sqldata1,array(
			'totalItemCount'=>$this->sqlcount1,
			'keyField'=>'sodetailid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'sodetailid','productname','unitofmeasureid','qty','giqty','qtyscan'
				),
				'defaultOrder' => array( 
					'productname' => CSort::SORT_DESC
				),
			),
		));
        	
		
		
        $this->render('index',array('dataProvider'=>$dataProvider,'dataProvider1'=>$dataProvider1));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into giheader (recordstatus) values (".$this->findstatusbyuser('insgi').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'giheaderid'=>$id,
			"gidate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insgi")
		));
	}
  public function actionCreategidetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "qtyres" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.giheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'gidate'=>$model['gidate'],
          'soheaderid'=>$model['soheaderid'],
          'headernote'=>$model['headernote'],
          'sono'=>$model['sono'],

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
    
    public function actionSaveqtyscan(){
        
        parent::actionSave();
		$error = $this->ValidateData(array(
			array('sodetailid','string','emptysodetailid'),
            array('qty','string','emptyqty'),
        ));
        
        if ($error == false)
		{
			$id = $_POST['sodetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call InsertNotStockScan(:vsodetailid,:vqty)';
				}
				
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vsodetailid',$_POST['sodetailid'],PDO::PARAM_STR);
				}
                $command->bindvalue(':vqty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
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

  public function actionUpdategidetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatagidetail.' where gidetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'slocid'=>$model['slocid'],
          'storagebinid'=>$model['storagebinid'],
          'itemnote'=>$model['itemnote'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'description'=>$model['description'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['giheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateGI (:gidate
,:soheaderid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':giheaderid',$_POST['giheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':gidate',(($_POST['gidate']!=='')?$_POST['gidate']:null),PDO::PARAM_STR);
        $command->bindvalue(':soheaderid',(($_POST['soheaderid']!=='')?$_POST['soheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
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
public function actionSavegidetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('unitofmeasureid','string','emptyunitofmeasureid'),
      array('slocid','string','emptyslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['gidetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update gidetail 
			      set productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,slocid = :slocid,storagebinid = :storagebinid,itemnote = :itemnote 
			      where gidetailid = :gidetailid';
				}
				else
				{
					$sql = 'insert into gidetail (productid,qty,unitofmeasureid,slocid,storagebinid,itemnote) 
			      values (:productid,:qty,:unitofmeasureid,:slocid,:storagebinid,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':gidetailid',$_POST['gidetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemnote',(($_POST['itemnote']!=='')?$_POST['itemnote']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->InsertTranslog($command,$id);
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}

public function actionApproveGi(){
        parent::actionPost();
        $giheader_0_soheaderid = $_POST['giheader_0_soheaderid'];
        $note = $_POST['giheader_0_note'];
            $connection = Yii::app()->db;
                $transaction=$connection->beginTransaction();
                try {
                    $sql = 'CALL ApproveScanGI(:vid,:vnote,:vcreatedby)';
                    $cmd = $connection->createCommand($sql);
                    $cmd->bindvalue(':vid',$giheader_0_soheaderid,PDO::PARAM_STR);
                    $cmd->bindvalue(':vnote',$note,PDO::PARAM_STR);
                    $cmd->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
                    $cmd->execute();
                    $transaction->commit();
                    $this->getMessage('success','alreadysaved',1);
                } catch(Exception $e){
                    $transaction->rollback();
                    $this->getMessage('error',$e->getMessage(),1);
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
				$sql = 'call Approvegi(:vid,:vcreatedby)';
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
				$sql = 'call Deletegi(:vid,:vcreatedby)';
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
				$sql = "delete from giheader where giheaderid = ".$id[$i];
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
	}public function actionPurgegidetail()
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
				$sql = "delete from gidetail where gidetailid = ".$id[$i];
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
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select b.companyid, a.gino,a.gidate,b.sono ,b.shipto,a.giheaderid,a.headernote,
						a.recordstatus,c.fullname as customer,d.fullname as sales,f.cityname,
						(
						select distinct g.mobilephone
						from addresscontact g 
						where g.addressbookid = c.addressbookid
						limit 1 
						) as hp,
							(
						select distinct h.phoneno
						from address h
						where h.addressbookid = c.addressbookid
						limit 1 
						) as phone 
						from giheader a
						left join soheader b on b.soheaderid = a.soheaderid 
						left join addressbook c on c.addressbookid = b.addressbookid
						left join employee d on d.employeeid = b.employeeid
						left join company e on e.companyid = b.companyid
						left join city f on f.cityid = e.cityid ";
		if ($_GET['giheaderid'] !== '') 
		{
				$sql = $sql . "where a.giheaderid in (".$_GET['giheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('giheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AddFont('tahoma','','tahoma.php');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('tahoma');
	  // definisi font
	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFontSize(9);      
      $this->pdf->text(10,$this->pdf->gety()+0,'No ');$this->pdf->text(25,$this->pdf->gety()+0,': '.$row['gino']);
			$this->pdf->text(10,$this->pdf->gety()+5,'Sales ');$this->pdf->text(25,$this->pdf->gety()+5,': '.$row['sales']);
      $this->pdf->text(140,$this->pdf->gety()+0,$row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gidate'])));
			$this->pdf->text(10,$this->pdf->gety()+10,'No. SO ');$this->pdf->text(25,$this->pdf->gety()+10,': '.$row['sono']);
			$this->pdf->text(10,$this->pdf->gety()+15,'Dengan hormat,');
			$this->pdf->text(10,$this->pdf->gety()+20,'Bersama ini kami kirimkan barang-barang sebagai berikut:');
			$this->pdf->text(140,$this->pdf->gety()+5,'Kepada Yth, ');
      $this->pdf->text(140,$this->pdf->gety()+10,$row['customer']);
		
      $sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,d.description,f.description as rak,itemnote
								from gidetail a
								inner join product b on b.productid = a.productid
								inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
								inner join sloc d on d.slocid = a.slocid
								left join storagebin f on f.storagebinid = a.storagebinid
								where giheaderid = ".$row['giheaderid']." group by b.productname,a.sodetailid order by sodetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('L','L','L','L','L','L','L');
      $this->pdf->setwidths(array(8,77,20,20,50,30));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang - Rak','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				Yii::app()->format->formatNumber($row1['vqty']),
				$row1['uomcode'],
				$row1['description'].' - '.$row1['rak'],
				$row1['itemnote']));
      }
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(20,170));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Ship To',$row['shipto'].' / '.$row['phone'].' / '.$row['hp']));

			$this->pdf->row(array('Note',$row['headernote']));
	  
			$this->pdf->colalign = array('C');
      $this->pdf->setwidths(array(150));
      $this->pdf->coldetailalign = array('L');
			$this->pdf->row(array(
			'Barang-barang tersebut diatas kami (saya) periksa dan terima dengan baik serta cukup.'
			));
			$this->pdf->checkNewPage(20);
			//$this->pdf->Image('images/ttdsj.jpg',5,$this->pdf->gety()+25,200);
						$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Disetujui oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');$this->pdf->text(137,$this->pdf->gety(),'Dibawa oleh,');$this->pdf->text(178,$this->pdf->gety(),' Diterima oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'........................');$this->pdf->text(137,$this->pdf->gety()+22,'........................');$this->pdf->text(178,$this->pdf->gety()+22,'........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'Admin Gudang');$this->pdf->text(55,$this->pdf->gety()+25,' Kepala Gudang');$this->pdf->text(96,$this->pdf->gety()+25,'     Distribusi');$this->pdf->text(137,$this->pdf->gety()+25,'        Supir');$this->pdf->text(178,$this->pdf->gety()+25,'Customer/Toko');

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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('giheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('gino'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('gidate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('sono'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('shipto'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['giheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['gino'])
->setCellValueByColumnAndRow(2, $i+1, $row1['gidate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sono'])
->setCellValueByColumnAndRow(4, $i+1, $row1['shipto'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
    
    public function actionScanbarcode(){
        date_default_timezone_set('Asia/Jakarta');
        parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$nobarcode = $_POST['giheader_0_nobarcode'];
			$id = $_POST['giheader_0_soheaderid'];
            $type = $_POST['type'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call scanbarcodegi(:barcode,:vdate,:vid,:type,:vcreatedby)';
				$command = $connection->createCommand($sql);
                $command->bindvalue(':barcode',$nobarcode,PDO::PARAM_STR);
                $command->bindvalue(':vdate',date('Y-m-d'),PDO::PARAM_STR);
                $command->bindvalue(':vid',$id,PDO::PARAM_STR);
                $command->bindvalue(':type',$type,PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
}
