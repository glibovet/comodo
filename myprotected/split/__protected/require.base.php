<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	define("ADMIN_PATH","protected/");
	
	define("WP_CHPU",true);
	
	define("WP_FOLDER","split/");
	
	define("APPS_DIR","applications/");
	
	define("SMARTY_DIR","smarty/");
	define("SMARTY_CORE_DIR",WP_FOLDER.SMARTY_DIR."libs/internals/");
	
	define("EXT_SEM",true);
	
	define("ADMIN_ID",$_COOKIE['user_id']);
	
	define("GLOBAL_ON_PAGE",10);
	
	//****************************************************************************
	
	require_once "core/DB_Mysql.class.php";
	require_once "core/DB_MysqlStatement.class.php";
	require_once "core/DB_Result.class.php";
	
	require_once "objects/ObjectInterface.interface.php";
	
	//require_once "objects/Tmp.class.php";
	
	require_once(WP_FOLDER."system/config.php");
	$config_obj = new Config();
	
	$db_user = $config_obj->configs['db']['user'];
	$db_pass = $config_obj->configs['db']['pass'];
	$db_host = $config_obj->configs['db']['host'];
	$db_name = $config_obj->configs['db']['name'];
	$db_code = $config_obj->configs['db']['encode'];
	$db_pref = "next_";
	
	$dbh = new DB_Mysql($db_user,$db_pass,$db_host,$db_name,$db_code,$db_pref);