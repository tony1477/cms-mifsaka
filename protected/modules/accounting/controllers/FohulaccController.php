<?php
class FohulaccController extends Controller {
  public $menuname = 'fohulacc';
  public function actionIndex() {
		parent::actionIndex();
    if (isset($_GET['grid']))
      echo $this->search();
    else
      $this->renderPartial('index', array());
  }
  public function search() {
    header("Content-Type: application/json");
    $fohulaccid   = isset($_POST['fohulaccid']) ? $_POST['fohulaccid'] : '';
    $sloccode       = isset($_POST['sloccode']) ? $_POST['sloccode'] : '';
    //$description    = isset($_POST['materialgroup']) ? $_POST['materialgroup'] : '';
    $description    = isset($_POST['mgprocess']) ? $_POST['mgprocess'] : '';
    $recordstatus   = isset($_POST['recordstatus']) ? $_POST['recordstatus'] : '';
    $page       = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows       = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $sort       = isset($_POST['sort']) ? strval($_POST['sort']) : 'fohulaccid';
    $order      = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
    $offset     = ($page - 1) * $rows;
    $result     = array();
    $row        = array();
    $cmd = Yii::app()->db->createCommand()->select('count(1) as total')
    ->from('fohulacc t')
    ->leftjoin('sloc b', 'b.slocid=t.slocid')
    //->leftjoin('materialgroup c', 'c.materialgroupid=t.materialgroupid')
    ->leftjoin('mgprocess c', 'c.mgprocessid=t.mgprocessid')
    ->where("((fohulaccid like :fohulaccid) and (coalesce(b.sloccode,'') like :sloccode) and (coalesce(c.description,'') like :description)) ", array(
        ':fohulaccid' => '%' . $fohulaccid . '%',
        ':sloccode' => '%' . $sloccode . '%',
        ':description' => '%' . $description . '%',
    ))->queryScalar();
    $result['total'] = $cmd;
    $cmd = Yii::app()->db->createCommand()->select('t.*,b.sloccode,c.description')
    ->from('fohulacc t')
    ->leftjoin('sloc b', 'b.slocid=t.slocid')
    //->leftjoin('materialgroup c', 'c.materialgroupid=t.materialgroupid')
    ->leftjoin('mgprocess c', 'c.mgprocessid=t.mgprocessid')
    ->where("((fohulaccid like :fohulaccid) and (coalesce(b.sloccode,'') like :sloccode) and (coalesce(c.description,'') like :description))", array(
        ':fohulaccid' => '%' . $fohulaccid . '%',
        ':sloccode' => '%' . $sloccode . '%',
        ':description' => '%' . $description . '%',
    ))->offset($offset)->limit($rows)->order($sort . ' ' . $order)->queryAll();
    foreach ($cmd as $data) {
      $row[] = array(
        'fohulaccid' => $data['fohulaccid'],
        //'materialgroupid' => $data['materialgroupid'],
        'mgprocessid' => $data['mgprocessid'],
        'description' => $data['description'],
        'sloccode' => $data['sloccode'],
        'fohcode' => $data['fohcode'],
        'ulcode' => $data['ulcode'],
        'slocid' => $data['slocid'],
        'recordstatus' => $data['recordstatus'],
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
			$sql     = 'call Insertfohulacc(:vslocid,:vmgprocessid,:vfohcode,:vulcode,:vrecordstatus,:vcreatedby)';
			$command = $connection->createCommand($sql);
		} else {
			$sql     = 'call Updatefohulacc(:vid,:vslocid,:vmgprocessid,:vfohcode,:vulcode,:vrecordstatus,:vcreatedby)';
			$command = $connection->createCommand($sql);
			$command->bindvalue(':vid', $arraydata[0], PDO::PARAM_STR);
		}
        $command->bindvalue(':vslocid', $arraydata[1], PDO::PARAM_STR);
        $command->bindvalue(':vmgprocessid', $arraydata[2], PDO::PARAM_STR);        
		$command->bindvalue(':vfohcode', $arraydata[3], PDO::PARAM_STR);
		$command->bindvalue(':vulcode', $arraydata[4], PDO::PARAM_STR);
		$command->bindvalue(':vrecordstatus', $arraydata[5], PDO::PARAM_STR);
		$command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
		$command->execute();
	}
	public function actionUpload() {
		parent::actionUpload();
    $target_file = dirname('__FILES__').'/uploads/' . basename($_FILES["file-fohulacc"]["name"]);
    if (move_uploaded_file($_FILES["file-fohulacc"]["tmp_name"], $target_file)) {
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
                    $sloccode = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
					$slocid = Yii::app()->db->createCommand("select slocid from sloc where sloccode = '".$sloccode."'")->queryScalar();
                    $description = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
					$mgprocessid = Yii::app()->db->createCommand("select mgprocessid from mgprocess where description = '".$description."'")->queryScalar();
					$fohcode = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $ulcode = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $rec = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $recordstatus = Yii::app()->db->createCommand("select case when '".$rec."' = 'Yes' then '1' else '0' end")->queryScalar();
					//$fohulaccamount = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
					$this->ModifyData($connection,array($id,$slocid,$mgprocessid,$fohcode,$ulcode,$recordstatus));
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
			$this->ModifyData($connection,array((isset($_POST['fohulaccid'])?$_POST['fohulaccid']:''),$_POST['slocid'],$_POST['mgprocessid'],$_POST['fohcode'],$_POST['ulcode'],$_POST['recordstatus']));
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
        $sql     = 'call Approvefohulacc(:vid,:vcreatedby)';
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
        $sql     = 'call Deletefohulacc(:vid,:vcreatedby)';
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
        $sql     = 'call Purgefohulacc(:vid,:vcreatedby)';
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
    $fohulaccid = filter_input(INPUT_GET,'id');
	$sloccode = filter_input(INPUT_GET,'sloccode');
	$description = filter_input(INPUT_GET,'description');
    
    
    
    /*$sql = "select a.fohulaccid,a.perioddate,b.accountname,a.expeditionamount,a.companyid,ifnull((select sum(d.debit-d.credit) from genledger d join genjournal e on e.genjournalid=d.genjournalid where e.recordstatus=3 and d.accountid=a.accountid and e.journaldate between DATE_ADD(DATE_ADD(LAST_DAY(a.perioddate),INTERVAL 1 DAY),INTERVAL - 1 MONTH) and LAST_DAY(a.perioddate)),0) as realisasi,
            ifnull((select sum(d.debit-d.credit) from genledger d join genjournal e on e.genjournalid=d.genjournalid where e.recordstatus=3 and d.accountid=a.accountid and e.journaldate between CONCAT(YEAR(a.perioddate),'-01-01') and LAST_DAY(a.perioddate)),0) as kumrealisasi
						from expedition a
						join account b on b.accountid = a.accountid 
						join company c on c.companyid = a.companyid ";
		$fohulaccid = filter_input(INPUT_GET,'fohulaccid');
		$perioddate = filter_input(INPUT_GET,'perioddate');
		$companyname = filter_input(INPUT_GET,'companyname');
		$accountname = filter_input(INPUT_GET,'accountname');
		$accountcode = filter_input(INPUT_GET,'accountcode');
		$sql .= " where coalesce(a.fohulaccid,'') like '%".$fohulaccid."%' 
			and coalesce(a.perioddate,'') like '%".$perioddate."%'
			and coalesce(c.companyname,'') like '%".$companyname."%'
			and coalesce(b.accountname,'') like '%".$accountname."%'
			and coalesce(b.accountcode,'') like '%".$accountcode."%'
			";
    
    if ($_GET['id'] !== '') {
      $sql = $sql . " and a.fohulaccid in (" . $_GET['id'] . ")";
    } 
    */
    $sql = "select t.*, a.description, b.sloccode, if(t.recordstatus=1,'Aktif','Not Aktif') as recordstatus
            from fohulacc t
            left join mgprocess a on a.mgprocessid = t.mgprocessid
            left join sloc b on b.slocid = t.slocid
            where coalesce(t.fohulaccid,'') like '%".$fohulaccid."%' 
            and coalesce(b.sloccode,'') like '%".$sloccode."%' 
            and coalesce(a.description,'') like '%".$description."%' 
            ";
    //$sql = $sql . " order by accountname asc ";
    $command          = Yii::app()->db->createCommand($sql);
    $dataReader       = $command->queryAll();
    foreach ($dataReader as $row1)
		{
			$this->pdf->companyid = 1;
		}
    $this->pdf->title = GetCatalog('fohulacc');
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial','B',9);
    $this->pdf->colalign  = array(
      'L',
      'L',
      'L',
      'L',
      'L',
    );
    $this->pdf->colheader = array(
      GetCatalog('sloc'),
      GetCatalog('mgprocess'),
      GetCatalog('fohcode'),
      GetCatalog('ulcode'),
      GetCatalog('recordstatus'),
      
    );
    $this->pdf->setwidths(array(
      27,
      40,
      50,
      50,
      20,
    ));
    $this->pdf->Rowheader();
    $this->pdf->setFont('Arial','',9);
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'L',
      'L',
      'R',
    );
    foreach ($dataReader as $row1) {
        $foh = null;
        $ul = null;
        $arrfoh = explode('+',$row1['fohcode']);
        $arrul = explode('+',$row1['ulcode']);
        
        if($arrfoh[0]!='') {
            foreach($arrfoh as $row2) {
                $q = Yii::app()->db->createCommand('select distinct accountname from account where accountcode = '.$row2)->queryScalar();
                if($foh == ''){
                    $foh = $q;
                }else
                {
                    $foh = $foh.' + '.$q;
                }
            }
        }
        else
        {
            $foh = '';
        }
        
        if($arrul[0]!='') {
            foreach($arrul as $row2) {
                $q = Yii::app()->db->createCommand('select distinct accountname from account where accountcode = '.$row2)->queryScalar();
                if($ul == ''){
                    $ul = $q;
                }else
                {
                    $ul = $ul.' + '.$q;
                }
            }
        }
        else
        {
            $ul = '';
        }
        
        $this->pdf->row(array(
        $row1['sloccode'],
        $row1['description'],
        $foh,
        $ul,
        $row1['recordstatus'],
      ));
    }
    $this->pdf->Output();
  }
  
  public function actionDownXLS() {
    $this->menuname = 'fohulacc';
    parent::actionDownxls();
    $fohulaccid = filter_input(INPUT_GET,'id');
	$sloccode = filter_input(INPUT_GET,'sloccode');
	$description = filter_input(INPUT_GET,'description');
    
     $sql = "select t.*, a.description, b.sloccode, if(t.recordstatus=1,'Yes','No') as recordstatus
            from fohulacc t
            left join mgprocess a on a.mgprocessid = t.mgprocessid
            left join sloc b on b.slocid = t.slocid
            where coalesce(t.fohulaccid,'') like '%".$fohulaccid."%' 
            and coalesce(b.sloccode,'') like '%".$sloccode."%' 
            and coalesce(a.description,'') like '%".$description."%' 
            ";
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $i          = 3;
    foreach ($dataReader as $row1) {
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $i, $row1['fohulaccid'])
          ->setCellValueByColumnAndRow(1, $i, $row1['sloccode'])
          ->setCellValueByColumnAndRow(2, $i, $row1['description'])
          ->setCellValueByColumnAndRow(3, $i, $row1['fohcode'])
          ->setCellValueByColumnAndRow(4, $i, $row1['ulcode'])
          ->setCellValueByColumnAndRow(5, $i, $row1['recordstatus']);
      $i++;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  
}