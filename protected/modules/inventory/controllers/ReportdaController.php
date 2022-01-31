<?php

class ReportdaController extends AdminController
{
	protected $menuname = 'reportda';
	public $module = 'Inventory';
	protected $pageTitle = 'Daftar Form Permintaan Barang';
	public $wfname = 'appda';
	protected $sqldata = "select getcompanysloc(a0.slocid) as companyid,a0.deliveryadviceid,a0.dadate,a0.dano,a0.useraccessid,a0.slocid,a0.productplanid,a0.soheaderid,a0.productoutputid,a0.headernote,a0.recordstatus,a1.username as username,a2.sloccode as sloccode,a0.statusname,
			e.productoutputno, f.productplanno, g.sono, a2.description 
    from deliveryadvice a0 
    left join useraccess a1 on a1.useraccessid = a0.useraccessid
    left join sloc a2 on a2.slocid = a0.slocid 
		left join productoutput e on e.productoutputid = a0.productoutputid 
		left join productplan f on f.productplanid = a0.productplanid 
		left join soheader g on g.soheaderid = a0.soheaderid 
		left join plant a3 on a3.plantid = a2.plantid 
		left join company a4 on a4.companyid = a3.companyid  
  ";
protected $sqldatadeliveryadvicedetail = "select a0.deliveryadvicedetailid,a0.deliveryadviceid,a0.productid,a0.qty,a0.unitofmeasureid,a0.requestedbyid,a0.reqdate,a0.itemtext,a0.prqty,a0.giqty,a0.grqty,a0.poqty,a0.productplandetailid,a0.sodetailid,a0.productoutputfgid,a0.slocid,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode,a3.requestedbycode as requestedbycode,a4.sloccode as sloccode 
    from deliveryadvicedetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join requestedby a3 on a3.requestedbyid = a0.requestedbyid
    left join sloc a4 on a4.slocid = a0.slocid
  ";
  protected $sqlcount = "select count(1) 
    from deliveryadvice a0 
    left join useraccess a1 on a1.useraccessid = a0.useraccessid
    left join sloc a2 on a2.slocid = a0.slocid 
		left join productoutput e on e.productoutputid = a0.productoutputid 
		left join productplan f on f.productplanid = a0.productplanid 
		left join soheader g on g.soheaderid = a0.soheaderid 
		left join plant a3 on a3.plantid = a2.plantid 
		left join company a4 on a4.companyid = a3.companyid  
  ";
protected $sqlcountdeliveryadvicedetail = "select count(1) 
    from deliveryadvicedetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join requestedby a3 on a3.requestedbyid = a0.requestedbyid
    left join sloc a4 on a4.slocid = a0.slocid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a4.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['dano'])) && (isset($_REQUEST['username'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .=  " 
where a0.dano like '%". $_REQUEST['dano']."%' 
and a1.username like '%". $_REQUEST['username']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['deliveryadviceid']))
			{
				if (($_REQUEST['deliveryadviceid'] !== '0') && ($_REQUEST['deliveryadviceid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.deliveryadviceid in (".$_REQUEST['deliveryadviceid'].")";
					}
					else
					{
						$where .= " and a0.deliveryadviceid in (".$_REQUEST['deliveryadviceid'].")";
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
			'keyField'=>'deliveryadviceid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'deliveryadviceid','dadate','dano','useraccessid','slocid','productplanid','soheaderid','productoutputid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'deliveryadviceid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['deliveryadviceid']))
		{
			$this->sqlcountdeliveryadvicedetail .= ' where a0.deliveryadviceid = '.$_REQUEST['deliveryadviceid'];
			$this->sqldatadeliveryadvicedetail .= ' where a0.deliveryadviceid = '.$_REQUEST['deliveryadviceid'];
			$count = Yii::app()->db->createCommand($this->sqlcountdeliveryadvicedetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatadeliveryadvicedetail .= " limit 0";
		}
		$countdeliveryadvicedetail = $count;
$dataProviderdeliveryadvicedetail=new CSqlDataProvider($this->sqldatadeliveryadvicedetail,array(
					'totalItemCount'=>$countdeliveryadvicedetail,
					'keyField'=>'deliveryadvicedetailid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'deliveryadvicedetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderdeliveryadvicedetail'=>$dataProviderdeliveryadvicedetail));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select getcompanysloc(a.slocid) as companyid,a.dano,a.dadate,a.headernote,
								a.deliveryadviceid,b.sloccode,b.description,a.recordstatus,c.productplanno,d.sono,e.productoutputno
								from deliveryadvice a 
								left join productplan c on c.productplanid = a.productplanid 
								left join soheader d on d.soheaderid = a.soheaderid 
								left join productoutput e on e.productoutputid = a.productoutputid
								left join sloc b on b.slocid = a.slocid ";
		if ($_GET['deliveryadviceid'] !== '') 
		{
				$sql = $sql . "where a.deliveryadviceid in (".$_GET['deliveryadviceid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('deliveryadvice');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
	  // definisi font  

    foreach($dataReader as $row)
    {
			$this->pdf->SetFontSize(8);
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['dano']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['dadate'])));
      $this->pdf->text(120,$this->pdf->gety()+6,'Gudang ');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['sloccode'].' - '.$row['description']);

      $sql1 = "select b.productname, sum(a.qty) as qty, c.uomcode, a.itemtext,concat(e.sloccode,' - ',e.description) as sloccode
							from deliveryadvicedetail a
							left join product b on b.productid = a.productid
							left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							left join sloc e on e.slocid = a.slocid
							where deliveryadviceid = ".$row['deliveryadviceid'].
							" group by b.productname,c.uomcode,e.sloccode ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

	  $this->pdf->sety($this->pdf->gety()+10);
      
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,60,30,15,60,25));
	  $this->pdf->colheader = array('No','Items','Qty','Unit','Gd Tujuan','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
						$row1['sloccode'],
            $row1['itemtext']));
      }
			
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(30,170));
			$this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array(
			'Note:',
			$row['headernote']));
			$this->pdf->checkNewPage(20);      
//      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Peminta');$this->pdf->text(170,$this->pdf->gety(),'Peminta Barang');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('deliveryadviceid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('dadate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('dano'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('username'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('productplanid'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('soheaderid'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('productoutputid'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['deliveryadviceid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['dadate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['dano'])
->setCellValueByColumnAndRow(3, $i+1, $row1['username'])
->setCellValueByColumnAndRow(4, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['productplanid'])
->setCellValueByColumnAndRow(6, $i+1, $row1['soheaderid'])
->setCellValueByColumnAndRow(7, $i+1, $row1['productoutputid'])
->setCellValueByColumnAndRow(8, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}