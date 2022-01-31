<?php
class ProductaccController extends Controller
{
	public $menuname = 'productacc';
	public function actionIndex()
	{
		if(isset($_GET['grid']))
			echo $this->search();
		else
			$this->renderPartial('index',array());
	}
	
	public function search()
	{
		header("Content-Type: application/json");
		
		// search 
		$productaccid = isset ($_POST['productaccid']) ? $_POST['productaccid'] : '';
		$productid = isset ($_POST['productid']) ? $_POST['productid'] : '';
		$accaktivatetap = isset ($_POST['accaktivatetap']) ? $_POST['accaktivatetap'] : '';
		$accakumat = isset ($_POST['accakumat']) ? $_POST['accakumat'] : '';
		$accbiayaat = isset ($_POST['accbiayaat']) ? $_POST['accbiayaat'] : '';
		$accpersediaan = isset ($_POST['accpersediaan']) ? $_POST['accpersediaan'] : '';
		$accreturpembelian = isset ($_POST['accreturpembelian']) ? $_POST['accreturpembelian'] : '';
		$accdiscpembelian = isset ($_POST['accdiscpembelian']) ? $_POST['accdiscpembelian'] : '';
		$accpenjualan = isset ($_POST['accpenjualan']) ? $_POST['accpenjualan'] : '';
		$accbiaya = isset ($_POST['accbiaya']) ? $_POST['accbiaya'] : '';
		$accreturpenjualan = isset ($_POST['accreturpenjualan']) ? $_POST['accreturpenjualan'] : '';
		$accspsi = isset ($_POST['accspsi']) ? $_POST['accspsi'] : '';
		$accexpedisi = isset ($_POST['accexpedisi']) ? $_POST['accexpedisi'] : '';
		$hpp = isset ($_POST['hpp']) ? $_POST['hpp'] : '';
		$accupahlembur = isset ($_POST['accupahlembur']) ? $_POST['accupahlembur'] : '';
		$foh = isset ($_POST['foh']) ? $_POST['foh'] : '';
		
		$productaccid = isset ($_GET['q']) ? $_GET['q'] : $productaccid;
		$productid = isset ($_GET['q']) ? $_GET['q'] : $productid;
		$accaktivatetap = isset ($_GET['q']) ? $_GET['q'] : $accaktivatetap;
		$accakumat = isset ($_GET['q']) ? $_GET['q'] : $accakumat;
		$accbiayaat = isset ($_GET['q']) ? $_GET['q'] : $accbiayaat;
		$accpersediaan = isset ($_GET['q']) ? $_GET['q'] : $accpersediaan;
		$accreturpembelian = isset ($_GET['q']) ? $_GET['q'] : $accreturpembelian;
		$accdiscpembelian = isset ($_GET['q']) ? $_GET['q'] : $accdiscpembelian;
		$accpenjualan = isset ($_GET['q']) ? $_GET['q'] : $accpenjualan;
		$accbiaya = isset ($_GET['q']) ? $_GET['q'] : $accbiaya;
		$accreturpenjualan = isset ($_GET['q']) ? $_GET['q'] : $accreturpenjualan;
		$accspsi = isset ($_GET['q']) ? $_GET['q'] : $accspsi;
		$accexpedisi = isset ($_GET['q']) ? $_GET['q'] : $accexpedisi;
		$hpp = isset ($_GET['q']) ? $_GET['q'] : $hpp;
		$accupahlembur = isset ($_GET['q']) ? $_GET['q'] : $accupahlembur;
		$foh = isset ($_GET['q']) ? $_GET['q'] : $foh;
		
		// pagging
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 't.productaccid';
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
		$cmd = Yii::app()->db->createCommand()
			->select('count(1) as total')	
			->from('productacc t')
			->join('product p','p.productid=t.productid')
			->leftjoin('account q','q.accountid=t.accaktivatetap')
			->leftjoin('account r','r.accountid=t.accakumat')
			->leftjoin('account s','s.accountid=t.accbiayaat')
			->leftjoin('account e','e.accountid=t.accpersediaan')
			->leftjoin('account u','u.accountid=t.accreturpembelian')
			->leftjoin('account v','v.accountid=t.accdiscpembelian')
			->leftjoin('account w','w.accountid=t.accpenjualan')
			->leftjoin('account x','x.accountid=t.accbiaya')
			->leftjoin('account y','y.accountid=t.accreturpenjualan')
			->leftjoin('account z','z.accountid=t.accspsi')
			->leftjoin('account a','a.accountid=t.accexpedisi')
			->leftjoin('account b','b.accountid=t.hpp')
			->leftjoin('account c','c.accountid=t.accupahlembur')
			->leftjoin('account d','d.accountid=t.foh')
			->where('(p.productname like :productid) or
							(q.accountname like :accaktivatetap) or 
							(r.accountname like :accakumat) or 
							(s.accountname like :accbiayaat) or 
							(e.accountname like :accpersediaan) or 
							(u.accountname like :accreturpembelian) or 
							(v.accountname like :accdiscpembelian) or 
							(w.accountname like :accpenjualan) or 
							(x.accountname like :accbiaya) or 
							(y.accountname like :accreturpenjualan) or 
							(z.accountname like :accspsi) or 
							(a.accountname like :accexpedisi) or 
							(b.accountname like :hpp) or 
							(c.accountname like :accupahlembur) or 
							(d.accountname like :foh)',
							array(':productid'=>'%'.$productid.'%',
									':accaktivatetap'=>'%'.$accaktivatetap.'%',
									':accakumat'=>'%'.$accakumat.'%',
									':accbiayaat'=>'%'.$accbiayaat.'%',
									':accpersediaan'=>'%'.$accpersediaan.'%',
									':accreturpembelian'=>'%'.$accreturpembelian.'%',
									':accdiscpembelian'=>'%'.$accdiscpembelian.'%',
									':accpenjualan'=>'%'.$accpenjualan.'%',
									':accbiaya'=>'%'.$accbiaya.'%',
									':accreturpenjualan'=>'%'.$accreturpenjualan.'%',
									':accspsi'=>'%'.$accspsi.'%',
									':accexpedisi'=>'%'.$accexpedisi.'%',
									':hpp'=>'%'.$hpp.'%',
									':accupahlembur'=>'%'.$accupahlembur.'%',
									':foh'=>'%'.$foh.'%'
									))
			->queryRow();
	
		$result['total'] = $cmd['total'];
		
		$cmd = Yii::app()->db->createCommand()
			->select()	
			->from('productacc t')
			->join('product p','p.productid=t.productid')
			->leftjoin('account q','q.accountid=t.accaktivatetap')
			->leftjoin('account r','r.accountid=t.accakumat')
			->leftjoin('account s','s.accountid=t.accbiayaat')
			->leftjoin('account e','e.accountid=t.accpersediaan')
			->leftjoin('account u','u.accountid=t.accreturpembelian')
			->leftjoin('account v','v.accountid=t.accdiscpembelian')
			->leftjoin('account w','w.accountid=t.accpenjualan')
			->leftjoin('account x','x.accountid=t.accbiaya')
			->leftjoin('account y','y.accountid=t.accreturpenjualan')
			->leftjoin('account z','z.accountid=t.accspsi')
			->leftjoin('account a','a.accountid=t.accexpedisi')
			->leftjoin('account b','b.accountid=t.hpp')
			->leftjoin('account c','c.accountid=t.accupahlembur')
			->leftjoin('account d','d.accountid=t.foh')
			->where('(p.productname like :productid) or
							(q.accountname like :accaktivatetap) or 
							(r.accountname like :accakumat) or 
							(s.accountname like :accbiayaat) or 
							(e.accountname like :accpersediaan) or 
							(u.accountname like :accreturpembelian) or 
							(v.accountname like :accdiscpembelian) or 
							(w.accountname like :accpenjualan) or 
							(x.accountname like :accbiaya) or 
							(y.accountname like :accreturpenjualan) or 
							(z.accountname like :accspsi) or 
							(a.accountname like :accexpedisi) or 
							(b.accountname like :hpp) or 
							(c.accountname like :accupahlembur) or 
							(d.accountname like :foh)',
								array(':productid'=>'%'.$productid.'%',
										':accaktivatetap'=>'%'.$accaktivatetap.'%',
										':accakumat'=>'%'.$accakumat.'%',
										':accbiayaat'=>'%'.$accbiayaat.'%',
										':accpersediaan'=>'%'.$accpersediaan.'%',
										':accreturpembelian'=>'%'.$accreturpembelian.'%',
										':accdiscpembelian'=>'%'.$accdiscpembelian.'%',
										':accpenjualan'=>'%'.$accpenjualan.'%',
										':accbiaya'=>'%'.$accbiaya.'%',
										':accreturpenjualan'=>'%'.$accreturpenjualan.'%',
										':accspsi'=>'%'.$accspsi.'%',
										':accexpedisi'=>'%'.$accexpedisi.'%',
										':hpp'=>'%'.$hpp.'%',
										':accupahlembur'=>'%'.$accupahlembur.'%',
										':foh'=>'%'.$foh.'%'
										))
			->offset($offset)
			->limit($rows)
			->order($sort.' '.$order)
			->queryAll();
		
		foreach($cmd as $data)
		{	
			$row[] = array(
				'productaccid'=>$data['productaccid'],
				'productid'=>$data['productid'],
				'productname'=>$data['productname'],
				'accaktivatetap'=>$data['accaktivatetap'],
				'accaktivatetapname'=>$data['accountname'],
				'accakumat'=>$data['accakumat'],
				'accakumatname'=>$data['accountname'],
				'accbiayaat'=>$data['accbiayaat'],
				'accbiayaatname'=>$data['accountname'],
				'accpersediaan'=>$data['accpersediaan'],
				'accpersediaanname'=>$data['accountname'],
				'accreturpembelian'=>$data['accreturpembelian'],
				'accreturpembelianname'=>$data['accountname'],
				'accdiscpembelian'=>$data['accdiscpembelian'],
				'accdiscpembelianname'=>$data['accountname'],
				'accpenjualan'=>$data['accpenjualan'],
				'accpenjualanname'=>$data['accountname'],
				'accbiaya'=>$data['accbiaya'],
				'accbiayaname'=>$data['accountname'],
				'accreturpenjualan'=>$data['accreturpenjualan'],
				'accreturpenjualanname'=>$data['accountname'],
				'accspsi'=>$data['accspsi'],
				'accspsiname'=>$data['accountname'],
				'accexpedisi'=>$data['accexpedisi'],
				'accexpedisiname'=>$data['accountname'],
				'hpp'=>$data['hpp'],
				'hppname'=>$data['accountname'],
				'accupahlembur'=>$data['accupahlembur'],
				'accupahlemburname'=>$data['accountname'],
				'foh'=>$data['foh'],
				'fohname'=>$data['accountname'],
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return CJSON::encode($result);
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
				$sql = 'call Insertproductacc(:vproductid,:vaccaktivatetap,:vaccakumat,:vaccbiayaat,:vaccpersediaan,:vaccreturpembelian,:vaccdiscpembelian,:vaccpenjualan,:vaccbiaya,:vaccreturpenjualan,:vaccspsi,:vaccexpedisi,:vhpp,:vaccupahlembur,:vfoh,:vcreatedby)';
				$command=$connection->createCommand($sql);
			}
			else
			{
				$sql = 'call Updateproductacc(:vid,:vproductid,:vaccaktivatetap,:vaccakumat,:vaccbiayaat,:vaccpersediaan,:vaccreturpembelian,:vaccdiscpembelian,:vaccpenjualan,:vaccbiaya,:vaccreturpenjualan,:vaccspsi,:vaccexpedisi,:vhpp,:vaccupahlembur,:vfoh,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['productaccid'],PDO::PARAM_STR);
				$this->DeleteLock($this->menuname, $_POST['productaccid']);
			}
			$command->bindvalue(':vproductid',$_POST['productid'],PDO::PARAM_STR);
			$command->bindvalue(':vaccaktivatetap',$_POST['accaktivatetap'],PDO::PARAM_STR);
			$command->bindvalue(':vaccakumat',$_POST['accakumat'],PDO::PARAM_STR);
			$command->bindvalue(':vaccbiayaat',$_POST['accbiayaat'],PDO::PARAM_STR);
			$command->bindvalue(':vaccpersediaan',$_POST['accpersediaan'],PDO::PARAM_STR);
			$command->bindvalue(':vaccreturpembelian',$_POST['accreturpembelian'],PDO::PARAM_STR);
			$command->bindvalue(':vaccdiscpembelian',$_POST['accdiscpembelian'],PDO::PARAM_STR);
			$command->bindvalue(':vaccpenjualan',$_POST['accpenjualan'],PDO::PARAM_STR);
			$command->bindvalue(':vaccbiaya',$_POST['accbiaya'],PDO::PARAM_STR);
			$command->bindvalue(':vaccreturpenjualan',$_POST['accreturpenjualan'],PDO::PARAM_STR);
			$command->bindvalue(':vaccspsi',$_POST['accspsi'],PDO::PARAM_STR);
			$command->bindvalue(':vaccexpedisi',$_POST['accexpedisi'],PDO::PARAM_STR);
			$command->bindvalue(':vhpp',$_POST['hpp'],PDO::PARAM_STR);
			$command->bindvalue(':vaccupahlembur',$_POST['accupahlembur'],PDO::PARAM_STR);
			$command->bindvalue(':vfoh',$_POST['foh'],PDO::PARAM_STR);
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
				$sql = 'call Purgeproductacc(:vid,:vcreatedby)';
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
	
	public function actionDownPDF()
	{
	  parent::actionDownload();
		//masukkan perintah download
	  $sql = "select productid,accaktivatetap,accakumat,accbiayaat,accpersediaan,accreturpembelian,accdiscpembelian,accpenjualan,accbiaya,accreturpenjualan,accspsi,accexpedisi,hpp,accupahlembur,foh
				from productacc a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productaccid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		//masukkan judul
		$this->pdf->title=Catalogsys::model()->getcatalog('productacc');
		$this->pdf->AddPage('P');
		//masukkan posisi judul
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		//masukkan colom judul
		$this->pdf->colheader = array(Catalogsys::model()->getcatalog('productid'),
                Catalogsys::model()->getcatalog('accaktivatetap'),
                Catalogsys::model()->getcatalog('accakumat'),
                Catalogsys::model()->getcatalog('accbiayaat'),
                Catalogsys::model()->getcatalog('accpersediaan'),
                Catalogsys::model()->getcatalog('accreturpembelian'),
                Catalogsys::model()->getcatalog('accdiscpembelian'),
                Catalogsys::model()->getcatalog('accpenjualan'),
                Catalogsys::model()->getcatalog('accbiaya'),
                Catalogsys::model()->getcatalog('accreturpenjualan'),
                Catalogsys::model()->getcatalog('accspsi'),
                Catalogsys::model()->getcatalog('accexpedisi'),
                Catalogsys::model()->getcatalog('hpp'),
                Catalogsys::model()->getcatalog('accupahlembur'),
                Catalogsys::model()->getcatalog('foh'));
		$this->pdf->setwidths(array(40,40,40,40,40,40,40,40,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productid'],$row1['accaktivatetap'],$row1['accakumat'],$row1['accbiayaat'],$row1['accpersediaan'],$row1['accreturpembelian'],$row1['accdiscpembelian'],$row1['accpenjualan'],$row1['accbiaya'],$row1['accreturpenjualan'],$row1['accspsi'],$row1['accexpedisi'],$row1['hpp'],$row1['accupahlembur'],$row1['foh']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	public function actionDownxls()
	{
		parent::actionDownload();
		$sql = "select productid,accaktivatetap,accakumat,accbiayaat,accpersediaan,accreturpembelian,accdiscpembelian,accpenjualan,accbiaya,accreturpenjualan,accspsi,accexpedisi,hpp,accupahlembur,foh
				from productacc a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productaccid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		 $excel=Yii::createComponent('application.extensions.PHPExcel.PHPExcel');
		$i=1;
		$excel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0,1,Catalogsys::model()->getcatalog('productid'))
                ->setCellValueByColumnAndRow(1,1,Catalogsys::model()->getcatalog('accaktivatetap'))
                ->setCellValueByColumnAndRow(2,1,Catalogsys::model()->getcatalog('accakumat'))
                ->setCellValueByColumnAndRow(3,1,Catalogsys::model()->getcatalog('accbiayaat'))
                ->setCellValueByColumnAndRow(4,1,Catalogsys::model()->getcatalog('accpersediaan'))
                ->setCellValueByColumnAndRow(5,1,Catalogsys::model()->getcatalog('accreturpembelian'))
                ->setCellValueByColumnAndRow(6,1,Catalogsys::model()->getcatalog('accdiscpembelian'))
                ->setCellValueByColumnAndRow(7,1,Catalogsys::model()->getcatalog('accpenjualan'))
                ->setCellValueByColumnAndRow(8,1,Catalogsys::model()->getcatalog('accbiaya'))
                ->setCellValueByColumnAndRow(9,1,Catalogsys::model()->getcatalog('accreturpenjualan'))
                ->setCellValueByColumnAndRow(10,1,Catalogsys::model()->getcatalog('accspsi'))
                ->setCellValueByColumnAndRow(11,1,Catalogsys::model()->getcatalog('accexpedisi'))
                ->setCellValueByColumnAndRow(12,1,Catalogsys::model()->getcatalog('hpp'))
                ->setCellValueByColumnAndRow(13,1,Catalogsys::model()->getcatalog('accupahlembur'))
                ->setCellValueByColumnAndRow(14,1,Catalogsys::model()->getcatalog('foh'))
                ;		foreach($dataReader as $row1)
		{
			  $excel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['productid'])
                                ->setCellValueByColumnAndRow(1, $i+1, $row1['accaktivatetap'])
                                ->setCellValueByColumnAndRow(2, $i+1, $row1['accakumat'])
                                ->setCellValueByColumnAndRow(3, $i+1, $row1['accbiayaat'])
                                ->setCellValueByColumnAndRow(4, $i+1, $row1['accpersediaan'])
                                ->setCellValueByColumnAndRow(5, $i+1, $row1['accreturpembelian'])
                                ->setCellValueByColumnAndRow(6, $i+1, $row1['accdiscpembelian'])
                                ->setCellValueByColumnAndRow(7, $i+1, $row1['accpenjualan'])
                                ->setCellValueByColumnAndRow(8, $i+1, $row1['accbiaya'])
                                ->setCellValueByColumnAndRow(9, $i+1, $row1['accreturpenjualan'])
                                ->setCellValueByColumnAndRow(10, $i+1, $row1['accspsi'])
                                ->setCellValueByColumnAndRow(11, $i+1, $row1['accexpedisi'])
                                ->setCellValueByColumnAndRow(12, $i+1, $row1['hpp'])
                                ->setCellValueByColumnAndRow(13, $i+1, $row1['accupahlembur'])
                                ->setCellValueByColumnAndRow(14, $i+1, $row1['foh'])
                                ;		$i+=1;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="productacc.xlsx"');
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
