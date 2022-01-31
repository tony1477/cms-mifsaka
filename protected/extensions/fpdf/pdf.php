<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('application.extensions.fpdf.*');
define('FPDF_FONTPATH', 'font/');
require_once("fpdf.php");

class PDF extends fpdf
{
  public $title='';
  public $subtitle='';
  public $isheader=true;
  public $iscustomborder=false;
  public $isneedpage=false;
	public $isfooter = true;
  public $colheader;
  public $colalign;
  public $coldetailalign;
  public $companyid = 1;
	public $rowstyles = array();
  var $widths;
  var $aligns;
  var $border = true;
  var $bordercell;
	    var $legends;
    var $wLegend;
    var $sum;
    var $NbVal;
	//barcode code128
	protected $T128;                                         // Tableau des codes 128
	protected $ABCset = "";                                  // jeu des caractères éligibles au C128
	protected $Aset = "";                                    // Set A du jeu des caractères éligibles
	protected $Bset = "";                                    // Set B du jeu des caractères éligibles
	protected $Cset = "";                                    // Set C du jeu des caractères éligibles
	protected $SetFrom;                                      // Convertisseur source des jeux vers le tableau
	protected $SetTo;                                        // Convertisseur destination des jeux vers le tableau
	protected $JStart = array("A"=>103, "B"=>104, "C"=>105); // Caractères de sélection de jeu au début du C128
	protected $JSwap = array("A"=>101, "B"=>100, "C"=>99);   // Caractères de changement de jeu
	//end of property code 128
	
