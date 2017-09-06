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
	$parents_query = "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=0";
			
			$parents_stmt = $dbh->prepare($parents_query);
			$parents_arr = $parents_stmt->execute();
		
			$parents = $parents_arr->fetchallAssoc();

	$id = $_GET['id'];
	
	$row_query = "SELECT * FROM [pre]admin_menu WHERE `id`=".$id;
			
	$row_stmt = $dbh->prepare($row_query);
	$row_arr = $row_stmt->execute();
		
	$row = $row_arr->fetchAssoc();
?>

<body>
	<h4>Редактирование пункта меню <span><?php echo $row['name'] ?></span></h4>
				<form name="edit_admin_row_form" action="ajax/edit/admin.menu.edit.php" method="POST" target="_blank">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <table>
                	<tr>
                    	<td>Название:</td>
                        <td><input type="text" name="name" value="<?php echo $row['name'] ?>"></td>
                    </tr>
                    <tr>
                    	<td>Алиас:</td>
                        <td><input type="text" name="alias" value="<?php echo $row['alias'] ?>"></td>
                    </tr>
                    <tr>
                    	<td>Вложенность:</td>
                        <td>
                        	<select name="parent">
                            		<option <?php if($row['parent'] == '0') echo 'selected' ?> value="0">Верхняя</option>
								<?php
                                foreach($parents as $parent)
								{
									?>
									<option <?php if($parent['id'] == $row['parent']) echo 'selected' ?> value="<?php echo $parent['id'] ?>"><?php echo $parent['name'] ?></option>
									<?php
								}
								?>
                            </select>
                        </td>
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
                    	<td>Порядковый номер:</td>
                        <td><input type="number" name="order_id" value="<?php echo $row['order_id'] ?>"></td>
                    </tr>
                    <tr>
                    	<td>Описание</td>
                        <td>
                        	<textarea name="details"><?php echo $row['details'] ?></textarea>	
                        </td>
                    </tr>
                </table>
                <button class="green" type="submit" onclick="$('#loadProgress').html(loader);">Сохранить</button>
                </form>
                
                <form name="del_admin_menu_row_form" action="ajax/delete/admin.menu.row.delete.php" method="POST">
                					<input type="hidden" name="id" value="<?php echo $id ?>">
                                	<button title="Моментальное удаление вместе с вложениями!" class="red right" type="submit" onclick="$('#loadProgress').html(loader);">Удалить</button>
								</form>
    
    <div class="clear"></div>
    
</body>

<script type="text/javascript" language="javascript">
	$('form[name=edit_admin_row_form]').ajaxForm(function(){
			load_sub_menu('admin','list');
		});
	$('form[name=del_admin_menu_row_form]').ajaxForm(function(){
			load_sub_menu('admin','list');
		});
</script>

</html>