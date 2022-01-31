<?php

class DashboardController extends AdminController
{
	protected $menuname = 'dashboard';
	public $module = 'admin';
	protected $pageTitle = 'Dashboard';
	
		protected $where_prod_kum1,$where_sales_kum1;
    protected $year;
    protected $month;
    protected $select_prod = "select ifnull(sum(y.qtyoutput),0) as jumlah ";
    protected $select_qty_sales = "select ifnull(sum(b.qty),0) as jumlah ";
    protected $select_price_sales = "select ifnull(sum(c.totalaftdisc),0) as jumlah ";
    protected $from_prod = "from productoutput x 
                    join productoutputfg y on x.productoutputid = y.productoutputid
                    join product d on d.productid = y.productid ";
        
    protected $from_sales = "from giheader a
                    join gidetail b on a.giheaderid = b.giheaderid
                    join soheader c on c.soheaderid = a.soheaderid
                    join product d on d.productid = b.productid ";
    protected $join_ab = "join addressbook e on e.addressbookid = c.addressbookid ";
    protected $join_mt = "join materialtype f on f.materialtypeid = d.materialtypeid ";
        
    protected $where_prod_day = "where x.recordstatus = 3 and x.productoutputdate = curdate() ";
    protected $where_sales_day = "where a.recordstatus = 3 and a.gidate = curdate()";
        
    protected $where_prod_kum = "where x.recordstatus = 3 ";
        
    protected $where_sales_kum = "where a.recordstatus = 3 ";
    
    protected $piutang_dagang = "select sum(amount-payamount) as sisa ";
    
