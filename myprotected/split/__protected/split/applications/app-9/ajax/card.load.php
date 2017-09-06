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

<title>Load EDIT USER</title>
</head>

<?php
	$app_id = 9;
	
	$user_id = $_POST['id'];
	
	$user_query = "SELECT * FROM [pre]users WHERE `id`='".$user_id."' ORDER BY id LIMIT 1";
			
		$user_stmt = $dbh->prepare($user_query);
		$user_arr = $user_stmt->execute();
		$user = $user_arr->fetchallAssoc();
		
		$user = $user[0];
		
		if($user['male'] == "М") $user['male'] = 0; else $user['male'] = 1;
	
	$types_query = "SELECT * FROM [pre]users_types WHERE `block`=0 ORDER BY id LIMIT 1000";
			
		$types_stmt = $dbh->prepare($types_query);
		$types_arr = $types_stmt->execute();
		$types = $types_stmt->fetchallAssoc();
		
	// Вытягиваем все группы дополнительных полей для зарегистрированных пользователей из таблицы users_types_extra_field_ref
	$reg_user_ef_groups_query = "SELECT * FROM [pre]users_types_extra_field_ref WHERE `group_id`='".$user['type']."' ORDER BY id LIMIT 100";
	
		$reg_user_ef_groups_stmt = $dbh->prepare($reg_user_ef_groups_query);
		$reg_user_ef_groups_arr = $reg_user_ef_groups_stmt->execute();
		$reg_user_ef_groups = $reg_user_ef_groups_arr->fetchallAssoc();
