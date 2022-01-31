<?php
class FohulController extends Controller {
  public $menuname = 'fohul';
  public function actionIndex() {
		parent::actionIndex();
    if (isset($_GET['grid']))
      echo $this->search();
    else
      $this->renderPartial('index', array());
  }
  public function search() {
    header("Content-Type: application/json");
    $fohulid   = isset($_POST['fohulid']) ? $_POST['fohulid'] : '';
    $perioddate        = isset($_POST['perioddate']) ? $_POST['perioddate'] : '';
    $companyname    = isset($_POST['companyname'])  ? $_POST['companyname'] : '';
    $plantfromcode  = isset($_POST['plantfromcode'])  ? $_POST['plantfromcode'] : '';
    $planttocode    = isset($_POST['planttocode'])  ? $_POST['planttocode'] : '';
    $description       = isset($_POST['description']) ? $_POST['description'] : '';
    $plantcode       = isset($_POST['plantcode']) ? $_POST['plantcode'] : '';
    $recordstatus   = isset($_POST['recordstatus']) ? $_POST['recordstatus'] : '';
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows       = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $sort       = isset($_POST['sort']) ? strval($_POST['sort']) : 'fohulid';
    $order      = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
    $offset     = ($page - 1) * $rows;
    $result     = array();
    $row        = array();
    $cmd = Yii::app()->db->createCommand()->select('count(1) as total')
    ->from('fohul t')
    ->leftjoin('company a', 'a.companyid=t.companyid')
    ->leftjoin('plant b', 'b.plantid=t.plantid')
    //->leftjoin('materialgroup c', 'c.materialgroupid=t.materialgroupid')
    ->leftjoin('mgprocess c', 'c.mgprocessid=t.mgprocessid')
    ->where("((fohulid like :fohulid) and (perioddate like :perioddate) and (a.companyname like :companyname) and (coalesce(c.description,'') like :description)) and ((coalesce(b.plantcode,'') like :plantcode)) and
            t.companyid in (".getUserObjectValues('company').")", array(
        ':fohulid' => '%' . $fohulid . '%',
        ':perioddate' => '%' . $perioddate . '%',
        ':companyname' => '%' . $companyname . '%',
        ':description' => '%' . $description . '%',
        ':plantcode' => '%' . $plantcode . '%'
    ))->queryScalar();
    $result['total'] = $cmd;
    $cmd = Yii::app()->db->createCommand()->select('t.*,a.companyname,c.description,b.plantcode')
    ->from('fohul t')
    ->leftjoin('company a', 'a.companyid=t.companyid')
    ->leftjoin('plant b', 'b.plantid=t.plantid')
    //->leftjoin('materialgroup c', 'c.materialgroupid=t.materialgroupid')
    ->leftjoin('mgprocess c', 'c.mgprocessid=t.mgprocessid')
    ->where("((fohulid like :fohulid) and (perioddate like :perioddate) and (a.companyname like :companyname) and (coalesce(c.description,'') like :description)) and ((coalesce(b.plantcode,'') like :plantcode)) and
            t.companyid in (".getUserObjectValues('company').")", array(
        ':fohulid' => '%' . $fohulid . '%',
        ':perioddate' => '%' . $perioddate . '%',
        ':companyname' => '%' . $companyname . '%',
        ':description' => '%' . $description . '%',
        ':plantcode' => '%' . $plantcode . '%'
    ))->offset($offset)->limit($rows)->order($sort . ' ' . $order)->queryAll();
    foreach ($cmd as $data) {
      $row[] = array(
        'fohulid' => $data['fohulid'],
        'docdate' => date(Yii::app()->params['dateviewfromdb'], strtotime($data['docdate'])),
        'perioddate' => date(Yii::app()->params['dateviewfromdb'], strtotime($data['perioddate'])),
        'companyid' => $data['companyid'],
        'companyname' => $data['companyname'],
        'mgprocessid' => $data['mgprocessid'],
        'description' => $data['description'],
        'plantid' => $data['plantid'],
        'plantcode' => $data['plantcode'],
        'foh' => Yii::app()->format->formatCurrency($data['foh']),
        'ul' => Yii::app()->format->formatCurrency($data['ul']),
        'totalfoh' => Yii::app()->format->formatCurrency($data['totalfoh']),
        'totalul' => Yii::app()->format->formatCurrency($data['totalul']),
        'qtyoutput' => Yii::app()->format->formatCurrency($data['qtyoutput']),
        'recordstatus' => $data['recordstatus'],
        'statusname' => $data['statusname']
      );
    }
    $result = array_merge($result, array(
      'rows' => $row
    ));
    return CJSON::encode($result);
  }
	private function ModifyData($connection,$arraydata) {
		$id = (isset($arraydata[0])?$arraydata[0]:'');
		if ($id == '') {
			$sql     = 'call Insertfohul(:vdocdate,:vperioddate,:vcompanyid,:vplantid,:vmgprocessid,:vfoh,:vul,:vcreatedby)';
			$command = $connection->createCommand($sql);
		} else {
			$sql     = 'call Updatefohul(:vid,:vdocdate,:vperioddate,:vcompanyid,:vplantid,:vmgprocessid,:vfoh,:vul,:vcreatedby)';
			$command = $connection->createCommand($sql);
			$command->bindvalue(':vid', $arraydata[0], PDO::PARAM_STR);
		}
		$command->bindvalue(':vdocdate', $arraydata[1], PDO::PARAM_STR);
		$command->bindvalue(':vperioddate', $arraydata[2], PDO::PARAM_STR);
        $command->bindvalue(':vcompanyid', $arraydata[3], PDO::PARAM_STR);
        $command->bindvalue(':vplantid', $arraydata[4], PDO::PARAM_STR);
        $command->bindvalue(':vmgprocessid', $arraydata[5], PDO::PARAM_STR);        
		$command->bindvalue(':vfoh', $arraydata[6], PDO::PARAM_STR);
		$command->bindvalue(':vul', $arraydata[7], PDO::PARAM_STR);
		$command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
		$command->execute();
	}
	public function actionUpload() {
		parent::actionUpload();
    $target_file = dirname('__FILES__').'/uploads/' . basename($_FILES["file-fohul"]["name"]);
    if (move_uploaded_file($_FILES["file-fohul"]["tmp_name"], $target_file)) {
      $objReader = PHPExcel_IOFactory::createReader('Excel2007');
      $objPHPExcel = $objReader->load($target_file);
      $objWorksheet = $objPHPExcel->getActiveSheet();
      $highestRow = $objWorksheet->getHighestRow(); 
      $highestColumn = $objWorksheet->getHighestColumn();
      $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
			try {
				for ($row = 3; $row <= $highestRow; ++$row) {
					$id = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
					$perioddate = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
					$companycode = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
					$companyid = Yii::app()->db->createCommand("select companyid from company where companycode = '".$companycode."'")->queryScalar();
                    $plantcode = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
					$plantid = Yii::app()->db->createCommand("select plantid from plant where plantcode = '".$plantcode."'")->queryScalar();
					$accountcode = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
					$accountid = Yii::app()->db->createCommand("select accountid from account where companyid = ".$companyid." and accountcode = '".$accountcode."'")->queryScalar();
					$fohulamount = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
					$this->ModifyData($connection,array($id,date(Yii::app()->params['datetodb'], strtotime($perioddate)),$companyid,$accountid,$fohulamount,$plantid));
				}
        $transaction->commit();
        GetMessage(false, 'insertsuccess');
			}
			catch (Exception $e) {
				$transaction->rollBack();
				GetMessage(true, $e->getMessage());
			}
    }
	}
  public function actionSave() {
    parent::actionWrite();
		$connection  = Yii::app()->db;
    $transaction = $connection->beginTransaction();
    try {
			$this->ModifyData($connection,array((isset($_POST['fohulid'])?$_POST['fohulid']:''),date(Yii::app()->params['datetodb'], strtotime($_POST['docdate'])),date(Yii::app()->params['datetodb'], strtotime($_POST['perioddate'])),$_POST['companyid'],$_POST['plantid'],$_POST['mgprocessid'],$_POST['foh'],$_POST['ul']));
      $transaction->commit();
      GetMessage(false, 'insertsuccess');
    }
    catch (Exception $e) {
      $transaction->rollBack();
      GetMessage(true, $e->getMessage());
    }
  }
  public function actionApprove() {
    parent::actionApprove();
    if(isset($_POST['id'])) {
      $id          = $_POST['id'];
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
      try {
        $sql     = 'call Approvefohul(:vid,:vcreatedby)';
        $command = $connection->createCommand($sql);
        foreach ($id as $ids) {
          $command->bindvalue(':vid', $ids, PDO::PARAM_STR);
          $command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
          $command->execute();
        }
        $transaction->commit();
        GetMessage(false, 'insertsuccess');
      }
      catch (Exception $e) {
        $transaction->rollback();
        GetMessage(true, $e->getMessage());
      }
    } else {
      GetMessage(true, 'chooseone');
    }
  }
  public function actionDelete() {
    parent::actionDelete();
    if (isset($_POST['id'])) {
      $id          = $_POST['id'];
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
      try {
        $sql     = 'call Deletefohul(:vid,:vcreatedby)';
        $command = $connection->createCommand($sql);
        foreach ($id as $ids) {
          $command->bindvalue(':vid', $ids, PDO::PARAM_STR);
          $command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
          $command->execute();
        }
        $transaction->commit();
        GetMessage(false, 'insertsuccess');
      }
      catch (Exception $e) {
        $transaction->rollback();
        GetMessage(true, $e->getMessage());
      }
    } else {
      GetMessage(true, 'chooseone');
    }
  }
  public function actionPurge() {
    parent::actionPurge();
    if (isset($_POST['id'])) {
      $id          = $_POST['id'];
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
      try {
        $sql     = 'call Purgefohul(:vid,:vcreatedby)';
        $command = $connection->createCommand($sql);
        $command->bindvalue(':vid', $id, PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
        $command->execute();
        $transaction->commit();
        GetMessage(false, 'insertsuccess');
      }
      catch (Exception $e) {
        $transaction->rollback();
        GetMessage(true, $e->getMessage());
      }
    } else {
      GetMessage(true, 'chooseone');
    }
  }
  public function actionDownPDF() {
    parent::actionDownload();
    $fohulid = filter_input(INPUT_GET,'fohulid');
	$perioddate = filter_input(INPUT_GET,'perioddate');
	$companyname = filter_input(INPUT_GET,'companyname');
	$description = filter_input(INPUT_GET,'description');
	$plantcode = filter_input(INPUT_GET,'plantcode');
    
    
    
    /*$sql = "select a.fohulid,a.perioddate,b.accountname,a.expeditionamount,a.companyid,ifnull((select sum(d.debit-d.credit) from genledger d join genjournal e on e.genjournalid=d.genjournalid where e.recordstatus=3 and d.accountid=a.accountid and e.journaldate between DATE_ADD(DATE_ADD(LAST_DAY(a.perioddate),INTERVAL 1 DAY),INTERVAL - 1 MONTH) and LAST_DAY(a.perioddate)),0) as realisasi,
            ifnull((select sum(d.debit-d.credit) from genledger d join genjournal e on e.genjournalid=d.genjournalid where e.recordstatus=3 and d.accountid=a.accountid and e.journaldate between CONCAT(YEAR(a.perioddate),'-01-01') and LAST_DAY(a.perioddate)),0) as kumrealisasi
						from expedition a
						join account b on b.accountid = a.accountid 
						join company c on c.companyid = a.companyid ";
		$fohulid = filter_input(INPUT_GET,'fohulid');
		$perioddate = filter_input(INPUT_GET,'perioddate');
		$companyname = filter_input(INPUT_GET,'companyname');
		$accountname = filter_input(INPUT_GET,'accountname');
		$accountcode = filter_input(INPUT_GET,'accountcode');
		$sql .= " where coalesce(a.fohulid,'') like '%".$fohulid."%' 
			and coalesce(a.perioddate,'') like '%".$perioddate."%'
			and coalesce(c.companyname,'') like '%".$companyname."%'
			and coalesce(b.accountname,'') like '%".$accountname."%'
			and coalesce(b.accountcode,'') like '%".$accountcode."%'
			";
    
    if ($_GET['id'] !== '') {
      $sql = $sql . " and a.fohulid in (" . $_GET['id'] . ")";
    } 
    */
    $sql = "select t.*, a.companyname, b.description, c.plantcode as plantfromcode,d.plantcode as planttocode, if(t.issupplier=1,'Yes','No') as issupp
            from fohul t
            join company a on a.companyid = t.companyid
            left join mgprocess b on b.mgprocessid = t.mgprocessid
            left join plant c on c.plantid = t.plantid
            left join plant d on d.plantid = t.planttoid
            where coalesce(t.fohulid,'') like '%".$fohulid."%' 
            and coalesce(t.perioddate,'') like '%".$perioddate."%' 
            and coalesce(a.companyname,'') like '%".$companyname."%' 
            and coalesce(b.description,'') like '%".$description."%' 
            and coalesce(c.plantcode,'') like '%".$plantcode."%' 
            and coalesce(d.plantcode,'') like '%".$plantcode."%' 
            ";
    //$sql = $sql . " order by accountname asc ";
    $command          = Yii::app()->db->createCommand($sql);
    $dataReader       = $command->queryAll();
    foreach ($dataReader as $row1)
		{
			$this->pdf->companyid = $row1['companyid'];
		}
    $this->pdf->title = GetCatalog('fohul');
    $this->pdf->AddPage('L',array(220,335));
    $this->pdf->setFont('Arial','B',9);
    $this->pdf->colalign  = array(
      'L',
      'L',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
    );
    $this->pdf->colheader = array(
      GetCatalog('perioddate'),
      GetCatalog('companyname'),
      GetCatalog('Supplier ?'),
      GetCatalog('Supplier'),
      GetCatalog('Cabang Sumber'),
      GetCatalog('Cabang Tujuan'),
      GetCatalog('Percent'),
      GetCatalog('Status')
    );
    $this->pdf->setwidths(array(
      27,
      63,
      18,
      35,
      35,
      35,
      20,
      35
    ));
    $this->pdf->Rowheader();
    $this->pdf->setFont('Arial','',9);
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R'
    );
    foreach ($dataReader as $row1) {
      $this->pdf->row(array(
        date(Yii::app()->params['dateviewfromdb'],strtotime($row1['perioddate'])),
        $row1['companyname'],
        $row1['issupp'],
        $row1['description'],
        $row1['plantfromcode'],
        $row1['planttocode'],
        $row1['percent'],
        $row1['statusname'],
      ));
    }
    $this->pdf->Output();
  }
  /*
  public function actionDownxls() {
    $this->menuname = 'expedition';
    parent::actionDownxls();
    $fohulid = filter_input(INPUT_GET,'fohulid');
	$perioddate = filter_input(INPUT_GET,'perioddate');
	$companyname = filter_input(INPUT_GET,'companyname');
	$accountname = filter_input(INPUT_GET,'accountname');
	$accountcode = filter_input(INPUT_GET,'accountcode');
    $year = date('Y',strtotime($perioddate));
    $month = date('m',strtotime($perioddate));
    $day1 = strtotime(''.$year.'-'.$month.'-01');
    $day2 = strtotime(''.$year.'-'.$month.'-01 -1 month');
    $bulanini = date('Y-m-d',($day1));
    $bulanlalu = date('Y-m-d',($day2));
    /*
    $sql = "select a.fohulid,a.perioddate,c.companycode,b.accountcode,b.accountname,a.expeditionamount,
            ifnull((select sum(d.debit-d.credit) from genledger d join genjournal e on e.genjournalid=d.genjournalid where e.recordstatus=3 and d.accountid=a.accountid and e.journaldate between DATE_ADD(DATE_ADD(LAST_DAY(a.perioddate),INTERVAL 1 DAY),INTERVAL - 1 MONTH) and LAST_DAY(a.perioddate)),0) as realisasi,
            ifnull((select sum(d.debit-d.credit) from genledger d join genjournal e on e.genjournalid=d.genjournalid where e.recordstatus=3 and d.accountid=a.accountid and e.journaldate between CONCAT(YEAR(a.perioddate),'-01-01') and LAST_DAY(a.perioddate)),0) as kumrealisasi
						from expedition a
						join account b on b.accountid = a.accountid
            join company c on c.companyid = a.companyid ";
		$fohulid = filter_input(INPUT_GET,'fohulid');
		$perioddate = filter_input(INPUT_GET,'perioddate');
		$companyname = filter_input(INPUT_GET,'companyname');
		$accountname = filter_input(INPUT_GET,'accountname');
		$accountcode = filter_input(INPUT_GET,'accountcode');
		$sql .= " where coalesce(a.fohulid,'') like '%".$fohulid."%' 
			and coalesce(a.perioddate,'') like '%".$perioddate."%'
			and coalesce(c.companyname,'') like '%".$companyname."%'
			and coalesce(b.accountname,'') like '%".$accountname."%'
			and coalesce(b.accountcode,'') like '%".$accountcode."%'
			";
    if ($_GET['id'] !== '') {
      $sql = $sql . " and a.fohulid in (" . $_GET['id'] . ")";
    } 
    $sql = $sql . " order by accountname asc ";
    
    $sql = "select fohulid, accountid, accountname, perioddate,companyid,companycode,accountcode,
            ifnull((select expeditionamount
            from expedition x where x.perioddate like '%{$bulanlalu}%' and x.accountid = z.accountid and x.companyid = z.companyid),0) as expeditionlalu,
            ifnull((select expeditionamount
            from expedition x where x.perioddate like '%{$bulanini}%' and x.accountid = z.accountid and x.companyid = z.companyid),0) as expeditionnow,
            ifnull((select if(z.expeditionamount<0,sum(d.debit-d.credit),sum(d.credit-d.debit))
            from genledger d 
            join genjournal e on e.genjournalid=d.genjournalid 
            where e.recordstatus=3 and d.accountid=z.accountid and e.journaldate between '{$bulanlalu}' and last_day('{$bulanlalu}')),0) as realisasilalu,
            ifnull((select if(z.expeditionamount<0,sum(d.debit-d.credit),sum(d.credit-d.debit)) 
            from genledger d 
            join genjournal e on e.genjournalid=d.genjournalid 
            where e.recordstatus=3 and d.accountid=z.accountid and e.journaldate between '{$bulanini}' and last_day('{$bulanini}')),0) as realisasinow,
            ifnull((select if(z.expeditionamount<0,sum(d.debit-d.credit),sum(d.credit-d.debit))
            from genledger d 
            join genjournal e on e.genjournalid=d.genjournalid 
            where e.recordstatus=3 and d.accountid=z.accountid and e.journaldate between CONCAT(YEAR(z.perioddate),'-01-01') 
            and last_day('{$bulanini}')),0) as kumrealisasi,
            ifnull((select sum(expeditionamount)
            from expedition y
            where y.accountid = z.accountid 
            and y.companyid = z.companyid
            and y.plantid = z.plantid
            and y.perioddate between concat(year('{$bulanini}'),'-01-01') and last_day('{$bulanini}')),0) as kumexpedition
            from (select a.fohulid,a.perioddate,b.accountname, a.accountid, a.companyid, expeditionamount, companycode, b.accountcode,plantid,plantcode
            from expedition a
            join account b on b.accountid = a.accountid 
            join company c on c.companyid = a.companyid
            join plant d on d.plantid = a.plantid
            where coalesce(a.fohulid,'') like '%%' 
            and coalesce(a.perioddate,'') like '%{$bulanlalu}%'
            and coalesce(c.companyname,'') like '%{$companyname}%'
            and coalesce(b.accountname,'') like '%{$accountname}%'
            and coalesce(b.accountcode,'') like '%{$accountcode}%'
            union
            select a.fohulid,a.perioddate,b.accountname, a.accountid, a.companyid, expeditionamount, companycode, b.accountcode,a.plantid,plantcode
            from expedition a
            join account b on b.accountid = a.accountid 
            join company c on c.companyid = a.companyid
            join plant d on d.plantid = a.plantid
            where coalesce(a.fohulid,'') like '%%' 
            and coalesce(a.perioddate,'') like '%{$bulanini}%'
            and coalesce(c.companyname,'') like '%{$companyname}%'
            and coalesce(b.accountname,'') like '%{$accountname}%'
            and coalesce(b.accountcode,'') like '%{$accountcode}%'
            ) z group by accountid order by perioddate,accountcode asc";
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $i          = 3;
    foreach ($dataReader as $row1) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i, $row1['fohulid'])->setCellValueByColumnAndRow(1, $i, date(Yii::app()->params['dateviewfromdb'],strtotime($bulanini)))->setCellValueByColumnAndRow(2, $i, $row1['companycode'])->setCellValueByColumnAndRowsetCellValueByColumnAndRow(3, $i, $row1['plantcode'])->setCellValueByColumnAndRow(4, $i, $row1['accountcode'])->setCellValueByColumnAndRow(5, $i, $row1['accountname'])->setCellValueByColumnAndRow(6, $i, $row1['expeditionnow'])->setCellValueByColumnAndRow(7, $i, $row1['realisasinow'])->setCellValueByColumnAndRow(8, $i, $row1['expeditionlalu'])->setCellValueByColumnAndRow(9, $i, $row1['realisasilalu'])->setCellValueByColumnAndRow(10, $i, $row1['kumexpedition'])->setCellValueByColumnAndRow(11, $i, $row1['kumrealisasi']);
      $i++;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  */
}