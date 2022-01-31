<?php

class ProductplantController extends AdminController
{
	protected $menuname = 'productplant';
	public $module = 'Common';
	protected $pageTitle = 'Material / Service Data Gudang';
	public $wfname = '';
	protected $sqldata = "select a0.productplantid,a0.productid,a0.slocid,a0.unitofissue,a0.isautolot,a0.sled,a0.snroid,a0.materialgroupid,a0.issource,a0.recordstatus,a1.productname as productname,a2.sloccode as sloccode,a3.uomcode as uomcode,a4.materialgroupcode as materialgroupcode, a5.description as snro, a6.description as mgprocess,a0.mgprocessid
    from productplant a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofissue
    left join materialgroup a4 on a4.materialgroupid = a0.materialgroupid
    left join snro a5 on a5.snroid = a0.snroid
    left join mgprocess a6 on a6.mgprocessid = a0.mgprocessid
  ";
  protected $sqlcount = "select count(1) 
    from productplant a0 
    left join product a1 on a1.productid = a0.productid
    left join sloc a2 on a2.slocid = a0.slocid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofissue
    left join materialgroup a4 on a4.materialgroupid = a0.materialgroupid
    left join snro a5 on a5.snroid = a0.snroid
    left join mgprocess a6 on a6.mgprocessid = a0.mgprocessid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['materialgroupcode'])))
		{				
			$where .= " where a1.productname like '%". $_REQUEST['productname']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%' 
and a3.uomcode like '%". $_REQUEST['uomcode']."%' 
and a4.materialgroupcode like '%". $_REQUEST['materialgroupcode']."%'"; 
		}
		if (isset($_REQUEST['productplantid']))
			{
				if (($_REQUEST['productplantid'] !== '0') && ($_REQUEST['productplantid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productplantid in (".$_REQUEST['productplantid'].")";
					}
					else
					{
						$where .= " and a0.productplantid in (".$_REQUEST['productplantid'].")";
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
			'keyField'=>'productplantid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productplantid','productid','slocid','unitofissue','isautolot','sled','snroid','materialgroupid','mgprocessid','issource','recordstatus'
				),
				'defaultOrder' => array( 
					'productplantid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	
	public function actiongetproductplant()
	{
		$uomid = '';
		$uomcode = '';
		$slocid = '';
		$sloccode = '';
		$cmd = null;
		$bomid = '';
		$bomversion = '';
		$companyid = isset($_REQUEST['companyid'])?$_REQUEST['companyid']:"null";
		$slocid = isset($_REQUEST['slocid'])?$_REQUEST['slocid']:"null";
		
		if(isset($_REQUEST['productid']) && (isset($_REQUEST['companyid'])) && (isset($_REQUEST['type']) && $_REQUEST['type']=='soheader')){
            if($_REQUEST['companyid']==0) {
                $companyid = getUserObjectWfValues('company','appso');
            }
            $cmd = Yii::app()->db->createCommand("
				select t.unitofissue,d.uomcode,a.sloccode,a.slocid 
				from productplant t 
				join unitofmeasure d on d.unitofmeasureid = t.unitofissue 
				join sloc a on a.slocid = t.slocid 
				join plant b on b.plantid = a.plantid
				join company c on c.companyid = b.companyid 
				where productid = ".$_REQUEST['productid']."
				and t.recordstatus = 1
				and t.slocid in (select gm.menuvalueid from groupaccess c
					inner join usergroup d on d.groupaccessid = c.groupaccessid
					inner join useraccess e on e.useraccessid = d.useraccessid
					inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
					inner join menuauth ma on ma.menuauthid = gm.menuauthid
					where upper(e.username)=upper('".Yii::app()->user->name."') and upper(ma.menuobject) = upper('sloc'))
					and c.companyid in (".$companyid.")
			")->queryRow();
        }
		else
		if(isset($_REQUEST['productid']) && (isset($_REQUEST['companyid'])))
	  {
			$cmd = Yii::app()->db->createCommand("
				select t.unitofissue,d.uomcode,a.sloccode,a.slocid 
				from productplant t 
				join unitofmeasure d on d.unitofmeasureid = t.unitofissue 
				join sloc a on a.slocid = t.slocid 
				join plant b on b.plantid = a.plantid
				join company c on c.companyid = b.companyid 
				where productid = ".$_REQUEST['productid']."
				and t.recordstatus = 1
				and t.issource = 1 
				and t.slocid in (select gm.menuvalueid from groupaccess c
					inner join usergroup d on d.groupaccessid = c.groupaccessid
					inner join useraccess e on e.useraccessid = d.useraccessid
					inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
					inner join menuauth ma on ma.menuauthid = gm.menuauthid
					where upper(e.username)=upper('".Yii::app()->user->name."') and upper(ma.menuobject) = upper('sloc'))
					and c.companyid = ".$companyid."
			")->queryRow();
		}
		else
		if(isset($_REQUEST['productid']) && (isset($_REQUEST['slocid'])))
		{
			$cmd = Yii::app()->db->createCommand("
				select t.unitofissue,d.uomcode,a.sloccode,a.slocid 
				from productplant t 
				join unitofmeasure d on d.unitofmeasureid = t.unitofissue 
				join sloc a on a.slocid = t.slocid 
				join plant b on b.plantid = a.plantid
				join company c on c.companyid = b.companyid 
				where productid = ".$_REQUEST['productid']."
				and t.recordstatus = 1
				and t.issource = 1 
				and t.slocid in (select gm.menuvalueid from groupaccess c
					inner join usergroup d on d.groupaccessid = c.groupaccessid
					inner join useraccess e on e.useraccessid = d.useraccessid
					inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
					inner join menuauth ma on ma.menuauthid = gm.menuauthid
					where upper(e.username)=upper('".Yii::app()->user->name."') and upper(ma.menuobject) = upper('sloc'))
					and t.slocid = ".$slocid."
			")->queryRow();
		}
		else
		if(isset($_REQUEST['productid']))
		{
			$cmd = Yii::app()->db->createCommand("
				select t.unitofissue,d.uomcode,a.sloccode,a.slocid 
				from productplant t 
				join unitofmeasure d on d.unitofmeasureid = t.unitofissue 
				join sloc a on a.slocid = t.slocid 
				join plant b on b.plantid = a.plantid
				join company c on c.companyid = b.companyid 
				where productid = ".$_REQUEST['productid']."
				and t.recordstatus = 1
				and t.issource = 1 
				and t.slocid in (select gm.menuvalueid from groupaccess c
					inner join usergroup d on d.groupaccessid = c.groupaccessid
					inner join useraccess e on e.useraccessid = d.useraccessid
					inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
					inner join menuauth ma on ma.menuauthid = gm.menuauthid
					where upper(e.username)=upper('".Yii::app()->user->name."') and upper(ma.menuobject) = upper('sloc'))
			")->queryRow();
		}
		$uomid = $cmd['unitofissue'];
		$uomcode = $cmd['uomcode'];
		$slocid = $cmd['slocid'];
		$sloccode = $cmd['sloccode'];
		
		$cmd = Yii::app()->db->createCommand()
			->select('t.bomid,t.bomversion')
			->from('billofmaterial t')
			->where("t.recordstatus = 1 and productid = ".$_POST['productid'])
			->limit(1)
			->queryRow();
		$bomid = $cmd['bomid'];
		$bomversion = $cmd['bomversion'];
		if (Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode(array(
				'status'=>'success',
				'uomid'=> $uomid,
				'uomcode'=> $uomcode,
				'slocid'=>$slocid,
				'sloccode'=>$sloccode,
				'bomid'=>$bomid,
				'bomversion'=>$bomversion
				));
			Yii::app()->end();
		}
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productplantid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productplantid'=>$model['productplantid'],
          'productid'=>$model['productid'],
          'slocid'=>$model['slocid'],
          'unitofissue'=>$model['unitofissue'],
          'isautolot'=>$model['isautolot'],
          'sled'=>$model['sled'],
          'snroid'=>$model['snroid'],
          'snro'=>$model['snro'],
          'materialgroupid'=>$model['materialgroupid'],
          'issource'=>$model['issource'],
          'recordstatus'=>$model['recordstatus'],
          'productname'=>$model['productname'],
          'sloccode'=>$model['sloccode'],
          'uomcode'=>$model['uomcode'],
          'materialgroupcode'=>$model['materialgroupcode'],
          'mgprocessid'=>$model['mgprocessid'],
          'mgprocess'=>$model['mgprocess'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('slocid','string','emptyslocid'),
      array('unitofissue','string','emptyunitofissue'),
      array('materialgroupid','string','emptymaterialgroupid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productplantid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateproductplant(:vid,:vproductid,:vslocid,:vunitofissue,:visautolot,:vsled,:vsnroid,:vmaterialgroupid,:vmgprocessid,:vrecordstatus,:vissource,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertproductplant(:vproductid,:vslocid,:vunitofissue,:visautolot,:vsled,:vsnroid,:vmaterialgroupid,:vmgprocessid,:vrecordstatus,:vissource,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['productplantid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vproductid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vslocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vunitofissue',(($_POST['unitofissue']!=='')?$_POST['unitofissue']:null),PDO::PARAM_STR);
        $command->bindvalue(':visautolot',(($_POST['isautolot']!=='')?$_POST['isautolot']:null),PDO::PARAM_STR);
        $command->bindvalue(':vsled',(($_POST['sled']!=='')?$_POST['sled']:null),PDO::PARAM_STR);
        $command->bindvalue(':vsnroid',(($_POST['snroid']!=='')?$_POST['snroid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vmaterialgroupid',(($_POST['materialgroupid']!=='')?$_POST['materialgroupid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vmgprocessid',(($_POST['mgprocessid']!=='')?$_POST['mgprocessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
        $command->bindvalue(':vissource',(($_POST['issource']!=='')?$_POST['issource']:null),PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
					$sql = "select recordstatus from productplant where productplantid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update productplant set recordstatus = 0 where productplantid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update productplant set recordstatus = 1 where productplantid = ".$id[$i];
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
				$sql = "delete from productplant where productplantid = ".$id[$i];
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
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('productplant');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('productplantid'),$this->getCatalog('product'),$this->getCatalog('sloc'),$this->getCatalog('unitofissue'),$this->getCatalog('isautolot'),$this->getCatalog('sled'),$this->getCatalog('snro'),$this->getCatalog('materialgroup'),$this->getCatalog('issource'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15,40,40,40,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productplantid'],$row1['productname'],$row1['sloccode'],$row1['uomcode'],$row1['isautolot'],$row1['sled'],$row1['snroid'],$row1['materialgroupcode'],$row1['issource'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productplantid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('isautolot'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('sled'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('snroid'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('materialgroupcode'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('issource'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productplantid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['isautolot'])
->setCellValueByColumnAndRow(5, $i+1, $row1['sled'])
->setCellValueByColumnAndRow(6, $i+1, $row1['snroid'])
->setCellValueByColumnAndRow(7, $i+1, $row1['materialgroupcode'])
->setCellValueByColumnAndRow(8, $i+1, $row1['issource'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}