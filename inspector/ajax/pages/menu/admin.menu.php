<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	require_once "../../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tables MENU</title>
</head>

<body>
	<ul class="left-menu">
                <li inspector_rel="list" 
                        	onclick="load_sub_menu('admin','list');" >&rsaquo; Админ меню</li>
                <li inspector_rel="apps" 
                        	onclick="load_sub_menu('admin','apps');" >&rsaquo; Админ приложения</li>
	</ul>
</body>
</html>