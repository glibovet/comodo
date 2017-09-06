<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	require_once "../../../require.base.php";
 
 	/*
	Процедура вывода даных:
	
	1. Считываеться HTTP адрес и определяеться по ЧПУ тип страницы для вывода.
	
	2. 
	*/	
	
	/*
	Таблицы, необходимы для управления типизацией страниц
	
	# page_types: (список страниц)
		
		- id
		- name
		- alias
		- block
		- details
		- app_groups (serialize Array)
			[ Array(
					Array( 
						app_group_id	=>	$id, 
						structure		=>	Array('<div>','<a>','<span>',...) 
						),... 
					) 
			]
	
	# app_groups: (список групп приложений)
		
		- id
		- name
		- alias
		- block
		- apps [app_id_1,app_id_2,...]
		- details
	
	# applications: (список приложений)
		
		- id
		- name
		- alias (.php)
		- block
		- details
		- fields (serialize Array)
			[ Array(
					Array(
						 'table'	=>	tableName,
						 'fields'	=>	Array(
						 					  Field_1,
											  Field_2,
											  ...
											  )
						 ),...
					) 
			]

	*/

	
 $query = ("SELECT * FROM [pre]page_types WHERE 1 ORDER BY id LIMIT 1000");
 
 $_stmt = $dbh->prepare($query);
 $_res = $_stmt->execute();
 
 $data = $_res->fetchallAssoc();
 
 //$data = array('name'=>1,'alias'=>1,'id'=>1);
 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pages Types</title>
</head>

<body>
	<ul class="left-menu">
    <?php
    foreach($data as $item)
	{
		?>
		<li inspector_rel="<?php echo $item['alias'] ?>" 
                        	onclick="load_sub_menu('pageTypes','<?php echo $item['id'] ?>');" >&raquo; <?php echo $item['name'] ?></li>
		<?php
	}
	?>
	</ul>
</body>
</html>