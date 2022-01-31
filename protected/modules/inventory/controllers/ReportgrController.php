<?php

class ReportgrController extends AdminController
{
	protected $menuname = 'reportgr';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Surat Tanda Terima Barang';
	public $wfname = 'appgr';
	protected $sqldata = "select a0.grheaderid,a0.grdate,a0.grno,a0.poheaderid,a0.headernote,a0.recordstatus,a0.statusname  
    from grheader a0 
	join poheader j on j.poheaderid = a0.poheaderid
  ";
protected $sqldatagrdetail = "select a0.grdetailid,a0.grheaderid,a0.productid,a0.qty,a0.unitofmeasureid,a0.slocid,a0.podetailid,a0.invqty,a0.storagebinid,a0.itemtext,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from grdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from grheader a0 
	join poheader j on j.poheaderid = a0.poheaderid
  ";
protected $sqlcountgrdetail = "select count(1) 
    from grdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where j.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['grno'])) && (isset($_REQUEST['poheaderid'])) && (isset($_REQUEST['headernote'])))
		{				
			$where .=  " 
and a0.grno like '%". $_REQUEST['grno']."%' 
and a0.poheaderid like '%". $_REQUEST['poheaderid']."%' 
and a0.headernote like '%". $_REQUEST['headernote']."%'"; 
		}
		if (isset($_REQUEST['grheaderid']))
			{
				if (($_REQUEST['grheaderid'] !== '0') && ($_REQUEST['grheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.grheaderid in (".$_REQUEST['grheaderid'].")";
					}
					else
					{
						$where .= " and a0.grheaderid in (".$_REQUEST['grheaderid'].")";
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
			'keyField'=>'grheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'grheaderid','grdate','grno','poheaderid','headernote','statusname'
				),
				'defaultOrder' => array( 
					'grheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['grheaderid']))
		{
			$this->sqlcountgrdetail .= ' where a0.grheaderid = '.$_REQUEST['grheaderid'];
			$this->sqldatagrdetail .= ' where a0.grheaderid = '.$_REQUEST['grheaderid'];
		}
		$countgrdetail = Yii::app()->db->createCommand($this->sqlcountgrdetail)->queryScalar();
$dataProvidergrdetail=new CSqlDataProvider($this->sqldatagrdetail,array(
					'totalItemCount'=>$countgrdetail,
					'keyField'=>'grdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'grdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergrdetail'=>$dataProvidergrdetail));
	}

	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select b.companyid,a.grno,a.grdate,a.grheaderid,b.pono,c.fullname,a.recordstatus,a.headernote
						from grheader a
						left join poheader b on b.poheaderid = a.poheaderid
						left join addressbook c on c.addressbookid = b.addressbookid ";
		if ($_GET['grheaderid'] !== '') 
		{
				$sql = $sql . "where a.grheaderid in (".$_GET['grheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('grheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->setFont('Arial'); 
		$this->pdf->AliasNbPages();
	  // definisi font	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFontSize(8);      
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['grno']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Date ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])));
      $this->pdf->text(130,$this->pdf->gety()+2,'PO No ');$this->pdf->text(165,$this->pdf->gety()+2,': '.$row['pono']);
      $this->pdf->text(130,$this->pdf->gety()+6,'Vendor ');$this->pdf->text(165,$this->pdf->gety()+6,': '.$row['fullname']);
      $sql1 = "select b.productname, a.qty, c.uomcode,concat(d.sloccode,'-',d.description) as description,
							e.description as rak
							from grdetail a
							left join product b on b.productid = a.productid
							left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							left join sloc d on d.slocid = a.slocid
							left join storagebin e on e.storagebinid = a.storagebinid
							where grheaderid = ".$row['grheaderid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,20,20,60));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            $row1['description']. ' - '. $row1['rak']));
      }
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(20,170));
			$this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Note:',$row['headernote']));
      $this->pdf->checkNewPage(40);
      //$this->pdf->Image('images/ttdttb.jpg',5,$this->pdf->gety()+5,200);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(90,$this->pdf->gety(),'Supplier / Perwakilan');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(90,$this->pdf->gety()+15,'........................');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('grheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('grdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('grno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('poheaderid'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['grheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['grdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['grno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['poheaderid'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}