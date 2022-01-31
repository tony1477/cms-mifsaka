<?php
class AddressbookController extends AdminController
{
  protected $menuname = 'addressbook';
  public $module = 'Admin';
  protected $pageTitle = 'Buku Alamat';
  public $wfname = '';
  protected $sqldata = "select a0.addressbookid,a0.fullname,a0.iscustomer,a0.isemployee,a0.isvendor,a0.ishospital,
			a0.currentlimit,a0.currentdebt,a0.taxno,a0.creditlimit,a0.isstrictlimit,a0.bankname,a0.bankaccountno,a0.accountowner,a0.salesareaid,a0.pricecategoryid,a0.overdue,a0.invoicedate,a0.logo,a0.url,a0.recordstatus 
    from addressbook a0 
  ";
  protected $sqlcount = "select count(1) 
    from addressbook a0 
  ";
  protected function getSQL()
  {
    $this->count = Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
    $where       = "";
    if ((isset($_REQUEST['fullname']))) {
      $where .= " where a0.fullname like '%" . $_REQUEST['fullname'] . "%'";
    }
    if (isset($_REQUEST['addressbookid'])) {
      if (($_REQUEST['addressbookid'] !== '0') && ($_REQUEST['addressbookid'] !== '')) {
        $where .= " and a0.addressbookid in (" . $_REQUEST['addressbookid'] . ")";
      }
    }
    $this->sqldata = $this->sqldata . $where;
    $this->count   = Yii::app()->db->createCommand($this->sqlcount . $where)->queryScalar();
  }
  public function actionIndex()
  {
    parent::actionIndex();
    $this->getSQL();
    $dataProvider = new CSqlDataProvider($this->sqldata, array(
      'totalItemCount' => $this->count,
      'keyField' => 'addressbookid',
      'pagination' => array(
        'pageSize' => $this->getParameter('DefaultPageSize'),
        'pageVar' => 'page'
      ),
      'sort' => array(
        'attributes' => array(
          'addressbookid',
          'fullname',
          'iscustomer',
          'isemployee',
          'isvendor',
          'ishospital',
          'currentlimit',
          'currentdebt',
          'taxno',
          'accpiutangid',
          'acchutangid',
          'creditlimit',
          'isstrictlimit',
          'bankname',
          'bankaccountno',
          'accountowner',
          'salesareaid',
          'pricecategoryid',
          'overdue',
          'invoicedate',
          'logo',
          'url',
          'recordstatus'
        ),
        'defaultOrder' => array(
          'addressbookid' => CSort::SORT_DESC
        )
      )
    ));
    $this->render('index', array(
      'dataProvider' => $dataProvider
    ));
  }
  public function actionCreate()
  {
    parent::actionCreate();
    echo CJSON::encode(array(
      'status' => 'success',
      "currentlimit" => 0,
      "currentdebt" => 0,
      "creditlimit" => 0,
      "invoicedate" => date("Y-m-d")
    ));
  }
  public function actionUpdate()
  {
    parent::actionUpdate();
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      if (is_array($id)) {
        $id = $id[0];
      }
      $model = Yii::app()->db->createCommand($this->sqldata . ' where addressbookid = ' . $id)->queryRow();
      if ($model !== null) {
        echo CJSON::encode(array(
          'status' => 'success',
          'addressbookid' => $model['addressbookid'],
          'fullname' => $model['fullname'],
          'iscustomer' => $model['iscustomer'],
          'isemployee' => $model['isemployee'],
          'isvendor' => $model['isvendor'],
          'ishospital' => $model['ishospital'],
          'recordstatus' => $model['recordstatus']
        ));
        Yii::app()->end();
      }
    }
  }
  public function actionSave()
  {
    parent::actionSave();
    $error = $this->ValidateData(array(
      array(
        'fullname',
        'string',
        'emptyfullname'
      )
    ));
    if ($error == false) {
      $id          = $_POST['addressbookid'];
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
      try {
        if ($id !== '') {
          $sql = 'update addressbook 
			      set fullname = :fullname,iscustomer = :iscustomer,isemployee = :isemployee,isvendor = :isvendor,ishospital = :ishospital,recordstatus = :recordstatus 
			      where addressbookid = :addressbookid';
        } else {
          $sql = 'insert into addressbook (fullname,iscustomer,isemployee,isvendor,ishospital,recordstatus) 
			      values (:fullname,:iscustomer,:isemployee,:isvendor,:ishospital,:recordstatus)';
        }
        $command = $connection->createCommand($sql);
        if ($id !== '') {
          $command->bindvalue(':addressbookid', $_POST['addressbookid'], PDO::PARAM_STR);
        }
        $command->bindvalue(':fullname', (($_POST['fullname'] !== '') ? $_POST['fullname'] : null), PDO::PARAM_STR);
        $command->bindvalue(':iscustomer', (($_POST['iscustomer'] !== '') ? $_POST['iscustomer'] : null), PDO::PARAM_STR);
        $command->bindvalue(':isemployee', (($_POST['isemployee'] !== '') ? $_POST['isemployee'] : null), PDO::PARAM_STR);
        $command->bindvalue(':isvendor', (($_POST['isvendor'] !== '') ? $_POST['isvendor'] : null), PDO::PARAM_STR);
        $command->bindvalue(':ishospital', (($_POST['ishospital'] !== '') ? $_POST['ishospital'] : null), PDO::PARAM_STR);
        $command->bindvalue(':recordstatus', (($_POST['recordstatus'] !== '') ? $_POST['recordstatus'] : null), PDO::PARAM_STR);
        $command->execute();
        $transaction->commit();
        $this->InsertTranslog($command, $id);
        $this->getMessage('success', 'alreadysaved');
      }
      catch (CDbException $e) {
        $transaction->rollBack();
        $this->getMessage('error', $e->getMessage());
      }
    }
  }
  public function actionDelete()
  {
    parent::actionDelete();
    $connection  = Yii::app()->db;
    $transaction = $connection->beginTransaction();
    try {
      if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if (!is_array($id)) {
          $ids[] = $id;
          $id    = $ids;
        }
        for ($i = 0; $i < count($id); $i++) {
          $sql    = "select recordstatus from addressbook where addressbookid = " . $id[$i];
          $status = Yii::app()->db->createCommand($sql)->queryRow();
          if ($status['recordstatus'] == 1) {
            $sql = "update addressbook set recordstatus = 0 where addressbookid = " . $id[$i];
          } else if ($status['recordstatus'] == 0) {
            $sql = "update addressbook set recordstatus = 1 where addressbookid = " . $id[$i];
          }
          $connection->createCommand($sql)->execute();
        }
        $transaction->commit();
        $this->getMessage('success', 'alreadysaved');
      } else {
        $this->getMessage('success', 'chooseone');
      }
    }
    catch (CDbException $e) {
      $transaction->rollback();
      $this->getMessage('error', $e->getMessage());
    }
  }
  public function actionPurge()
  {
    parent::actionPurge();
    $connection  = Yii::app()->db;
    $transaction = $connection->beginTransaction();
    try {
      if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if (!is_array($id)) {
          $ids[] = $id;
          $id    = $ids;
        }
        for ($i = 0; $i < count($id); $i++) {
          $sql = "delete from addressbook where addressbookid = " . $id[$i];
          Yii::app()->db->createCommand($sql)->execute();
        }
        $transaction->commit();
        $this->getMessage('success', 'alreadysaved');
      } else {
        $this->getMessage('success', 'chooseone');
      }
    }
    catch (CDbException $e) {
      $transaction->rollback();
      $this->getMessage('error', $e->getMessage());
    }
  }
  public function actionDownPDF()
  {
    parent::actionDownPDF();
    $this->getSQL();
    $dataReader       = Yii::app()->db->createCommand($this->sqldata)->queryAll();
    $this->pdf->title = $this->getCatalog('addressbook');
    $this->pdf->AddPage('P');
    $this->pdf->colalign  = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->colheader = array(
      $this->getCatalog('addressbookid'),
      $this->getCatalog('fullname'),
      $this->getCatalog('iscustomer'),
      $this->getCatalog('isemployee'),
      $this->getCatalog('isvendor'),
      $this->getCatalog('ishospital'),
      $this->getCatalog('currentlimit'),
      $this->getCatalog('currentdebt'),
      $this->getCatalog('taxno'),
      $this->getCatalog('accpiutang'),
      $this->getCatalog('acchutang'),
      $this->getCatalog('creditlimit'),
      $this->getCatalog('isstrictlimit'),
      $this->getCatalog('bankname'),
      $this->getCatalog('bankaccountno'),
      $this->getCatalog('accountowner'),
      $this->getCatalog('salesarea'),
      $this->getCatalog('pricecategory'),
      $this->getCatalog('overdue'),
      $this->getCatalog('invoicedate'),
      $this->getCatalog('logo'),
      $this->getCatalog('url'),
      $this->getCatalog('recordstatus')
    );
    $this->pdf->setwidths(array(
      10,
      40,
      15,
      15,
      15,
      15,
      40,
      40,
      40,
      40,
      40,
      40,
      15,
      40,
      40,
      40,
      40,
      40,
      40,
      40,
      40,
      40,
      15
    ));
    $this->pdf->Rowheader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L'
    );
    foreach ($dataReader as $row1) {
      $this->pdf->row(array(
        $row1['addressbookid'],
        $row1['fullname'],
        $row1['iscustomer'],
        $row1['isemployee'],
        $row1['isvendor'],
        $row1['ishospital'],
        $row1['currentlimit'],
        $row1['currentdebt'],
        $row1['taxno'],
        $row1['accpiutangid'],
        $row1['acchutangid'],
        $row1['creditlimit'],
        $row1['isstrictlimit'],
        $row1['bankname'],
        $row1['bankaccountno'],
        $row1['accountowner'],
        $row1['salesareaid'],
        $row1['pricecategoryid'],
        $row1['overdue'],
        $row1['invoicedate'],
        $row1['logo'],
        $row1['url'],
        $row1['recordstatus']
      ));
    }
    $this->pdf->Output();
  }
  public function actionDownXLS()
  {
    parent::actionDownXLS();
    $this->getSQL();
    $dataReader = Yii::app()->db->createCommand($this->sqldata)->queryAll();
    $i          = 4;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 4, $this->getCatalog('addressbookid'))->setCellValueByColumnAndRow(1, 4, $this->getCatalog('fullname'))->setCellValueByColumnAndRow(2, 4, $this->getCatalog('iscustomer'))->setCellValueByColumnAndRow(3, 4, $this->getCatalog('isemployee'))->setCellValueByColumnAndRow(4, 4, $this->getCatalog('isvendor'))->setCellValueByColumnAndRow(5, 4, $this->getCatalog('ishospital'))->setCellValueByColumnAndRow(6, 4, $this->getCatalog('currentlimit'))->setCellValueByColumnAndRow(7, 4, $this->getCatalog('currentdebt'))->setCellValueByColumnAndRow(8, 4, $this->getCatalog('taxno'))->setCellValueByColumnAndRow(9, 4, $this->getCatalog('accpiutangid'))->setCellValueByColumnAndRow(10, 4, $this->getCatalog('acchutangid'))->setCellValueByColumnAndRow(11, 4, $this->getCatalog('creditlimit'))->setCellValueByColumnAndRow(12, 4, $this->getCatalog('isstrictlimit'))->setCellValueByColumnAndRow(13, 4, $this->getCatalog('bankname'))->setCellValueByColumnAndRow(14, 4, $this->getCatalog('bankaccountno'))->setCellValueByColumnAndRow(15, 4, $this->getCatalog('accountowner'))->setCellValueByColumnAndRow(16, 4, $this->getCatalog('salesareaid'))->setCellValueByColumnAndRow(17, 4, $this->getCatalog('pricecategoryid'))->setCellValueByColumnAndRow(18, 4, $this->getCatalog('overdue'))->setCellValueByColumnAndRow(19, 4, $this->getCatalog('invoicedate'))->setCellValueByColumnAndRow(20, 4, $this->getCatalog('logo'))->setCellValueByColumnAndRow(21, 4, $this->getCatalog('url'))->setCellValueByColumnAndRow(22, 4, $this->getCatalog('recordstatus'));
    foreach ($dataReader as $row1) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i + 1, $row1['addressbookid'])->setCellValueByColumnAndRow(1, $i + 1, $row1['fullname'])->setCellValueByColumnAndRow(2, $i + 1, $row1['iscustomer'])->setCellValueByColumnAndRow(3, $i + 1, $row1['isemployee'])->setCellValueByColumnAndRow(4, $i + 1, $row1['isvendor'])->setCellValueByColumnAndRow(5, $i + 1, $row1['ishospital'])->setCellValueByColumnAndRow(6, $i + 1, $row1['currentlimit'])->setCellValueByColumnAndRow(7, $i + 1, $row1['currentdebt'])->setCellValueByColumnAndRow(8, $i + 1, $row1['taxno'])->setCellValueByColumnAndRow(9, $i + 1, $row1['accpiutangid'])->setCellValueByColumnAndRow(10, $i + 1, $row1['acchutangid'])->setCellValueByColumnAndRow(11, $i + 1, $row1['creditlimit'])->setCellValueByColumnAndRow(12, $i + 1, $row1['isstrictlimit'])->setCellValueByColumnAndRow(13, $i + 1, $row1['bankname'])->setCellValueByColumnAndRow(14, $i + 1, $row1['bankaccountno'])->setCellValueByColumnAndRow(15, $i + 1, $row1['accountowner'])->setCellValueByColumnAndRow(16, $i + 1, $row1['salesareaid'])->setCellValueByColumnAndRow(17, $i + 1, $row1['pricecategoryid'])->setCellValueByColumnAndRow(18, $i + 1, $row1['overdue'])->setCellValueByColumnAndRow(19, $i + 1, $row1['invoicedate'])->setCellValueByColumnAndRow(20, $i + 1, $row1['logo'])->setCellValueByColumnAndRow(21, $i + 1, $row1['url'])->setCellValueByColumnAndRow(22, $i + 1, $row1['recordstatus']);
      $i += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
}