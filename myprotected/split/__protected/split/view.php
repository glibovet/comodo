<?php
	//$controller->callApp('N',$dbh);
	
	$wp_login = false;
	if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != null && trim($_COOKIE['user_id']) !== "" && $_COOKIE['user_id'])
	{
		$wp_login = true;
	}
	define("WP_LOGIN",$wp_login);
	if(WP_LOGIN)
	{
		require_once("admin_view.php");
	}else
	{
		require_once("admin_login.php");
	}
?>