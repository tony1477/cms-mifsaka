<?php

class RepprodplanController extends AdminController
{
	protected $menuname = 'repprodplan';
	public $module = 'Production';
	protected $pageTitle = 'Daftar SPP';
	public $wfname = 'appprodplan';
	protected $sqldata = "select a0.productplanid,a0.companyid,a0.soheaderid,a0.productplanno,a0.productplandate,a0.description,a0.recordstatus,a0.isbarcode,a1.companyname as companyname,a2.sono as sono,a0.statusname  
    from productplan a0 
    left join company a1 on a1.companyid = a0.companyid
    left join soheader a2 on a2.soheaderid = a0.soheaderid
  ";
protected $sqldataproductplanfg = "select a0.productplanfgid,a0.productplanid,a0.productid,a0.qty,a0.uomid,a0.slocid,a0.bomid,a0.startdate,a0.enddate,a0.qtyres,a0.description,a0.sodetailid,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.bomversion as bomversion 
    from productplanfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join billofmaterial a4 on a4.bomid = a0.bomid
  ";
protected $sqldataproductplandetail = "select a0.productplandetailid,a0.productplanid,a0.productplanfgid,a0.productid,a0.qty,a0.uomid,a0.fromslocid,a0.toslocid,a0.bomid,a0.reqdate,a0.qtyres,a0.description,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.sloccode as toslocid 
    from productplandetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.fromslocid
    left join sloc a4 on a4.slocid = a0.toslocid
  ";
  protected $sqlcount = "select count(1) 
    from productplan a0 
    left join company a1 on a1.companyid = a0.companyid
    left join soheader a2 on a2.soheaderid = a0.soheaderid
  ";
protected $sqlcountproductplanfg = "select count(1) 
    from productplanfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join billofmaterial a4 on a4.bomid = a0.bomid
  ";
protected $sqlcountproductplandetail = "select count(1) 
    from productplandetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.fromslocid
    left join sloc a4 on a4.slocid = a0.toslocid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['productplanno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['sono'])))
		{				
			$where .=  " 
and a0.productplanno like '%". $_REQUEST['productplanno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.sono like '%". $_REQUEST['sono']."%'"; 
		}
		if (isset($_REQUEST['productplanid']))
			{
				if (($_REQUEST['productplanid'] !== '0') && ($_REQUEST['productplanid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productplanid in (".$_REQUEST['productplanid'].")";
					}
					else
					{
						$where .= " and a0.productplanid in (".$_REQUEST['productplanid'].")";
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
			'keyField'=>'productplanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productplanid','companyid','soheaderid','productplanno','productplandate','description','recordstatus','isbarcode'
				),
				'defaultOrder' => array( 
					'productplanid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productplanid']))
		{
			$this->sqlcountproductplanfg .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
			$this->sqldataproductplanfg .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
		}
		$countproductplanfg = Yii::app()->db->createCommand($this->sqlcountproductplanfg)->queryScalar();
$dataProviderproductplanfg=new CSqlDataProvider($this->sqldataproductplanfg,array(
					'totalItemCount'=>$countproductplanfg,
					'keyField'=>'productplanfgid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'productplanfgid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['productplanid']))
		{
			$this->sqlcountproductplandetail .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
			$this->sqldataproductplandetail .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
		}
		$countproductplandetail = Yii::app()->db->createCommand($this->sqlcountproductplandetail)->queryScalar();
$dataProviderproductplandetail=new CSqlDataProvider($this->sqldataproductplandetail,array(
					'totalItemCount'=>$countproductplandetail,
					'keyField'=>'productplandetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'productplandetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductplanfg'=>$dataProviderproductplanfg,'dataProviderproductplandetail'=>$dataProviderproductplandetail));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.*,b.sono 
      from productplan a
left join soheader b on b.soheaderid = a.soheaderid	";
		if ($_REQUEST['productplanid'] !== '') {
				$sql = $sql . "where a.productplanid in (".$_REQUEST['productplanid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title=$this->getcatalog('productplan');
	  $this->pdf->AddPage('P');
		$this->pdf->AliasNBPages();
		$this->pdf->SetFont('Arial');
	  // definisi font  

    foreach($dataReader as $row)
    {
			$this->pdf->SetFontSize(8);
      $this->pdf->text(15,$this->pdf->gety()+5,'No SPP ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['productplanno']);
      $this->pdf->text(115,$this->pdf->gety()+5,'No SO ');$this->pdf->text(135,$this->pdf->gety()+5,': '.$row['sono']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Tgl SPP ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));

      $sql1 = "select b.productname, a.qty, c.uomcode, a.description,d.sloccode,d.description as slocdesc,a.startdate,a.enddate
        from productplanfg a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join sloc d on d.slocid = a.slocid
        where productplanid = ".$row['productplanid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+20,'FG');
			$this->pdf->sety($this->pdf->gety()+25);
      
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,50,20,15,36,17,17,25));
			$this->pdf->colheader = array('No','Items','Qty','Unit','Gudang','Tgl Mulai','Tgl Selesai','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
						$row1['sloccode'].' - '.$row1['slocdesc'],date(Yii::app()->params['dateviewfromdb'], strtotime($row1['startdate'])),date(Yii::app()->params['dateviewfromdb'], strtotime($row1['enddate'])),
            $row1['description']));
      }
			 $sql1 = "select b.productname, sum(a.qty) as qty, c.uomcode, a.description,d.bomversion,
				(select sloccode from sloc d where d.slocid = a.fromslocid) as fromsloccode,
				(select description from sloc d where d.slocid = a.fromslocid) as fromslocdesc,
				(select sloccode from sloc d where d.slocid = a.toslocid) as tosloccode,	
				(select description from sloc d where d.slocid = a.toslocid) as toslocdesc			
        from productplandetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join billofmaterial d on d.bomid = a.bomid
        where b.isstock = 1 and productplanid = ".$row['productplanid']." 
				group by b.productname,c.uomcode,d.bomversion,fromsloccode,fromslocdesc,tosloccode,toslocdesc ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'RM');
			$this->pdf->sety($this->pdf->gety()+15);
      
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,60,20,15,25,25,35));
			$this->pdf->colheader = array('No','Items','Qty','Unit','Gudang Asal','Gudang Tujuan','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
						$row1['fromsloccode'].' - '.$row1['fromslocdesc'],
						$row1['tosloccode'].' - '.$row1['toslocdesc'],
            $row1['bomversion'].''.$row1['description']));
				$this->pdf->checkPageBreak(20);
      }
      $this->pdf->text(10,$this->pdf->gety()+10,'Approved By');$this->pdf->text(150,$this->pdf->gety()+10,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+30,'____________ ');$this->pdf->text(150,$this->pdf->gety()+30,'____________');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productplanid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sono'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('productplanno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('productplandate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('isbarcode'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productplanid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sono'])
->setCellValueByColumnAndRow(3, $i+1, $row1['productplanno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['productplandate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['description'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(7, $i+1, $row1['isbarcode']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}