<?php

class SlocaccountingController extends AdminController
{
	protected $menuname = 'slocaccounting';
	public $module = 'Common';
	protected $pageTitle = 'Sloc Data Accounting';
	public $wfname = '';
	protected $sqldata = "select a0.slocaccid,a0.slocid,a0.materialgroupid,a0.accaktivatetap,a0.accakumat,a0.accbiayaat,a0.accpersediaan,a0.accreturpembelian,a0.accdiscpembelian,a0.accpenjualan,a0.accbiaya,a0.accreturpenjualan,a0.accspsi,a0.accexpedisi,a0.hpp,a0.accupahlembur,a0.foh,a1.sloccode as sloccode,a2.materialgroupcode as materialgroupcode,a3.accountname as accaktivatetapname,a4.accountname as accakumatname,a5.accountname as accbiayaatname,a6.accountname as accpersediaanname,a7.accountname as accreturpembelianname,a8.accountname as accdiscpembelianname,a9.accountname as accpenjualanname,a10.accountname as accbiayaname,a11.accountname as accreturpenjualanname,a12.accountname as accspsiname,a13.accountname as accexpedisiname,a14.accountname as acchppname,a15.accountname as accupahlemburname,a16.accountname as accfohname,a3.accountcode, a17.accountname as acckoreksiname, a18.accountname as acccadanganname, a0.acckoreksi, a0.acccadangan
    from slocaccounting a0 
    left join sloc a1 on a1.slocid = a0.slocid
    left join materialgroup a2 on a2.materialgroupid = a0.materialgroupid
    left join account a3 on a3.accountid = a0.accaktivatetap
    left join account a4 on a4.accountid = a0.accakumat
    left join account a5 on a5.accountid = a0.accbiayaat
    left join account a6 on a6.accountid = a0.accpersediaan
    left join account a7 on a7.accountid = a0.accreturpembelian
    left join account a8 on a8.accountid = a0.accdiscpembelian
    left join account a9 on a9.accountid = a0.accpenjualan
    left join account a10 on a10.accountid = a0.accbiaya
    left join account a11 on a11.accountid = a0.accreturpenjualan
    left join account a12 on a12.accountid = a0.accspsi
    left join account a13 on a13.accountid = a0.accexpedisi
    left join account a14 on a14.accountid = a0.hpp
    left join account a15 on a15.accountid = a0.accupahlembur
    left join account a16 on a16.accountid = a0.foh
    left join account a17 on a16.accountid = a0.acckoreksi
    left join account a18 on a16.accountid = a0.acccadangan
  ";
  protected $sqlcount = "select count(1) 
    from slocaccounting a0 
    left join sloc a1 on a1.slocid = a0.slocid
    left join materialgroup a2 on a2.materialgroupid = a0.materialgroupid
    left join account a3 on a3.accountid = a0.accaktivatetap
    left join account a4 on a4.accountid = a0.accakumat
    left join account a5 on a5.accountid = a0.accbiayaat
    left join account a6 on a6.accountid = a0.accpersediaan
    left join account a7 on a7.accountid = a0.accreturpembelian
    left join account a8 on a8.accountid = a0.accdiscpembelian
    left join account a9 on a9.accountid = a0.accpenjualan
    left join account a10 on a10.accountid = a0.accbiaya
    left join account a11 on a11.accountid = a0.accreturpenjualan
    left join account a12 on a12.accountid = a0.accspsi
    left join account a13 on a13.accountid = a0.accexpedisi
    left join account a14 on a14.accountid = a0.hpp
    left join account a15 on a15.accountid = a0.accupahlembur
    left join account a16 on a16.accountid = a0.foh
    left join account a17 on a16.accountid = a0.acckoreksi
    left join account a18 on a16.accountid = a0.acccadangan
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['sloccode'])) && (isset($_REQUEST['materialgroupcode'])))
		{				
			$where .= " where a1.sloccode like '%". $_REQUEST['sloccode']."%' 
and a2.materialgroupcode like '%". $_REQUEST['materialgroupcode']."%'"; 
		}
		if (isset($_REQUEST['slocaccid']))
			{
				if (($_REQUEST['slocaccid'] !== '0') && ($_REQUEST['slocaccid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.slocaccid in (".$_REQUEST['slocaccid'].")";
					}
					else
					{
						$where .= " and a0.slocaccid in (".$_REQUEST['slocaccid'].")";
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
			'keyField'=>'slocaccid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'slocaccid','slocid','materialgroupid','accaktivatetap','accakumat','accbiayaat','accpersediaan','accreturpembelian','accdiscpembelian','accpenjualan','accbiaya','accreturpenjualan','accspsi','accexpedisi','hpp','accupahlembur','foh','acckoreksi','acccadangan'
				),
				'defaultOrder' => array( 
					'slocaccid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.slocaccid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'slocaccid'=>$model['slocaccid'],
          'slocid'=>$model['slocid'],
          'materialgroupid'=>$model['materialgroupid'],
          'accaktivatetap'=>$model['accaktivatetap'],
          'accakumat'=>$model['accakumat'],
          'accbiayaat'=>$model['accbiayaat'],
          'accpersediaan'=>$model['accpersediaan'],
          'accreturpembelian'=>$model['accreturpembelian'],
          'accdiscpembelian'=>$model['accdiscpembelian'],
          'accpenjualan'=>$model['accpenjualan'],
          'accbiaya'=>$model['accbiaya'],
          'accreturpenjualan'=>$model['accreturpenjualan'],
          'accspsi'=>$model['accspsi'],
          'accexpedisi'=>$model['accexpedisi'],
          'hpp'=>$model['hpp'],
          'accupahlembur'=>$model['accupahlembur'],
          'foh'=>$model['foh'],
          'acckoreksi'=>$model['acckoreksi'],
          'acccadangan'=>$model['acccadangan'],
          'sloccode'=>$model['sloccode'],
          'materialgroupcode'=>$model['materialgroupcode'],
          'accaktivatetapname'=>$model['accaktivatetapname'],
          'accakumatname'=>$model['accakumatname'],
          'accbiayaatname'=>$model['accbiayaatname'],
          'accpersediaanname'=>$model['accpersediaanname'],
          'accreturpembelianname'=>$model['accreturpembelianname'],
          'accdiscpembelianname'=>$model['accdiscpembelianname'],
          'accpenjualanname'=>$model['accpenjualanname'],
          'accbiayaname'=>$model['accbiayaname'],
          'accreturpenjualanname'=>$model['accreturpenjualanname'],
          'accspsiname'=>$model['accspsiname'],
          'accexpedisiname'=>$model['accexpedisiname'],
          'acchppname'=>$model['acchppname'],
          'accupahlemburname'=>$model['accupahlemburname'],
          'accfohname'=>$model['accfohname'],
          'acckoreksiname'=>$model['acckoreksiname'],
          'acccadanganname'=>$model['acccadanganname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('slocid','string','emptyslocid'),
      array('materialgroupid','string','emptymaterialgroupid'),
    ));
		if ($error == false)
		{
			$id = $_POST['slocaccid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateslocaccounting(:vid,:vslocid,:vmaterialgroupid,:vaccaktivatetap,:vaccakumat,:vaccbiayaat,:vaccpersediaan,:vaccreturpembelian,:vaccdiscpembelian,:vaccpenjualan,:vaccbiaya,:vaccreturpenjualan,:vaccspsi,:vaccexpedisi,:vhpp,:vaccupahlembur,:vfoh,:vacckoreksi,:vacccadangan,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertslocaccounting(:vslocid,:vmaterialgroupid,:vaccaktivatetap,:vaccakumat,:vaccbiayaat,:vaccpersediaan,:vaccreturpembelian,:vaccdiscpembelian,:vaccpenjualan,:vaccbiaya,:vaccreturpenjualan,:vaccspsi,:vaccexpedisi,:vhpp,:vaccupahlembur,:vfoh,:vacckoreksi,:vacccadangan,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['slocaccid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vslocid',$_POST['slocid'],PDO::PARAM_STR);
                $command->bindvalue(':vmaterialgroupid',$_POST['materialgroupid'],PDO::PARAM_STR);
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
                $command->bindvalue(':vacckoreksi',$_POST['acckoreksi'],PDO::PARAM_STR);
                $command->bindvalue(':vacccadangan',$_POST['acccadangan'],PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
				
	
	
	public function actionPurge()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from slocaccounting where slocaccid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
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
		$sql = "select t.slocaccid,f.description,a.accountname as accexpedisiname,b.accountname as acchppname,c.accountname as accupahlemburname,
			d.accountname as accfohname,e.accountname as accpersediaanname,p.sloccode as sloccode,q.accountname as accaktivatetapname
			,r.accountname as accakumatname,s.accountname as accbiayaatname,u.accountname as accreturpembelianname,v.accountname as accdiscpembelianname
			,w.accountname as accpenjualanname,x.accountname as accbiayaname,y.accountname as accreturpenjualanname,z.accountname as accspsiname,
            h.accountname as acckoreksiname,g.accountname as acccadanganname
				from slocaccounting t 
				left join sloc p on p.slocid = t.slocid 
				left join materialgroup f on f.materialgroupid = t.materialgroupid  
				left join account q on q.accountid=t.accaktivatetap 
				left join account r on r.accountid=t.accakumat 
				left join account s on s.accountid=t.accbiayaat 
			  left join account e on e.accountid=t.accpersediaan 
			left join account u on u.accountid=t.accreturpembelian 
			left join account v on v.accountid=t.accdiscpembelian 
			left join account w on w.accountid=t.accpenjualan 
			left join account x on x.accountid=t.accbiaya 
			left join account y on y.accountid=t.accreturpenjualan 
			left join account z on z.accountid=t.accspsi 
			left join account a on a.accountid=t.accexpedisi 
			left join account b on b.accountid=t.hpp 
			left join account c on c.accountid=t.accupahlembur 
			left join account d on d.accountid=t.foh 
			left join account h on h.accountid=t.acckoreksi
			left join account g on g.accountid=t.acccadangan ";
		$slocaccid = filter_input(INPUT_GET,'slocaccid');
		$sloccode = filter_input(INPUT_GET,'sloccode');
		$materialgroupname = filter_input(INPUT_GET,'materialgroupname');
		$sql .= " where coalesce(t.slocaccid,'') like '%".$slocaccid."%' 
			and coalesce(p.sloccode,'') like '%".$sloccode."%'
			and coalesce(f.description,'') like '%".$materialgroupname."%'
			";
		if ($_GET['id'] !== '') {
				$sql = $sql . " and a.slocaccid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->title=GetCatalog('slocaccounting');
		$this->pdf->AddPage('L',array(400,640));
		$this->pdf->SetFontSize(8);
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		$this->pdf->colheader = array(
		GetCatalog('sloc'),
		GetCatalog('materialgroup'),
		GetCatalog('accaktivatetap'),
		GetCatalog('accakumat'),
		GetCatalog('accbiayaat'),
		GetCatalog('accpersediaan'),
		GetCatalog('accreturpembelian'),
		GetCatalog('accdiscpembelian'),
		GetCatalog('accpenjualan'),
		GetCatalog('accbiaya'),
		GetCatalog('accreturpenjualan'),
		GetCatalog('accspsi'),
		GetCatalog('accexpedisi'),
		GetCatalog('hpp'),
		GetCatalog('accupahlembur'),
		GetCatalog('foh'),
		GetCatalog('acckoreksi'),
		GetCatalog('acccadangan'));
		$this->pdf->setwidths(array(30,35,35,35,35,35,35,35,35,35,35,35,35,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1) {
		  $this->pdf->row(array(
				$row1['sloccode'],
				$row1['description'],
				$row1['accaktivatetapname'],
				$row1['accakumatname'],
				$row1['accbiayaatname'],
				$row1['accpersediaanname'],
				$row1['accreturpembelianname'],
				$row1['accdiscpembelianname'],
				$row1['accpenjualanname'],
				$row1['accbiayaname'],
				$row1['accreturpenjualanname'],
				$row1['accspsiname'],
				$row1['accexpedisiname'],
				$row1['acchppname'],
				$row1['accupahlemburname'],
				$row1['accfohname'],
				$row1['acckoreksiname'],
				$row1['acccadanganname']));
		}
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$sql = "select t.slocaccid,f.description,a.accountname as accexpedisiname,b.accountname as acchppname,c.accountname as accupahlemburname,
			d.accountname as accfohname,e.accountname as accpersediaanname,p.sloccode as sloccode,q.accountname as accaktivatetapname
			,r.accountname as accakumatname,s.accountname as accbiayaatname,u.accountname as accreturpembelianname,v.accountname as accdiscpembelianname
			,w.accountname as accpenjualanname,x.accountname as accbiayaname,y.accountname as accreturpenjualanname,z.accountname as accspsiname,
            h.accountname as acckoreksiname,g.accountname as acccadanganname
				from slocaccounting t 
				left join sloc p on p.slocid = t.slocid 
				left join materialgroup f on f.materialgroupid = t.materialgroupid  
				left join account q on q.accountid=t.accaktivatetap 
				left join account r on r.accountid=t.accakumat 
				left join account s on s.accountid=t.accbiayaat 
			  left join account e on e.accountid=t.accpersediaan 
			left join account u on u.accountid=t.accreturpembelian 
			left join account v on v.accountid=t.accdiscpembelian 
			left join account w on w.accountid=t.accpenjualan 
			left join account x on x.accountid=t.accbiaya 
			left join account y on y.accountid=t.accreturpenjualan 
			left join account z on z.accountid=t.accspsi 
			left join account a on a.accountid=t.accexpedisi 
			left join account b on b.accountid=t.hpp 
			left join account c on c.accountid=t.accupahlembur 
			left join account d on d.accountid=t.foh
            left join account h on h.accountid=t.acckoreksi
			left join account g on g.accountid=t.acccadangan";
		$slocaccid = filter_input(INPUT_GET,'slocaccid');
		$sloccode = filter_input(INPUT_GET,'sloccode');
		$materialgroupname = filter_input(INPUT_GET,'materialgroupname');
		$sql .= " where coalesce(t.slocaccid,'') like '%".$slocaccid."%' 
			and coalesce(p.sloccode,'') like '%".$sloccode."%'
			and coalesce(f.description,'') like '%".$materialgroupname."%'
			";
		if ($_GET['id'] !== '') {
				$sql = $sql . " and t.slocaccid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$i=1;
		$this->phpExcel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0,1,GetCatalog('slocaccid'))
		->setCellValueByColumnAndRow(1,1,GetCatalog('sloc'))
		->setCellValueByColumnAndRow(2,1,GetCatalog('materialgroup'))
		->setCellValueByColumnAndRow(3,1,GetCatalog('accaktivatetap'))
		->setCellValueByColumnAndRow(4,1,GetCatalog('accakumat'))
		->setCellValueByColumnAndRow(5,1,GetCatalog('accbiayaat'))
		->setCellValueByColumnAndRow(6,1,GetCatalog('accpersediaan'))
		->setCellValueByColumnAndRow(7,1,GetCatalog('accreturpembelian'))
		->setCellValueByColumnAndRow(8,1,GetCatalog('accdiscpembelian'))
		->setCellValueByColumnAndRow(9,1,GetCatalog('accpenjualan'))
		->setCellValueByColumnAndRow(10,1,GetCatalog('accbiaya'))
		->setCellValueByColumnAndRow(11,1,GetCatalog('accreturpenjualan'))
		->setCellValueByColumnAndRow(12,1,GetCatalog('accspsi'))
		->setCellValueByColumnAndRow(13,1,GetCatalog('accexpedisi'))
		->setCellValueByColumnAndRow(14,1,GetCatalog('hpp'))
		->setCellValueByColumnAndRow(15,1,GetCatalog('accupahlembur'))
		->setCellValueByColumnAndRow(16,1,GetCatalog('foh'))
		->setCellValueByColumnAndRow(17,1,GetCatalog('acckoreksi'))
		->setCellValueByColumnAndRow(18,1,GetCatalog('acccadangan'));		
		foreach($dataReader as $row1) {
			  $this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['slocaccid'])
				->setCellValueByColumnAndRow(1, $i+1, $row1['sloccode'])
				->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
				->setCellValueByColumnAndRow(3, $i+1, $row1['accaktivatetapname'])
				->setCellValueByColumnAndRow(4, $i+1, $row1['accakumatname'])
				->setCellValueByColumnAndRow(5, $i+1, $row1['accbiayaatname'])
				->setCellValueByColumnAndRow(6, $i+1, $row1['accpersediaanname'])
				->setCellValueByColumnAndRow(7, $i+1, $row1['accreturpembelianname'])
				->setCellValueByColumnAndRow(8, $i+1, $row1['accdiscpembelianname'])
				->setCellValueByColumnAndRow(9, $i+1, $row1['accpenjualanname'])
				->setCellValueByColumnAndRow(10, $i+1, $row1['accbiayaname'])
				->setCellValueByColumnAndRow(11, $i+1, $row1['accreturpenjualanname'])
				->setCellValueByColumnAndRow(12, $i+1, $row1['accspsiname'])
				->setCellValueByColumnAndRow(13, $i+1, $row1['accexpedisiname'])
				->setCellValueByColumnAndRow(14, $i+1, $row1['acchppname'])
				->setCellValueByColumnAndRow(15, $i+1, $row1['accupahlemburname'])
				->setCellValueByColumnAndRow(16, $i+1, $row1['accfohname'])
				->setCellValueByColumnAndRow(17, $i+1, $row1['acckoreksiname'])
				->setCellValueByColumnAndRow(18, $i+1, $row1['acccadanganname'])
				;		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}