    protected $piutang_dagang1 = "from (select a.invoiceno,a.invoicedate,e.paydays,
                    date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
                    datediff(curdate(),a.invoicedate) as umur,
                    datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),curdate()) as umurtempo,a.amount,ff.fullname as sales,
                    ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                    from cutarinv f
                    join cutar g on g.cutarid=f.cutarid
                    where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
                    from invoice a
                    inner join giheader b on b.giheaderid = a.giheaderid
                    inner join soheader c on c.soheaderid = b.soheaderid
                    inner join addressbook d on d.addressbookid = c.addressbookid
                    inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
                    inner join employee ff on ff.employeeid = c.employeeid ";
                    
    
    protected $count = "select count(1) ";
    
    protected $rows = array(); protected $rows1 = array(); protected $rows2 = array(); protected $rows3 = array(); protected $rows4 = array(); protected $rows5 = array(); protected $rows6 = array();
    protected $name = array(); protected $name1 = array(); protected $name2 = array(); protected $name5 = array(); protected $name6 = array(); 
    protected $rows7 = array(); protected $rows8 = array(); protected $rows9 = array(); protected $rows10 = array(); protected $rows11 = array(); protected $rows12 = array(); protected $rows13 = array(); protected $rows14 = array();
    protected $name7 = array(); protected $name8 = array(); protected $name9 = array(); protected $name10 = array(); protected $name11= array(); protected $name12 = array(); protected $name13 = array(); protected $name14 = array();
	
	public function actionIndex()
	{
		//parent::actionIndex();
		if (Yii::app()->user->id !== null)
		{
		$sql = "select d.widgetname,d.widgettitle,d.widgeturl,a.dashgroup,a.webformat,a.position, (
			select count(1)
			from userdash d0
			where d0.dashgroup = a.dashgroup and d0.menuaccessid = a.menuaccessid and d0.groupaccessid = b.groupaccessid
			) dashcount
from userdash a
join usergroup b on b.groupaccessid = a.groupaccessid 
join useraccess c on c.useraccessid = b.useraccessid
join widget d on d.widgetid = a.widgetid 
join menuaccess e on e.menuaccessid = a.menuaccessid 
			where lower(menuname) = lower('".$this->menuname."') and c.username = '".Yii::app()->user->name."'
			order by dashgroup asc, position asc ";
		$datas = Yii::app()->db->createCommand($sql)->queryAll();
		$this->render('index',array('datas'=>$datas));
		}
		else
		{
			$this->redirect(Yii::app()->createUrl('site/index'));
		}
	}
	public function actionGetSql()
	{
        $id = $_REQUEST['companyid'];
            $premium = Yii::app()->db->createCommand("select materialtypeid, substring(description,1,locate('kangaroo', description)-2) as string from materialtype where recordstatus = 1 and description like '%premium%' order by nourut asc")->queryAll();
        $count = Yii::app()->db->createCommand("select count(1) from materialtype where recordstatus = 1 and description like '%premium%'")->queryScalar();
        $cp=1;
        foreach($premium as $row){
            $kumprodprem = $this->select_prod.",'".$row['string']."' as string ".$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodpremium = Yii::app()->db->createCommand($kumprodprem)->queryRow();
            
            $dayprodprem = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodpremium = Yii::app()->db->createCommand($dayprodprem)->queryRow();
            
            $kumsalesprem = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsalespremium = Yii::app()->db->createCommand($kumsalesprem)->queryRow();
            
            $daysalesprem = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysalespremium = Yii::app()->db->createCommand($daysalesprem)->queryRow();
            
            $this->rows['kum_prod'.$cp] = number_format($kumprodpremium['jumlah'],0,',','.');
            $this->rows['day_prod'.$cp] = number_format($dayprodpremium['jumlah'],0,',','.');
            $this->rows['kum_sal'.$cp] = number_format($kumsalespremium['jumlah'],0,',','.');
            $this->rows['day_sal'.$cp] = number_format($daysalespremium['jumlah'],0,',','.');
            $this->name['name'.$cp] = $kumprodpremium['string'];
            $cp++;
            
        }
        
        $regular = Yii::app()->db->createCommand("select materialtypeid, substring(description,1,locate('kangaroo', description)-2) as string from materialtype where recordstatus = 1 and description like '%regular%' and description not like '%non%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($regular as $row){
            $kumprodreg = $this->select_prod.",'".$row['string']."' as string ".$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodregular = Yii::app()->db->createCommand($kumprodreg)->queryRow();
            
            $dayprodreg = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodregular = Yii::app()->db->createCommand($dayprodreg)->queryRow();
            
            $kumsalesreg = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsalesregular = Yii::app()->db->createCommand($kumsalesreg)->queryRow();
            
            $daysalesreg = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysalesregular = Yii::app()->db->createCommand($daysalesreg)->queryRow();
            
            $this->rows1['kum_prod'.$cp] = number_format($kumprodregular['jumlah'],0,',','.');
            $this->rows1['day_prod'.$cp] = number_format($dayprodregular['jumlah'],0,',','.');
            $this->rows1['kum_sal'.$cp] = number_format($kumsalesregular['jumlah'],0,',','.');
            $this->rows1['day_sal'.$cp] = number_format($daysalesregular['jumlah'],0,',','.');
            $this->name1['name'.$cp] = $kumprodregular['string'];
            $cp++;
            
        }
        
        $np = Yii::app()->db->createCommand("select materialtypeid, substring(description,1,locate('non', description)-2) as string from materialtype where recordstatus = 1 and description like '%non regular%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($np as $row){
            $kumprodnp = $this->select_prod.",'".$row['string']."' as string ".$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodnonreg = Yii::app()->db->createCommand($kumprodnp)->queryRow();
            
            $dayprodnp = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodnonreg = Yii::app()->db->createCommand($dayprodnp)->queryRow();
            
            $kumsalesnp = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsalesnonreg = Yii::app()->db->createCommand($kumsalesnp)->queryRow();
            
            $daysalesnp = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysalesnonreg = Yii::app()->db->createCommand($daysalesnp)->queryRow();
            
            $this->rows2['kum_prod'.$cp] = number_format($kumprodnonreg['jumlah'],0,',','.');
            $this->rows2['day_prod'.$cp] = number_format($dayprodnonreg['jumlah'],0,',','.');
            $this->rows2['kum_sal'.$cp] = number_format($kumsalesnonreg['jumlah'],0,',','.');
            $this->rows2['day_sal'.$cp] = number_format($daysalesnonreg['jumlah'],0,',','.');
            $this->name2['name'.$cp] = $kumprodnonreg['string'];
            $cp++;
        }
        
        $kb = Yii::app()->db->createCommand("select materialtypeid from materialtype where recordstatus = 1 and description like '%kasur busa%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($kb as $row){
            $kumprodkb = $this->select_prod.$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodkbs = Yii::app()->db->createCommand($kumprodkb)->queryRow();
            
            $dayprodkb = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodkbs = Yii::app()->db->createCommand($dayprodkb)->queryRow();
            
            $kumsaleskb = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsaleskbs = Yii::app()->db->createCommand($kumsaleskb)->queryRow();
            
            $daysaleskb = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysaleskbs = Yii::app()->db->createCommand($daysaleskb)->queryRow();
            
            $this->rows3['kum_prod'.$cp] = number_format($kumprodkbs['jumlah'],0,',','.');
            $this->rows3['day_prod'.$cp] = number_format($dayprodkbs['jumlah'],0,',','.');
            $this->rows3['kum_sal'.$cp] = number_format($kumsaleskbs['jumlah'],0,',','.');
            $this->rows3['day_sal'.$cp] = number_format($daysaleskbs['jumlah'],0,',','.');
            $cp++;
        }
        
        $bl = Yii::app()->db->createCommand("select materialtypeid from materialtype where recordstatus = 1 and description like '%balokan%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($bl as $row){
            $kumprodbl = $this->select_prod.$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodblk = Yii::app()->db->createCommand($kumprodbl)->queryRow();
            
            $dayprodbl = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodblk = Yii::app()->db->createCommand($dayprodbl)->queryRow();
            
            $kumsalesbl = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsalesblk = Yii::app()->db->createCommand($kumsalesbl)->queryRow();
            
            $daysalesbl = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysalesblk = Yii::app()->db->createCommand($daysalesbl)->queryRow();
            
            $this->rows4['kum_prod'.$cp] = number_format($kumprodblk['jumlah'],0,',','.');
            $this->rows4['day_prod'.$cp] = number_format($dayprodblk['jumlah'],0,',','.');
            $this->rows4['kum_sal'.$cp] = number_format($kumsalesblk['jumlah'],0,',','.');
            $this->rows4['day_sal'.$cp] = number_format($daysalesblk['jumlah'],0,',','.');
            $cp++;
        }
        
        $wr = Yii::app()->db->createCommand("select materialtypeid, substring(description,locate('rangka', description)+6) as string from materialtype where recordstatus = 1 and description like '%wip rangka%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($wr as $row){
            $kumprodwr = $this->select_prod.",'".$row['string']."' as string ".$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodwrp = Yii::app()->db->createCommand($kumprodwr)->queryRow();
            
            $dayprodwr = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodwrp = Yii::app()->db->createCommand($dayprodwr)->queryRow();
            
            $kumsaleswr = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsaleswrp = Yii::app()->db->createCommand($kumsaleswr)->queryRow();
            
            $daysaleswr = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysaleswrp = Yii::app()->db->createCommand($daysaleswr)->queryRow();
            
            $this->rows5['kum_prod'.$cp] = number_format($kumprodwrp['jumlah'],0,',','.');
            $this->rows5['day_prod'.$cp] = number_format($dayprodwrp['jumlah'],0,',','.');
            $this->rows5['kum_sal'.$cp] = number_format($kumsaleswrp['jumlah'],0,',','.');
            $this->rows5['day_sal'.$cp] = number_format($daysaleswrp['jumlah'],0,',','.');
            $this->name5['name'.$cp] = $kumprodwrp['string'];
            $cp++;
        }
        
        $wk = Yii::app()->db->createCommand("select materialtypeid, substring(description,locate('kain', description)+5) as string from materialtype where recordstatus = 1 and description like '%wip kain%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($wk as $row){
            $kumprodwk = $this->select_prod.",'".$row['string']."' as string ".$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodwkp = Yii::app()->db->createCommand($kumprodwk)->queryRow();
            
            $dayprodwk = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodwkp = Yii::app()->db->createCommand($dayprodwk)->queryRow();
            
            $kumsaleswk = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsaleswkp = Yii::app()->db->createCommand($kumsaleswk)->queryRow();
            
            $daysaleswk = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysaleswkp = Yii::app()->db->createCommand($daysaleswk)->queryRow();
            
            $this->rows6['kum_prod'.$cp] = number_format($kumprodwkp['jumlah'],0,',','.');
            $this->rows6['day_prod'.$cp] = number_format($dayprodwkp['jumlah'],0,',','.');
            $this->rows6['kum_sal'.$cp] = number_format($kumsaleswkp['jumlah'],0,',','.');
            $this->rows6['day_sal'.$cp] = number_format($daysaleswkp['jumlah'],0,',','.');
            $this->name6['name'.$cp] = $kumprodwkp['string'];
            $cp++;
        }
        
        $wk = Yii::app()->db->createCommand("select materialtypeid, substring(description,locate('kain', description)+5) as string from materialtype where recordstatus = 1 and description like '%panelt%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($wk as $row){
            $kumprodwk = $this->select_prod.",'".$row['string']."' as string ".$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodwkp = Yii::app()->db->createCommand($kumprodwk)->queryRow();
            
            $dayprodwk = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodwkp = Yii::app()->db->createCommand($dayprodwk)->queryRow();
            
            $kumsaleswk = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsaleswkp = Yii::app()->db->createCommand($kumsaleswk)->queryRow();
            
            $daysaleswk = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysaleswkp = Yii::app()->db->createCommand($daysaleswk)->queryRow();
            
            $this->rows11['kum_prod'.$cp] = number_format($kumprodwkp['jumlah'],0,',','.');
            $this->rows11['day_prod'.$cp] = number_format($dayprodwkp['jumlah'],0,',','.');
            $this->rows11['kum_sal'.$cp] = number_format($kumsaleswkp['jumlah'],0,',','.');
            $this->rows11['day_sal'.$cp] = number_format($daysaleswkp['jumlah'],0,',','.');
            $this->name11['name'.$cp] = $kumprodwkp['string'];
            $cp++;
        }
        
        $ct = Yii::app()->db->createCommand("select materialtypeid from materialtype where recordstatus = 1 and description like '%centian%' order by nourut asc")->queryAll();
        $cp=1;
        foreach($ct as $row){
            $kumprodct = $this->select_prod.$this->from_prod.$this->where_prod_kum.$this->where_prod_kum1.' and x.companyid = '.$id.' and d.materialtypeid = '.$row['materialtypeid'];
            $kumprodctn = Yii::app()->db->createCommand($kumprodct)->queryRow();
            
            $dayprodct = $this->select_prod.$this->from_prod.$this->where_prod_day.' and d.materialtypeid = '.$row['materialtypeid'].' and x.companyid = '.$id;
            $dayprodctn = Yii::app()->db->createCommand($dayprodct)->queryRow();
            
            $kumsalesct = $this->select_qty_sales.$this->from_sales.$this->where_sales_kum1.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $kumsalesctn = Yii::app()->db->createCommand($kumsalesct)->queryRow();
            
            $daysalesct = $this->select_qty_sales.$this->from_sales.$this->where_sales_day.' and d.materialtypeid = '.$row['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) and companyid = '.$id;
            $daysalesctn = Yii::app()->db->createCommand($daysalesct)->queryRow();
            
            $this->rows7['kum_prod'.$cp] = number_format($kumprodctn['jumlah'],0,',','.');
            $this->rows7['day_prod'.$cp] = number_format($dayprodctn['jumlah'],0,',','.');
            $this->rows7['kum_sal'.$cp] = number_format($kumsalesctn['jumlah'],0,',','.');
            $this->rows7['day_sal'.$cp] = number_format($daysalesctn['jumlah'],0,',','.');
            $cp++;
        }
        
        $ct = Yii::app()->db->createCommand("select materialtypeid, `description` as string from materialtype where recordstatus = 1 and isparent=1 order by nourut asc")->queryAll();
        $cp=1;
        foreach($ct as $row){
            $kumsalspr = $this->select_price_sales.",'".$row['string']."' as string ".$this->from_sales.$this->join_mt.$this->where_sales_kum1.' and f.parentid = '.$row['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and isvendor=0) and companyid = '.$id;
            $kumsalesspr = Yii::app()->db->createCommand($kumsalspr)->queryRow();

            $daysalspr = $this->select_price_sales.$this->from_sales.$this->join_mt.$this->where_sales_day.'  and f.parentid = '.$row['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and z.isvendor=0) and companyid = '.$id;
            $daysalesspr = Yii::app()->db->createCommand($daysalspr)->queryRow();
            
            $this->rows8['kum_prod'.$cp] = ($kumsalesspr['jumlah']);
            $this->rows8['day_prod'.$cp] = ($daysalesspr['jumlah']);
            $this->name8['name'.$cp] = $kumsalesspr['string'];
            $cp++;
        }
        
        $ct = Yii::app()->db->createCommand("select materialtypeid, `description` as string from materialtype where recordstatus = 1 and isparent=1 and description not like 'sampah' order by nourut asc")->queryAll();
        $groupcustomerid = Yii::app()->db->createCommand("select groupcustomerid from groupcustomer b where b.groupname = 'cabang'")->queryScalar();
        $cp=1;
        foreach($ct as $row){
            $kumsalspr = $this->select_price_sales.",'".$row['string']."' as string ".$this->from_sales.$this->join_ab.$this->join_mt.$this->where_sales_kum1.' and f.parentid = '.$row['materialtypeid'].' and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$id;
            $kumsalesspr = Yii::app()->db->createCommand($kumsalspr)->queryRow();

            $daysalspr = $this->select_price_sales.$this->from_sales.$this->join_ab.$this->join_mt.$this->where_sales_day.'  and f.parentid = '.$row['materialtypeid'].' and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$id;
            $daysalesspr = Yii::app()->db->createCommand($daysalspr)->queryRow();
            
            $this->rows9['kum_prod'.$cp] = ($kumsalesspr['jumlah']);
            $this->rows9['day_prod'.$cp] = ($daysalesspr['jumlah']);
            $this->name9['name'.$cp] = $kumsalesspr['string'];
            $cp++;
        }
        
        $cp=1;
        $where = "where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$id." 
                    and a.invoicedate <= curdate())z
                    where amount > payamount ";
        $a=0; $b=60;
        for($i=1; $i<=4; $i++){
            if($a=='120'){
                $umur[$i] = Yii::app()->db->createCommand($this->piutang_dagang.", '> $a' as string ".$this->piutang_dagang1.$where.' and umur > '.$a)->queryRow();    
            }else{
                $umur[$i] = Yii::app()->db->createCommand($this->piutang_dagang.", '$a - $b' as string ".$this->piutang_dagang1.$where.' and umur > '.$a.' and umur <= '.$b)->queryRow();
            }
            $a = $b;
            $b = $b+30;
            $this->rows10['jumlah'.$cp] = $umur[$i]['sisa'];
            $this->name10['name'.$cp] = $umur[$i]['string'];
            $cp++;
        }
         //$this->getSQL();
        $nilai1 = array_merge($this->rows,$this->name);
        $nilai2 = array_merge($this->rows1,$this->name1);
        $nilai3 = array_merge($this->rows2,$this->name2);
        $nilai4 = $this->rows3;
        $nilai5 = $this->rows4;
        $nilai6 = array_merge($this->rows5,$this->name5);
        $nilai7 = array_merge($this->rows6,$this->name6);
        $nilai8 = $this->rows7;
        $nilai9 = array_merge($this->rows8,$this->name8);
        $nilai10 = array_merge($this->rows9,$this->name9);
        $nilai11 = array_merge($this->rows10,$this->name10);
        $nilai12 = array_merge($this->rows11,$this->name11);
        $this->renderPartial('getsql',array('nilai1'=>$nilai1,'nilai2'=>$nilai2,'nilai3'=>$nilai3,'nilai4'=>$nilai4,'nilai5'=>$nilai5,'nilai6'=>$nilai6,'nilai7'=>$nilai7,'nilai8'=>$nilai8,'nilai9'=>$nilai9,'nilai10'=>$nilai10,'nilai11'=>$nilai11,'nilai12'=>$nilai12));
    }
}