?>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="save-user-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-user.php" method="POST" target="_blank">
            
            <div class="zen-form-item">
				<label for="create-name">Имя*</label><br>
				<div class="zif-wrap">
                	<input id="create-name" class="my-field" type="text" placeholder="Введите имя" value="<?php echo $user['name'] ?>" name="name" size="25" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-fname">Фамилия*</label><br>
				<div class="zif-wrap">
                	<input id="create-fname" class="my-field" type="text" placeholder="Введите фамилию" value="<?php echo $user['fname'] ?>" name="fname" size="25" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-email">Email*</label><br>
				<div class="zif-wrap">
                	<input id="create-email" class="my-field" type="email" placeholder="Введите email" value="<?php echo $user['login'] ?>" name="email" size="25" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-type">Группа</label><br>
				<div class="zif-wrap-select styled-select">               	
					<select class="sampling_changed" id="create-type" name="type" onchange="reload_extra_fields($(this).val());">
						<option value="0" <?php if($user['type'] == 0) echo 'selected="selected" data-skip="1"'; ?> >Зарегистрированный</option>
						<?php
                        foreach($types as $type)
						{
							?><option value="<?php echo $type['id'] ?>" <?php if($user['type'] == $type['id']) echo 'selected="selected" data-skip="1"'; ?>><?php echo $type['name'] ?></option><?php
						}
						?>
					</select>
				</div>
			</div>
            
            <div class="zen-form-item">
				<label for="radio-block-yes">Опубликован</label><br>
                <div class="hidden">
                	<input type="radio" name="block[]" id="radio-block-yes" value="0" <?php if(!$user['block']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="block[]" id="radio-block-no" value="1"<?php if($user['block']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if(!$user['block']) echo 'active'; ?>" id="block-yes" onclick="change_rotator('block','yes','no');">Да</div>
                        <div class="item_yn <?php if($user['block']) echo 'active'; ?>" id="block-no" onclick="change_rotator('block','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-old-pass">Старый Пароль*</label><br>
				<div class="zif-wrap">
                	<input id="create-old-pass" class="my-field" type="password" placeholder="Старый Пароль" value="" name="old_pass" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-pass">Новый Пароль*</label><br>
				<div class="zif-wrap">
                	<input id="create-pass" class="my-field" type="password" placeholder="Новый Пароль" value="" name="pass" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-repass">Пароль повторно*</label><br>
				<div class="zif-wrap">
                	<input id="create-repass" class="my-field" type="password" placeholder="Проверка" value="" name="repass" size="20" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-phone">Телефон</label><br>
				<div class="zif-wrap">
                	<span>+</span><input id="create-phone" class="my-field" type="text" placeholder="38 (096) 000-00-00" value="<?php echo $user['phone'] ?>" name="phone" size="18"
                    onkeypress="valid_phone($(this).val());" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-birthday">Дата рождения</label><br>
				<div class="zif-wrap-date">
                	<input id="create-birthday" class="my-field" type="date" placeholder="Проверка" value="<?php echo date("Y-m-d",strtotime($user['birthday'])) ?>" name="birthday" size="25" />
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-male-yes">Пол</label><br>
                <div class="hidden">
                	<input type="radio" name="male[]" id="radio-male-yes" value="0" <?php if(!$user['male']) echo 'checked="checked"'; ?> >
                    <input type="radio" name="male[]" id="radio-male-no" value="1" <?php if($user['male']) echo 'checked="checked"'; ?> >
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if(!$user['male']) echo 'active'; ?>" id="male-yes" onclick="change_rotator('male','yes','no');">М</div>
                        <div class="item_yn <?php if($user['male']) echo 'active'; ?>" id="male-no" onclick="change_rotator('male','no','yes');">Ж</div>
                    </div>
                </div>
            </div>
            
            <div class="zen-form-item">
				<label for="create-active-yes">Подтвержден</label><br>
                <div class="hidden">
                	<input type="radio" name="avtice[]" id="radio-active-yes" value="1" <?php if($user['active']) echo 'checked="checked"'; ?>>
                    <input type="radio" name="active[]" id="radio-active-no" value="0" <?php if(!$user['active']) echo 'checked="checked"'; ?>>
                </div>
				<div class="zif-wrap-rotator">
                	<div class="check_yn">
                    	<div class="item_yn <?php if($user['active']) echo 'active'; ?>" id="active-yes" onclick="change_rotator('active','yes','no');">Да</div>
                        <div class="item_yn <?php if(!$user['active']) echo 'active'; ?>" id="active-no" onclick="change_rotator('active','no','yes');">Нет</div>
                    </div>
                </div>
            </div>
            
            <div class="clear"></div>
            
            <div id="wp-form-extra-fields-wrap">
            <?php
            	foreach($reg_user_ef_groups as $reg_user_ef_group)
				{
					$ef_group_id = $reg_user_ef_group['ef_group_id'];
					// Вытягиваем группу дополнительных полей из таблицы users_extra_fields_groups
					$ef_group_query = "SELECT * FROM [pre]users_extra_fields_groups WHERE `id`='".$ef_group_id."' LIMIT 1";
	
						$ef_group_stmt = $dbh->prepare($ef_group_query);
						$ef_group_arr = $ef_group_stmt->execute();
						$ef_group = $ef_group_stmt->fetchallAssoc();
						$ef_group = $ef_group[0];
						
						// Выводим название группы дополнительных полей
						?>
							<div class="clear"></div>
                        	<h4><?php echo $ef_group['name'] ?></h4>
						<?php
					
					// Вытягиваем дополнительные поля группы из таблиц users_ef_group_ref и user_extra_fields
					$extra_fields_query = "SELECT * FROM [pre]user_extra_fields as EF
											   LEFT JOIN [pre]users_ef_group_ref AS REF on EF.id = REF.ef_id
											   WHERE REF.group_id = '".$ef_group_id."'
											   ORDER BY EF.id
											   LIMIT 100";
	
						$extra_fields_stmt = $dbh->prepare($extra_fields_query);
						$extra_fields_arr = $extra_fields_stmt->execute();
						$extra_fields = $extra_fields_arr->fetchallAssoc();
						
						foreach($extra_fields as $ef) // Выводим дополниьедльные поля в HTML
						{
							$value_query = "SELECT * FROM [pre]user_ef_ref WHERE `user_id`='".$user_id."' AND `ef_id`='".$ef['ef_id']."' LIMIT 1";
	
								$value_stmt = $dbh->prepare($value_query);
								$value_arr = $value_stmt->execute();
								$value = $value_arr->fetchallAssoc();
							
								$value = $value[0]['value'];
							
							if($ef['type'] == "DATETIME")
							{
						?>
							<div class="zen-form-item">
								<label for="extra-field-<?php echo $ef['ef_id'] ?>" title="<?php echo $ef['details'] ?>"><?php echo $ef['name'] ?></label><br>
								<div class="zif-wrap-date">
                				<input	id="extra-field-<?php echo $ef['ef_id'] ?>" 
                                		class="my-field"
                                		type="date" 
                                        placeholder="Выберите дату" 
                                        value="<?php echo date("Y-m-d",strtotime($value)) ?>" 
                                        name="ef_date[<?php echo $ef['ef_id'] ?>]"
                                />
                				</div>
            				</div>
						<?php	
							}else
							{
						?>
							<div class="zen-form-item">
								<label for="create-type" title="<?php echo $ef['details'] ?>"><?php echo $ef['name'] ?></label><br>
								<div class="zif-wrap">
                				<input	id="extra-field-<?php echo $ef['ef_id'] ?>" 
                                		class="my-field"
                                		type="text" 
                                        placeholder="<?php echo $ef['default'] ?>" 
                                        value="<?php echo $value ?>" 
                                        name="ef[<?php echo $ef['ef_id'] ?>]" 
                                        size="<?php echo $ef['length'] ?>"
                                        maxlength="<?php echo $ef['length'] ?>"
                                />
                				</div>
            				</div>
						<?php
							}
						}
				}
			?>
            </div><!-- wp-form-extra-fields-wrap -->
            
        </form>
        
        	<div class="clear"></div>
            
            <div class="photo-frame" id="photo-frame-1">
            <?php
            	if(trim($user['avatar']) != "" && $user['avatar'] != "0")
				{
			?>
				<img alt="Photo Not Found" src="../<?php echo WP_FOLDER."files/users/crop/150x150_".$user['avatar'] ?>" title="Аватар пользователя">
			<?php
				}else
				{
			?>
            	<img alt="Photo" src="<?php echo WP_FOLDER."img/ava-tmp.png" ?>" title="Место под фото">
            <?php
				}
			?>
            </div>
            	<form id="f1" name="create-user-avatar-form" action="<?php echo WP_FOLDER."ajax/insert/preload-avatar.php" ?>" method="POST" enctype="multipart/form-data" target="_blank">
                	<input type="hidden" name="admin_id" value="<?php echo ADMIN_ID ?>">
                    <input name="file" type="file" class="hidden" id="user-avatar-input" 
                    	   onchange="$('#file-1-name').html($(this).val()); $('#ava-submit').show(200);"
                    >
                    <a href="javascript:void(0);" title="Загрузить аватарку (квадрат jpeg/png)" onclick="$('#user-avatar-input').click();">Изменить</a>
                    <div id="file-1-name"></div>
                    <div><button type="submit" class="hidden" id="ava-submit">Загрузить файл</button></div>
                </form>
        
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id = <?php echo ADMIN_ID ?>;
	$(function(){
			$('form[name=save-user-form]').ajaxForm(function(){
					$('#ajax-getter').load('<?php echo WP_FOLDER."ajax/load/create-user.status.php" ?>',function(){
						});
				});
			$('form[name=create-user-avatar-form]').ajaxForm(function(){
					$('#photo-frame-1').html('<br><br>Loading...');
					var data = { admin_id:admin_id }
					$('#photo-frame-1').load('<?php echo WP_FOLDER."ajax/load/preload-avatar.load.php" ?>',data,function(){
							$('#file-1-name').html('Файл загружен.');
							$('#ava-submit').hide(200);
						});
				});
		});
	function valid_phone(phone)
	{	
	}
	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');
		
		$('#radio-'+id+'-'+place).click();
	}
	
	function submit_save_form(choice)
	{
		$('#ajax-getter').html('Loading...');
		$('form[name=create-user-form]').submit();
		
		switch(choice)
		{
			case 1: // Сохранить и дублировать
					{
						break;
					} 
			case 2: // Сохранить и редактировать
					{
						break;
					} 
			case 3: // Сохранить и закрыть
					{
						change_head(1); 
						load_app_content(content_path,<?php echo $app_id ?>);
						break;
					} 
			case 4: // Сохранить и создать
					{
						break;
					} 
			default: break;
		}
	}
	function reload_extra_fields(id)
	{
		$('#wp-form-extra-fields-wrap').html('Loading...');
		$('#wp-form-extra-fields-wrap').load('<?php echo WP_FOLDER ?>ajax/load/reload-extra-fields.php?id='+id);
	}
</script>

</html>