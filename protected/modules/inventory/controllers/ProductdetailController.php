<?php

class ProductdetailController extends AdminController
{
	protected $menuname = 'productdetail';
	public $module = 'Inventory';
	protected $pageTitle = 'Material Detail';
	public $wfname = '';
	protected $sqldata = "select a0.productdetailid,a0.materialcode,a0.productid,a0.slocid,a0.expiredate,a0.qty,a0.unitofmeasureid,a0.buydate,a0.buyprice,a0.currencyid,a0.storagebinid,a0.location,a0.locationdate,a0.materialstatusid,a0.ownershipid,a0.referenceno,a0.vrqty,a0.serialno,a0.recordstatus,a1.productname as productname,a2.sloccode as sloccode,a3.uomcode as uomcode,a4.currencyname as currencyname,a5.description as description,a6.materialstatusname as materialstatusname,a7.ownershipname as ownershipname 
    from productdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofmeasureid
    left join currency a4 on a4.currencyid = a0.currencyid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join materialstatus a6 on a6.materialstatusid = a0.materialstatusid
    left join ownership a7 on a7.ownershipid = a0.ownershipid 
		left join plant a8 on a8.plantid = a2.plantid
		left join company a9 on a9.companyid = a8.companyid 
  ";
  protected $sqlcount = "select count(1) 
    from productdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofmeasureid
    left join currency a4 on a4.currencyid = a0.currencyid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join materialstatus a6 on a6.materialstatusid = a0.materialstatusid
    left join ownership a7 on a7.ownershipid = a0.ownershipid
		left join plant a8 on a8.plantid = a2.plantid
		left join company a9 on a9.companyid = a8.companyid 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a9.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['materialcode'])) && (isset($_REQUEST['location'])) && (isset($_REQUEST['referenceno'])) && (isset($_REQUEST['serialno'])) && (isset($_REQUEST['productname'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['currencyname'])) && (isset($_REQUEST['description'])) && (isset($_REQUEST['ownershipname'])))
		{				
			$where .= " and a0.materialcode like '%". $_REQUEST['materialcode']."%' 
and a0.location like '%". $_REQUEST['location']."%' 
and a0.referenceno like '%". $_REQUEST['referenceno']."%' 
and a0.serialno like '%". $_REQUEST['serialno']."%' 
and a1.productname like '%". $_REQUEST['productname']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%' 
and a3.uomcode like '%". $_REQUEST['uomcode']."%' 
and a4.currencyname like '%". $_REQUEST['currencyname']."%' 
and a5.description like '%". $_REQUEST['description']."%' 
and a7.ownershipname like '%". $_REQUEST['ownershipname']."%'"; 
		}
		if (isset($_REQUEST['productdetailid']))
			{
				if (($_REQUEST['productdetailid'] !== '0') && ($_REQUEST['productdetailid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productdetailid in (".$_REQUEST['productdetailid'].")";
					}
					else
					{
						$where .= " and a0.productdetailid in (".$_REQUEST['productdetailid'].")";
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
			'keyField'=>'productdetailid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productdetailid','materialcode','productid','slocid','expiredate','qty','unitofmeasureid','buydate','buyprice','currencyid','storagebinid','location','locationdate','materialstatusid','ownershipid','referenceno','vrqty','serialno','recordstatus'
				),
				'defaultOrder' => array( 
					'productdetailid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	
	
	
	
	public function actionDelete()
	{
		parent::actionDelete();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
					$sql = "select recordstatus from productdetail where productdetailid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update productdetail set recordstatus = 0 where productdetailid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update productdetail set recordstatus = 1 where productdetailid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			else
			{
				$this->getMessage('success','chooseone');
			}
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('productdetail');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('productdetailid'),$this->getCatalog('materialcode'),$this->getCatalog('product'),$this->getCatalog('sloc'),$this->getCatalog('expiredate'),$this->getCatalog('qty'),$this->getCatalog('unitofmeasure'),$this->getCatalog('buydate'),$this->getCatalog('buyprice'),$this->getCatalog('currency'),$this->getCatalog('storagebin'),$this->getCatalog('location'),$this->getCatalog('locationdate'),$this->getCatalog('materialstatus'),$this->getCatalog('ownership'),$this->getCatalog('referenceno'),$this->getCatalog('vrqty'),$this->getCatalog('serialno'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productdetailid'],$row1['materialcode'],$row1['productname'],$row1['sloccode'],$row1['expiredate'],$row1['qty'],$row1['uomcode'],$row1['buydate'],$row1['buyprice'],$row1['currencyname'],$row1['description'],$row1['location'],$row1['locationdate'],$row1['materialstatusname'],$row1['ownershipname'],$row1['referenceno'],$row1['vrqty'],$row1['serialno'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productdetailid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('materialcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('expiredate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('buydate'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('buyprice'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('location'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('locationdate'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('materialstatusname'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('ownershipname'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('referenceno'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('vrqty'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('serialno'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productdetailid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['materialcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['expiredate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['qty'])
->setCellValueByColumnAndRow(6, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(7, $i+1, $row1['buydate'])
->setCellValueByColumnAndRow(8, $i+1, $row1['buyprice'])
->setCellValueByColumnAndRow(9, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(10, $i+1, $row1['description'])
->setCellValueByColumnAndRow(11, $i+1, $row1['location'])
->setCellValueByColumnAndRow(12, $i+1, $row1['locationdate'])
->setCellValueByColumnAndRow(13, $i+1, $row1['materialstatusname'])
->setCellValueByColumnAndRow(14, $i+1, $row1['ownershipname'])
->setCellValueByColumnAndRow(15, $i+1, $row1['referenceno'])
->setCellValueByColumnAndRow(16, $i+1, $row1['vrqty'])
->setCellValueByColumnAndRow(17, $i+1, $row1['serialno'])
->setCellValueByColumnAndRow(18, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}