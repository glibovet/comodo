<?php 
	//********************
	//** WEB INSPECTOR
	//********************

	error_reporting(0);
	require_once "core/DB_Mysql.class.php";
	require_once "core/DB_MysqlStatement.class.php";
	require_once "core/DB_Result.class.php";
	
	require_once "objects/ObjectInterface.interface.php";
	
	//require_once "objects/Tmp.class.php";
	
	//LOCAL
	/*$db_user = "root";
	$db_pass = "";
	$db_host = "localhost";
	$db_name = "comodo";
	$db_code = "utf8";
	$db_pref = "osc_";*/
	
	
	//ONLINE
	$db_user = "comodoki_kamstud";
	$db_pass = "qmEU1P6W";
	$db_host = "localhost";
	$db_name = "comodoki_kamstudio";
	$db_code = "utf8";
	$db_pref = "osc_";
	
	$dbh = new DB_Mysql($db_user,$db_pass,$db_host,$db_name,$db_code,$db_pref);