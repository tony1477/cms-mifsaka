<?php
class ReqquotController extends Controller
{
	public $menuname = 'reqquot';
	public function actionIndex()
	{
		if(isset($_GET['grid']))
			echo $this->search();
		else
			$this->renderPartial('index',array());
	}
        
	public function actionIndexdetail()
	{
		if(isset($_GET['grid']))
			echo $this->actionSearchDetail();
		else
			$this->renderPartial('index',array());
	}
        
	public function actionIndexdisc()
	{
		if(isset($_GET['grid']))
			echo $this->actionSearchDisc();
		else
			$this->renderPartial('index',array());
	}
	        
  public function actionGetData()
	{
		if (isset($_GET['id']))
		{
			$model = Reqquot::model()->findbypk($_GET['id']);
			if ($model!==null)
			{
				echo CJSON::encode(array(
					'reqquotid'=>$model->reqquotid,
					'companyid'=>$model->companyid,
					'companyname'=>($model->company!==null)?$model->company->companyname:"",
					'addressbookid'=>$model->addressbookid,
					'customername'=>($model->customer!==null)?$model->customer->fullname:"",
					'custreqno'=>$model->custreqno,
					'quotno'=>$model->quotno,
					'taxid'=>$model->taxid,
					'taxcode'=>($model->tax!==null)?$model->tax->taxcode:"",
					'headernote'=>$model->headernote,
					'recordstatus'=>$model->recordstatus
				));
			}
			else
			{
				GetMessage(true,'chooseone');
			}
		}
		else
		{
			$model=new Reqquot;
			if ($model->save())
			{
				echo CJSON::encode(array(
						'status'=>'success',
						'reqquotid'=>$model->reqquotid,
				));
			}
		}
	}
	
