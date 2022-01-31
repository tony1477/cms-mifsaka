<?php

class ProductstockController extends AdminController
{
	protected $menuname = 'productstock';
	public $module = 'Inventory';
	protected $pageTitle = 'Stock Barang';
	public $wfname = '';
	protected $sqldata = "select a0.productstockid,a0.productid ,a1.productname as productname,a0.slocid,a2.sloccode as sloccode,a0.storagebinid,a3.description as storagebindesc,a0.qty,a0.unitofmeasureid,a0.qtyinprogress,a3.description as storagebindesc,a4.uomcode as uomcode,
			a6.materialgroupcode,a2.description as slocdesc
    from productstock a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
		left join productplant a5 on a5.productid = a1.productid and a5.unitofissue = a4.unitofmeasureid and a5.slocid = a0.slocid
		left join materialgroup a6 on a6.materialgroupid = a5.materialgroupid 
		left join plant a7 on a7.plantid = a2.plantid
		left join company a8 on a8.companyid = a7.companyid 
  ";
protected $sqldataproductstockdet = "select productstockdetid ,referenceno,transdate,qty
    from productstockdet ";
  protected $sqlcount = "select count(1) 
    from productstock a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join storagebin a3 on a3.storagebinid = a0.storagebinid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
		left join productplant a5 on a5.productid = a1.productid and a5.unitofissue = a4.unitofmeasureid and a5.slocid = a0.slocid
		left join materialgroup a6 on a6.materialgroupid = a5.materialgroupid 
		left join plant a7 on a7.plantid = a2.plantid
		left join company a8 on a8.companyid = a7.companyid 
  ";
protected $sqlcountproductstockdet = "select count(1) 
    from productstockdet a0 
   
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a8.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['uomcode']))&& (isset($_REQUEST['storagebindesc'])))
		{				
			$where .= " and a1.productname like '%". $_REQUEST['productname']."%' 
                                    and a2.sloccode like '%". $_REQUEST['sloccode']."%'"
                                . " and a4.uomcode like '%". $_REQUEST['uomcode']."%'"
                                . " and a3.description like '%". $_REQUEST['storagebindesc']."%' "; 
                                    
		}
		if (isset($_REQUEST['productstockid']))
			{
				if (($_REQUEST['productstockid'] !== '0') && ($_REQUEST['productstockid'] !== ''))
				{
					$where .= " and a0.productstockid in (".$_REQUEST['productstockid'].")";
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
			'keyField'=>'productstockid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productstockid','productid','productname','sloccode','uomcode','storagebindesc','qty','qtyinprogress'
					 
				),
				'defaultOrder' => array( 
					'productstockid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productstockid']))
		{
			$this->sqlcountproductstockdet .= ' where productstockid = '.$_REQUEST['productstockid'];
			$this->sqldataproductstockdet .= ' where productstockid = '.$_REQUEST['productstockid'];
		}
		$countproductstockdet = Yii::app()->db->createCommand($this->sqlcountproductstockdet)->queryScalar();
$dataProviderproductstockdet=new CSqlDataProvider($this->sqldataproductstockdet,array(
					'totalItemCount'=>$countproductstockdet,
					'keyField'=>'productstockdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
                       
    
					'sort'=>array(
						'defaultOrder' => array( 
							'productstockdetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductstockdet'=>$dataProviderproductstockdet));
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
    $this->pdf->SetFont('Arial','B',10);
		$this->pdf->title=$this->getCatalog('productstock');
		$this->pdf->AddPage('P',array(450,250));
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('product'),$this->getCatalog('sloc'),$this->getCatalog('storagebin'),$this->getCatalog('qty'),$this->getCatalog('unitofmeasure'),$this->getCatalog('qtyinprogress'));
		$this->pdf->setwidths(array(200,80,80,20,20,30));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','R','C','R');
     $this->pdf->SetFont('Arial','',10);            
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productname'],$row1['sloccode'].'-'.$row1['slocdesc'],$row1['storagebindesc'], $row1['qty'],$row1['uomcode'],$row1['qtyinprogress']));
                  
		}
		// me-render ke browser
		$this->pdf->Output();
	}
        public function actionDownEan13()
	{
		parent::actionDownPDF();
                $id = '';
                if ($_REQUEST['id'] == '')
                {
                    $sql = "select a.*,b.productname 
			from tempscan a 
			join product b on b.productid = a.productid 
			where a.isean = 1";
                }
		else
                {
                    $sql = "select a.*,b.productname 
			from tempscan a 
			join product b on b.productid = a.productid 
			where a.isean = 1 and a.productplanid = ".$_REQUEST['id'];
                }
		$fgs = Yii::app()->db->createCommand($sql)->queryAll();
		$this->pdf->AddPage('L',array(60,70));
		$this->pdf->isfooter = false;
		foreach ($fgs as $row)
		{
			for ($i=1;$i<=$row['qtyori'];$i++)
			{
				$this->pdf->setxy(5,9);
				$this->pdf->SetFont('Arial','',8);
				$this->pdf->row(array($row['productname']));
                                //$this->EAN13(13,$this->pdf->gety(),$row['barcode']);
				$this->pdf->EAN13(13,$this->pdf->gety(),$row['barcode']);
				$this->pdf->sety($this->pdf->gety()+25);
                                
				$sql = "select a.*,b.productname 
				from tempscan a 
				join product b on b.productid = a.productid 
				where a.isean = 0 and a.productplanid = ".$row['productplanid']." 
				and a.productid = ".$row['productid']. " and right(a.barcode,5) = ".$i;
				$c128s = Yii::app()->db->createCommand($sql)->queryAll();
				foreach ($c128s as $c128)
				{
					$code = $c128['barcode'];
					$this->pdf->Code128(6,$this->pdf->gety(),$code,50,15);
					$this->pdf->SetFont('Arial','',8);
					$this->pdf->text(15,$this->pdf->gety()+19,$code);
				}
				$this->pdf->AddPage('L',array(60,70));
			}
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productstockid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('storagebindesc'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('qtyinprogress'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productstockid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['storagebindesc'])
->setCellValueByColumnAndRow(4, $i+1, $row1['qty'])
->setCellValueByColumnAndRow(5, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(6, $i+1, $row1['qtyinprogress']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}