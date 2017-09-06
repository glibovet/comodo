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
	$id = $_GET['id'];
	
	$row_query = "SELECT * FROM [pre]admin_applications WHERE `id`=".$id;
			
	$row_stmt = $dbh->prepare($row_query);
	$row_arr = $row_stmt->execute();
		
	$row = $row_arr->fetchAssoc();
	
	$parents_query = "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=0 ORDER BY order_id";
			
			$parents_stmt = $dbh->prepare($parents_query);
			$parents_arr = $parents_stmt->execute();
		
			$parents = $parents_arr->fetchallAssoc();
?>

<body>
	<h4>Редактирование приложения <span><?php echo $row['name'] ?></span></h4>
				<form name="edit_admin_app_form" action="ajax/edit/admin.app.edit.php" method="POST" target="_blank">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <table>
                	<tr>
                    	<td>ID:</td>
                        <td><b><?php echo $row['id'] ?></b></td>
                    </tr>
                    <tr>
                    	<td>Название:</td>
                        <td><input type="text" name="name" value="<?php echo $row['name'] ?>"></td>
                    </tr>
                    <tr>
                    	<td>Блокировка:</td>
                        <td>
                        	<select name="block">
                            		<option <?php if($row['block'] == '0') echo 'selected' ?> value="0">Нет</option>
                                    <option <?php if($row['block'] == '1') echo 'selected' ?> value="1">Заблокировать</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td>Описание</td>
                        <td>
                        	<textarea name="details"><?php echo $row['details'] ?></textarea>	
                        </td>
                    </tr>
                    <tr>
                    	<td>Назначить приложением для:</td>
                        <td>
                        <select name="menu_id">
                        <option value="-1">Не указанно</option>
						<?php
						$menu_query = "SELECT * FROM [pre]admin_menu_app_ref WHERE `app_id`='".$id."' LIMIT 1";
						
						$menu_stmt = $dbh->prepare($menu_query);
						$menu_arr = $menu_stmt->execute();
	
						$ref = $menu_arr->fetchallAssoc();
						
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
								
								if(sizeof($ref) > 0 && $child['id'] == $ref[0]['menu_id'])
								{
								?>
								<option value="<?php echo $child['id'] ?>" selected="selected"> &raquo; <?php echo $child['name'] ?></option>
								<?php
								}else
								{
								?>
								<option value="<?php echo $child['id'] ?>" <?php echo $my_disabled ?> > - <?php echo $child['name'] ?></option>
								<?php
								}
							}
						}
						?>
                        </select>
                        </td>
                    </tr>
                </table>
                <button class="green" type="submit" onclick="$('#loadProgress').html(loader);">Сохранить</button>
                </form>
                
                <div id="save_result"></div>
                
                <form name="del_admin_app_row_form" action="ajax/delete/admin.app.row.delete.php" method="POST">
                					<input type="hidden" name="id" value="<?php echo $id ?>">
                                	<button title="Моментальное удаление вместе с файлами!" class="red right" type="submit" onclick="$('#loadProgress').html(loader);">Удалить</button>
								</form>
    
    <div class="clear"></div>
    
</body>

<script type="text/javascript" language="javascript">
	$('form[name=edit_admin_app_form]').ajaxForm(function(){
			saving_edit();
		});
	$('form[name=del_admin_app_row_form]').ajaxForm(function(){
			load_sub_menu('admin','apps');
		});
</script>

</html>