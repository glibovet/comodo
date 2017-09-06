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

<title>Pages Type CARD</title>
</head>


<?php
	$id = $_GET['name'];
	
	$query = "SELECT * FROM [pre]page_types WHERE `id`='".$id."'";
	
	$_stmt = $dbh->prepare($query);
	$_res = $_stmt->execute();
	
	$data = $_res->fetchallAssoc();
	$item = $data[0];
	
	// Выбрать все группы приложений
	$query = ("SELECT * FROM [pre]applications_groups WHERE 1 ORDER BY id LIMIT 1000");
 
 	$_stmt = $dbh->prepare($query);
 	$_res = $_stmt->execute();
 	
 	$app_groups = $_res->fetchallAssoc();
	
	$it_data = $item['data'];
	
	$js_lim = 0;
	
	if(trim($it_data) != "")
	{
		$it_data = unserialize($it_data);
		$js_lim = sizeof($it_data);
	}
?>

<body>
	<?php
    	// echo '<pre>'; print_r(unserialize($item['data'])); echo '</pre>';
	?>
	<h4><?php echo $item['name']; ?></h4>
    <div class="wrap">
    	<fieldset>
    	<legend>Редактировать страницу:</legend>
        <form name="create-page-form" action="ajax/edit/sitePage.edit.php" method="POST" target="_blank">
        	<input type="hidden" name="id" value="<?php echo $id ?>">
            
        	<input type="text" class="if" name="name" placeholder="site page name" value="<?php echo $item['name'] ?>" id="new_page_name">
            <input type="text" class="if" name="alias" placeholder="alias" value="<?php echo $item['alias'] ?>" id="new_page_alias">
            
            <select class="if" name="block">
            	<option value="0" <?php if(!$item['block']) echo 'selected'; ?> >Включен</option>
                <option value="1" <?php if($item['block']) echo 'selected'; ?>>Выключен</option>
            </select>
        
        <div class="clear"></div>    
        
        <textarea class="ifa" name="details" placeholder="Описание страницы" id="new_page_details"><?php echo $item['details'] ?></textarea>
        
        
        <div class="clear"></div>
        <br>    
           
            <h5>Определить структуру страницы</h5>
            
            <select id="ag_list">
            	<option value="0">Выбрать группу приложений...</option>
            <?php
            foreach($app_groups as $apg)
			{
				?>
				<option value="<?php echo $apg['id'] ?>" title="<?php echo $apg['details'] ?>"><?php echo $apg['name'] ?></option>
				<?php
			}
			?>
            </select>
            <button type="button" class="mtvc-button add-button" onclick="add_checked_ag();">Добавить</button>
            <button type="button" class="mtvc-button" onclick="sort_ags();">Сортировать по порядку</button>
            
            <div class="clear"></div>
            
            <h4>Список групп приложений на странице:</h4>
            <div>[</div>
            <div id="create_ag_wrap" class="modify_list">
            	<ul class="inside">
                <?php
                if($it_data)
				{
					$lcount = 0;
					foreach($it_data as $it_item)
					{
						$lcount++;
						
						$query = ("SELECT `name` FROM [pre]applications_groups WHERE `id`='".$it_item['ag_id']."' ORDER BY id LIMIT 1");
 
 						$_stmt = $dbh->prepare($query);
 						$_res = $_stmt->execute();
 	
 						$agd = $_res->fetchallAssoc();
						$agd = $agd[0];
						?>
						<li count="<?php echo $lcount ?>" ag_id="<?php echo $it_item['ag_id'] ?>"><?php echo $agd['name'] ?>
                        	<span class="delete" onclick="delete_one_ag(<?php echo $lcount ?>);"></span>
                            <span class="edit" onclick="edit_one_ag(<?php echo $lcount ?>);"></span>
                            <textarea name="divs[]" class="divs" placeholder="first div &crarr; second div &crarr; ..."><?php echo $it_item['divs'] ?></textarea>
                            <select class="block" name="blocks[]">
                            	<option value="0" <?php if(!$it_item['block']) echo 'selected' ?> >Вкл</option>
                                <option value="1" <?php if($it_item['block']) echo 'selected' ?> >Выкл</option>
                            </select>
                            <input name="ags[]" type="hidden" value="<?php echo $it_item['ag_id'] ?>" />
                            <input name="sort[]" id="sorts-<?php echo $lcount ?>" class="sort" type="number" placeholder="0" value="<?php echo $lcount ?>" />
                        </li>
						<?php
					}
				}
				?>
                </ul>
            </div>
            <div>]</div>
            
        
        <div class="clear"></div>    
        <br>
            <button type="submit" class="mtvc-button add-button">Сохранить изменения</button>
        </form>
        
        <div id="test">TEST</div>
        
    </fieldset>
    </div>
</body>

<script type="text/javascript" language="javascript">
	list_count = <?php echo $js_lim ?>;
	
	function add_checked_ag()
	{
		list_count++;
		ag_id = $('#ag_list option:checked').val();
		ag_name = $('#ag_list option:checked').html();
		if(ag_id > 0)
		{
			$('#create_ag_wrap ul.inside').append('<li count="'+list_count+'" ag_id="'+ag_id+'">'+ag_name+' <span class="delete" onclick="delete_one_ag('+list_count+');"></span><span class="edit" onclick="edit_one_ag('+list_count+');"></span><textarea name="divs[]" class="divs" placeholder="first div &crarr; second div &crarr; ..."></textarea><select class="block" name="blocks[]"><option value="0" selected >Вкл</option><option value="1">Выкл</option></select><input name="ags[]" type="hidden" value="'+ag_id+'" /><input id="sorts-'+list_count+'" name="sort[]" class="sort" type="number" placeholder="0" value="'+list_count+'" /></li>');
		}
	}
	function delete_one_ag(id)
	{
		$('#create_ag_wrap ul.inside li[count='+id+']').remove();
	}
	function edit_one_ag(id)
	{
		$('#create_ag_wrap ul.inside li[count!='+id+'] textarea.divs').hide(200);
		$('#create_ag_wrap ul.inside li[count='+id+'] textarea.divs').slideToggle(200);
	}

	
	function sort_ags()
	{
		var lis = [];
		$('#create_ag_wrap ul.inside li').each(function(){
				var my_li = $(this);
				var my_sort = $('input#sorts-'+my_li.attr('count')).val();
				lis[my_sort] = my_li.html();
			});
			
		lis.forEach(function(item){
				alert(item);
			})
	}
	
</script>

</html>