<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	require_once "../../../require.base.php";
 
	// Выбрать все приложения
	$query = ("SELECT * FROM [pre]applications WHERE 1 ORDER BY id LIMIT 1000");
 
 	$_stmt = $dbh->prepare($query);
 	$_res = $_stmt->execute();
 	
 	$data = $_res->fetchallAssoc();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tables MENU</title>
</head>

<body>
	<ul class="left-menu">
    <?php
    foreach($data as $item)
	{
		?>
		<li inspector_rel="<?php echo $item['alias'] ?>" class="<?php if($item['block']) echo 'red' ?>" 
                        	onclick="load_sub_menu('app','<?php echo $item['id'] ?>');" >&raquo; <?php echo $item['name'] ?></li>
		<?php
	}
	?>       
	</ul>
</body>
</html>