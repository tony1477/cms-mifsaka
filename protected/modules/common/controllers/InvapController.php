<?php
class InvapController extends Controller
{
	public $menuname = 'invap';
	public function actionIndex()
	{
		if(isset($_GET['grid']))
			echo $this->search();
		else
			$this->renderPartial('index',array());
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
				$sql = 'call Insertaddressbook(:vfullname,:viscustomer,:visemployee,:visvendor,:vishospital,:vtaxno,:vaccpiutangid,:vacchutangid,:vrecordstatus,:vcreatedby)';
				$command=$connection->createCommand($sql);
			}
			else
			{
				$sql = 'call Updateaddressbook(:vid,:vfullname,:viscustomer,:visemployee,:visvendor,:vishospital,:vtaxno,:vaccpiutangid,:vacchutangid,:vrecordstatus,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['addressbookid'],PDO::PARAM_STR);
			}
			$command->bindvalue(':vfullname',$_POST['fullname'],PDO::PARAM_STR);
			$command->bindvalue(':viscustomer',$_POST['iscustomer'],PDO::PARAM_STR);
			$command->bindvalue(':visemployee',$_POST['isemployee'],PDO::PARAM_STR);
			$command->bindvalue(':visvendor',$_POST['isvendor'],PDO::PARAM_STR);
			$command->bindvalue(':vishospital',$_POST['ishospital'],PDO::PARAM_STR);
			$command->bindvalue(':vtaxno',$_POST['taxno'],PDO::PARAM_STR);
			$command->bindvalue(':vaccpiutangid',$_POST['accpiutangid'],PDO::PARAM_STR);
			$command->bindvalue(':vacchutangid',$_POST['acchutangid'],PDO::PARAM_STR);
			$command->bindvalue(':vrecordstatus',$_POST['recordstatus'],PDO::PARAM_STR);
			$command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
			$command->execute();
			$transaction->commit();
			$this->DeleteLock($this->menuname, $_POST['addressbookid']);
			$this->GetMessage(false,'insertsuccess');
		}
		catch (Exception $e)
		{
			$transaction->rollBack();
			$this->GetMessage(true,$e->getMessage());
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
				$sql = 'call Purgeaddressbook(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);

					$command->bindvalue(':vid',$id,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				
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
	
	public function search()
	{
		header("Content-Type: application/json");
		
		// search 
		$addressbookid = isset ($_POST['addressbookid']) ? $_POST['addressbookid'] : '';
		$fullname = isset ($_POST['fullname']) ? $_POST['fullname'] : '';
		$iscustomer = isset ($_POST['iscustomer']) ? $_POST['iscustomer'] : '';
		$isemployee = isset ($_POST['isemployee']) ? $_POST['isemployee'] : '';
		$isvendor = isset ($_POST['isvendor']) ? $_POST['isvendor'] : '';
		$ishospital = isset ($_POST['ishospital']) ? $_POST['ishospital'] : '';
		$taxno = isset ($_POST['taxno']) ? $_POST['taxno'] : '';
		$accpiutangid = isset ($_POST['accpiutangid']) ? $_POST['accpiutangid'] : '';
		$acchutangid = isset ($_POST['acchutangid']) ? $_POST['acchutangid'] : '';
		$recordstatus = isset ($_POST['recordstatus']) ? $_POST['recordstatus'] : '';
		$addressbookid = isset ($_GET['q']) ? $_GET['q'] : $addressbookid;
		$fullname = isset ($_GET['q']) ? $_GET['q'] : $fullname;
		$iscustomer = isset ($_GET['q']) ? $_GET['q'] : $iscustomer;
		$isemployee = isset ($_GET['q']) ? $_GET['q'] : $isemployee;
		$isvendor = isset ($_GET['q']) ? $_GET['q'] : $isvendor;
		$ishospital = isset ($_GET['q']) ? $_GET['q'] : $ishospital;
		$taxno = isset ($_GET['q']) ? $_GET['q'] : $taxno;
		$accpiutangid = isset ($_GET['q']) ? $_GET['q'] : $accpiutangid;
		$acchutangid = isset ($_GET['q']) ? $_GET['q'] : $acchutangid;
		$recordstatus = isset ($_GET['q']) ? $_GET['q'] : $recordstatus;
		
		// pagging
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 't.addressbookid';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
                
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
                                ->from('addressbook t')
                                ->leftjoin('account p','p.accountid=t.accpiutangid')
                                ->leftjoin('account q','q.accountid=t.acchutangid')
                                ->where('(fullname like :fullname) or 
                                        (taxno like :taxno) or 
                                        (p.accountname like :accpiutangid) or 
                                        (q.accountname like :acchutangid)',
                                                array(':fullname'=>'%'.$fullname.'%',
                                                    ':taxno'=>'%'.$taxno.'%',
                                                    ':accpiutangid'=>'%'.$accpiutangid.'%',
                                                    ':acchutangid'=>'%'.$acchutangid.'%'
                                                    ))
                                ->queryRow();
                }
                else
                {
                        $cmd = Yii::app()->db->createCommand()
                                ->select('count(1) as total')	
                                ->from('addressbook t')
                                ->leftjoin('account p','p.accountid=t.accpiutangid')
                                ->leftjoin('account q','q.accountid=t.acchutangid')
                                ->where('((fullname like :fullname) or 
                                        (taxno like :taxno) or 
                                        (p.accountname like :accpiutangid) or 
                                        (q.accountname like :acchutangid)) and 
                                        t.recordstatus=1',
                                                array(':fullname'=>'%'.$fullname.'%',
                                                    ':taxno'=>'%'.$taxno.'%',
                                                    ':accpiutangid'=>'%'.$accpiutangid.'%',
                                                    ':acchutangid'=>'%'.$acchutangid.'%'
                                                    ))
                                ->queryRow();
                }
	
		$result['total'] = $cmd['total'];
		
		if (!isset($_GET['combo']))
                {
                        $cmd = Yii::app()->db->createCommand()
                                ->select()	
                                ->from('addressbook t')
                                ->leftjoin('account p','p.accountid=t.accpiutangid')
                                ->leftjoin('account q','q.accountid=t.acchutangid')
                                ->where('(fullname like :fullname) or 
                                        (taxno like :taxno) or 
                                        (p.accountname like :accpiutangid) or 
                                        (q.accountname like :acchutangid)',
                                                array(':fullname'=>'%'.$fullname.'%',
                                                    ':taxno'=>'%'.$taxno.'%',
                                                    ':accpiutangid'=>'%'.$accpiutangid.'%',
                                                    ':acchutangid'=>'%'.$acchutangid.'%'
                                                    ))
                                ->offset($offset)
                                ->limit($rows)
                                ->order($sort.' '.$order)
                                ->queryAll();
                }
                else
                {
                        $cmd = Yii::app()->db->createCommand()
                                ->select()	
                                ->from('addressbook t')
                                ->leftjoin('account p','p.accountid=t.accpiutangid')
                                ->leftjoin('account q','q.accountid=t.acchutangid')
                                ->where('((fullname like :fullname) or 
                                        (taxno like :taxno) or 
                                        (p.accountname like :accpiutangid) or 
                                        (q.accountname like :acchutangid)) and 
                                        t.recordstatus=1',
                                                array(':fullname'=>'%'.$fullname.'%',
                                                    ':taxno'=>'%'.$taxno.'%',
                                                    ':accpiutangid'=>'%'.$accpiutangid.'%',
                                                    ':acchutangid'=>'%'.$acchutangid.'%'
                                                    ))
                                ->offset($offset)
                                ->limit($rows)
                                ->order($sort.' '.$order)
                                ->queryAll();
                }
		
		foreach($cmd as $data)
		{	
			$row[] = array(
				'addressbookid'=>$data['addressbookid'],
				'fullname'=>$data['fullname'],
				'iscustomer'=>$data['iscustomer'],
				'isemployee'=>$data['isemployee'],
				'isvendor'=>$data['isvendor'],
				'ishospital'=>$data['ishospital'],
				'taxno'=>$data['taxno'],
				'accpiutangid'=>$data['accpiutangid'],
				'accpiutangname'=>$data['accountname'],
				'acchutangid'=>$data['acchutangid'],
				'acchutangname'=>$data['accountname'],
				'recordstatus'=>$data['recordstatus'],
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return CJSON::encode($result);
	}
	
	public function actionDownPDF()
	{
	  parent::actionDownload();
		//masukkan perintah download
	  $sql = "select fullname,iscustomer,isemployee,isvendor,ishospital,taxno,accpiutangid,acchutangid,recordstatus
				from addressbook a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.addressbookid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		//masukkan judul
		$this->pdf->title=Catalogsys::model()->getcatalog('addressbook');
		$this->pdf->AddPage('P');
		//masukkan posisi judul
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L');
		//masukkan colom judul
		$this->pdf->colheader = array(Catalogsys::model()->getcatalog('fullname'),
		Catalogsys::model()->getcatalog('iscustomer'),
		Catalogsys::model()->getcatalog('isemployee'),
		Catalogsys::model()->getcatalog('isvendor'),
		Catalogsys::model()->getcatalog('ishospital'),
		Catalogsys::model()->getcatalog('taxno'),
		Catalogsys::model()->getcatalog('accpiutangid'),
		Catalogsys::model()->getcatalog('acchutangid'),
		Catalogsys::model()->getcatalog('recordstatus'));
		$this->pdf->setwidths(array(40,40,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['fullname'],$row1['iscustomer'],$row1['isemployee'],$row1['isvendor'],$row1['ishospital'],$row1['taxno'],$row1['accpiutangid'],$row1['acchutangid'],$row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	public function actionDownxls()
	{
		parent::actionDownload();
		$sql = "select fullname,iscustomer,isemployee,isvendor,ishospital,taxno,accpiutangid,acchutangid,recordstatus
				from addressbook a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.addressbookid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		 $excel=Yii::createComponent('application.extensions.PHPExcel.PHPExcel');
		$i=1;
		$excel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0,1,Catalogsys::model()->getcatalog('fullname'))
		->setCellValueByColumnAndRow(1,1,Catalogsys::model()->getcatalog('iscustomer'))
		->setCellValueByColumnAndRow(2,1,Catalogsys::model()->getcatalog('isemployee'))
		->setCellValueByColumnAndRow(3,1,Catalogsys::model()->getcatalog('isvendor'))
		->setCellValueByColumnAndRow(4,1,Catalogsys::model()->getcatalog('ishospital'))
		->setCellValueByColumnAndRow(5,1,Catalogsys::model()->getcatalog('taxno'))
		->setCellValueByColumnAndRow(6,1,Catalogsys::model()->getcatalog('accpiutangid'))
		->setCellValueByColumnAndRow(7,1,Catalogsys::model()->getcatalog('acchutangid'))
		->setCellValueByColumnAndRow(8,1,Catalogsys::model()->getcatalog('recordstatus'))
;		foreach($dataReader as $row1)
		{
			  $excel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['fullname'])
				->setCellValueByColumnAndRow(1, $i+1, $row1['iscustomer'])
				->setCellValueByColumnAndRow(2, $i+1, $row1['isemployee'])
				->setCellValueByColumnAndRow(3, $i+1, $row1['isvendor'])
				->setCellValueByColumnAndRow(4, $i+1, $row1['ishospital'])
				->setCellValueByColumnAndRow(5, $i+1, $row1['taxno'])
				->setCellValueByColumnAndRow(6, $i+1, $row1['accpiutangid'])
				->setCellValueByColumnAndRow(7, $i+1, $row1['acchutangid'])
				->setCellValueByColumnAndRow(8, $i+1, $row1['recordstatus']);			
				$i+=1;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="addressbook.xlsx"');
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