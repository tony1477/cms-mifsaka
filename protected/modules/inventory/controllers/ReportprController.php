<?php

class ReportprController extends AdminController
{
	protected $menuname = 'reportpr';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Form Permohonan Pembelian';
	public $wfname = 'apppr';
	protected $sqldata = "select a0.prheaderid,a0.prdate,a0.prno,a0.headernote,a0.deliveryadviceid,a0.recordstatus,a0.statusname  
    from prheader a0 
	left join deliveryadvice s on s.deliveryadviceid = a0.deliveryadviceid 
	left join sloc a3 on a3.slocid = s.slocid 
		left join plant a4 on a4.plantid = a3.plantid
		left join company a5 on a5.companyid = a4.companyid 
  ";
protected $sqldataprmaterial = "select a0.prmaterialid,a0.prheaderid,a0.productid,a0.qty,a0.unitofmeasureid,a0.requestedbyid,a0.reqdate,a0.itemtext,a0.poqty,a0.deliveryadvicedetailid,a0.grqty,a0.giqty,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode,a3.requestedbycode as requestedbycode 
    from prmaterial a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join requestedby a3 on a3.requestedbyid = a0.requestedbyid
  ";
  protected $sqlcount = "select count(1) 
    from prheader a0 
	left join deliveryadvice s on s.deliveryadviceid = a0.deliveryadviceid
	left join sloc a3 on a3.slocid = s.slocid 
		left join plant a4 on a4.plantid = a3.plantid
		left join company a5 on a5.companyid = a4.companyid 
  ";
protected $sqlcountprmaterial = "select count(1) 
    from prmaterial a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join requestedby a3 on a3.requestedbyid = a0.requestedbyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a5.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['prno'])) && (isset($_REQUEST['deliveryadviceid'])))
		{				
			$where .=  " 
and a0.prno like '%". $_REQUEST['prno']."%' 
and a0.deliveryadviceid like '%". $_REQUEST['deliveryadviceid']."%'"; 
		}
		if (isset($_REQUEST['prheaderid']))
			{
				if (($_REQUEST['prheaderid'] !== '0') && ($_REQUEST['prheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.prheaderid in (".$_REQUEST['prheaderid'].")";
					}
					else
					{
						$where .= " and a0.prheaderid in (".$_REQUEST['prheaderid'].")";
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
			'keyField'=>'prheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'prheaderid','prdate','prno','headernote','deliveryadviceid','statusname'
				),
				'defaultOrder' => array( 
					'prheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['prheaderid']))
		{
			$this->sqlcountprmaterial .= ' where a0.prheaderid = '.$_REQUEST['prheaderid'];
			$this->sqldataprmaterial .= ' where a0.prheaderid = '.$_REQUEST['prheaderid'];
		}
		$countprmaterial = Yii::app()->db->createCommand($this->sqlcountprmaterial)->queryScalar();
$dataProviderprmaterial=new CSqlDataProvider($this->sqldataprmaterial,array(
					'totalItemCount'=>$countprmaterial,
					'keyField'=>'prmaterialid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'prmaterialid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderprmaterial'=>$dataProviderprmaterial));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select b.slocid,e.companyid,a.prno,a.prdate,a.headernote,a.prheaderid,b.description,c.dano,a.recordstatus
						from prheader a 
						inner join deliveryadvice c on c.deliveryadviceid = a.deliveryadviceid
						inner join sloc b on b.slocid = c.slocid     
						inner join plant d on d.plantid = b.plantid
						inner join company e on e.companyid = d.companyid ";
		if ($_REQUEST['prheaderid'] !== '') 
		{
				$sql = $sql . "where a.prheaderid in (".$_REQUEST['prheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('prheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->SetFont('Arial');
		
    foreach($dataReader as $row)
    {
			$this->pdf->SetFontSize(8);
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['prno']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['prdate'])));
      $this->pdf->text(120,$this->pdf->gety()+2,'Gudang ');$this->pdf->text(150,$this->pdf->gety()+2,': '.$row['description']);
      $this->pdf->text(120,$this->pdf->gety()+6,'No Permintaan Barang ');$this->pdf->text(150,$this->pdf->gety()+6,': '.$row['dano']);

      $sql1 = "select b.productname, a.qty, c.uomcode, a.itemtext
							from prmaterial a
							left join product b on b.productid = a.productid
							left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							where prheaderid = ".$row['prheaderid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->colalign = array('C','C','C','C','C');
      $this->pdf->setwidths(array(10,90,20,15,55));
			$this->pdf->colheader = array('No','Items','Qty','Unit','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            $row1['itemtext']));
      }
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,140));
			$this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Note:',$row['headernote']));
			$this->pdf->checkNewPage(40);
      //$this->pdf->Image('images/ttdpr.jpg',5,$this->pdf->gety()+5,200);
			$this->pdf->sety($this->pdf->gety()+10);
						$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Pembuat');$this->pdf->text(170,$this->pdf->gety(),'Pembuat');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');

      }
	  $this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('prheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('prdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('prno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('deliveryadviceid'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['prheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['prdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['prno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(4, $i+1, $row1['deliveryadviceid'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}