	public function search()
	{
		header("Content-Type: application/json");
		
		// search 
		$companyid = isset ($_POST['companyid']) ? $_POST['companyid'] : '';
		$addressbookid = isset ($_POST['addressbookid']) ? $_POST['addressbookid'] : '';
		$custreqno = isset ($_POST['custreqno']) ? $_POST['custreqno'] : '';
		$quotno = isset ($_POST['quotno']) ? $_POST['quotno'] : '';
		$headernote = isset ($_POST['headernote']) ? $_POST['headernote'] : '';
				
		$companyid = isset ($_GET['q']) ? $_GET['q'] : $companyid;
		$addressbookid = isset ($_GET['q']) ? $_GET['q'] : $addressbookid;
		$custreqno = isset ($_GET['q']) ? $_GET['q'] : $custreqno;
		$quotno = isset ($_GET['q']) ? $_GET['q'] : $quotno;
		$headernote = isset ($_GET['q']) ? $_GET['q'] : $headernote;
		
		// pagging
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'reqquotid';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : $page;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : $rows;
		$sort = isset($_GET['sort']) ? strval($_GET['sort']) : (strpos($sort,'t.') > 0)?$sort:'t.'.$sort;
		$order = isset($_GET['order']) ? strval($_GET['order']) : $order;
		$offset = ($page-1) * $rows;
		
		$result = array();
		$row = array();
	
		// result
		if (!isset($_GET['combo']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select('count(1) as total')
				->from('reqquot t')
				->join('company a','a.companyid = t.companyid')
				->join('addressbook b','b.addressbookid = t.addressbookid')
				->join('tax c','c.taxid = t.taxid')
				->where('(companyname like :companyname) or (fullname like :fullname) or (custreqno like :custreqno) or (quotno like :quotno) or (headernote like :headernote)',
						array(':companyname'=>'%'.$companyid.'%',':fullname'=>'%'.$addressbookid.'%',':custreqno'=>'%'.$custreqno.'%',':quotno'=>'%'.$quotno.'%',':headernote'=>'%'.$headernote.'%'))
				->queryRow();
		}
		else
		{
			$cmd = Yii::app()->db->createCommand()
				->select('count(1) as total')
				->from('reqquot t')
				->join('company a','a.companyid = t.companyid')
				->join('addressbook b','b.addressbookid = t.addressbookid')
				->join('tax c','c.taxid = t.taxid')
				->where('((companyname like :companyname) or (fullname like :fullname) or (custreqno like :custreqno) or (quotno like :quotno) or (headernote like :headernote)) and t.recordstatus = 1',
						array(':companyname'=>'%'.$companyid.'%',':fullname'=>'%'.$addressbookid.'%',':custreqno'=>'%'.$custreqno.'%',':quotno'=>'%'.$quotno.'%',':headernote'=>'%'.$headernote.'%'))
				->queryRow();
		}
		
		$result['total'] = $cmd['total'];
		
		if (!isset($_GET['combo']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select('t.*,a.companyname,b.fullname,c.taxcode')			
				->from('reqquot t')
				->join('company a','a.companyid = t.companyid')
				->join('addressbook b','b.addressbookid = t.addressbookid')
				->join('tax c','c.taxid = t.taxid')
				->where('(companyname like :companyname) or (fullname like :fullname) or (custreqno like :custreqno) or (quotno like :quotno) or (headernote like :headernote)',
						array(':companyname'=>'%'.$companyid.'%',':fullname'=>'%'.$addressbookid.'%',':custreqno'=>'%'.$custreqno.'%',':quotno'=>'%'.$quotno.'%',':headernote'=>'%'.$headernote.'%'))
				->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		}
		else 
		{
			$cmd = Yii::app()->db->createCommand()
				->select('t.*,a.companyname,b.fullname,c.taxcode')			
				->from('reqquot t')
				->join('company a','a.companyid = t.companyid')
				->join('addressbook b','b.addressbookid = t.addressbookid')
				->join('tax c','c.taxid = t.taxid')
				->where('((companyname like :companyname) or (fullname like :fullname) or (custreqno like :custreqno) or (quotno like :quotno) or (headernote like :headernote)) and t.recordstatus = 1',
						array(':companyname'=>'%'.$companyid.'%',':fullname'=>'%'.$addressbookid.'%',':custreqno'=>'%'.$custreqno.'%',':quotno'=>'%'.$quotno.'%',':headernote'=>'%'.$headernote.'%'))
				->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		}
		
		foreach($cmd as $data)
		{	
			$row[] = array(
				'reqquotid'=>$data['reqquotid'],
				'companyid'=>$data['companyid'],
				'companyname'=>$data['companyname'],
				'addressbookid'=>$data['addressbookid'],
				'customername'=>$data['fullname'],
				'custreqno'=>$data['custreqno'],
				'quotno'=>$data['quotno'],
				'headernote'=>$data['headernote'],
				'taxid'=>$data['taxid'],
				'taxcode'=>$data['taxcode'],
				'recordstatusreqquot'=>$data['recordstatus'],
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return CJSON::encode($result);
	}
	
	public function actionSearchDetail()
	{
		header("Content-Type: application/json");
		$id=0;	
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
		}
		else
		if (isset($_GET['id']))
		{
			$id = $_GET['id'];
		}
                
    // pagging
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 't.reqquotdetailid';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : $page;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : $rows;
		$sort = isset($_GET['sort']) ? strval($_GET['sort']) : $sort;
		$order = isset($_GET['order']) ? strval($_GET['order']) : $order;
		$offset = ($page-1) * $rows;
		
		$result = array();
		$row = array();
                
    // result
		if (!isset($_GET['combo']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select('count(1) as total')
				->from('reqquotdetail t')
				->leftjoin('product a','a.productid = t.productid')
				->leftjoin('unitofmeasure b','b.unitofmeasureid = t.uomid')
				->leftjoin('currency c','c.currencyid = t.currencyid')
				->where('reqquotid = :reqquotid',
						array(':reqquotid'=>$id))
				->queryRow();
		}
		else
		{
			$cmd = Yii::app()->db->createCommand()
				->select('count(1) as total')
				->from('reqquotdetail t')
				->leftjoin('product a','a.productid = t.productid')
				->leftjoin('unitofmeasure b','b.unitofmeasureid = t.uomid')
				->leftjoin('currency c','c.currencyid = t.currencyid')
				->where('reqquotid = :reqquotid and t.recordstatus = 1',
						array(':reqquotid'=>$id))
				->queryRow();
		}
		
		$result['total'] = $cmd['total'];
		
		if (!isset($_GET['combo']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select('t.*,a.productname,b.uomcode,c.currencyname')
				->from('reqquotdetail t')
				->leftjoin('product a','a.productid = t.productid')
				->leftjoin('unitofmeasure b','b.unitofmeasureid = t.uomid')
				->leftjoin('currency c','c.currencyid = t.currencyid')
				->where('reqquotid = :reqquotid',
						array(':reqquotid'=>$id))
				->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		}
		else
		{
			$cmd = Yii::app()->db->createCommand()
				->select('t.*,a.productname,b.uomcode,c.currencyname')
				->from('reqquotdetail t')
				->leftjoin('product a','a.productid = t.productid')
				->leftjoin('unitofmeasure b','b.unitofmeasureid = t.uomid')
				->leftjoin('currency c','c.currencyid = t.currencyid')
				->where('reqquotid = :reqquotid and t.recordstatus = 1',
						array(':reqquotid'=>$id))
				->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		}
		
		foreach($cmd as $data)
		{	
			$row[] = array(
			'reqquotdetailid'=>$data['reqquotdetailid'],
			'reqquotid'=>$data['reqquotid'],
			'productid'=>$data['productid'],
			'productname'=>$data['productname'],
			'uomid'=>$data['uomid'],
			'uomcode'=>$data['uomcode'],
			'price'=>$data['price'],
			'qty'=>$data['qty'],
			'total'=>($data['price'] * $data['qty']),
			'currencyrate'=>$data['currencyrate'],
			'currencyid'=>$data['currencyid'],
			'currencyname'=>$data['currencyname'],
			'description'=>$data['description']
			);
		}
		$result=array_merge($result,array('rows'=>$row));;
		echo CJSON::encode($result);
	}
	
	public function actionSearchdisc()
	{
		header("Content-Type: application/json");
		$id=0;	
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
		}
		else
		if (isset($_GET['id']))
		{
			$id = $_GET['id'];
		}
                
		// pagging
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 't.reqquotdiscid';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : $page;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : $rows;
		$sort = isset($_GET['sort']) ? strval($_GET['sort']) : $sort;
		$order = isset($_GET['order']) ? strval($_GET['order']) : $order;
		$offset = ($page-1) * $rows;
		
		$result = array();
		$row = array();
                
		// result
		if (!isset($_GET['combo']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select('count(1) as total')
				->from('reqquotdisc t')
				->where('reqquotid = :reqquotid',
						array(':reqquotid'=>$id))
				->queryRow();
		}
		else
		{
			$cmd = Yii::app()->db->createCommand()
				->select('count(1) as total')
				->from('reqquotdisc t')
				->queryRow();
		}
		
		$result['total'] = $cmd['total'];
		
		if (!isset($_GET['combo']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select()
				->from('reqquotdisc t')
				->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		}
		else
		{
			$cmd = Yii::app()->db->createCommand()
				->select()
				->from('reqquotdisc t')
				->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		}
		
		foreach($cmd as $data)
		{	
			$row[] = array(
			'reqquotdiscid'=>$data['reqquotdiscid'],
			'reqquotid'=>$data['reqquotid'],
			'discvalue'=>$data['discvalue'],
			);
		}
		$result=array_merge($result,array('rows'=>$row));;
		echo CJSON::encode($result);
	}
	
	public function actionSave()
	{
		header("Content-Type: application/json");
		if(!Yii::app()->request->isPostRequest)
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['isNewRecord']))
			{
				$sql = 'call Insertreqquot(:vcompanyid,:vaddressbookid,:vcustreqno,:vquotno,:vheadernote,:vrecordstatus,:vcreatedby)';
				$command=$connection->createCommand($sql);
			}
			else
			{
				$sql = 'call Updatereqquot(:vid,:vcompanyid,:vaddressbookid,:vcustreqno,:vquotno,:vheadernote,:vrecordstatus,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['reqquotid'],PDO::PARAM_STR);
				$this->DeleteLock($this->menuname, $_POST['reqquotid']);
			}
			$command->bindvalue(':vcompanyid',$_POST['companyid'],PDO::PARAM_STR);
			$command->bindvalue(':vaddressbookid',$_POST['addressbookid'],PDO::PARAM_STR);
			$command->bindvalue(':vcustreqno',$_POST['custreqno'],PDO::PARAM_STR);
			$command->bindvalue(':vquotno',$_POST['quotno'],PDO::PARAM_STR);
			$command->bindvalue(':vheadernote',$_POST['headernote'],PDO::PARAM_STR);
			$status = isset($_POST['recordstatusreqquot'])?($_POST['recordstatusreqquot']=="on")?1:0:0;
			$command->bindvalue(':vrecordstatus',$status,PDO::PARAM_STR);
			$command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
			$command->execute();
			$transaction->commit();
			$this->GetMessage(true,'insertsuccess',1);
		}
		catch (Exception $e)
		{
			$transaction->rollBack();
			$this->GetMessage(false,$e->getMessage(),1);
		}
	}
	
	public function actionSaveDetail()
	{
		header("Content-Type: application/json");
		if(!Yii::app()->request->isPostRequest)
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['isNewRecord']))
			{
				$sql = 'call Insertreqquotdetail(:vreqquotid,:vproductid,:vqty,:vuomid,:vprice,:vcurrencyid,:vcurrencyrate,:vdescription,:vcreatedby)';
				$command=$connection->createCommand($sql);
			}
			else
			{
				$sql = 'call Updatereqquotdetail(:vid,:vreqquotid,:vproductid,:vqty,:vuomid,:vprice,:vcurrencyid,:vcurrencyrate,:vdescription,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['reqquotid'],PDO::PARAM_STR);
				$this->DeleteLock($this->menuname, $_POST['reqquotid']);
			}
			$command->bindvalue(':vreqquotid',$_POST['reqquotid'],PDO::PARAM_STR);
			$command->bindvalue(':vproductid',$_POST['productid'],PDO::PARAM_STR);
			$command->bindvalue(':vqty',$_POST['qty'],PDO::PARAM_STR);
			$command->bindvalue(':vuomid',$_POST['uomid'],PDO::PARAM_STR);
			$command->bindvalue(':vprice',$_POST['price'],PDO::PARAM_STR);
			$command->bindvalue(':vcurrencyid',$_POST['currencyid'],PDO::PARAM_STR);
			$command->bindvalue(':vcurrencyrate',$_POST['currencyrate'],PDO::PARAM_STR);
			$command->bindvalue(':vdescription',$_POST['description'],PDO::PARAM_STR);
			$command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
			$command->execute();
			$transaction->commit();
			$this->GetMessage(true,'insertsuccess',1);
		}
		catch (Exception $e)
		{
			$transaction->rollBack();
			$this->GetMessage(false,$e->getMessage(),1);
		}
	}
	
