<?php

class ReportprodoutController extends AdminController
{
	protected $menuname = 'reportprodout';
	public $module = 'Production';
	protected $pageTitle = 'Daftar Hasil Produksi';
	public $wfname = 'appop';
	protected $sqldata = "select a1.companyid,a2.companyname,a0.productoutputid,a0.productoutputno,a0.productoutputdate,a0.productplanid,a0.description,a0.recordstatus,a1.productplanno as productplanno,a0.statusname,
			a1.productplandate
    from productoutput a0 
    left join productplan a1 on a1.productplanid = a0.productplanid
		left join company a2 on a2.companyid = a1.companyid 
  ";
protected $sqldataproductoutputfg = "select a0.productoutputfgid,a0.productoutputid,a0.productplanfgid,a0.productid,a0.qtyoutput,a0.uomid,a0.slocid,a0.storagebinid,a0.outputdate,a0.description,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as storagedesc 
    from productoutputfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
protected $sqldataproductoutputdetail = "select a0.productoutputdetailid,a0.productoutputid,a0.productoutputfgid,a0.productid,a0.qty,a0.uomid,a0.toslocid,a0.storagebinid,a0.productplandetailid,a0.productplanfgid,a0.description,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as storagedesc 
    from productoutputdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.toslocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from productoutput a0 
    left join productplan a1 on a1.productplanid = a0.productplanid
		left join company a2 on a2.companyid = a1.companyid 
  ";
protected $sqlcountproductoutputfg = "select count(1) 
    from productoutputfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
protected $sqlcountproductoutputdetail = "select count(1) 
    from productoutputdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.toslocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['productoutputno'])) && (isset($_REQUEST['productplanno'])))
		{				
			$where .=  " 
and a0.productoutputno like '%". $_REQUEST['productoutputno']."%' 
and a2.companyname like '%". $_REQUEST['companyname']."%' 
and a1.productplanno like '%". $_REQUEST['productplanno']."%'"; 
		}
		if (isset($_REQUEST['productoutputid']))
			{
				if (($_REQUEST['productoutputid'] !== '0') && ($_REQUEST['productoutputid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productoutputid in (".$_REQUEST['productoutputid'].")";
					}
					else
					{
						$where .= " and a0.productoutputid in (".$_REQUEST['productoutputid'].")";
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
			'keyField'=>'productoutputid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productoutputid','productoutputno','productoutputdate','productplanid','description','recordstatus','companyid'
				),
				'defaultOrder' => array( 
					'productoutputid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productoutputid']))
		{
			$this->sqlcountproductoutputfg .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
			$this->sqldataproductoutputfg .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
		}
		$countproductoutputfg = Yii::app()->db->createCommand($this->sqlcountproductoutputfg)->queryScalar();
$dataProviderproductoutputfg=new CSqlDataProvider($this->sqldataproductoutputfg,array(
					'totalItemCount'=>$countproductoutputfg,
					'keyField'=>'productoutputfgid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'productoutputfgid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['productoutputid']))
		{
			$this->sqlcountproductoutputdetail .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
			$this->sqldataproductoutputdetail .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
		}
		$countproductoutputdetail = Yii::app()->db->createCommand($this->sqlcountproductoutputdetail)->queryScalar();
$dataProviderproductoutputdetail=new CSqlDataProvider($this->sqldataproductoutputdetail,array(
					'totalItemCount'=>$countproductoutputdetail,
					'keyField'=>'productoutputdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'productoutputdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductoutputfg'=>$dataProviderproductoutputfg,'dataProviderproductoutputdetail'=>$dataProviderproductoutputdetail));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.*,b.productplanno,b.productplandate
      from productoutput a 
	join productplan b on b.productplanid = a.productplanid ";
		if ($_REQUEST['productoutputid'] !== '') {
				$sql = $sql . "where a.productoutputid in (".$_REQUEST['productoutputid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title=$this->getcatalog('productoutput');
	  $this->pdf->AddPage('P');
		$this->pdf->AliasNBPages();
	  // definisi font  

    foreach($dataReader as $row)
    {
			$this->pdf->SetFont('Arial','',10);
      $this->pdf->text(15,$this->pdf->gety()+5,'No Output ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['productoutputno']);
	$this->pdf->text(120,$this->pdf->gety()+5,'No Plan ');$this->pdf->text(140,$this->pdf->gety()+5,': '.$row['productplanno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Tgl Output ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productoutputdate'])));
      $this->pdf->text(120,$this->pdf->gety()+10,'Tgl Plan ');$this->pdf->text(140,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));

      $sql1 = "select b.productname, a.qtyoutput as qty, c.uomcode, a.description,
			concat(d.sloccode,'-',d.description) as sloccode, 
			e.description as rak
        from productoutputfg a
        inner join product b on b.productid = a.productid
        inner join unitofmeasure c on c.unitofmeasureid = a.uomid
				inner join sloc d on d.slocid = a.slocid
				inner join storagebin e on e.storagebinid = a.storagebinid
        where productoutputid = ".$row['productoutputid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,30,20,35,15));
			$this->pdf->colheader = array('No','Items','Qty','Unit','Gudang','Rak');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','R','C','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
						$row1['sloccode'],
						$row1['rak']));
      }
      $this->pdf->checkPagebreak(40);
      $this->pdf->setFont('Arial','',10);
      $this->pdf->text(10,$this->pdf->gety()+25,'Approved By');$this->pdf->text(150,$this->pdf->gety()+25,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+45,'____________ ');$this->pdf->text(150,$this->pdf->gety()+45,'____________');
			/*$this->pdf->AddPage($this->pdf->CurOrientation);*/
			}
	  $this->pdf->Output();
	}
	public function actionDownxls()
  {
    $this->menuname = 'productoutput';
    parent::actionDownxls();
    $sql = "select a.*,b.productplanno,b.productplandate
            from productoutput a 
	        join productplan b on b.productplanid = a.productplanid ";
    if ($_GET['productoutputid'] !== '') {
      $sql = $sql . "where a.productoutputid in (" . $_GET['productoutputid'] . ")";
    }
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $line       = 5;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 3, 'No Output')
          ->setCellValueByColumnAndRow(2, 3, ': ' . $row['productoutputno'])
          ->setCellValueByColumnAndRow(1, 4, 'Tgl Output')
          ->setCellValueByColumnAndRow(2, 4, ': ' . $row['productplandate'])
          ->setCellValueByColumnAndRow(4, 3, 'No Plan')
          ->setCellValueByColumnAndRow(5, 3, ': ' . $row['productplanno']) 
          ->setCellValueByColumnAndRow(4, 4, 'Tgl Plan')
          ->setCellValueByColumnAndRow(5, 4, ': ' . $row['productplandate']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, 'No')
          ->setCellValueByColumnAndRow(1, $line, 'Items')
          ->setCellValueByColumnAndRow(3, $line, 'Qty')
          ->setCellValueByColumnAndRow(4, $line, 'Unit')
          ->setCellValueByColumnAndRow(5, $line, 'Gudang')
          ->setCellValueByColumnAndRow(6, $line, 'Rak');
      $line++;
      $sql1        = "select b.productname, a.qtyoutput as qty, c.uomcode, a.description,
			concat(d.sloccode,'-',d.description) as sloccode, 
			e.description as rak
            from productoutputfg a
                inner join product b on b.productid = a.productid
                inner join unitofmeasure c on c.unitofmeasureid = a.uomid
				inner join sloc d on d.slocid = a.slocid
				inner join storagebin e on e.storagebinid = a.storagebinid
        where productoutputid = " . $row['productoutputid'];
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i += 1)
            ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
            ->setCellValueByColumnAndRow(3, $line, $row1['qty'])
            ->setCellValueByColumnAndRow(4, $line, $row1['uomcode'])
            ->setCellValueByColumnAndRow(5, $line, $row1['sloccode'])
            ->setCellValueByColumnAndRow(6, $line, $row1['rak']);
       
