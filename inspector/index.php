<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	require_once "require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link type="text/css" rel="stylesheet" href="css/reset.css">
    <link type="text/css" rel="stylesheet" href="css/style.css">

	<script type="text/javascript" language="javascript" src="js/jquery.min.js">jQuery.noConflict();</script>
	<script type="text/javascript" language="javascript" src="js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.cookie.js"></script>

<title>WEB INSPECTOR</title>
</head>

<body>
	<?php
    if(isset($_COOKIE['insp_id']) && $_COOKIE['insp_id'] > 0)
	{
	?>
    <a style="display:block; padding:2px 5px; background:#333; color:#FFF; position:absolute; top:0px; right:0px; z-index:1000; width:100px;" href="javascript:void(0);" onclick="exit_insp();">Exit</a>
    <div id="inspector-wrap">
        <div id="inspector-menu">
        	<ul>
            	<li inspector_rel="tables" class="active" onclick="load_menu('tables')">Управление Таблицами</li>
                <li inspector_rel="pageTypes" onclick="load_menu('pageTypes')">Типы страниц</li>
                <li inspector_rel="appsGroups" onclick="load_menu('appsGroups')">ApplicationsGroups</li>
                <li inspector_rel="apps" onclick="load_menu('apps')">Applications</li>
                <li inspector_rel="admin" onclick="load_menu('admin')">Настройка АдминПанели</li>
            </ul>
        </div>
        <div id="inspector-content">
        	<div id="inspector-left">
            		<center><img align="Loading..." src="img/pulse.gif"></center>
            </div>
            <div id="inspector-right">
            		<center><img align="Loading..." src="img/pulse.gif"></center>
            </div>
        </div>
        <div id="inspector-footer">WEB INSPECTOR</div>
    </div>
<?php
	
	}else
	{
		?>
		<div style="position:absolute; top:100px; left:50%; margin-left:-200px; z-index:1000; width:400px; text-align:center;">
        	<fieldset>
            	<legend>Авторизация администратора:</legend>
            <?php
            if(isset($_POST['insp_login']))
			{
				if($_POST['insp_login'] == "ms-tx@yandex.ru" && $_POST['insp_pass'] == "abc1928")
				{
					?>
					<script type="text/javascript" language="javascript">
						$.cookie('insp_id',1);
						document.location.href = "index.php";
                    </script>
					<?php
				}else
				{
					echo '<p class="error">Неверные данные.</p>';
				}
			}
			?>
                <form name="auto-form" action="#" method="POST">
                <table>
                	<tr>
                    	<td>Login:</td>
                        <td><input class="ifield" type="email" name="insp_login" placeholder="Login"></td>
                    </tr>
                    <tr>
                    	<td>Pass:</td>
                        <td><input class="ifield" type="password" name="insp_pass" placeholder="Password"></td>
                    </tr>
                </table>
                <button class="ibut" type="submit">Enter</button>
                </form>
            </fieldset>
        </div>
		<?php
	}
	
	/*
	$balans = 900;
	$projects_stmt = $dbh->prepare("SELECT * FROM next_bookkeeping WHERE balans = :1");
	$projects_result = $projects_stmt->execute($balans);
	
	$result = new DB_Result($projects_stmt);
	
	echo '<pre>';
		//print_r(($result->Next()));
		//print_r($projects_result->fetchallAssoc()); 
		while($result->Next()){	print $result->source; }
	echo '</pre>';
	
	echo '<hr>';
	echo $result->source;
	echo '<hr> Модель преопразователя (TEST): <br>';
	
	$tmp_id = 1;
	$tmp = TmpMapper::findById($tmp_id,$dbh);
	
	$tmp->username = "Maxim";
	TmpMapper::update($tmp,$dbh);
	
	echo '<pre>'; print_r($tmp); echo '</pre>';
	
	$tmp_id = 0;
	$query = "SELECT * FROM users WHERE userid > :1";
	$params = array($tmp_id);
	$tmp_arr = TmpMapper::findByQuery($query,$params,$dbh);
	
	echo '<pre>'; print_r($tmp_arr); echo '</pre>';
	
	$user = new Tmp(NULL,"NewName","NewFirst","NewLast","NewSolut","NewCode");
	//TmpMapper::insert($user,$dbh);
	echo $user->userid;
	
	$del_tmp = TmpMapper::findById(28,$dbh);
	TmpMapper::delete($del_tmp,$dbh);
	*/
?>
</body>
<script type="text/javascript" language="javascript" src="js/inspector.js"></script>
<script type="text/javascript" language="javascript">
	function exit_insp()
	{
		$.cookie('insp_id',null);
		document.location.href = "index.php";
	}
</script>
</html>