	public function actionSaveDisc()
	{
		header("Content-Type: application/json");
		if(!Yii::app()->request->isPostRequest)
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['isNewRecord']))
			{
				$sql = 'call Insertreqquotdisc(:vreqquotid,:vdiscvalue,:vcreatedby)';
				$command=$connection->createCommand($sql);
			}
			else
			{
				$sql = 'call Updatereqquotdisc(:vid,:vreqquotid,:vdiscvalue,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['reqquotid'],PDO::PARAM_STR);
				$this->DeleteLock($this->menuname, $_POST['reqquotid']);
			}
			$command->bindvalue(':vreqquotid',$_POST['reqquotid'],PDO::PARAM_STR);
			$command->bindvalue(':vdiscvalue',$_POST['discvalue'],PDO::PARAM_STR);
			$command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
			$command->execute();
			$transaction->commit();
			$this->GetMessage(true,'insertsuccess',1);
		}
		catch (Exception $e)
		{
			$transaction->rollBack();
			$this->GetMessage(false,$e->getMessage(),1);
		}
	}
	
	public function actionPurge()
	{
		header("Content-Type: application/json");
		
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Purgereqquot(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage(false,'insertsuccess');
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage(true,$e->getMessage());
			}
		}
		else
		{
			$this->GetMessage(true,'chooseone');
		}
	}
	
	public function actionDownPDF()
	{
	  parent::actionDownload();
		//masukkan perintah download
	  $sql = "select b.fullname,a.custreqno,a.headernote,a.companyid,a.taxid
from reqquot a
inner join addressbook b on b.addressbookid = a.addressbookid
 ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.reqquotid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		//masukkan judul
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title='Quotation';
		$this->pdf->AddPage('P');
		
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Rect(10,65,190,25);
		  $this->pdf->text(15,$this->pdf->gety()+10,'Customer');$this->pdf->text(40,$this->pdf->gety()+10,$row['fullname']);
		  $this->pdf->text(15,$this->pdf->gety()+15,'Req No');$this->pdf->text(40,$this->pdf->gety()+15,$row['custreqno']);
			$this->pdf->sety($this->pdf->gety()+30);
			$this->pdf->iscustomborder = false;
				  $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(35,155));
		  $this->pdf->setbordercell(array('none','none'));
			$this->pdf->row(array(
		'Note',
		$row['headernote']
	  ));
			$sql1 = "select b.productname,a.qty,c.uomcode,a.price,e.currencyname,a.currencyrate,g.taxcode,a.description,e.symbol,g.taxvalue,
			(qty * price) + (g.taxvalue * qty * price / 100) as total
