<?php

class ReportperdayController extends AdminController
{
	protected $menuname = 'reportperday';
	public $module = 'Hr';
	protected $pageTitle = 'Laporan Absensi Harian';
	public $wfname = '';
	protected $sqldata = "select a0.reportperdayid,a0.employeeid,a0.fullname,a0.oldnik,a0.fulldivision,a0.absdate,a0.hourin,a0.hourout,a0.absscheduleid,a0.schedulename,a0.statusin,a0.statusout,a0.reason 
    from reportperday a0
    ";
    
    protected $sqlcount = "select count(1) 
    from reportperday a0
    ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['fullname'])) && (isset($_REQUEST['oldnik'])) && (isset($_REQUEST['fulldivision'])) && (isset($_REQUEST['absdate'])))
		{				
			$where .= " where a0.fullname like '%". $_REQUEST['fullname']."%' 
                        and a0.oldnik like '%". $_REQUEST['oldnik']."%' 
                        and a0.fulldivision like '%". $_REQUEST['fulldivision']."%'
                        and a0.absdate like '%". $_REQUEST['absdate']."%'"; 
		}
		if (isset($_REQUEST['reportperdayid']))
			{
				if (($_REQUEST['reportperdayid'] != 0) && ($_REQUEST['reportperdayid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.reportperdayid in (".$_REQUEST['reportperdayid'].")";
					}
					else
					{
						$where .= " and a0.reportperdayid in (".$_REQUEST['reportperdayid'].")";
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
			'keyField'=>'reportperdayid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'reportperdayid','employeeid','fullname','oldnik','fulldivision','absdate','hourin','hourout','schedulename','statusin','statusout','reason',
				),
				'defaultOrder' => array( 
					'reportperdayid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=getCatalog('reportperday');
		$this->pdf->AddPage('L');
        $this->pdf->setFont('Arial','',9);
		//masukkan posisi judul
        $this->pdf->setwidths(array(40,25,40,25,15,15,30,15,15,60));
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L');
		//masukkan colom judul
		$this->pdf->colheader = array(
                    getCatalog('fullname'),
                    getCatalog('oldnik'),
                    getCatalog('fulldivision'),
                    getCatalog('absdate'),
                    getCatalog('hourin'),
                    getCatalog('hourout'),
                    getCatalog('schedulename'),
                    getCatalog('statusin'),
                    getCatalog('statusout'),
                    getCatalog('reason'));
		//$this->pdf->setwidths(array(40,40,40,40,40,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['fullname'],$row1['oldnik'],$row1['fulldivision'],$row1['absdate'],$row1['hourin'],$row1['hourout'],$row1['schedulename'],$row1['statusin'],$row1['statusout'],$row1['reason']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
        $this->menuname = 'reportperday';
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=1;
        $line=2;
		$this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0,$line,getCatalog('employeeid'))
                ->setCellValueByColumnAndRow(1,$line,getCatalog('fullname'))
                ->setCellValueByColumnAndRow(2,$line,getCatalog('oldnik'))
                ->setCellValueByColumnAndRow(3,$line,getCatalog('fulldivision'))
                ->setCellValueByColumnAndRow(4,$line,getCatalog('absdate'))
                ->setCellValueByColumnAndRow(5,$line,getCatalog('hourin'))
                ->setCellValueByColumnAndRow(6,$line,getCatalog('hourout'))
                ->setCellValueByColumnAndRow(7,$line,getCatalog('schedulename'))
                ->setCellValueByColumnAndRow(8,$line,getCatalog('statusin'))
                ->setCellValueByColumnAndRow(9,$line,getCatalog('statusout'))
                ->setCellValueByColumnAndRow(10,$line,getCatalog('reason'));		
        $line++;
        foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $line, $row1['employeeid'])
                    ->setCellValueByColumnAndRow(1, $line, $row1['fullname'])
                    ->setCellValueByColumnAndRow(2, $line, $row1['oldnik'])
                    ->setCellValueByColumnAndRow(3, $line, $row1['fulldivision'])
                    ->setCellValueByColumnAndRow(4, $line, $row1['absdate'])
                    ->setCellValueByColumnAndRow(5, $line, $row1['hourin'])
                    ->setCellValueByColumnAndRow(6, $line, $row1['hourout'])
                    ->setCellValueByColumnAndRow(7, $line, $row1['schedulename'])
                    ->setCellValueByColumnAndRow(8, $line, $row1['statusin'])
                    ->setCellValueByColumnAndRow(9, $line, $row1['statusout'])
                    ->setCellValueByColumnAndRow(10, $line, $row1['reason']);		
            $i+=1;
            $line++;
		}
        /*
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="reportperday.xlsx"');
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
        */
        $this->getFooterXLS($this->phpExcel);
	}
}