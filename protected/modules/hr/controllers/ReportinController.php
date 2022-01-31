<?php

class ReportinController extends AdminController
{
	protected $menuname = 'reportin';
	public $module = 'Hr';
	protected $pageTitle = 'Laporan Absensi Masuk';
	public $wfname = '';
	protected $sqldata = "select a0.reportinid,a0.employeeid,a0.fullname,a0.oldnik,a0.fulldivision,a0.month,a0.year,a0.s1,a0.d1,a0.s2,a0.d2,a0.s3,a0.d3,a0.s4,a0.d4,a0.s5,a0.d5,a0.s6,a0.d6,a0.s7,a0.d7,a0.s8,a0.d8,a0.s9,a0.d9,a0.s10,a0.d10,a0.s11,a0.d11,a0.s12,a0.d12,a0.s13,a0.d13,a0.s14,a0.d14,a0.s15,a0.d15,a0.s16,a0.d16,a0.s17,a0.d17,a0.s18,a0.d18,a0.s19,a0.d19,a0.s20,a0.d20,a0.s21,a0.d21,a0.s22,a0.d22,a0.s23,a0.d23,a0.s24,a0.d24,a0.s25,a0.d25,a0.s26,a0.d26,a0.s27,a0.d27,a0.s28,a0.d28,a0.s29,a0.d29,a0.s30,a0.d30,a0.s31,a0.d31 
    from reportin a0 
  ";
  protected $sqlcount = "select count(1) 
    from reportin a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['fullname'])) && (isset($_REQUEST['oldnik'])) && (isset($_REQUEST['fulldivision'])) && (isset($_REQUEST['month'])) && (isset($_REQUEST['year'])))
		{				
			$where .= " where a0.fullname like '%". $_REQUEST['fullname']."%' 
and a0.oldnik like '%". $_REQUEST['oldnik']."%' 
and a0.fulldivision like '%". $_REQUEST['fulldivision']."%'
and a0.month like '%". $_REQUEST['month']."%'
and a0.year like '%". $_REQUEST['year']."%'"; 
		}
		if (isset($_REQUEST['reportinid']))
			{
				if (($_REQUEST['reportinid'] !== '0') && ($_REQUEST['reportinid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.reportinid in (".$_REQUEST['reportinid'].")";
					}
					else
					{
						$where .= " and a0.reportinid in (".$_REQUEST['reportinid'].")";
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
			'keyField'=>'reportinid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'reportinid','employeeid','fullname','oldnik','fulldivision','month','year','s1','d1','s2','d2','s3','d3','s4','d4','s5','d5','s6','d6','s7','d7','s8','d8','s9','d9','s10','d10','s11','d11','s12','d12','s13','d13','s14','d14','s15','d15','s16','d16','s17','d17','s18','d18','s19','d19','s20','d20','s21','d21','s22','d22','s23','d23','s24','d24','s25','d25','s26','d26','s27','d27','s28','d28','s29','d29','s30','d30','s31','d31'
				),
				'defaultOrder' => array( 
					'reportinid' => CSort::SORT_DESC
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
		$this->pdf->title=getCatalog('reportin');
		$this->pdf->AddPage('L',array(450,935));
		//masukkan posisi judul
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		//masukkan colom judul
		$this->pdf->colheader = array(getCatalog('employeeid'),
                                getCatalog('fullname'),
                                getCatalog('oldnik'),
                                getCatalog('fulldivision'),
                                getCatalog('month'),
                                getCatalog('year'),
                                getCatalog('s1'),
                                getCatalog('d1'),
                                getCatalog('s2'),
                                getCatalog('d2'),
                                getCatalog('s3'),
                                getCatalog('d3'),
                                getCatalog('s4'),
                                getCatalog('d4'),
                                getCatalog('s5'),
                                getCatalog('d5'),
                                getCatalog('s6'),
                                getCatalog('d6'),
                                getCatalog('s7'),
                                getCatalog('d7'),
                                getCatalog('s8'),
                                getCatalog('d8'),
                                getCatalog('s9'),
                                getCatalog('d9'),
                                getCatalog('s10'),
                                getCatalog('d10'),
                                getCatalog('s11'),
                                getCatalog('d11'),
                                getCatalog('s12'),
                                getCatalog('d12'),
                                getCatalog('s13'),
                                getCatalog('d13'),
                                getCatalog('s14'),
                                getCatalog('d14'),
                                getCatalog('s15'),
                                getCatalog('d15'),
                                getCatalog('s16'),
                                getCatalog('d16'),
                                getCatalog('s17'),
                                getCatalog('d17'),
                                getCatalog('s18'),
                                getCatalog('d18'),
                                getCatalog('s19'),
                                getCatalog('d19'),
                                getCatalog('s20'),
                                getCatalog('d20'),
                                getCatalog('s21'),
                                getCatalog('d21'),
                                getCatalog('s22'),
                                getCatalog('d22'),
                                getCatalog('s23'),
                                getCatalog('d23'),
                                getCatalog('s24'),
                                getCatalog('d24'),
                                getCatalog('s25'),
                                getCatalog('d25'),
                                getCatalog('s26'),
                                getCatalog('d26'),
                                getCatalog('s27'),
                                getCatalog('d27'),
                                getCatalog('s28'),
                                getCatalog('d28'),
                                getCatalog('s29'),
                                getCatalog('d29'),
                                getCatalog('s30'),
                                getCatalog('d30'),
                                getCatalog('s31'),
                                getCatalog('d31'));
		$this->pdf->setwidths(array(10,90,26,90,9,12,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,9,13,7));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['employeeid'],$row1['fullname'],$row1['oldnik'],$row1['fulldivision'],$row1['month'],$row1['year'],$row1['s1'],$row1['d1'],$row1['s2'],$row1['d2'],$row1['s3'],$row1['d3'],$row1['s4'],$row1['d4'],$row1['s5'],$row1['d5'],$row1['s6'],$row1['d6'],$row1['s7'],$row1['d7'],$row1['s8'],$row1['d8'],$row1['s9'],$row1['d9'],$row1['s10'],$row1['d10'],$row1['s11'],$row1['d11'],$row1['s12'],$row1['d12'],$row1['s13'],$row1['d13'],$row1['s14'],$row1['d14'],$row1['s15'],$row1['d15'],$row1['s16'],$row1['d16'],$row1['s17'],$row1['d17'],$row1['s18'],$row1['d18'],$row1['s19'],$row1['d19'],$row1['s20'],$row1['d20'],$row1['s21'],$row1['d21'],$row1['s22'],$row1['d22'],$row1['s23'],$row1['d23'],$row1['s24'],$row1['d24'],$row1['s25'],$row1['d25'],$row1['s26'],$row1['d26'],$row1['s27'],$row1['d27'],$row1['s28'],$row1['d28'],$row1['s29'],$row1['d29'],$row1['s30'],$row1['d30'],$row1['s31'],$row1['d31']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
        $this->menuname = 'reportin';
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
->setCellValueByColumnAndRow(4,$line,getCatalog('month'))
->setCellValueByColumnAndRow(5,$line,getCatalog('year'))
->setCellValueByColumnAndRow(6,$line,getCatalog('s1'))
->setCellValueByColumnAndRow(7,$line,getCatalog('d1'))
->setCellValueByColumnAndRow(8,$line,getCatalog('s2'))
->setCellValueByColumnAndRow(9,$line,getCatalog('d2'))
->setCellValueByColumnAndRow(10,$line,getCatalog('s3'))
->setCellValueByColumnAndRow(11,$line,getCatalog('d3'))
->setCellValueByColumnAndRow(12,$line,getCatalog('s4'))
->setCellValueByColumnAndRow(13,$line,getCatalog('d4'))
->setCellValueByColumnAndRow(14,$line,getCatalog('s5'))
->setCellValueByColumnAndRow(15,$line,getCatalog('d5'))
->setCellValueByColumnAndRow(16,$line,getCatalog('s6'))
->setCellValueByColumnAndRow(17,$line,getCatalog('d6'))
->setCellValueByColumnAndRow(18,$line,getCatalog('s7'))
->setCellValueByColumnAndRow(19,$line,getCatalog('d7'))
->setCellValueByColumnAndRow(20,$line,getCatalog('s8'))
->setCellValueByColumnAndRow(21,$line,getCatalog('d8'))
->setCellValueByColumnAndRow(22,$line,getCatalog('s9'))
->setCellValueByColumnAndRow(23,$line,getCatalog('d9'))
->setCellValueByColumnAndRow(24,$line,getCatalog('s10'))
->setCellValueByColumnAndRow(25,$line,getCatalog('d10'))
->setCellValueByColumnAndRow(26,$line,getCatalog('s11'))
->setCellValueByColumnAndRow(27,$line,getCatalog('d11'))
->setCellValueByColumnAndRow(28,$line,getCatalog('s12'))
->setCellValueByColumnAndRow(29,$line,getCatalog('d12'))
->setCellValueByColumnAndRow(30,$line,getCatalog('s13'))
->setCellValueByColumnAndRow(31,$line,getCatalog('d13'))
->setCellValueByColumnAndRow(32,$line,getCatalog('s14'))
->setCellValueByColumnAndRow(33,$line,getCatalog('d14'))
->setCellValueByColumnAndRow(34,$line,getCatalog('s15'))
->setCellValueByColumnAndRow(35,$line,getCatalog('d15'))
->setCellValueByColumnAndRow(36,$line,getCatalog('s16'))
->setCellValueByColumnAndRow(37,$line,getCatalog('d16'))
->setCellValueByColumnAndRow(38,$line,getCatalog('s17'))
->setCellValueByColumnAndRow(39,$line,getCatalog('d17'))
->setCellValueByColumnAndRow(40,$line,getCatalog('s18'))
->setCellValueByColumnAndRow(41,$line,getCatalog('d18'))
->setCellValueByColumnAndRow(42,$line,getCatalog('s19'))
->setCellValueByColumnAndRow(43,$line,getCatalog('d19'))
->setCellValueByColumnAndRow(44,$line,getCatalog('s20'))
->setCellValueByColumnAndRow(45,$line,getCatalog('d20'))
->setCellValueByColumnAndRow(46,$line,getCatalog('s21'))
->setCellValueByColumnAndRow(47,$line,getCatalog('d21'))
->setCellValueByColumnAndRow(48,$line,getCatalog('s22'))
->setCellValueByColumnAndRow(49,$line,getCatalog('d22'))
->setCellValueByColumnAndRow(50,$line,getCatalog('s23'))
->setCellValueByColumnAndRow(51,$line,getCatalog('d23'))
->setCellValueByColumnAndRow(52,$line,getCatalog('s24'))
->setCellValueByColumnAndRow(53,$line,getCatalog('d24'))
->setCellValueByColumnAndRow(54,$line,getCatalog('s25'))
->setCellValueByColumnAndRow(55,$line,getCatalog('d25'))
->setCellValueByColumnAndRow(56,$line,getCatalog('s26'))
->setCellValueByColumnAndRow(57,$line,getCatalog('d26'))
->setCellValueByColumnAndRow(58,$line,getCatalog('s27'))
->setCellValueByColumnAndRow(59,$line,getCatalog('d27'))
->setCellValueByColumnAndRow(60,$line,getCatalog('s28'))
->setCellValueByColumnAndRow(61,$line,getCatalog('d28'))
->setCellValueByColumnAndRow(62,$line,getCatalog('s29'))
->setCellValueByColumnAndRow(63,$line,getCatalog('d29'))
->setCellValueByColumnAndRow(64,$line,getCatalog('s30'))
->setCellValueByColumnAndRow(65,$line,getCatalog('d30'))
->setCellValueByColumnAndRow(66,$line,getCatalog('s31'))
->setCellValueByColumnAndRow(67,$line,getCatalog('d31'))
;
        $line++;
        foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $line, $row1['employeeid'])
->setCellValueByColumnAndRow(1, $line, $row1['fullname'])
->setCellValueByColumnAndRow(2, $line, $row1['oldnik'])
->setCellValueByColumnAndRow(3, $line, $row1['fulldivision'])
->setCellValueByColumnAndRow(4, $line, $row1['month'])
->setCellValueByColumnAndRow(5, $line, $row1['year'])
->setCellValueByColumnAndRow(6, $line, $row1['s1'])
->setCellValueByColumnAndRow(7, $line, $row1['d1'])
->setCellValueByColumnAndRow(8, $line, $row1['s2'])
->setCellValueByColumnAndRow(9, $line, $row1['d2'])
->setCellValueByColumnAndRow(10, $line, $row1['s3'])
->setCellValueByColumnAndRow(11, $line, $row1['d3'])
->setCellValueByColumnAndRow(12, $line, $row1['s4'])
->setCellValueByColumnAndRow(13, $line, $row1['d4'])
->setCellValueByColumnAndRow(14, $line, $row1['s5'])
->setCellValueByColumnAndRow(15, $line, $row1['d5'])
->setCellValueByColumnAndRow(16, $line, $row1['s6'])
->setCellValueByColumnAndRow(17, $line, $row1['d6'])
->setCellValueByColumnAndRow(18, $line, $row1['s7'])
->setCellValueByColumnAndRow(19, $line, $row1['d7'])
->setCellValueByColumnAndRow(20, $line, $row1['s8'])
->setCellValueByColumnAndRow(21, $line, $row1['d8'])
->setCellValueByColumnAndRow(22, $line, $row1['s9'])
->setCellValueByColumnAndRow(23, $line, $row1['d9'])
->setCellValueByColumnAndRow(24, $line, $row1['s10'])
->setCellValueByColumnAndRow(25, $line, $row1['d10'])
->setCellValueByColumnAndRow(26, $line, $row1['s11'])
->setCellValueByColumnAndRow(27, $line, $row1['d11'])
->setCellValueByColumnAndRow(28, $line, $row1['s12'])
->setCellValueByColumnAndRow(29, $line, $row1['d12'])
->setCellValueByColumnAndRow(30, $line, $row1['s13'])
->setCellValueByColumnAndRow(31, $line, $row1['d13'])
->setCellValueByColumnAndRow(32, $line, $row1['s14'])
->setCellValueByColumnAndRow(33, $line, $row1['d14'])
->setCellValueByColumnAndRow(34, $line, $row1['s15'])
->setCellValueByColumnAndRow(35, $line, $row1['d15'])
->setCellValueByColumnAndRow(36, $line, $row1['s16'])
->setCellValueByColumnAndRow(37, $line, $row1['d16'])
->setCellValueByColumnAndRow(38, $line, $row1['s17'])
->setCellValueByColumnAndRow(39, $line, $row1['d17'])
->setCellValueByColumnAndRow(40, $line, $row1['s18'])
->setCellValueByColumnAndRow(41, $line, $row1['d18'])
->setCellValueByColumnAndRow(42, $line, $row1['s19'])
->setCellValueByColumnAndRow(43, $line, $row1['d19'])
->setCellValueByColumnAndRow(44, $line, $row1['s20'])
->setCellValueByColumnAndRow(45, $line, $row1['d20'])
->setCellValueByColumnAndRow(46, $line, $row1['s21'])
->setCellValueByColumnAndRow(47, $line, $row1['d21'])
->setCellValueByColumnAndRow(48, $line, $row1['s22'])
->setCellValueByColumnAndRow(49, $line, $row1['d22'])
->setCellValueByColumnAndRow(50, $line, $row1['s23'])
->setCellValueByColumnAndRow(51, $line, $row1['d23'])
->setCellValueByColumnAndRow(52, $line, $row1['s24'])
->setCellValueByColumnAndRow(53, $line, $row1['d24'])
->setCellValueByColumnAndRow(54, $line, $row1['s25'])
->setCellValueByColumnAndRow(55, $line, $row1['d25'])
->setCellValueByColumnAndRow(56, $line, $row1['s26'])
->setCellValueByColumnAndRow(57, $line, $row1['d26'])
->setCellValueByColumnAndRow(58, $line, $row1['s27'])
->setCellValueByColumnAndRow(59, $line, $row1['d27'])
->setCellValueByColumnAndRow(60, $line, $row1['s28'])
->setCellValueByColumnAndRow(61, $line, $row1['d28'])
->setCellValueByColumnAndRow(62, $line, $row1['s29'])
->setCellValueByColumnAndRow(63, $line, $row1['d29'])
->setCellValueByColumnAndRow(64, $line, $row1['s30'])
->setCellValueByColumnAndRow(65, $line, $row1['d30'])
->setCellValueByColumnAndRow(66, $line, $row1['s31'])
->setCellValueByColumnAndRow(67, $line, $row1['d31'])
;		$i+=1;
        $line++;
		}
		/*header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="reportin.xlsx"');
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
		unset($excel);*/
        $this->getFooterXLS($this->phpExcel);
	}
}