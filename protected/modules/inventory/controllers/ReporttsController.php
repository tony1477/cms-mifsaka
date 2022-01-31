<?php

class ReporttsController extends AdminController
{
	protected $menuname = 'reportts';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Transfer Gudang';
	public $wfname = 'appts';
	protected $sqldata = "select a0.transstockid,a0.transstockno,a0.slocfromid,a0.sloctoid,a0.docdate,a0.headernote,a0.deliveryadviceid,a0.recordstatus,a1.sloccode as sloccode,a2.sloccode as sloccode,a3.dano as dano,a0.statusname  
    from transstock a0 
    left join sloc a1 on a1.slocid = a0.slocfromid
    left join sloc a2 on a2.slocid = a0.sloctoid
    left join deliveryadvice a3 on a3.deliveryadviceid = a0.deliveryadviceid
		left join plant a4 on a4.plantid = a1.plantid
		left join company a5 on a5.companyid = a4.companyid 
  ";
protected $sqldatatransstockdet = "select a0.transstockdetid,a0.transstockid,a0.productid,a0.storagebinid,a0.unitofmeasureid,a0.qty,a0.storagebintoid,a0.deliveryadvicedetailid,a0.itemtext,a1.productname as productname,a2.description as description,a3.uomcode as uomcode,a4.description as description 
    from transstockdet a0 
    left join product a1 on a1.productid = a0.productid
    left join storagebin a2 on a2.storagebinid = a0.storagebinid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofmeasureid
    left join storagebin a4 on a4.storagebinid = a0.storagebintoid
  ";
  protected $sqlcount = "select count(1) 
    from transstock a0 
    left join sloc a1 on a1.slocid = a0.slocfromid
    left join sloc a2 on a2.slocid = a0.sloctoid
    left join deliveryadvice a3 on a3.deliveryadviceid = a0.deliveryadviceid
		left join plant a4 on a4.plantid = a1.plantid
		left join company a5 on a5.companyid = a4.companyid 
  ";
protected $sqlcounttransstockdet = "select count(1) 
    from transstockdet a0 
    left join product a1 on a1.productid = a0.productid
    left join storagebin a2 on a2.storagebinid = a0.storagebinid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofmeasureid
    left join storagebin a4 on a4.storagebinid = a0.storagebintoid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a5.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['transstockno'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['dano'])))
		{				
			$where .=  " 
and a0.transstockno like '%". $_REQUEST['transstockno']."%' 
and a1.sloccode like '%". $_REQUEST['sloccode']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%' 
and a3.dano like '%". $_REQUEST['dano']."%'"; 
		}
		if (isset($_REQUEST['transstockid']))
			{
				if (($_REQUEST['transstockid'] !== '0') && ($_REQUEST['transstockid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.transstockid in (".$_REQUEST['transstockid'].")";
					}
					else
					{
						$where .= " and a0.transstockid in (".$_REQUEST['transstockid'].")";
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
			'keyField'=>'transstockid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'transstockid','transstockno','slocfromid','sloctoid','docdate','headernote','deliveryadviceid','recordstatus'
				),
				'defaultOrder' => array( 
					'transstockid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['transstockid']))
		{
			$this->sqlcounttransstockdet .= ' where a0.transstockid = '.$_REQUEST['transstockid'];
			$this->sqldatatransstockdet .= ' where a0.transstockid = '.$_REQUEST['transstockid'];
		}
		$counttransstockdet = Yii::app()->db->createCommand($this->sqlcounttransstockdet)->queryScalar();
$dataProvidertransstockdet=new CSqlDataProvider($this->sqldatatransstockdet,array(
					'totalItemCount'=>$counttransstockdet,
					'keyField'=>'transstockdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'transstockdetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidertransstockdet'=>$dataProvidertransstockdet));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.*,getcompanysloc(slocfromid) as companyid,b.dano,
						(select concat(z.sloccode,' - ',z.description) from sloc z where z.slocid = a.slocfromid) as fromsloc,
						(select concat(zz.sloccode,' - ',zz.description) from sloc zz where zz.slocid = a.sloctoid) as tosloc
						from transstock a
						left join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid ";
		if ($_GET['transstockid'] !== '') 
		{
				$sql = $sql . "where a.transstockid in (".$_GET['transstockid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('transstock');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
	  // definisi font	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFontSize(8);      
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(40,$this->pdf->gety()+2,': '.$row['transstockno']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(40,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(10,$this->pdf->gety()+10,'No Permintaan');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['dano']);
      $this->pdf->text(120,$this->pdf->gety()+2,'Gd Asal');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['fromsloc']);
      $this->pdf->text(120,$this->pdf->gety()+6,'Gd Tujuan');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['tosloc']);
		
      $sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,
							(select description from storagebin z where z.storagebinid = a.storagebinid) as storagebinfrom,
							(select description from storagebin z where z.storagebinid = a.storagebintoid) as storagebinto
							from transstockdet a
							inner join product b on b.productid = a.productid
							inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							where transstockid = ".$row['transstockid']." group by b.productname order by transstockdetid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->colalign = array('L','L','R','C','L','L','L');
      $this->pdf->setwidths(array(10,85,25,20,25,25));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Rak Asal','Rak Tujuan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				Yii::app()->format->formatNumber($row1['vqty']),
				$row1['uomcode'],
				$row1['storagebinfrom'],
				$row1['storagebinto']));
      }
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(30,160));
			$this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');	  
			$this->pdf->row(array('Keterangan',$row['headernote']));
			$this->pdf->checkNewPage(40);
			//$this->pdf->Image('images/ttdts.jpg',10,$this->pdf->gety()+5,190);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'Dibuat oleh,');$this->pdf->text(50,$this->pdf->gety(),'Diserahkan oleh,');$this->pdf->text(120,$this->pdf->gety(),'Diketahui oleh,');$this->pdf->text(170,$this->pdf->gety(),'Diterima oleh,');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');

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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('transstockid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('transstockno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('dano'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['transstockid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['transstockno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(6, $i+1, $row1['dano'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}