<?php

class ReportbsController extends AdminController
{
	protected $menuname = 'reportbs';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Stok Opname';
	public $wfname = 'appbs';
	protected $sqldata = "select a0.bsheaderid,a0.slocid,a0.bsdate,a0.bsheaderno,a0.headernote,a0.recordstatus,a1.sloccode as sloccode,a0.statusname  
    from bsheader a0 
    left join sloc a1 on a1.slocid = a0.slocid 
		left join plant a2 on a2.plantid = a1.plantid 
		left join company a3 on a3.companyid = a2.companyid  
  ";
protected $sqldatabsdetail = "select a0.bsdetailid,a0.bsheaderid,a0.productid,a0.unitofmeasureid,a0.qty,a0.ownershipid,a0.expiredate,a0.materialstatusid,a0.storagebinid,a0.location,a0.itemnote,a0.currencyid,a0.buyprice,a0.currencyrate,a1.productname as productname,a2.uomcode as uomcode,a3.ownershipname as ownershipname,a4.materialstatusname as materialstatusname,a5.description as description,a6.currencyname as currencyname 
    from bsdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join ownership a3 on a3.ownershipid = a0.ownershipid
    left join materialstatus a4 on a4.materialstatusid = a0.materialstatusid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join currency a6 on a6.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from bsheader a0 
    left join sloc a1 on a1.slocid = a0.slocid
		left join plant a2 on a2.plantid = a1.plantid 
		left join company a3 on a3.companyid = a2.companyid  
  ";
protected $sqlcountbsdetail = "select count(1) 
    from bsdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join ownership a3 on a3.ownershipid = a0.ownershipid
    left join materialstatus a4 on a4.materialstatusid = a0.materialstatusid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join currency a6 on a6.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a3.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['bsheaderno'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .=  " 
and a0.bsheaderno like '%". $_REQUEST['bsheaderno']."%' 
and a1.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['bsheaderid']))
			{
				if (($_REQUEST['bsheaderid'] !== '0') && ($_REQUEST['bsheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.bsheaderid in (".$_REQUEST['bsheaderid'].")";
					}
					else
					{
						$where .= " and a0.bsheaderid in (".$_REQUEST['bsheaderid'].")";
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
			'keyField'=>'bsheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'bsheaderid','slocid','bsdate','bsheaderno','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'bsheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['bsheaderid']))
		{
			$this->sqlcountbsdetail .= ' where a0.bsheaderid = '.$_REQUEST['bsheaderid'];
			$this->sqldatabsdetail .= ' where a0.bsheaderid = '.$_REQUEST['bsheaderid'];
		}
		$countbsdetail = Yii::app()->db->createCommand($this->sqlcountbsdetail)->queryScalar();
$dataProviderbsdetail=new CSqlDataProvider($this->sqldatabsdetail,array(
					'totalItemCount'=>$countbsdetail,
					'keyField'=>'bsdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'bsdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderbsdetail'=>$dataProviderbsdetail));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.bsheaderid,a.bsheaderno,a.bsdate,b.sloccode,a.headernote
						from bsheader a
						inner join sloc b on b.slocid = a.slocid ";
		if ($_REQUEST['bsheaderid'] !== '') 
		{
				$sql = $sql . "where a.bsheaderid in (".$_REQUEST['bsheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title=$this->getcatalog('bsheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNBPages();
	  // definisi font
	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFont('Arial','B',10);      
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['bsheaderno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['bsdate'])));
			$this->pdf->text(135,$this->pdf->gety()+5,'Gudang ');$this->pdf->text(170,$this->pdf->gety()+5,': '.$row['sloccode']);
	
			$i=0;$totalqty=0;$totaljumlah=0;
			$sql1 = "select b.productname,a.qty,a.buyprice,c.uomcode,a.itemnote,a.location,d.ownershipname,a.expiredate,e.materialstatusname,f.description
							from bsdetail a
							inner join product b on b.productid = a.productid
							inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							inner join ownership d on d.ownershipid = a.ownershipid
							inner join materialstatus e on e.materialstatusid = a.materialstatusid
							inner join storagebin f on f.storagebinid = a.storagebinid
							where bsheaderid = ".$row['bsheaderid']." order by bsdetailid ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->setwidths(array(7,45,20,15,22,25,30,20,20));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Hrg Beli/Prd','Jumlah','Rak','Status','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','R','C','R','C','L','L','L');
      
      foreach($dataReader1 as $row1)
      {
            if($this->GetMenuAuth('currency') == 'false'){
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
					Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],
					Yii::app()->format->formatCurrency($row1['buyprice']),
					Yii::app()->format->formatCurrency($row1['qty']*$row1['buyprice']),
					$row1['description'],
					$row1['ownershipname'].'-'.$row1['materialstatusname'],				
					$row1['itemnote']));
				$totalqty+=$row1['qty'];
				$totaljumlah+=$row1['qty']*$row1['buyprice'];
      }
      if($this->GetMenuAuth('currency') == 'true') {
          $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
					$row1['uomcode'].'  '.Yii::app()->format->formatNumber($row1['qty']),
					'0',
					'0',
					$row1['description'],
					$row1['ownershipname'].'-'.$row1['materialstatusname'],				
					$row1['itemnote']));
				
      }
      
            }
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->setFont('Arial','B',8);
      $this->pdf->coldetailalign = array('L','R','R','R','R','C','L','L');
			$this->pdf->row(array('','TOTAL',
				Yii::app()->format->formatNumber($totalqty),
				'',
				
				'',Yii::app()->format->formatCurrency($totaljumlah),'',''));
			
			$this->pdf->setFont('Arial','',8);
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,140));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Note',$row['headernote']));
			$this->pdf->checkNewPage(20);
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+5);
			//$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Peminta');$this->pdf->text(170,$this->pdf->gety(),'Peminta Barang');
			//$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),' Diketahui oleh,');$this->pdf->text(137,$this->pdf->gety(),'     Disetujui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'.........................');$this->pdf->text(137,$this->pdf->gety()+22,'.................................');
			$this->pdf->text(15,$this->pdf->gety()+25,'       Admin');$this->pdf->text(55,$this->pdf->gety()+25,'    Supervisor');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');$this->pdf->text(137,$this->pdf->gety()+25,'Manager Accounting');
			//$this->pdf->Image('images/ttdbs.jpg',5,$this->pdf->gety()+5,200);
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('bsheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('bsdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('bsheaderno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['bsheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['bsdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['bsheaderno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}