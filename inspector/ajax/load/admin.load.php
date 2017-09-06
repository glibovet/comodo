<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMIN MANAGER</title>
</head>

<?php
	$name = $_GET['name'];
	
	$parents_query = "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=0 ORDER BY order_id";
			
			$parents_stmt = $dbh->prepare($parents_query);
			$parents_arr = $parents_stmt->execute();
		
			$parents = $parents_arr->fetchallAssoc();
?>

<body>
<?php
	if($name == 'list')
	{
		?>
        <button class="right brown" type="button" onclick="$('#add_admin_row_wrap').slideToggle(0);">+ Добавить пункт меню</button>
        
        <h3>Админ <span class="click" onclick="load_sub_menu('admin','list');">меню</span><span id="loadProgress"></span> (<?php echo sizeof($parents) ?>)</h3>
        
        <div id="add_admin_row_wrap" class="hidden">
        	<fieldset>
                <legend>Добавить новый пункт меню:</legend>
                <form name="add_admin_row_form" action="ajax/insert/admin.menu.insert.php" method="POST" target="_blank">
                <table>
                	<tr>
                    	<td>Название:</td>
                        <td><input type="text" name="name" value=""></td>
                    </tr>
                    <tr>
                    	<td>Алиас:</td>
                        <td><input type="text" name="alias" value=""></td>
                    </tr>
                    <tr>
                    	<td>Вложенность:</td>
                        <td>
                        	<select name="parent">
                            		<option value="0">Верхняя</option>
								<?php
                                foreach($parents as $parent)
								{
									?>
									<option value="<?php echo $parent['id'] ?>"><?php echo $parent['name'] ?></option>
									<?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td>Порядковый номер:</td>
                        <td><input type="number" name="order_id" value="0"></td>
                    </tr>
                    <tr>
                    	<td>Описание</td>
                        <td>
                        	<textarea name="details"></textarea>	
                        </td>
                    </tr>
                </table>
                <button class="green" type="submit" onclick="$('#loadProgress').html(loader);">Добавить</button>
                </form>
            </fieldset>
        </div>
        
		<div id="page_content">
        	<ul>
			<?php	
			foreach($parents as $parent)
			{
				$cq_query = "SELECT COUNT(*) FROM [pre]admin_menu WHERE `type`=1 AND `parent`=".$parent['id']." ORDER BY order_id";
			
				$cq_stmt = $dbh->prepare($cq_query);
				$cq_arr = $cq_stmt->execute();
				
				$cq = $cq_arr->fetchallAssoc();
				?>
				<li class="pointer" onclick="$('#page_content').html(loader); $('#page_content').load('ajax/load/admin.menu.row.load.php?id=<?php echo $parent['id'] ?>');">&rsaquo; <?php echo $parent['name'] ?> (<?php echo $cq[0]['COUNT(*)'] ?>)</li>
                <li>
                	<ul class="left-menu">
				<?php
				$childs_query = "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=".$parent['id']." ORDER BY order_id";
			
				$childs_stmt = $dbh->prepare($childs_query);
				$childs_stmt->execute();
                	
				$childs_result = new DB_Result($childs_stmt);
				while($childs_result->Next())
				{
					?>
					<li  onclick="$('#page_content').html(loader); $('#page_content').load('ajax/load/admin.menu.row.load.php?id=<?php echo $childs_result->id ?>');">&rsaquo; <?php echo $childs_result->name ?></li>
					<?php
				}
				?>	
                	</ul>
				</li>
				<?php
			}
			?>
            </ul>
       </div>
		<?php
	}elseif($name == 'apps')
	{
		//require_once("../../controller.php");
		//$controller = new Controller();
		
		//mkdir("../../../wpmanager/split/applications/app-S",0777);
		//$controller->mtvc_Read_and_Copy_data_from_dir("../../../wpmanager/split/applications/app-N/","../../../wpmanager/split/applications/app-S/");
		
        	$apps_query = "SELECT * FROM [pre]admin_applications WHERE 1 ORDER BY id";
			
			$apps_stmt = $dbh->prepare($apps_query);
			$apps_arr = $apps_stmt->execute();
		
			$apps = $apps_arr->fetchallAssoc();
			
			
			$js_query	= "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=0 ORDER BY order_id";
			
			$js_stmt	= $dbh->prepare($js_query);
			$js_arr		= $js_stmt->execute();
		
			$js = $parents_arr->fetchallAssoc();
		?>
        <button class="right brown" type="button" onclick="$('#add_admin_app_wrap').slideToggle(0);">+ Добавить приложение</button>
        
        <h3>Админ <span class="click" onclick="load_sub_menu('admin','apps');">приложения</span><span id="loadProgress"></span> (<?php echo sizeof($apps) ?>)</h3>
        
        <div id="add_admin_app_wrap" class="hidden">
        	<fieldset>
                <legend>Добавить новый пункт меню:</legend>
                <form name="add_admin_app_form" action="ajax/insert/admin.app.insert.php" method="POST" target="_blank">
                <table>
                	<tr>
                    	<td>Название:</td>
                        <td><input type="text" name="name" value=""></td>
                    </tr>
                    <tr>
                    	<td>Описание</td>
                        <td>
                        	<textarea name="details"></textarea>	
                        </td>
                    </tr>
                    <tr>
                    	<td>Назначить приложением для:</td>
                        <td>
                        <select name="menu_id">
                        <option value="-1">Не указанно</option>
						<?php
                        foreach($parents as $parent)
						{
						?>
							<option value="<?php echo $parent['id'] ?>" disabled="disabled"><?php echo $parent['name'] ?></option>
						<?php
						$childs_query = "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=".$parent['id']." ORDER BY order_id";
			
						$childs_stmt	= $dbh->prepare($childs_query);
						$childs_arr		= $childs_stmt->execute();
						
						$childs = $childs_arr->fetchallAssoc();
						
						foreach($childs as $child)
							{
								$isset_query = "SELECT COUNT(*) FROM [pre]admin_menu_app_ref WHERE `menu_id`='".$child['id']."' LIMIT 1";
								
								$isset_stmt	= $dbh->prepare($isset_query);
								$isset_arr	= $isset_stmt->execute();
								
								$isset = $isset_arr->fetchallAssoc();
								
								$my_disabled = "";
								if($isset[0]['COUNT(*)'] > 0){ $my_disabled = "disabled"; }
								
								?>
								<option value="<?php echo $child['id'] ?>" <?php echo $my_disabled ?> > - <?php echo $child['name'] ?></option>
								<?php
							}
						}
						?>
                        </select>
                        </td>
                    </tr>
                </table>
                <button class="green" type="submit" onclick="$('#loadProgress').html(loader);">Добавить</button>
                </form>
            </fieldset>
        </div>
        
		<div id="page_content">
        	<ul class="left-menu">
			<?php	
			foreach($apps as $app)
			{
				?>
				<li class="pointer" onclick="$('#page_content').html(loader); $('#page_content').load('ajax/load/admin.app.row.load.php?id=<?php echo $app['id'] ?>');">&rsaquo; [ <?php echo $app['id'] ?> ] <?php echo $app['name'] ?></li>
				<?php
			}
			?>
            </ul>
       </div>
		<?php
	}
	?> 
</body>

<script type="text/javascript" language="javascript">
	$('form[name=add_admin_row_form]').ajaxForm(function(){
			load_sub_menu('admin','list');
		});
	$('form[name=add_admin_app_form]').ajaxForm(function(){
			load_sub_menu('admin','apps');
		});
</script>

</html>