$sql2        = "SELECT DISTINCT t.*,a.productname,b.uomcode,
					(select sloccode from sloc zz where zz.slocid = t.fromslocid) as fromsloccode,
			(select description from sloc zz where zz.slocid = t.fromslocid) as fromslocdesc,
			(select sloccode from sloc zz where zz.slocid = t.toslocid) as tosloccode,
			(select description from sloc zz where zz.slocid = t.toslocid) as toslocdesc,
			d.description as rak,
			getstock(t.productid,t.uomid,t.fromslocid) as fromslocstock,
			getstock(t.productid,t.uomid,t.toslocid) as toslocstock,
			getminstockmrp(t.productid,t.uomid,t.fromslocid) as minfromstock,
			getminstockmrp(t.productid,t.uomid,t.toslocid) as mintostock
FROM productoutputdetail t
LEFT JOIN productoutputfg c ON c.productoutputfgid = t.productoutputfgid
LEFT JOIN product a ON a.productid = t.productid
LEFT JOIN unitofmeasure b ON b.unitofmeasureid = t.uomid
LEFT JOIN storagebin d ON d.storagebinid = t.storagebinid 

 where t.productoutputid = " . $row['productoutputid'] ;
      $dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
      $c           = 0;
      $line++; 
            $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, $line, 'Material/Service - FG');
      $line++;  
          $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, $line, 'No')
          ->setCellValueByColumnAndRow(2, $line, 'Items')
          ->setCellValueByColumnAndRow(3, $line, 'Qty')
          ->setCellValueByColumnAndRow(4, $line, 'Unit')
          ->setCellValueByColumnAndRow(5, $line, 'Gudang Asal')
          ->setCellValueByColumnAndRow(6, $line, 'Stock Gd Asal')
          ->setCellValueByColumnAndRow(7, $line, 'Stock Gd Tujuan')
          ->setCellValueByColumnAndRow(8, $line, 'Rak');
      $line++;
      foreach ($dataReader2 as $row2) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $line, $c += 1)
            ->setCellValueByColumnAndRow(2, $line, $row2['productname'])
            ->setCellValueByColumnAndRow(3, $line, $row2['qty'])
            ->setCellValueByColumnAndRow(4, $line, $row2['uomcode'])
            ->setCellValueByColumnAndRow(5, $line, $row2['fromsloccode'])
            ->setCellValueByColumnAndRow(6, $line, $row2['fromslocstock'])
            ->setCellValueByColumnAndRow(7, $line, $row2['toslocstock'])
            ->setCellValueByColumnAndRow(8, $line, $row2['rak']);
        $line++;
      }
      }
     
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1, $line, 'Approved By')
      ->setCellValueByColumnAndRow(4, $line, 'Proposed By');
      
    $line += 4;
    $this->phpExcel->setActiveSheetIndex(0)    
      ->setCellValueByColumnAndRow(1,$line, '____________ ')
      ->setCellValueByColumnAndRow(4, $line, '____________ ');
    }
    $this->getFooterXLS($this->phpExcel);
  }
}