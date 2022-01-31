<?php

class ProductionModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'production.models.*',
			'production.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function Install()
	{
		$connection = Yii::app()->db;
		$sql = "select moduleid from modules where lower(modulename) = 'admin'";
		$adminid = $connection->createCommand($sql)->queryScalar();
		if ($adminid > 0)
		{
			$sql = "select moduleid from modules where lower(modulename) = 'adminerp'";
			$adminerpid = $connection->createCommand($sql)->queryScalar();
			if ($adminerpid > 0)
			{
				$sql = "select moduleid from modules where lower(modulename) = 'common'";
				$commonid = $connection->createCommand($sql)->queryScalar();
				if ($commonid > 0)
				{
					$sql = "select moduleid from modules where lower(modulename) = 'stock'";
					$commonid = $connection->createCommand($sql)->queryScalar();
					if ($commonid > 0)
					{
						$this->UnInstall();
						$sql = "insert into modules (modulename,description,createdby,moduleversion,installdate,themeid,recordstatus) 
							values ('production','Production','Prisma Data Abadi','0.1',now(),2,1)";
						$connection->createCommand($sql)->execute();
						
						$sql = "select moduleid from modules where lower(modulename) = 'production'";
						$moduleid = $connection->createCommand($sql)->queryScalar();
								
						$sql = "replace into modulerelation (moduleid,relationid) 
							values (".$moduleid.",".$adminerpid.")";
						$connection->createCommand($sql)->execute();
						
						$sql = "replace into modulerelation (moduleid,relationid) 
							values (".$moduleid.",".$adminerpid.")";
						$connection->createCommand($sql)->execute();
						
						$sql = "replace into modulerelation (moduleid,relationid) 
							values (".$moduleid.",".$commonid.")";
						$connection->createCommand($sql)->execute();
						
						$sql = "select max(sortorder) from menuaccess where menuurl is null";
						$sortorder = $connection->createCommand($sql)->queryScalar() + 1;
						
						$sql = "replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
							values ('stock','Material Stock','Material Stock',".$moduleid.",null,null,".$sortorder.",1)";
						$connection->createCommand($sql)->execute();
						
						$sql = "select menuaccessid from menuaccess where lower(menuname) = 'stock'";
						$menuparent = $connection->createCommand($sql)->queryScalar();
						
						$sql = "replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
							values ('stockopname','Stock Opname','Stock Opname',".$moduleid.",".$menuparent.",'stockopname',1,1)";
						$connection->createCommand($sql)->execute();

						$sql = "replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
							values ('productstock','Material Stock Overvew','Material Stock Overvew',".$moduleid.",".$menuparent.",'productstock',2,1)";
						$connection->createCommand($sql)->execute();
						
						$sql = "replace into menuaccess (menuname,menutitle,description,moduleid,parentid,menuurl,sortorder,recordstatus) 
							values ('productdetail','Material Detail','Material Detail',".$moduleid.",".$menuparent.",'productdetail',2,1)";
						$connection->createCommand($sql)->execute();
						
						$sql = "REPLACE INTO `widget` (`widgetname`, `widgettitle`, `widgetversion`, `widgetby`, `description`, `widgeturl`, `moduleid`, `installdate`, `recordstatus`) 
							VALUES ('materialstockoverview', 'Material Stock Overview', '0.1', 'Prisma Data Abadi', 'Material Stock Overview', 'stock.components.Materialstockoverview', 24, now(), 0);";
						$connection->createCommand($sql)->execute();
						
						$sql = "
							replace into groupmenu (groupaccessid,menuaccessid,isread,iswrite,ispost,isreject,ispurge,isupload,isdownload)
							select 1,menuaccessid,1,1,1,1,1,1,1
							from menuaccess 
							where moduleid = ".$moduleid."
							";
						$connection->createCommand($sql)->execute();
						
						$sql = "CREATE TABLE IF NOT EXISTS `stockopname` (
							`stockopnameid` INT(11) NOT NULL AUTO_INCREMENT,
							`slocid` INT(10) NOT NULL,
							`transdate` DATE NOT NULL,
							`stockopnameno` VARCHAR(50) NULL DEFAULT NULL,
							`headernote` TEXT NOT NULL,
							`recordstatus` TINYINT(4) NOT NULL DEFAULT '1',
							PRIMARY KEY (`stockopnameid`)
						)
						COLLATE='utf8_general_ci'
						ENGINE=InnoDB;
						";
						$connection->createCommand($sql)->execute();
						
						$sql = "CREATE TABLE IF NOT EXISTS `stockopnamedet` (
							`stockopnamedetid` INT(11) NOT NULL AUTO_INCREMENT,
							`stockopnameid` INT(11) NOT NULL,
							`productid` INT(11) NOT NULL,
							`unitofmeasureid` INT(11) NOT NULL,
							`storagebinid` INT(11) NOT NULL,
							`qty` DECIMAL(30,4) NOT NULL DEFAULT '0.0000',
							`buyprice` INT(10) NOT NULL,
							`buydate` DATE NOT NULL,
							`currencyid` INT(11) NOT NULL,
							`expiredate` DATE NOT NULL,
							`materialstatusid` INT(10) NOT NULL,
							`ownershipid` INT(10) NOT NULL,
							`serialno` VARCHAR(50) NOT NULL,
							`location` VARCHAR(50) NOT NULL,
							`itemnote` TEXT NOT NULL,
							PRIMARY KEY (`stockopnamedetid`)
						)
						COLLATE='utf8_general_ci'
						ENGINE=InnoDB;";
						$connection->createCommand($sql)->execute();
						
						
						$sql = "CREATE TABLE IF NOT EXISTS `productstock` (
							`productstockid` INT(11) NOT NULL AUTO_INCREMENT,
							`productid` INT(11) NOT NULL,
							`slocid` INT(11) NOT NULL,
							`storagebinid` INT(11) NOT NULL,
							`qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
							`unitofmeasureid` INT(11) NOT NULL,
							`qtyinprogress` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
							PRIMARY KEY (`productstockid`),
							UNIQUE INDEX `uq_prodstock_pssu` (`productid`, `slocid`, `storagebinid`, `unitofmeasureid`),
							INDEX `fk_prodstock_pro` (`productid`),
							INDEX `fk_prodstock_sloc` (`slocid`),
							INDEX `fk_prodstock_uom` (`unitofmeasureid`),
							INDEX `fk_prodstock_sbin` (`storagebinid`),
							CONSTRAINT `fk_prodstock_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
							CONSTRAINT `fk_prodstock_sbin` FOREIGN KEY (`storagebinid`) REFERENCES `storagebin` (`storagebinid`),
							CONSTRAINT `fk_prodstock_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`),
							CONSTRAINT `fk_prodstock_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
						)
						COLLATE='utf8_general_ci'
						ENGINE=InnoDB;
						";
						$connection->createCommand($sql)->execute();
						
						$sql = "CREATE TABLE IF NOT EXISTS `productstockdet` (
							`productstockdetid` INT(11) NOT NULL AUTO_INCREMENT,
							`productid` INT(10) NOT NULL,
							`qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
							`unitofmeasureid` INT(10) NOT NULL,
							`slocid` INT(10) NOT NULL,
							`referenceno` VARCHAR(50) NOT NULL,
							`productstockid` INT(10) NOT NULL,
							`storagebinid` INT(11) NOT NULL,
							`transdate` DATE NOT NULL,
							PRIMARY KEY (`productstockdetid`),
							INDEX `fk_prodstockdet_pro` (`productid`),
							INDEX `fk_prodstockdet_uom` (`unitofmeasureid`),
							INDEX `fk_prodstockdet_sloc` (`slocid`),
							INDEX `fk_prodstockdet_sbin` (`storagebinid`),
							CONSTRAINT `fk_prodstockdet_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
							CONSTRAINT `fk_prodstockdet_sbin` FOREIGN KEY (`storagebinid`) REFERENCES `storagebin` (`storagebinid`),
							CONSTRAINT `fk_prodstockdet_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`),
							CONSTRAINT `fk_prodstockdet_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
						)
						COLLATE='utf8_general_ci'
						ENGINE=InnoDB;
						";
						$connection->createCommand($sql)->execute();
						
						$sql = "CREATE TABLE IF NOT EXISTS `productdetail` (
							`productdetailid` BIGINT(20) NOT NULL AUTO_INCREMENT,
							`materialcode` VARCHAR(50) NOT NULL,
							`productid` INT(10) NOT NULL,
							`slocid` INT(10) NOT NULL,
							`storagebinid` INT(11) NOT NULL,
							`qty` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
							`unitofmeasureid` INT(10) NOT NULL,
							`buydate` DATE NOT NULL,
							`expiredate` DATE NOT NULL,
							`buyprice` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
							`currencyid` INT(10) NOT NULL,
							`location` VARCHAR(150) NOT NULL,
							`locationdate` DATE NOT NULL DEFAULT '0000-00-00',
							`materialstatusid` INT(10) NOT NULL,
							`ownershipid` INT(10) NOT NULL,
							`referenceno` VARCHAR(50) NOT NULL,
							`vrqty` DECIMAL(30,4) NOT NULL DEFAULT '0.0000',
							`serialno` VARCHAR(50) NULL DEFAULT NULL,
							PRIMARY KEY (`productdetailid`),
							UNIQUE INDEX `uq_productdetail` (`productid`, `slocid`, `unitofmeasureid`, `storagebinid`, `materialstatusid`, `ownershipid`),
							INDEX `fk_prodet_pro` (`productid`),
							INDEX `fk_prodet_sloc` (`slocid`),
							INDEX `fk_prodet_uom` (`unitofmeasureid`),
							INDEX `fk_prodet_curr` (`currencyid`),
							INDEX `fk_prodet_sbin` (`storagebinid`),
							INDEX `fk_prodet_matstatus` (`materialstatusid`),
							INDEX `fk_prodet_own` (`ownershipid`),
							CONSTRAINT `fk_prodet_curr` FOREIGN KEY (`currencyid`) REFERENCES `currency` (`currencyid`),
							CONSTRAINT `fk_prodet_matstatus` FOREIGN KEY (`materialstatusid`) REFERENCES `materialstatus` (`materialstatusid`),
							CONSTRAINT `fk_prodet_own` FOREIGN KEY (`ownershipid`) REFERENCES `ownership` (`ownershipid`),
							CONSTRAINT `fk_prodet_pro` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
							CONSTRAINT `fk_prodet_sbin` FOREIGN KEY (`storagebinid`) REFERENCES `storagebin` (`storagebinid`),
							CONSTRAINT `fk_prodet_sloc` FOREIGN KEY (`slocid`) REFERENCES `sloc` (`slocid`),
							CONSTRAINT `fk_prodet_uom` FOREIGN KEY (`unitofmeasureid`) REFERENCES `unitofmeasure` (`unitofmeasureid`)
						)
						COLLATE='utf8_general_ci'
						ENGINE=InnoDB;";
						$connection->createCommand($sql)->execute();
						
						$sql = "CREATE TABLE  IF NOT EXISTS `productdetailhist` (
							`productdetailhistid` BIGINT(20) NOT NULL AUTO_INCREMENT,
							`slocid` INT(10) NOT NULL,
							`expiredate` DATE NOT NULL,
							`serialno` VARCHAR(50) NULL DEFAULT NULL,
							`qty` DECIMAL(30,6) NOT NULL,
							`unitofmeasureid` INT(10) NOT NULL,
							`buydate` DATE NULL DEFAULT NULL,
							`buyprice` DECIMAL(30,6) NOT NULL DEFAULT '0.000000',
							`currencyid` INT(10) NOT NULL,
							`productid` INT(10) NOT NULL,
							`storagebinid` INT(11) NOT NULL,
							`location` VARCHAR(150) NOT NULL,
							`locationdate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
							`materialcode` VARCHAR(50) NULL DEFAULT NULL,
							`materialstatusid` INT(10) NOT NULL,
							`ownershipid` INT(10) NOT NULL,
							`referenceno` VARCHAR(50) NOT NULL,
							`productdetailid` INT(10) NOT NULL,
							PRIMARY KEY (`productdetailhistid`)
						)
						COLLATE='utf8_general_ci'
						ENGINE=InnoDB;";
						$connection->createCommand($sql)->execute();
						
						$sql = "CREATE PROCEDURE `ApproveStockopname`(IN `vid` INT, IN `vlastupdateby` VARCHAR(50))
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare vsnroid,vrecstat,vnextstat,vslocid,vproductid,vtypeid,vuomid,k,l,
				vbsdetailid,vownershipid,vmaterialstatusid,vmatcode,vcompanyid,vcurrencyid   integer;
			declare vqty,vprice decimal(30,6);declare vpostdate,vdate,vexpiredate date;
		declare vgrno,vcc,vpt,vpp,vlocation,vstoragebin,vserialno varchar(50);
			declare vitemnote text;
			DECLARE done INT DEFAULT 0;
			DECLARE cur1 CURSOR FOR SELECT stockopnamedetid,productid,qty,unitofmeasureid,itemnote,location,
			expiredate,ownershipid,materialstatusid,storagebinid,currencyid,buyprice,serialno
		FROM stockopnamedet where stockopnameid = vid;
		DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=1;
		
		select a.transdate, a.transdate, a.recordstatus, a.slocid, d.companyid
		into vpostdate, vdate, vrecstat, vslocid, vcompanyid
		from stockopname a
		inner join sloc b on b.slocid = a.slocid 
		inner join plant c on c.plantid = b.plantid 
		inner join company d on d.companyid = c.companyid
		where a.stockopnameid = vid;
		
		select a.snroid
		into vsnroid 
		from snro a
		where upper(a.formatdoc) like upper('%TSO%');
		
		select getwfrecstatbycreated('appbs',vrecstat,vlastupdateby)
		into vnextstat;
		
		select ifnull(count(1),0)
		into k
		from stockopnamedet
		where stockopnameid = vid;

	select ifnull(count(1),0)
	into l
	from stockopname a
	inner join stockopnamedet b on b.stockopnameid = a.stockopnameid
	where a.stockopnameid = vid and a.slocid not in 
	(select x.slocid from productplant x 
	where x.productid = b.productid and x.unitofissue = b.unitofmeasureid);

	if k > 0 then
		if l = 0 then
			if checkaccperiod(vpostdate) > 0 then
				if GetWfBefStatByCreated('appbs',vrecstat,vlastupdateby) > 0 then
					update stockopname
					set stockopnameno = ifnull(stockopnameno,getrunno(vcompanyid,vsnroid,vdate)),
					recordstatus=vnextstat
					where stockopnameid = vid;
						
					call inserttranslog (vlastupdateby,'approve','','','stockopname',vid);
					
					select stockopnameno
					into vgrno
					from stockopname
					where stockopnameid = vid;
						
					call sendnotif('listbs',vnextstat,
					(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'bsheader'),
					vgrno,(select catalogval from catalogsys where languageid = (select paramvalue from parameter where paramname = 'language') and catalogname = 'approvedoc'));if getwfcomparemax('appbs',vnextstat,vlastupdateby) = 1 then
		
					OPEN cur1;read_loop: LOOP
					FETCH cur1 INTO vbsdetailid,vproductid,vqty,vuomid,vitemnote,
							 vlocation,vexpiredate,vownershipid,vmaterialstatusid,vstoragebin,vcurrencyid,vprice,vserialno;
						IF done THEN
							LEAVE read_loop;
						END IF;
							
						call insertstock (vgrno,vcompanyid,vproductid,vuomid,vslocid,vstoragebin,vqty,0,vdate,vexpiredate,vprice,vcurrencyid,vlocation,
							vdate,vmaterialstatusid,vownershipid,vserialno);
							
					END LOOP;
					CLOSE cur1;
				end if;
				else
						CALL pRaiseError('flowapp');
					end if;
				else
					CALL pRaiseError('periodover');
				end if;
		else
			CALL pRaiseError('falsesloc');
			end if;
	else
		CALL pRaiseError('detailempty');
	end if;
	END";
	$connection->createCommand($sql)->execute();

				$sql = "CREATE PROCEDURE `InsertStockopname`(IN `vactiontype` TINYINT, IN `vstockopnameid` INT, IN `vslocid` INT, IN `vtransdate` DATE, IN `vheadernote` TEXT, IN `vcreatedby` VARCHAR(50), IN `vrecordstatus` TINYINT)
		LANGUAGE SQL
		NOT DETERMINISTIC
		CONTAINS SQL
		SQL SECURITY DEFINER
		COMMENT ''
	BEGIN
		declare k int;if (vactiontype = 0) then
				insert into stockopname (slocid,transdate,headernote,recordstatus)
				values (vslocid,vtransdate,vheadernote,vrecordstatus);set k = last_insert_id();else
				if (vactiontype = 1) then
					update stockopname
					set slocid = vslocid,transdate = vtransdate,headernote = vheadernote
					where stockopnameid = vstockopnameid;set k = vstockopnameid;end if;end if;update stockopnamedet
			set stockopnameid = k
			where stockopnameid = vstockopnameid;END";
			$connection->createCommand($sql)->execute();
			
						return "ok";
					}
					else
					{
						return "Need module Stock to be installed";
					}
				}
				else
				{
					return "Need module Common to be installed";
				}
			}
			else
			{
				return "Need module Admin ERP to be installed";
			}
		}
		else
		{
			return "Need module Admin to be installed";
		}
	}
	
	public function UnInstall()
	{
		$connection = Yii::app()->db;
		$sql="select moduleid from modules where modulename = 'blog'";
		$module = $connection->createCommand($sql)->queryScalar();
		
		if ($module > 0)
		{
			$sql = "delete from menuaccess where moduleid = ".$module;
			$connection->createCommand($sql)->execute();
					
			$sql = "delete from modulerelation where moduleid = ".$module;
			$connection->createCommand($sql)->execute();
			
			$sql = "delete from widget where moduleid = ".$module;
			$connection->createCommand($sql)->execute();
			
			$sql = "delete from modules where modulename = 'blog'";
			$connection->createCommand($sql)->execute();
			
			$sql = "drop table if exists productdetailhist";
			$connection->createCommand($sql)->execute();
			
			$sql = "drop table if exists productdetail";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productstockdet";
			$connection->createCommand($sql)->execute();

			$sql = "drop table if exists productstock";
			$connection->createCommand($sql)->execute();
			
			$sql = "drop table if exists stockopnamedet";
			$connection->createCommand($sql)->execute();
			
			$sql = "drop table if exists stockopname";
			$connection->createCommand($sql)->execute();
		}
		return "ok";
	}
}
