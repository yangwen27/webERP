<?php

CreateTable('mrpdemandtypes',
"CREATE TABLE `mrpdemandtypes` (
  `mrpdemandtype` varchar(6) NOT NULL default '',
  `description` char(30) NOT NULL default '',
  PRIMARY KEY  (`mrpdemandtype`),
  KEY `mrpdemandtype` (`mrpdemandtype`)
)",
$db);

CreateTable('mrpdemands',
"CREATE TABLE `mrpdemands` (
  `demandid` int(11) NOT NULL AUTO_INCREMENT,
  `stockid` varchar(20) NOT NULL default '',
  `mrpdemandtype` varchar(6) NOT NULL default '',
  `quantity` double NOT NULL default '0',
  `duedate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`demandid`),
  KEY `StockID` (`stockid`)
)",
$db);

AddConstraint('mrpdemands', 'mrpdemands_ibfk_1', 'mrpdemantype', 'mrpdemandtypes', 'mrpdemandtype', $db);
AddConstraint('mrpdemands', 'mrpdemands_ibfk_2', 'stockid', 'stockmaster', 'stockid', $db);

AddColumn('pansize', 'stockmaster', 'DOUBLE', 'NOT NULL', 'DEFAULT 0.0', 'decimalplaces', $db);
AddColumn('shrinkfactor', 'stockmaster', 'DOUBLE', 'NOT NULL', 'DEFAULT 0.0', 'pansize', $db);

CreateTable('mrpcalendar',
"CREATE TABLE `mrpcalendar` (
	calendardate date NOT NULL,
	daynumber int(6) NOT NULL,
	manufacturingflag smallint(6) NOT NULL default '1',
	INDEX (daynumber),
	PRIMARY KEY (calendardate)
)",
$db);

InsertRecord('mrpdemandtypes', array('mrpdemandtype', 'description'), array('FOR','Forecast'), array('mrpdemandtype', 'description'), array('FOR','Forecast'), $db);

AddPrimaryKey('geocode_param', array('geocodeid'), $db);
ChangeColumnName('geocodeid', 'geocode_param', 'TINYINT', 'NOT NULL', 'DEFAULT 0', 'geocodeid', $db, 'autoincrement');
AddIndex(array('coyname'), 'factorcompanies', 'factor_name', $db);

AddColumn('currcode', 'bankaccounts', 'CHAR(3)', 'NOT NULL', "DEFAULT ''", 'accountcode', $db);

ChangeColumnType('role', 'custcontacts', 'VARCHAR(40)', 'NOT NULL', "DEFAULT ''", $db);
ChangeColumnType('phoneno', 'custcontacts', 'VARCHAR(20)', 'NOT NULL', "DEFAULT ''", $db);
ChangeColumnType('notes', 'custcontacts', 'VARCHAR(255)', 'NOT NULL', "DEFAULT ''", $db);

DropPrimaryKey('purchdata', ('supplierno','stockid'), $db);
AddPrimaryKey('purchdata', ('supplierno','stockid', 'effectivefrom'), $db);

AddColumn('quotedate', 'salesorders', 'DATE', 'NOT NULL', "DEFAULT '0000-00-00'", 'quotation', $db);
AddColumn('confirmeddate', 'salesorders', 'DATE', 'NOT NULL', "DEFAULT '0000-00-00'", 'deliverydate', $db);

CreateTable('woserialnos',
"CREATE TABLE `woserialnos` (
	`wo` INT NOT NULL ,
	`stockid` VARCHAR( 20 ) NOT NULL ,
	`serialno` VARCHAR( 30 ) NOT NULL ,
	`quantity` DOUBLE NOT NULL DEFAULT '1',
	`qualitytext` TEXT NOT NULL,
	 PRIMARY KEY (`wo`,`stockid`,`serialno`)
)",
$db);

NewConfigValue('AutoCreateWOs', 1, $db);
NewConfigValue('DefaultFactoryLocation','MEL', $db);
NewConfigValue('FactoryManagerEmail','manager@company.com', $db);
NewConfigValue('DefineControlledOnWOEntry', '1', $db);

AddColumn('nextserialno', 'stockmaster', 'BIGINT', 'NOT NULL', "DEFAULT 0", 'shrinkfactor', $db);
AddColumn('qualitytext', 'stockserialitems', 'TEXT', 'NOT NULL', "DEFAULT ''", 'quantity', $db);
ChangeColumnType('orderno', 'salesorders', 'INT( 11 )', 'NOT NULL', "DEFAULT ''", $db);

CreateTable('purchorderauth',
"CREATE TABLE `purchorderauth` (
	`userid` varchar(20) NOT NULL DEFAULT '',
	`currabrev` char(3) NOT NULL DEFAULT '',
	`cancreate` smallint(2) NOT NULL DEFAULT 0,
	`authlevel` int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (`userid`,`currabrev`)
)",
$db);

AddColumn('version', 'purchorders', 'DECIMAL(3,2)', 'NOT NULL', "DEFAULT 1.0", 'contact', $db);
AddColumn('revised', 'purchorders', 'DATE', 'NOT NULL', "DEFAULT '0000-00-00'", 'version', $db);
AddColumn('realorderno', 'purchorders', 'VARCHAR(16)', 'NOT NULL', "DEFAULT ''", 'revised', $db);
AddColumn('deliveryby', 'purchorders', 'VARCHAR(100)', 'NOT NULL', "DEFAULT ''", 'realorderno', $db);
AddColumn('deliverydate', 'purchorders', 'DATE', 'NOT NULL', "DEFAULT '0000-00-00'", 'deliveryby', $db);
AddColumn('status', 'purchorders', 'VARCHAR(12)', 'NOT NULL', "DEFAULT ''", 'deliverydate', $db);
AddColumn('stat_comment', 'purchorders', 'TEXT', 'NOT NULL', "DEFAULT ''", 'status', $db);

AddColumn('itemno', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'itemcode', $db);
AddColumn('uom', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'itemno', $db);
AddColumn('subtotal_amount', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'uom', $db);
AddColumn('package', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'subtotal_amount', $db);
AddColumn('pcunit', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'package', $db);
AddColumn('nw', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'pcunit', $db);
AddColumn('suppliers_partno', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'nw', $db);
AddColumn('gw', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'suppliers_partno', $db);
AddColumn('cuft', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'gw', $db);
AddColumn('total_quantity', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'cuft', $db);
AddColumn('total_amount', 'purchorderdetails', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'total_quantity', $db);

AddColumn('phn', 'suppliers', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'taxref', $db);
AddColumn('port', 'suppliers', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'phn', $db);

AddColumn('netweight', 'stockmaster', 'DECIMAL(20,4)', 'NOT NULL', "DEFAULT 0.0", 'nextserialno', $db);
AddColumn('suppliers_partno', 'purchdata', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'effectivefrom', $db);

ChangeColumnType('note', 'custnotes', 'TEXT', 'NOT NULL', "DEFAULT ''", $db);

AddColumn('bankaccountcode', 'bankaccounts', 'VARCHAR(50)', 'NOT NULL', "DEFAULT ''", 'currcode', $db);
AddColumn('invoice', 'bankaccounts', 'SMALLINT(2)', 'NOT NULL', "DEFAULT 0", 'bankaccountcode', $db);

AddColumn('salesman', 'www_users', 'CHAR( 3 )', 'NOT NULL', "DEFAULT ''", 'customerid', $db);

ChangeColumnType('shipvia', 'debtortrans', 'INT(11)', 'NOT NULL', 'DEFAULT 0', $db);

CreateTable('audittrail',
"CREATE TABLE IF NOT EXISTS `audittrail` (
  `transactiondate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` varchar(20) NOT NULL DEFAULT '',
  `querystring` text,
  KEY `UserID` (`userid`)
)",
$db);

AddConstraint('audittrail', 'audittrail_ibfk_1', 'userid', 'www_users', 'userid', $db);

CreateTable('deliverynotes',
"CREATE TABLE IF NOT EXISTS `deliverynotes` (
  `deliverynotenumber` int(11) NOT NULL,
  `deliverynotelineno` tinyint(4) NOT NULL,
  `salesorderno` int(11) NOT NULL,
  `salesorderlineno` int(11) NOT NULL,
  `qtydelivered` double NOT NULL DEFAULT '0',
  `printed` tinyint(4) NOT NULL DEFAULT '0',
  `invoiced` tinyint(4) NOT NULL DEFAULT '0',
  `deliverydate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`deliverynotenumber`,`deliverynotelineno`),
  KEY `deliverynotes_ibfk_2` (`salesorderno`,`salesorderlineno`)
)",
$db);

AddConstraint('deliverynotes', 'deliverynotes_ibfk_1', array('salesorderno', 'salesorderlineno'), 'salesorderdetails', array('orderno', 'orderlineno'), $db);
ALTER TABLE ``  ADD CONSTRAINT `` FOREIGN KEY  REFERENCES `` (`orderno`, `orderlineno`);


UpdateDBNo(basename(__FILE__, '.php'), $db);

?>