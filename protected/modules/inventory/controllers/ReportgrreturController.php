<?php

class ReportgrreturController extends AdminController
{
	protected $menuname = 'reportgrretur';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Retur Pembelian';
	public $wfname = 'appgrretur';
	protected $sqldata = "select a0.grreturid,a0.grreturno,a0.grreturdate,a0.poheaderid,a0.headernote,a0.recordstatus,a1.pono as pono,a0.statusname  
    from grretur a0 
    left join poheader a1 on a1.poheaderid = a0.poheaderid
  ";
protected $sqldatagrreturdetail = "select a0.grreturdetailid,a0.grreturid,a0.podetailid,a0.productid,a0.qty,a0.uomid,a0.slocid,a0.storagebinid,a0.grdetailid,a0.itemnote,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from grreturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from grretur a0 
    left join poheader a1 on a1.poheaderid = a0.poheaderid
  ";
protected $sqlcountgrreturdetail = "select count(1) 
    from grreturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['grreturno'])) && (isset($_REQUEST['pono'])))
		{				
			$where .=  " 
and a0.grreturno like '%". $_REQUEST['grreturno']."%' 
and a1.pono like '%". $_REQUEST['pono']."%'"; 
		}
		if (isset($_REQUEST['grreturid']))
			{
				if (($_REQUEST['grreturid'] !== '0') && ($_REQUEST['grreturid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.grreturid in (".$_REQUEST['grreturid'].")";
					}
					else
					{
						$where .= " and a0.grreturid in (".$_REQUEST['grreturid'].")";
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
			'keyField'=>'grreturid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'grreturid','grreturno','grreturdate','poheaderid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'grreturid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['grreturid']))
		{
			$this->sqlcountgrreturdetail .= ' where a0.grreturid = '.$_REQUEST['grreturid'];
			$this->sqldatagrreturdetail .= ' where a0.grreturid = '.$_REQUEST['grreturid'];
		}
		$countgrreturdetail = Yii::app()->db->createCommand($this->sqlcountgrreturdetail)->queryScalar();
$dataProvidergrreturdetail=new CSqlDataProvider($this->sqldatagrreturdetail,array(
					'totalItemCount'=>$countgrreturdetail,
					'keyField'=>'grreturdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'grreturdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergrreturdetail'=>$dataProvidergrreturdetail));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.grreturid,b.companyid,a.grreturno,a.grreturdate,a.poheaderid,b.pono,c.fullname,a.recordstatus,a.headernote
      from grretur a
      left join poheader b on b.poheaderid = a.poheaderid
      left join addressbook c on c.addressbookid = b.addressbookid ";
		if ($_REQUEST['grreturid'] !== '') {
				$sql = $sql . "where a.grreturid in (".$_REQUEST['grreturid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
     foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('grretur');
	  $this->pdf->AddPage('P');
	  // definisi font	  

    foreach($dataReader as $row)
    {
	        $this->pdf->Rect(10,60,190,25);
      $this->pdf->setFont('Arial','B',9);      
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['grreturno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'PO No ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['pono']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Vendor ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['fullname']);

      $sql1 = "select b.productname, a.qty, c.uomcode,d.description
        from grreturdetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.uomid
        left join sloc d on d.slocid = a.slocid
        where grreturid = ".$row['grreturid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

	  $this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,90,20,20,50));
	  $this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            $row1['description']));
      }
		$this->pdf->sety($this->pdf->gety()+10);
	  $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,140));
	  $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
	  $this->pdf->colheader = array('Item','Description');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L');
	  $this->pdf->row(array(
		'Note:',
		$row['headernote']
	  ));
      
      $this->pdf->Image('images/ttdgrretur.jpg',5,$this->pdf->gety()+25,200);
				$this->pdf->isheader=false;
				$this->pdf->AddPage('L',array(100,200));
      
      $this->pdf->AddPage('P');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('grreturid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('grreturno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('grreturdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('pono'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['grreturid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['grreturno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['grreturdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['pono'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}