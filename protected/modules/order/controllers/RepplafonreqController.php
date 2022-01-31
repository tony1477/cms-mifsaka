<?php

class RepplafonreqController extends AdminController
{
	protected $menuname = 'repplafonreq';
	public $module = 'Order';
	protected $pageTitle = 'Perubahan Plafon';
	public $wfname = 'appplafonreq';
	protected $sqldata = "select a0.plafonreqid,a0.plafonreqdate,a0.addressbookid,a0.reqlimit,a0.reqsalesid,a0.recordstatus,a1.fullname as fullname,a2.fullname as salesname,getwfstatusbywfname('appplafonreq',a0.recordstatus) as statusname,a0.plafonreqno,
  ifnull((select sum((a.cashamount + a.bankamount + a.discamount + a.returnamount + a.obamount) * a.currencyrate)/3
  from cutarinv a
  join cutar b on b.cutarid=a.cutarid
  join invoice c on c.invoiceid=a.invoiceid
  join giheader d on d.giheaderid=c.giheaderid
  join soheader e on e.soheaderid=d.soheaderid
  where b.docdate between date_sub(a0.plafonreqdate,interval 3 MONTH) and a0.plafonreqdate
  and e.addressbookid=a0.addressbookid),0) as averagepayment,
  GetTotalPendingInvoiceByDate(a0.addressbookid,a0.plafonreqdate) as piutangreqplafon,
  ifnull(GetOldInvoiceTermByDate(a0.addressbookid,a0.plafonreqdate),0) as topreqplafon
    from plafonreq a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
    left join employee a2 on a2.employeeid = a0.reqsalesid
  ";
  protected $sqlcount = "select count(1) 
    from plafonreq a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
    left join employee a2 on a2.employeeid = a0.reqsalesid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.recordstatus > -1 ";
		if ((isset($_REQUEST['fullname'])) && (isset($_REQUEST['plafonreqno'])) && (isset($_REQUEST['salesname'])))
		{				
			$where .=  " 
and a1.fullname like '%". $_REQUEST['fullname']."%' 
and coalesce(a0.plafonreqno,'') like '%". $_REQUEST['plafonreqno']."%' 
and a2.fullname like '%". $_REQUEST['salesname']."%' "; 
		}
		if (isset($_REQUEST['plafonreqid']))
			{
				if (($_REQUEST['plafonreqid'] !== '0') && ($_REQUEST['plafonreqid'] !== ''))
				{
					$where .= " and a0.plafonreqid in (".$_REQUEST['plafonreqid'].")";
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'plafonreqid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'plafonreqid','plafonreqdate','addressbookid','reqlimit','reqsalesid','recordstatus','plafonreqno','statusname','averagepayment','piutangreqplafon','topreqplafon',
				),
				'defaultOrder' => array( 
					'plafonreqid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"reqlimit" =>0,
      "recordstatus" =>$this->findstatusbyuser("insplafonreq")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.plafonreqid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'plafonreqid'=>$model['plafonreqid'],
          'plafonreqdate'=>$model['plafonreqdate'],
          'addressbookid'=>$model['addressbookid'],
          'reqlimit'=>$model['reqlimit'],
          'reqsalesid'=>$model['reqsalesid'],
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],
          'salesname'=>$model['salesname'],
          'averagepayment'=>$model['averagepayment'],
          'piutangreqplafon'=>$model['piutangreqplafon'],
          'topreqplafon'=>$model['topreqplafon'],

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
    
    public function actionGetinfocust(){
        if(isset($_POST['id'])){
            $id = $_POST['id']; 
            if (!is_array($id)) { $ids[] = $id; $id = $ids; }
            //$row = array(); $res = array();
            //for ($i = 0; $i < count($_POST['id']);$i++)
			//{
                //$model = 'select group_concat(addressbookid) as addressbookid from plafonreq where plafonreqid in ('.$id[$i].')';
                $model = 'select b.addressbookid, b.fullname 
                        from plafonreq a
                        join addressbook b on b.addressbookid = a.addressbookid
                        where a.plafonreqid = '.$id[0];
                $rows = Yii::app()->db->createCommand($model)->queryRow();
                //array_push($row,$rows['addressbookid']);
			//}
            //$addressbookid = implode(',',$row);
            echo CJSON::encode(array(
                'status' => 'success',
                'addressbook' => $rows['addressbookid'],
                'fullname' => $rows['fullname']));
            Yii::app()->end();
        }else{
            $this->getMessage('error',$this->getCatalog("notselected"));
        }
    }

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
      array('addressbookid','string','emptyaddressbookid'),
      array('reqlimit','string','emptyreqlimit'),
      array('reqsalesid','string','emptyreqsalesid'),
    ));
		if ($error == false)
		{
			$id = $_POST['plafonreqid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update plafonreq 
			      set addressbookid = :addressbookid,reqlimit = :reqlimit,reqsalesid = :reqsalesid,recordstatus = :recordstatus 
			      where plafonreqid = :plafonreqid';
				}
				else
				{
					$sql = 'insert into plafonreq (addressbookid,reqlimit,reqsalesid,recordstatus) 
			      values (:addressbookid,:reqlimit,:reqsalesid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':plafonreqid',$_POST['plafonreqid'],PDO::PARAM_STR);
				}
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':reqlimit',(($_POST['reqlimit']!=='')?$_POST['reqlimit']:null),PDO::PARAM_STR);
        $command->bindvalue(':reqsalesid',(($_POST['reqsalesid']!=='')?$_POST['reqsalesid']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveplafonreq(:vid,:vcreatedby)';
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
				$sql = 'call Deleteplafonreq(:vid,:vcreatedby)';
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
				$sql = "delete from plafonreq where plafonreqid = ".$id[$i];
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
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('plafonreq');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('plafonreqid'),$this->getCatalog('plafonreqdate'),$this->getCatalog('addressbook'),$this->getCatalog('reqlimit'),$this->getCatalog('reqsales'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['plafonreqid'],$row1['plafonreqdate'],$row1['fullname'],$row1['reqlimit'],$row1['fullname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('plafonreqid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('plafonreqdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('reqlimit'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['plafonreqid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['plafonreqdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['reqlimit'])
->setCellValueByColumnAndRow(4, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
