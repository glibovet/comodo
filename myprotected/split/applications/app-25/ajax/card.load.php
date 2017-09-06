<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>TOTAL CONFIG</title>
</head>

<?php
	$app_id = 25;
	
	$item_id = 1;
	
	$item_query = "SELECT * FROM [pre]total_config WHERE `id`='".$item_id."' ORDER BY id LIMIT 1";
			
		$item_stmt = $dbh->prepare($item_query);
		$item_arr = $item_stmt->execute();
		$item = $item_arr->fetchallAssoc();
		
	$item = $item[0];
	
	$author_id = $item['adminMod'];
	
	$author_query = "SELECT * FROM [pre]users WHERE `id` = :1 LIMIT 1";
	
		$author_stmt = $dbh->prepare($author_query);
		$author_arr = $author_stmt->execute($author_id);
		$author = $author_arr->fetchallAssoc();
		
	$author = $author[0];
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="save-item-form" action="<?php echo WP_FOLDER ?>ajax/edit/save-total-config.php" method="POST" target="_blank">
            
            <input type="hidden" name="id" value="<?php echo $item_id ?>">
            
            <div class="zen-form-item">
				<label for="create-sitename">Название сайта</label><br>
				<div class="zif-wrap">
                	<input	id="create-sitename" class="my-field" type="text" placeholder="Укажите название сайта" value="<?php echo $item['sitename'] ?>" 
                    		name="sitename" size="25" maxlength="25" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-active-yes">Включить</label><br>
                <div class="hidden">
                	<input type="radio" name="active[]" id="radio-active-yes" value="1" <?php if(!$item['active']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="active[]" id="radio-active-no" value="0"<?php if($item['active']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if($item['active']) echo 'active'; ?>" id="active-yes" onclick="change_rotator('active','yes','no');">Да</div>
                        <div class="item_yn <?php if(!$item['active']) echo 'active'; ?>" id="active-no" onclick="change_rotator('active','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-editor-yes">Текст редактор</label><br>
                <div class="hidden">
                	<input type="radio" name="editor[]" id="radio-editor-yes" value="1" <?php if(!$item['editor']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="editor[]" id="radio-editor-no" value="0"<?php if($item['editor']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if($item['editor']) echo 'active'; ?>" id="editor-yes" onclick="change_rotator('editor','yes','no');">Да</div>
                        <div class="item_yn <?php if(!$item['editor']) echo 'active'; ?>" id="editor-no" onclick="change_rotator('editor','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="radio-index-yes">Индексировать</label><br>
                <div class="hidden">
                	<input type="radio" name="index[]" id="radio-index-yes" value="1" <?php if($item['index']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="index[]" id="radio-index-no" value="0"<?php if(!$item['index']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if($item['index']) echo 'active'; ?>" id="index-yes" onclick="change_rotator('index','yes','no');">Да</div>
                        <div class="item_yn <?php if(!$item['index']) echo 'active'; ?>" id="index-no" onclick="change_rotator('index','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="clear"></div>
            
            <br>
            <p>Мета данные главной страницы</p>
            
            <div class="zen-form-item">
				<label for="create-title">META Title</label><br>
				<div class="zif-wrap">
                	<input	id="create-title" class="my-field" type="text" placeholder="Title" value="<?php echo $item['meta_title'] ?>" 
                    		name="title" size="25" maxlength="50" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-keys">META Keys</label><br>
				<div class="zif-wrap">
                	<input	id="create-keys" class="my-field" type="text" placeholder="Keywords" value="<?php echo $item['meta_keys'] ?>" 
                    		name="keys" size="25" maxlength="100" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-desc">META DESC</label><br>
				<div class="zif-wrap">
                	<input	id="create-desc" class="my-field" type="text" placeholder="Description" value="<?php echo $item['meta_desc'] ?>" 
                    		name="desc" size="50" maxlength="255" />
                </div>
            </div>
            
            </form>
            
            <div class="clear"></div>
            
            <br><br>
            
            <div class="clear"></div>
        	<div class="ajax" id="ajax-getter"></div>
            
            <br><br>
            
            <div class="card-information">
            	<p>Информация:</p>
                <table class="maintable">
                	<tr class="trcolor">
                    	<td>Автор:</td>
                        <td><?php echo $author['name']." ".$author['lname'] ?></td>
                    </tr>
                    <tr class="">
                    	<td>Последние изменения:</td>
                        <td><?php echo $item['dateModify'] ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="clear"></div>
            
            <div id="wp-form-extra-fields-wrap">
            </div><!-- wp-form-extra-fields-wrap -->
        
        	<div class="clear"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id = <?php echo ADMIN_ID ?>;
	$(function(){
			$('form[name=save-item-form]').ajaxForm(function(){
					$('#ajax-getter').html('Изменения успешно вступили в силу.');
				});
		});
		
	function save_config()
	{
		$('#ajax-getter').html('Сохранение...');
		$('form[name=save-item-form]').submit();
	}	
	
	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');
		
		$('#radio-'+id+'-'+place).click();
	}
</script>

</html>