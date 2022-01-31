<?php
class UserfavController extends Controller
{
	public $menuname = 'userfav';
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
				$sql = 'call Insertuserfav(:vuseraccessid,:vmenuaccessid,:vcreatedby)';
				$command=$connection->createCommand($sql);
			}
			else
			{
				$sql = 'call Updateuserfav(:vid,:vuseraccessid,:vmenuaccessid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['userfavid'],PDO::PARAM_STR);
				$this->DeleteLock($this->menuname, $_POST['userfavid']);
			}
			$command->bindvalue(':vuseraccessid',$_POST['useraccessid'],PDO::PARAM_STR);
			$command->bindvalue(':vmenuaccessid',$_POST['menuaccessid'],PDO::PARAM_STR);
			$command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
			$command->execute();
			$transaction->commit();
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
				$sql = 'call Purgeuserfav(:vid,:vcreatedby)';
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
		$userfavid = isset ($_POST['userfavid']) ? $_POST['userfavid'] : '';
                $useraccessid = isset ($_POST['useraccessid']) ? $_POST['useraccessid'] : '';
                $menuaccessid = isset ($_POST['menuaccessid']) ? $_POST['menuaccessid'] : '';

		$userfavid = isset ($_GET['q']) ? $_GET['q'] : 	$userfavid;
                $useraccessid = isset ($_GET['q']) ? $_GET['q'] : $useraccessid;
                $menuaccessid = isset ($_GET['q']) ? $_GET['q'] : $menuaccessid;
		
		// pagging
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'userfavid';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : $page;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : $rows;
		$sort = isset($_GET['sort']) ? strval($_GET['sort']) : (strpos($sort,'t.') > 0)?$sort:'t.'.$sort;
		$order = isset($_GET['order']) ? strval($_GET['order']) : $order;
		$offset = ($page-1) * $rows;
		
		$result = array();
		$row = array();
	
		// result
		$cmd = Yii::app()->db->createCommand()
                        ->select('count(1) as total')	
                        ->from('userfav t')
                        ->join('useraccess p', 'p.useraccessid=t.useraccessid')
                        ->join('menuaccess q', 'q.menuaccessid=t.menuaccessid')
                        ->where('(p.username like :useraccessid) or (q.menuname like :menuaccessid)',
                                        array(':useraccessid'=>'%'.$useraccessid.'%',':menuaccessid'=>'%'.$menuaccessid.'%'))
                        ->queryRow();
	
		$result['total'] = $cmd['total'];
		
		$cmd = Yii::app()->db->createCommand()
                        ->select()	
                        ->from('userfav t')
                        ->join('useraccess p', 'p.useraccessid=t.useraccessid')
                        ->join('menuaccess q', 'q.menuaccessid=t.menuaccessid')
                        ->where('(p.username like :useraccessid) or (q.menuname like :menuaccessid)',
                                        array(':useraccessid'=>'%'.$useraccessid.'%',':menuaccessid'=>'%'.$menuaccessid.'%'))
                        ->offset($offset)
				->limit($rows)
				->order($sort.' '.$order)
				->queryAll();
		
		foreach($cmd as $data)
		{	
			$row[] = array(
				'userfavid'=>$data['userfavid'],
				'useraccessid'=>$data['useraccessid'],
				'username'=>$data['username'],
				'menuaccessid'=>$data['menuaccessid'],
				'menuname'=>$data['menuname'],
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return CJSON::encode($result);
	}
	
	public function actionDownPDF()
	{
	  parent::actionDownload();
		//masukkan perintah download
	  $sql = "select useraccessid,menuaccessid
				from userfav a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.userfavid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		//masukkan judul
		$this->pdf->title=Catalogsys::model()->getcatalog('userfav');
		$this->pdf->AddPage('P');
		//masukkan posisi judul
		$this->pdf->colalign = array('L','L');
		//masukkan colom judul
		$this->pdf->colheader = array(Catalogsys::model()->getcatalog('useraccessid'),
                Catalogsys::model()->getcatalog('menuaccessid'));
		$this->pdf->setwidths(array(40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['useraccessid'],$row1['menuaccessid']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	public function actionDownxls()
	{
		parent::actionDownload();
		$sql = "select useraccessid,menuaccessid
				from userfav a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.userfavid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		 $excel=Yii::createComponent('application.extensions.PHPExcel.PHPExcel');
		$i=1;
		$excel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0,1,Catalogsys::model()->getcatalog('useraccessid'))
                ->setCellValueByColumnAndRow(1,1,Catalogsys::model()->getcatalog('menuaccessid'));
                foreach($dataReader as $row1)
		{
			  $excel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['useraccessid'])
                                ->setCellValueByColumnAndRow(1, $i+1, $row1['menuaccessid']);
                          $i+=1;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="userfav.xlsx"');
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