from reqquotdetail a
inner join reqquot f on f.reqquotid = a.reqquotid
left join tax g on g.taxid = f.taxid
inner join product b on b.productid = a.productid
inner join unitofmeasure c on c.unitofmeasureid = a.uomid
inner join currency e on e.currencyid = a.currencyid ";
		if ($_GET['id'] !== '') {
				$sql1 = $sql1 . "where a.reqquotid in (".$_GET['id'].")";
		}
		$command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();
			$this->pdf->sety($this->pdf->gety());
		$this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(20,15,55,30,30,40));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Qty','Units','Description', 'Unit Price','Tax','Total');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('R','C','L','R','R','R');
			foreach($dataReader1 as $row1)
		{
		$this->pdf->row(array($row1['qty'],$row1['uomcode'],$row1['productname'],
            Yii::app()->numberFormatter->formatCurrency($row1['price'], $row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['taxvalue'], $row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['total'], $row1['symbol'])));
		}
		        $this->pdf->text(10,$this->pdf->gety()+35,'Approved By');$this->pdf->text(150,$this->pdf->gety()+35,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+55,'___________________ ');$this->pdf->text(150,$this->pdf->gety()+55,'___________________');

		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	public function actionDownxls()
	{
		parent::actionDownload();
		$sql = "select addressbookid,custreqno,quotno,headernote,recordstatus
				from reqquot a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.reqquotid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		 $excel=Yii::createComponent('application.extensions.PHPExcel.PHPExcel');
		$i=1;
		$excel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0,1,Catalogsys::model()->getcatalog('addressbookid'))
                ->setCellValueByColumnAndRow(1,1,Catalogsys::model()->getcatalog('custreqno'))
                ->setCellValueByColumnAndRow(2,1,Catalogsys::model()->getcatalog('quotno'))
                ->setCellValueByColumnAndRow(8,1,Catalogsys::model()->getcatalog('headernote'))
                ->setCellValueByColumnAndRow(9,1,Catalogsys::model()->getcatalog('recordstatus'))
                ;		foreach($dataReader as $row1)
		{
			  $excel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['addressbookid'])
                                ->setCellValueByColumnAndRow(1, $i+1, $row1['custreqno'])
                                ->setCellValueByColumnAndRow(2, $i+1, $row1['quotno'])
                                ->setCellValueByColumnAndRow(8, $i+1, $row1['headernote'])
                                ->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus'])
                                ;		$i+=1;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="reqquot.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save('php://output');
		unset($excel);
	}
	

}
