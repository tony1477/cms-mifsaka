<?php

class PlafonreqController extends AdminController
{
	protected $menuname = 'plafonreq';
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
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appplafonreq')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.recordstatus in (".getUserRecordStatus('listplafonreq').")
						and a0.recordstatus < {$maxstat}
						and a0.addressbookid in (select za.addressbookid from addressaccount za where za.companyid in (".getUserObjectWfValues('company','appplafonreq')."))";
		if ((isset($_REQUEST['customer'])) && (isset($_REQUEST['plafonreqno'])) && (isset($_REQUEST['salesname'])))
		{				
			$where .=  " 
								and a1.fullname like '%". $_REQUEST['customer']."%' 
								and a0.plafonreqno like '%". $_REQUEST['plafonreqno']."%' 
								and a2.fullname like '%". $_REQUEST['salesname']."%'
								"; 
		}
		if (isset($_REQUEST['plafonreq_0_plafonreqid']))
		{
			if (($_REQUEST['plafonreq_0_plafonreqid'] !== '0') && ($_REQUEST['plafonreq_0_plafonreqid'] !== ''))
			{
				if ($where == "")
				{
					$where = " where a0.plafonreqid in (".$_REQUEST['plafonreq_0_plafonreqid'].")";
				}
				else
				{
					$where .= " and a0.plafonreqid in (".$_REQUEST['plafonreq_0_plafonreqid'].")";
				}
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
	public function actionGetinfocust()
	{
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
			$connection  = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
              if ($id === '') {
                $sql     = 'call Insertplafonreq(:vaddressbookid,:vreqlimit,:vreqsalesid,:vrecordstatus,:vcreatedby)';
                $command = $connection->createCommand($sql);
              } else {
                $sql     = 'call Updateplafonreq(:vid,:vaddressbookid,:vreqlimit,:vreqsalesid,:vrecordstatus,:vcreatedby)';
                $command = $connection->createCommand($sql);
                $command->bindvalue(':vid', $_POST['plafonreqid'], PDO::PARAM_STR);
              }
              $command->bindvalue(':vaddressbookid', $_POST['addressbookid'], PDO::PARAM_STR);
              $command->bindvalue(':vreqlimit', $_POST['reqlimit'], PDO::PARAM_STR);
              $command->bindvalue(':vreqsalesid', $_POST['reqsalesid'], PDO::PARAM_STR);
              $command->bindvalue(':vrecordstatus', $_POST['recordstatus'], PDO::PARAM_STR);
              $command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
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
	private function SendNotifWa($menuname,$idarray)
	{
    // getrecordstatus
		$ids = null;
		if(is_array($idarray)==TRUE) {
			foreach($idarray as $id) {
				$sql = "select plafonreqid
							from plafonreq
							where recordstatus = getwfmaxstatbywfname('appplafonreq') and plafonreqid = ".$id;
				if($ids == null) {
					$ids = Yii::app()->db->createCommand($sql)->queryScalar();
				}
				else
				{
					$ids .= ','.Yii::app()->db->createCommand($sql)->queryScalar();
				}
				//var_dump($idarray);
			}
			// get customer number
			if($ids == null) {
				foreach($idarray as $id) {
					$sql = "select plafonreqid
								from plafonreq
								where plafonreqid = ".$id;
					if($ids == null) {
						$ids = Yii::app()->db->createCommand($sql)->queryScalar();
					}
					else
					{
						$ids .= ','.Yii::app()->db->createCommand($sql)->queryScalar();
					}
					//var_dump($idarray);
				}
				$getSalesOrder = "select a.plafonreqid, a2.fullname, a.plafonreqdate, a.plafonreqno, a2.creditlimit, a.reqlimit,e.fullname as sales,getwfstatusbywfname('appplafonreq',a.recordstatus) as statusname
								from plafonreq a
								join addressbook a2 on a2.addressbookid = a.addressbookid 
								join employee e on e.employeeid = a.reqsalesid
								where a.plafonreqid in ({$ids})
								group by plafonreqid
				";

				$res = Yii::app()->db->createCommand($getSalesOrder)->queryAll();
				
				foreach($res as $row) {
					$companyid = $row['companyid'];
					$wanumber = $row['wanumber'];
					$telegramid = $row['telegramid'];
					$time = date('Y-m-d H:i:s');
					
					$pesanwa = 
					"Perubahan Plafon No.: ".$row['plafonreqno']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['plafonreqdate']))."\nSales: ".$row['sales']."\n\nCustomer: *".$row['fullname']."*\nKredit Limit\n- Saat Ini Rp.".Yii::app()->format->formatCurrency($row['creditlimit'])."\n- Diajukan Rp.".Yii::app()->format->formatCurrency($row['reqlimit'])."\n\nTelah disetujui oleh bagian terkait dengan status *".$row['statusname']."*, silahkan _*Review*_ lalu _*Approve*_ / _*Reject*_ pada Aplikasi ERP AKA Group.\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;
					
					$pesantele = 
					"Perubahan Plafon No.: ".$row['plafonreqno']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['plafonreqdate']))."\nSales: ".$row['sales']."\n\nCustomer: ".$row['fullname']."\nKredit Limit\n- Saat Ini Rp.".Yii::app()->format->formatCurrency($row['creditlimit'])."\n- Diajukan Rp.".Yii::app()->format->formatCurrency($row['reqlimit'])."\n\nTelah disetujui oleh bagian terkait dengan status ".$row['statusname'].", silahkan Review lalu Approve / Reject pada Aplikasi ERP AKA Group.\n\nPesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)\n".
					$time;
					
					$getWaNumber = "SELECT e.useraccessid,b.groupaccessid,replace(e.wanumber,'+','') as wanumber,e.telegramid
									FROM plafonreq a
									JOIN employeeorgstruc e2 on e2.employeeid=a.reqsalesid 
									join orgstructure o on o.orgstructureid=e2.orgstructureid and e2.recordstatus=1
									JOIN wfgroup b ON b.wfbefstat=a.recordstatus AND b.workflowid=186
									JOIN groupmenuauth c ON c.groupaccessid=b.groupaccessid AND c.menuauthid=5 AND c.menuvalueid=o.companyid
									JOIN usergroup d ON d.groupaccessid=c.groupaccessid
									JOIN useraccess e ON e.useraccessid=d.useraccessid AND e.recordstatus=1 AND e.useraccessid<>2 AND e.useraccessid<>106
									-- AND e.useraccessid<>3
									WHERE a.plafonreqid = {$row['plafonreqid']}
					";
					$res1 = Yii::app()->db->createCommand($getWaNumber)->queryAll();
					
					foreach($res1 as $row1)
					{
						$wanumber = $row1['wanumber'];
						$telegramid = $row1['telegramid'];
						if ($row1['useraccessid'] == 3){$ui=" - cms ".$row1['groupaccessid'];}else{$ui="";}
/*					//Whatsapp Japri
						$ch = curl_init();
						curl_setopt_array($ch, array(
							CURLOPT_URL => "http://akagroup.co.id:8888/api/sendText?id_device=1&message=".urlencode($pesanwa)."&tujuan=".$wanumber."@s.whatsapp.net",
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "POST",
							  CURLOPT_HTTPHEADER => array(
								"apikey: t0k3nb4ruwh4ts4k4"
							  ),
						));
						$res = curl_exec($ch);
*/						
						if ($telegramid > 0)
						{
							$url = Yii::app()->params['tele']."/sendMessage?chat_id=".$telegramid."&text=".urlencode($pesantele.$ui);
							$ch = curl_init();
							$optArray = array(
								CURLOPT_URL => $url,
								CURLOPT_RETURNTRANSFER => true
							);
							curl_setopt_array($ch, $optArray);
							$result = curl_exec($ch);
						}
					}
				curl_close($ch);
				}
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
				$this->SendNotifWa($this->menuname,$id);
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