	//barcode code128
	function __construct($orientation='P', $unit='mm', $format='A4') {
		parent::__construct($orientation,$unit,$format);
		//start initial code128
		$this->T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]               // composition des caractères
		$this->T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
		$this->T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
		$this->T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
		$this->T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
		$this->T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
		$this->T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
		$this->T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
		$this->T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
		$this->T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
		$this->T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
		$this->T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
		$this->T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
		$this->T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
		$this->T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
		$this->T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
		$this->T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
		$this->T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
		$this->T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
		$this->T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
		$this->T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
		$this->T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
		$this->T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
		$this->T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
		$this->T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
		$this->T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
		$this->T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
		$this->T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
		$this->T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
		$this->T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
		$this->T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
		$this->T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
		$this->T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
		$this->T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
		$this->T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
		$this->T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
		$this->T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
		$this->T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
		$this->T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
		$this->T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
		$this->T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
		$this->T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
		$this->T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
		$this->T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
		$this->T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
		$this->T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
		$this->T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
		$this->T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
		$this->T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
		$this->T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
		$this->T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
		$this->T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
		$this->T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
		$this->T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
		$this->T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
		$this->T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
		$this->T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
		$this->T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
		$this->T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
		$this->T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
		$this->T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
		$this->T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
		$this->T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
		$this->T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
		$this->T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
		$this->T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
		$this->T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
		$this->T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
		$this->T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
		$this->T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
		$this->T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
		$this->T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
		$this->T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
		$this->T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
		$this->T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
		$this->T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
		$this->T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
		$this->T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
		$this->T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
		$this->T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
		$this->T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
		$this->T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
		$this->T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
		$this->T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
		$this->T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
		$this->T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
		$this->T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
		$this->T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
		$this->T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
		$this->T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
		$this->T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
		$this->T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
		$this->T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
		$this->T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
		$this->T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
		$this->T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
		$this->T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
		$this->T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
		$this->T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
		$this->T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
		$this->T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]                
		$this->T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
		$this->T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
		$this->T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
		$this->T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
		$this->T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
		$this->T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
		$this->T128[] = array(2, 1);                       //107 : [END BAR]

		for ($i = 32; $i <= 95; $i++) {                                            // jeux de caractères
			$this->ABCset .= chr($i);
		}
		$this->Aset = $this->ABCset;
		$this->Bset = $this->ABCset;
		
		for ($i = 0; $i <= 31; $i++) {
			$this->ABCset .= chr($i);
			$this->Aset .= chr($i);
		}
		for ($i = 96; $i <= 127; $i++) {
			$this->ABCset .= chr($i);
			$this->Bset .= chr($i);
		}
		for ($i = 200; $i <= 210; $i++) {                                           // controle 128
			$this->ABCset .= chr($i);
			$this->Aset .= chr($i);
			$this->Bset .= chr($i);
		}
		$this->Cset="0123456789".chr(206);

		for ($i=0; $i<96; $i++) {                                                   // convertisseurs des jeux A & B
			@$this->SetFrom["A"] .= chr($i);
			@$this->SetFrom["B"] .= chr($i + 32);
			@$this->SetTo["A"] .= chr(($i < 32) ? $i+64 : $i-32);
			@$this->SetTo["B"] .= chr($i);
		}
		for ($i=96; $i<107; $i++) {                                                 // contrôle des jeux A & B
			@$this->SetFrom["A"] .= chr($i + 104);
			@$this->SetFrom["B"] .= chr($i + 104);
			@$this->SetTo["A"] .= chr($i);
			@$this->SetTo["B"] .= chr($i);
		}
		// end of code 128
	}
	public function Code128($x, $y, $code, $w, $h) {
		$Aguid = "";                                                                      // Création des guides de choix ABC
		$Bguid = "";
		$Cguid = "";
		for ($i=0; $i < strlen($code); $i++) {
			$needle = substr($code,$i,1);
			$Aguid .= ((strpos($this->Aset,$needle)===false) ? "N" : "O"); 
			$Bguid .= ((strpos($this->Bset,$needle)===false) ? "N" : "O"); 
			$Cguid .= ((strpos($this->Cset,$needle)===false) ? "N" : "O");
		}

		$SminiC = "OOOO";
		$IminiC = 4;

		$crypt = "";
		while ($code > "") {
																																											// BOUCLE PRINCIPALE DE CODAGE
			$i = strpos($Cguid,$SminiC);                                                // forçage du jeu C, si possible
			if ($i!==false) {
				$Aguid [$i] = "N";
				$Bguid [$i] = "N";
			}

			if (substr($Cguid,0,$IminiC) == $SminiC) {                                  // jeu C
				$crypt .= chr(($crypt > "") ? $this->JSwap["C"] : $this->JStart["C"]);  // début Cstart, sinon Cswap
				$made = strpos($Cguid,"N");                                             // étendu du set C
				if ($made === false) {
					$made = strlen($Cguid);
				}
				if (fmod($made,2)==1) {
					$made--;                                                            // seulement un nombre pair
				}
				for ($i=0; $i < $made; $i += 2) {
					$crypt .= chr(strval(substr($code,$i,2)));                          // conversion 2 par 2
				}
				$jeu = "C";
			} else {
				$madeA = strpos($Aguid,"N");                                            // étendu du set A
				if ($madeA === false) {
					$madeA = strlen($Aguid);
				}
				$madeB = strpos($Bguid,"N");                                            // étendu du set B
				if ($madeB === false) {
					$madeB = strlen($Bguid);
				}
				$made = (($madeA < $madeB) ? $madeB : $madeA );                         // étendu traitée
				$jeu = (($madeA < $madeB) ? "B" : "A" );                                // Jeu en cours

				$crypt .= chr(($crypt > "") ? $this->JSwap[$jeu] : $this->JStart[$jeu]); // début start, sinon swap

				$crypt .= strtr(substr($code, 0,$made), $this->SetFrom[$jeu], $this->SetTo[$jeu]); // conversion selon jeu

			}
			$code = substr($code,$made);                                           // raccourcir légende et guides de la zone traitée
			$Aguid = substr($Aguid,$made);
			$Bguid = substr($Bguid,$made);
			$Cguid = substr($Cguid,$made);
		}                                                                          // FIN BOUCLE PRINCIPALE

		$check = ord($crypt[0]);                                                   // calcul de la somme de contrôle
		for ($i=0; $i<strlen($crypt); $i++) {
			$check += (ord($crypt[$i]) * $i);
		}
		$check %= 103;

		$crypt .= chr($check) . chr(106) . chr(107);                               // Chaine cryptée complète

		$i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
		$modul = $w/$i;

		for ($i=0; $i<strlen($crypt); $i++) {                                      // BOUCLE D'IMPRESSION
			$c = $this->T128[ord($crypt[$i])];
			for ($j=0; $j<count($c); $j++) {
				$this->Rect($x,$y,$c[$j]*$modul,$h,"F");
				$x += ($c[$j++]+$c[$j])*$modul;
			}
		}
	}
	//end of code128
	
	//barcode ean13
	function EAN13($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->BarcodeEan13($x,$y,$barcode,$h,$w,13);
	}

	function UPC_A($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->BarcodeEan13($x,$y,$barcode,$h,$w,12);
	}

	function GetCheckDigit($barcode)
	{
		//Compute the check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		$r=$sum%10;
		if($r>0)
			$r=10-$r;
		return $r;
	}

	function TestCheckDigit($barcode)
	{
		//Test validity of check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		return ($sum+$barcode[12])%10==0;
	}

	function BarcodeEan13($x, $y, $barcode, $h, $w, $len)
	{
		//Padding
		$barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
		if($len==12)
			$barcode='0'.$barcode;
		//Add or control the check digit
		if(strlen($barcode)==12)
			$barcode.=$this->GetCheckDigit($barcode);
		elseif(!$this->TestCheckDigit($barcode))
			$this->Error('Incorrect check digit');
		//Convert digits to bars
		$codes=array(
			'A'=>array(
				'0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
				'5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
			'B'=>array(
				'0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
				'5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
			'C'=>array(
				'0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
				'5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
			);
		$parities=array(
			'0'=>array('A','A','A','A','A','A'),
			'1'=>array('A','A','B','A','B','B'),
			'2'=>array('A','A','B','B','A','B'),
			'3'=>array('A','A','B','B','B','A'),
			'4'=>array('A','B','A','A','B','B'),
			'5'=>array('A','B','B','A','A','B'),
			'6'=>array('A','B','B','B','A','A'),
			'7'=>array('A','B','A','B','A','B'),
			'8'=>array('A','B','A','B','B','A'),
			'9'=>array('A','B','B','A','B','A')
			);
		$code='101';
		$p=$parities[$barcode[0]];
		for($i=1;$i<=6;$i++)
			$code.=$codes[$p[$i-1]][$barcode[$i]];
		$code.='01010';
		for($i=7;$i<=12;$i++)
			$code.=$codes['C'][$barcode[$i]];
		$code.='101';
		//Draw bars
		for($i=0;$i<strlen($code);$i++)
		{
			if($code[$i]=='1')
				$this->Rect($x+$i*$w,$y,$w,$h,'F');
		}
		//Print text uder barcode
		$this->SetFont('Arial','',12);
		$this->Text($x+1,$y+$h+11/$this->k,substr($barcode,-$len));
	}
	// end of ean13

		function LineGraph($w, $h, $data, $options='', $colors=null, $maxVal=0, $nbDiv=4){
        /*******************************************
        Explain the variables:
        $w = the width of the diagram
        $h = the height of the diagram
        $data = the data for the diagram in the form of a multidimensional array
        $options = the possible formatting options which include:
            'V' = Print Vertical Divider lines
            'H' = Print Horizontal Divider Lines
            'kB' = Print bounding box around the Key (legend)
            'vB' = Print bounding box around the values under the graph
            'gB' = Print bounding box around the graph
            'dB' = Print bounding box around the entire diagram
        $colors = A multidimensional array containing RGB values
        $maxVal = The Maximum Value for the graph vertically
        $nbDiv = The number of vertical Divisions
        *******************************************/
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.2);
        $keys = array_keys($data);
        $ordinateWidth = 10;
        $w -= $ordinateWidth;
        $valX = $this->getX()+$ordinateWidth;
        $valY = $this->getY();
        $margin = 1;
        $titleH = 8;
        $titleW = $w;
        $lineh = 5;
        $keyH = count($data)*$lineh;
        $keyW = $w/5;
        $graphValH = 5;
        $graphValW = $w-$keyW-3*$margin;
        $graphH = $h-(3*$margin)-$graphValH;
        $graphW = $w-(2*$margin)-($keyW+$margin);
        $graphX = $valX+$margin;
        $graphY = $valY+$margin;
        $graphValX = $valX+$margin;
        $graphValY = $valY+2*$margin+$graphH;
        $keyX = $valX+(2*$margin)+$graphW;
        $keyY = $valY+$margin+.5*($h-(2*$margin))-.5*($keyH);
        //draw graph frame border
        if(strstr($options,'gB')){
            $this->Rect($valX,$valY,$w,$h);
        }
        //draw graph diagram border
        if(strstr($options,'dB')){
            $this->Rect($valX+$margin,$valY+$margin,$graphW,$graphH);
        }
        //draw key legend border
        if(strstr($options,'kB')){
            $this->Rect($keyX,$keyY,$keyW,$keyH);
        }
        //draw graph value box
        if(strstr($options,'vB')){
            $this->Rect($graphValX,$graphValY,$graphValW,$graphValH);
        }
        //define colors
        if($colors===null){
            $safeColors = array(0,51,102,153,204,225);
            for($i=0;$i<count($data);$i++){
                $colors[$keys[$i]] = array($safeColors[array_rand($safeColors)],$safeColors[array_rand($safeColors)],$safeColors[array_rand($safeColors)]);
            }
        }
        //form an array with all data values from the multi-demensional $data array
        $ValArray = array();
        foreach($data as $key => $value){
            foreach($data[$key] as $val){
                $ValArray[]=$val;                    
            }
        }
        //define max value
        if($maxVal<ceil(max($ValArray))){
            $maxVal = ceil(max($ValArray));
        }
        //draw horizontal lines
        $vertDivH = $graphH/$nbDiv;
        if(strstr($options,'H')){
            for($i=0;$i<=$nbDiv;$i++){
                if($i<$nbDiv){
                    $this->Line($graphX,$graphY+$i*$vertDivH,$graphX+$graphW,$graphY+$i*$vertDivH);
                } else{
                    $this->Line($graphX,$graphY+$graphH,$graphX+$graphW,$graphY+$graphH);
                }
            }
        }
        //draw vertical lines
        $horiDivW = floor($graphW/(count($data[$keys[0]])-1));
        if(strstr($options,'V')){
            for($i=0;$i<=(count($data[$keys[0]])-1);$i++){
                if($i<(count($data[$keys[0]])-1)){
                    $this->Line($graphX+$i*$horiDivW,$graphY,$graphX+$i*$horiDivW,$graphY+$graphH);
                } else {
                    $this->Line($graphX+$graphW,$graphY,$graphX+$graphW,$graphY+$graphH);
                }
            }
        }
        //draw graph lines
        foreach($data as $key => $value){
            $this->setDrawColor($colors[$key][0],$colors[$key][1],$colors[$key][2]);
            $this->SetLineWidth(0.8);
            $valueKeys = array_keys($value);
            for($i=0;$i<count($value);$i++){
                if($i==count($value)-2){
                    $this->Line(
                        $graphX+($i*$horiDivW),
                        $graphY+$graphH-($value[$valueKeys[$i]]/$maxVal*$graphH),
                        $graphX+$graphW,
                        $graphY+$graphH-($value[$valueKeys[$i+1]]/$maxVal*$graphH)
                    );
                } else if($i<(count($value)-1)) {
                    $this->Line(
                        $graphX+($i*$horiDivW),
                        $graphY+$graphH-($value[$valueKeys[$i]]/$maxVal*$graphH),
                        $graphX+($i+1)*$horiDivW,
                        $graphY+$graphH-($value[$valueKeys[$i+1]]/$maxVal*$graphH)
                    );
                }
            }
            //Set the Key (legend)
            $this->SetFont('Courier','',10);
            if(!isset($n))$n=0;
            $this->Line($keyX+1,$keyY+$lineh/2+$n*$lineh,$keyX+8,$keyY+$lineh/2+$n*$lineh);
            $this->SetXY($keyX+8,$keyY+$n*$lineh);
            $this->Cell($keyW,$lineh,$key,0,1,'L');
            $n++;
        }
        //print the abscissa values
        foreach($valueKeys as $key => $value){
            if($key==0){
                $this->SetXY($graphValX,$graphValY);
                $this->Cell(30,$lineh,$value,0,0,'L');
            } else if($key==count($valueKeys)-1){
                $this->SetXY($graphValX+$graphValW-30,$graphValY);
                $this->Cell(30,$lineh,$value,0,0,'R');
            } else {
                $this->SetXY($graphValX+$key*$horiDivW-15,$graphValY);
                $this->Cell(30,$lineh,$value,0,0,'C');
            }
        }
        //print the ordinate values
        for($i=0;$i<=$nbDiv;$i++){
            $this->SetXY($graphValX-10,$graphY+($nbDiv-$i)*$vertDivH-3);
            $this->Cell(8,6,sprintf('%.1f',$maxVal/$nbDiv*$i),0,0,'R');
        }
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.2);
    }
		
    function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(155, 155, 155);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
				if ($maxVal > 0)
				{
					$unit = $lDiag / $maxVal;
				}
				else
				{
					$unit = 0;
				}	
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);
        $this->SetFillColor($color[0], $color[1], $color[2]);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i], 0, 0, 'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }

    function SetLegends($data, $format)
    {
        $this->legends=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
					if ($this->sum > 0)
					{
            $p=sprintf('%.2f', $val/$this->sum*100).'%';						
					}
					else
					{
            $p=sprintf('%.2f', 0).'%';						
					}
            $legend=str_replace(array('%l', '%v', '%p'), array($l, $val, $p), $format);
            $this->legends[]=$legend;
            $this->wLegend=max($this->GetStringWidth($legend), $this->wLegend);
        }
    }


  function SetWidths($w)
  {
      //Set the array of column widths
      $this->widths=$w;
  }

  function SetAligns($a)
  {
      //Set the array of column alignments
      $this->aligns=$a;
  }

  function SetBorder($a)
  {
      //Set the array of column alignments
      $this->border=$a;
  }

    function SetBorderCell($a)
  {
      //Set the array of column alignments
      $this->bordercell=$a;
  }

  //Page header
	function Header()
	{
		/*if ($this->companyid !== '') {
			$this->companyid = 1;
		};
	  $company = Company::model()->findbysql('select * from company where companyid = '.$this->companyid);
		if ($company !== null)
		{
			if (($this->w > 280) and ($this->w < 350)) 
			{
				if ($this->isheader == true)
				{
					$this->Image('images/'.$company->leftlogofile,5,5,25);
					$this->SetFont('Arial','B',20);
					$this->Cell(0,0,$company->companyname,0,0,'C');
					$this->SetFont('Arial','',9);
					$this->Cell(-270,15,'Office: '.$company->address.' '.($company->city!==null)?$company->city->cityname:"". ' ' . $company->zipcode. ' - Indonesia',0,0,'C');
					$this->Cell(292,30,'Telp.: '.$company->phoneno.' '.$company->faxno,0,0,'C');
					$this->Cell(-275,31,'Email: '.$company->email.' Web : '.$company->webaddress,0,0,'C');
					$this->Image('images/'.$company->rightlogofile,245,5,50);
					$this->SetLineWidth(0.5);
					$this->Line(0, 35, 300, 35); 
					$this->SetFont('Arial','B',16);
					$this->cell(0);
					$this->Cell(-280,100,$this->subtitle,0,0,'C');
					$this->Cell(-280,80,$this->title,0,0,'C');
				}				
			}
			else
			if ($this->w > 350) 
			{
				if ($this->isheader == true)
				{
					$this->Image('images/'.$company->leftlogofile,5,5,25);
					$this->SetFont('Arial','B',20);
					$this->Cell(0,0,$company->companyname,0,0,'C');
					$this->SetFont('Arial','',9);
					$this->Cell(-340,15,'Office: '.$company->address.' '.($company->city!==null)?$company->city->cityname:"". ' ' . $company->zipcode. ' - Indonesia',0,0,'C');
					$this->Cell(262,23,'Telp.: '.$company->phoneno.' '.$company->faxno,0,0,'C');
					$this->Cell(-200,31,'Email: '.$company->email.' Web : '.$company->webaddress,0,0,'C');
					$this->Image('images/'.$company->rightlogofile,290,5,50);
					$this->SetLineWidth(0.5);
					$this->Line(0, 35, 360, 35); 
					$this->SetFont('Arial','B',16);
					$this->cell(0);
					$this->Cell(-340,80,$this->title,0,0,'C');
				}				
			}
			else
			{
				if ($this->isheader == true)
				{
					$this->Image('images/'.$company->leftlogofile,0,5,25);
					$this->SetFont('Arial','BI',20);
					$this->Cell(170,0,$company->companyname,0,0,'C');
					$this->SetFont('Arial','',9);
					$this->Cell(-145,15,'Office: '.$company->address,0,0,'C');
					$this->Cell(130,23,'Telp.: '.$company->phoneno.' '.$company->faxno,0,0,'C');
					$this->Cell(-135,31,'Email: '.$company->email.' Web : '.$company->webaddress,0,0,'C');
					$this->Image('images/'.$company->rightlogofile,185,5,25);
					$this->SetLineWidth(0.5);
					$this->Line(0, 38, 300, 38); 
					$this->SetFont('Arial','B',16);
					$this->cell(0);
					$this->Cell(-190,80,$this->title,0,0,'C');
					$this->Cell(-190,100,$this->subtitle,0,0,'C');
				}
			}
		}*/
		$this->SetFont('Arial','',12);
		$this->text(10,7,$this->title);
		$this->text(10,12,$this->subtitle);
		$this->sety($this->gety()+5);
		$this->AliasNbPages();
	}

  //Page footer
  function Footer()
  {
		$this->SetY(-8);
		if ($this->isfooter == true)
		{
			if($this->companyid>0)
			{
				$company = Yii::app()->db->createCommand()
				->select('companycode')
				->from('company')
				->where('companyid = '.$this->companyid)
				->queryScalar();
			}
			else
			{
				$company = 'GROUP';
			}
      //Position at 1.5 cm from bottom
      
      //Arial italic 8
      $this->SetFont('Arial','I',8);
      //Page number
			$this->SetLineWidth(0.2);
			$this->Line(0, $this->GetY(), 300, $this->GetY());
			$this->Cell(0,10,'Tgl Cetak : '.date('d-m-Y H:i:s'). ' Oleh : '.Yii::app()->user->id,0,0,'L');
			$this->Cell(0,10,' '.$company.' Hal : '.$this->PageNo().'/{nb}',0,0,'R');
		}
  }

  function SetTableHeader()
  {
    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
  }

  function SetTableData()
  {
    //Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
  }

	function Row($data)
	{
		$this->setaligns($this->coldetailalign);
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		$k = 0;
		//Draw the cells of the row
		//$this->setFont('Arial','',8);
		for($i=0;$i<count($data);$i++)
		{
			$w = $this->widths[$i];
			$a = $this->aligns[$i];
			$x = $this->GetX();
			$y = $this->GetY();
			$c = $this->bordercell[$i];
			if ($c == '') 
			{
				$c = '';
			}
			//var_dump($this->rowstyles[$i]);
			if (count($this->rowstyles) == count($data))
			{
				$this->SetFont($this->rowstyles[$i][0],$this->rowstyles[$i][1],$this->rowstyles[$i][2]);
			}
			$this->CustomMultiCell($w, 5, $data[$i], $c, $a);
			$this->SetXY($x+$w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function CustomMultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
	{
		//Output text with automatic or explicit line breaks
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 && $s[$nb-1]=="\n")
			$nb--;
		$b=0;
		if($border)
		{
			if($border==1)
			{
				$border='LTRB';
				$b='LRT';
				$b2='LR';
			}
			else
			{
				$b2='';
				if(strpos($border,'L')!==false)
					$b2.='L';
				if(strpos($border,'R')!==false)
					$b2.='R';
				$b=(strpos($border,'T')!==false) ? $b2.'T' : $b2;
			}
		}
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$ns=0;
		$nl=1;
		while($i<$nb)
		{
			//Get next character
			$c=$s[$i];
			if($c=="\n")
			{
				//Explicit line break
				if($this->ws>0)
				{
					$this->ws=0;
					$this->_out('0 Tw');
				}
				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$ns=0;
				$nl++;
				if($border && $nl==2)
					$b=$b2;
				continue;
			}
			if($c==' ')
			{
				$sep=$i;
				$ls=$l;
				$ns++;
			}
			$l+=$cw[$c];
			if($l>$wmax)
			{
				//Automatic line break
				if($sep==-1)
				{
					if($i==$j)
						$i++;
					if($this->ws>0)
					{
						$this->ws=0;
						$this->_out('0 Tw');
					}
					$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
				}
				else
				{
					if($align=='J')
					{
						$this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
						$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
					}
					$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
					$i=$sep+1;
				}
				$sep=-1;
				$j=$i;
				$l=0;
				$ns=0;
				$nl++;
				if($border && $nl==2)
					$b=$b2;
			}
			else
				$i++;
		}
		//var_dump($s);

		//Last chunk
		if($this->ws>0)
		{
			$this->ws=0;
			$this->_out('0 Tw');
		}
		if($border && strpos($border,'B')!==false)
			$b.='B';
		$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
		//var_dump($s);
		$this->x=$this->lMargin;
	}
	
	function RowHeader()
	{
		$this->setaligns($this->colalign);
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($this->colheader);$i++)
			$nb=max($nb, $this->NbLines($this->widths[$i], $this->colheader[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		$k = 0;
		//Draw the cells of the row
		//$this->setFont('Arial','B',8);
		for($i=0;$i<count($this->colheader);$i++)
		{
			$w = $this->widths[$i];
			$a = $this->aligns[$i];
			$x = $this->GetX();
			$y = $this->GetY();
			$c = $this->bordercell[$i];
			if ($c == '') 
			{
				$c = 'TB';
			}
			$this->CustomMultiCell($w, 5, $this->colheader[$i], $c, $a);
			$this->SetXY($x+$w, $y);
		}
		//Go to the next line
		$this->Ln($h);
		$this->setaligns($this->coldetailalign);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
		{
			$this->AddPage($this->CurOrientation,$this->CurPageFormat);
		  	//$this->ln(30);
		}
	}
	
	function CheckNewPage($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
		{
			$this->AddPage($this->CurOrientation,$this->CurPageFormat);
		}
	}

  function NbLines($w, $txt)
  {
      //Computes the number of lines a MultiCell of width w will take
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
          $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r", '', $txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
          $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb)
      {
          $c=$s[$i];
          if($c=="\n")
          {
              $i++;
              $sep=-1;
              $j=$i;
              $l=0;
              $nl++;
              continue;
          }
          if($c==' ')
              $sep=$i;
          $l+=$cw[$c];
          if($l>$wmax)
          {
              if($sep==-1)
              {
                  if($i==$j)
                      $i++;
              }
              else
                  $i=$sep+1;
              $sep=-1;
              $j=$i;
              $l=0;
              $nl++;
          }
          else
              $i++;
      }
      return $nl;
  }
	
	function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
        if (strpos($corners, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($corners, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($corners, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($corners, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
}

?>
