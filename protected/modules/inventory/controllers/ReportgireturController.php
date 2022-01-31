<?php

class ReportgireturController extends AdminController
{
	protected $menuname = 'reportgiretur';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Retur Penjualan';
	public $wfname = 'appgiretur';
	protected $sqldata = "select a0.gireturid,a0.gireturno,a0.giheaderid,a0.gireturdate,a0.headernote,a0.recordstatus,a1.gino as gino,a0.statusname  
    from giretur a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
	left join soheader b on b.soheaderid = a1.soheaderid
				left join company c on c.companyid = b.companyid
  ";
protected $sqldatagireturdetail = "select a0.gireturdetailid,a0.gireturid,a0.productid,a0.qty,a0.uomid,a0.gidetailid,a0.slocid,a0.storagebinid,a0.itemnote,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from gireturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from giretur a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
	left join soheader b on b.soheaderid = a1.soheaderid
				left join company c on c.companyid = b.companyid
  ";
protected $sqlcountgireturdetail = "select count(1) 
    from gireturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where c.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['gireturno'])) && (isset($_REQUEST['gino'])))
		{				
			$where .=  " 
and a0.gireturno like '%". $_REQUEST['gireturno']."%' 
and a1.gino like '%". $_REQUEST['gino']."%'"; 
		}
		if (isset($_REQUEST['gireturid']))
			{
				if (($_REQUEST['gireturid'] !== '0') && ($_REQUEST['gireturid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.gireturid in (".$_REQUEST['gireturid'].")";
					}
					else
					{
						$where .= " and a0.gireturid in (".$_REQUEST['gireturid'].")";
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
			'keyField'=>'gireturid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'gireturid','gireturno','giheaderid','gireturdate','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'gireturid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['gireturid']))
		{
			$this->sqlcountgireturdetail .= ' where a0.gireturid = '.$_REQUEST['gireturid'];
			$this->sqldatagireturdetail .= ' where a0.gireturid = '.$_REQUEST['gireturid'];
		}
		$countgireturdetail = Yii::app()->db->createCommand($this->sqlcountgireturdetail)->queryScalar();
$dataProvidergireturdetail=new CSqlDataProvider($this->sqldatagireturdetail,array(
					'totalItemCount'=>$countgireturdetail,
					'keyField'=>'gireturdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'gireturdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergireturdetail'=>$dataProvidergireturdetail));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select c.companyid, a.gireturno,a.gireturdate,b.gino ,c.shipto,a.gireturid,a.headernote,
						a.recordstatus
						from giretur a
						left join giheader b on b.giheaderid = a.giheaderid 
						left join soheader c on c.soheaderid = b.soheaderid ";
		if ($_REQUEST['gireturid'] !== '') 
		{
				$sql = $sql . "where a.gireturid in (".$_REQUEST['gireturid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('giretur');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNBPages();
	  // definisi font
		
    foreach($dataReader as $row)
    {
      $this->pdf->setFont('Arial','B',9);      
      $this->pdf->text(15,$this->pdf->gety(),'No ');$this->pdf->text(50,$this->pdf->gety(),': '.$row['gireturno']);
      $this->pdf->text(15,$this->pdf->gety()+5,'Date ');$this->pdf->text(50,$this->pdf->gety()+5,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])));
      $this->pdf->text(15,$this->pdf->gety()+10,'SJ No ');$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['gino']);
		
      $sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,d.description,
								f.description as rak
								from gireturdetail a
								inner join product b on b.productid = a.productid
								inner join unitofmeasure c on c.unitofmeasureid = a.uomid
								inner join sloc d on d.slocid = a.slocid
								left join storagebin f on f.storagebinid = a.storagebinid
								left join gidetail g on g.gidetailid = a.gidetailid
								left join sodetail h on h.sodetailid = g.sodetailid
								where gireturid = ".$row['gireturid']." group by b.productname order by h.sodetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->setwidths(array(10,95,20,15,50,30));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','R','L','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				Yii::app()->format->formatNumber($row1['vqty']),
				$row1['uomcode'],
				$row1['description'].' - '.$row1['rak']));
      }
				$this->pdf->sety($this->pdf->gety());
				$this->pdf->colalign = array('C','C');
				$this->pdf->setwidths(array(50,140));
				$this->pdf->coldetailalign = array('L','L');
				$this->pdf->row(array('Note',$row['headernote']));
		
			$this->pdf->checkNewPage(35);
			//$this->pdf->Image('images/ttdgir.jpg',5,$this->pdf->gety()+5,200);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'');$this->pdf->text(20,$this->pdf->gety(),' Dibuat Oleh,');$this->pdf->text(70,$this->pdf->gety(),'  Dibawa Oleh,');$this->pdf->text(120,$this->pdf->gety(),'Diserahkan,');$this->pdf->text(170,$this->pdf->gety(),'Diterima Oleh,');
			$this->pdf->text(10,$this->pdf->gety()+22,'');$this->pdf->text(20,$this->pdf->gety()+20,'.........................');$this->pdf->text(70,$this->pdf->gety()+20,'............................');$this->pdf->text(120,$this->pdf->gety()+20,'........................');$this->pdf->text(170,$this->pdf->gety()+20,'.............................');
			$this->pdf->text(10,$this->pdf->gety()+25,'');$this->pdf->text(20,$this->pdf->gety()+23,'  Adm Gudang');$this->pdf->text(70,$this->pdf->gety()+23,' Ekspedisi/ Supir');$this->pdf->text(120,$this->pdf->gety()+23,'    Customer');$this->pdf->text(170,$this->pdf->gety()+23,' Kepala Gudang');

			}
    // me-render ke browser
    $this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownxls();
		$sql = "select c.companyid, a.gireturno,a.gireturdate,b.gino ,c.shipto,a.gireturid,a.headernote,
						a.recordstatus
						from giretur a
						left join giheader b on b.giheaderid = a.giheaderid 
						left join soheader c on c.soheaderid = b.soheaderid ";
		if ($_GET['gireturid'] !== '') 
		{
				$sql = $sql . "where a.gireturid in (".$_GET['gireturid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();	
			
		$line=3;
			
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,': '.$row['gireturno']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Date')
						->setCellValueByColumnAndRow(1,$line,': '.$row['gireturdate']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'SJ No')
						->setCellValueByColumnAndRow(1,$line,': '.$row['gino']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Unit')				
				->setCellValueByColumnAndRow(4,$line,'Gudang');
			$line++;
			
			$sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,d.description,
								f.description as rak
								from gireturdetail a
								inner join product b on b.productid = a.productid
								inner join unitofmeasure c on c.unitofmeasureid = a.uomid
								inner join sloc d on d.slocid = a.slocid
								left join storagebin f on f.storagebinid = a.storagebinid
								left join gidetail g on g.gidetailid = a.gidetailid
								left join sodetail h on h.sodetailid = g.sodetailid
								where gireturid = ".$row['gireturid']." group by b.productname order by h.sodetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;
			
			foreach($dataReader1 as $row1)
			{
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])
							->setCellValueByColumnAndRow(2,$line,$row1['vqty'])
							->setCellValueByColumnAndRow(3,$line,$row1['uomcode'])							
							->setCellValueByColumnAndRow(4,$line,$row1['description']. ' - '. $row1['rak']);
				$line++;
			}
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Note : ')
						->setCellValueByColumnAndRow(1,$line,$row['headernote']);
						$line+=2;
						
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Dibuat oleh, ')
				->setCellValueByColumnAndRow(1,$line,'Dibawa oleh, ')
				->setCellValueByColumnAndRow(2,$line,'Diserahkan oleh, ')
				->setCellValueByColumnAndRow(3,$line,'Diterima oleh, ');
			$line+=5;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'........................')
				->setCellValueByColumnAndRow(1,$line,'........................')
				->setCellValueByColumnAndRow(2,$line,'........................')
				->setCellValueByColumnAndRow(3,$line,'........................');
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Admin Gudang')
				->setCellValueByColumnAndRow(1,$line,'Ekspedisi/ Supir')			
				->setCellValueByColumnAndRow(2,$line,'Customer')
				->setCellValueByColumnAndRow(3,$line,'Kepala Gudang');
			$line++;
		}
		
		$this->getFooterXLS($this->phpExcel);
	}
}