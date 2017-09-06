<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
	
	require_once "../../../library/BasicHelp.php";
	
	class CardHelp extends BasicHelp
	{
		public $groups;
		public $curtime;
		public $fulltime;
		
		public function set_values($table)
		{
			$this->table	= $table;
			$this->curtime	= date("Y-m-d",time());
			$this->fulltime	= date("Y-m-d",time()+(3600*24*365));
		
			$query = "SELECT * FROM [pre]shop_products_groups 
						WHERE 1 
						ORDER BY id LIMIT 1000";
			$this->groups = $this->rs($query);
		}
		
		public function cat_group_chars()
		{
			echo '<div id="wp-form-extra-fields-wrap">';
			if($this->cat_id)
			{
				$query = "SELECT group_id FROM [pre]shop_cat_chars_group_ref 
							WHERE `cat_id`='".$this->cat_id."' 
							ORDER BY id LIMIT 1";
				$items = $this->rs($query);
				$group_id = $items[0]['group_id'];
			
				$query = "SELECT * FROM [pre]shop_chars_groups 
							WHERE `id`='".$group_id."' 
							ORDER BY id LIMIT 1";
            	$items = $this->rs($query);
				$group = $items[0];
			
				$query = "SELECT * FROM [pre]shop_chars 
							WHERE `group_id`='".$group_id."' 
							ORDER BY id LIMIT 100";
				$chars = $this->rs($query);
				
				if(sizeof($chars) == 0)
				{
					echo "<br><p>Для выбранной категории не назначена ни одна группа характеристик.</p>";
				}else
				{
			
				?>
            	<br>
                <p title="<?php echo $group['details'] ?>">Группа свойств: <b><?php echo $group['name'] ?></b></p>
                <br>
				<table class="chars-table">
				<?php
				foreach($chars as $char)
				{
					$query = "SELECT id,value FROM [pre]shop_chars_prod_ref WHERE `char_id`='".$char['id']."' AND `prod_id`='".$this->id."' LIMIT 1";
					
					$cvs = $this->rs($query);
					$cv = ($cvs ? $cvs[0]['value'] : "");
					?>
					<tr>
                    	<td><?php echo $char['name']; if(trim($char['measure']) != "") echo ", ".$char['measure'] ?></td>
                        <td>
					<?php
							if($char['type'] == "DATETIME")
							{
								$cv = date("Y-m-d",strtotime($cv));
						?>
                				<input	id="char-<?php echo $char['id'] ?>" 
                                		class="my-field"
                                		type="date" 
                                        placeholder="Выберите дату" 
                                        value="<?php echo date("Y.m.d",strtotime($cv)) ?>" 
                                        name="char[<?php echo $char['id'] ?>]"
                                />
						<?php	
							}else
							{
						?>
								<input	id="char-<?php echo $char['id'] ?>" 
                                		class="my-field"
                                		type="text" 
                                        placeholder="<?php echo $char['name'] ?>" 
                                        value="<?php echo $cv ?>" 
                                        name="char[<?php echo $char['id'] ?>]" 
                                        size="25"
                                        maxlength="100"
                                />
						<?php
							}
						?>
						</td>
						<?php
				}
				?>
				</table>
				<?php
				}
			}
			echo '</div>';
		}
	} // end of Class
	
	
	$ph = new CardHelp($dbh);
	
	$ph->set_values("shop_products");
	
	$app_id = 20;
	
	$card_data = array
	(
		array(
				'type'		=>	'simple',
				'table'		=>	$ph->table,
				'fields'	=>	array(
									 	array('type' => 'varchar',	'field' => 'name'),
										array('type' => 'varchar',	'field' => 'alias'),
										array('type' => 'varchar',	'field' => 'sku'),
										array('type' => 'varchar',	'field' => 'code'),
										array('type' => 'float',	'field' => 'price'),
										array('type' => 'rotator',	'field' => 'block'),
										array('type' => 'rotator',	'field' => 'index'),
										array('type' => 'varchar',	'field' => 'title'),
										array('type' => 'varchar',	'field' => 'keys'),
										array('type' => 'varchar',	'field' => 'desc'),
										array('type' => 'int',		'field' => 'quant'),
										array('type' => 'text',		'field' => 'details'),
										array('type' => 'date',		'field' => 'date_start'),
										array('type' => 'date',		'field' => 'date_finish')
									 )
			 ),
		array(
				'type'		=>	'require',
				'path'		=>	'shop_products/setProductCategory.php'
			 ),
		array(
				'type'		=>	'require',
				'path'		=>	'shop_products/insertProductGroups.php'
			 ),
		array(
				'type'		=>	'require',
				'path'		=>	'shop_products/insertProductChars.php'
			 ),
		array(
				'type'		=>	'require',
				'path'		=>	'shop_products/insertProductImages.php'
			 )
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load CREATE USER</title>
</head>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="create-item-form" action="<?php echo WP_FOLDER ?>ajax/insert/create-object.php" method="POST" target="_blank">
        	
            <input type="hidden" name="table" value='<?php echo $ph->table ?>'>
            <input type="hidden" name="card_data" value='<?php echo serialize($card_data) ?>'>
            
        <?php
            
				$ph->print_input("Название","name","Название товара","",25);
			
				$ph->print_select_tree("Категория","cat_id","Не выбрана",0,"reload_extra_fields($(this).val());","shop_catalog");
				
				$ph->print_rotator("Публикация","block",0,true);
				
				$ph->print_input("Артикул","sku","SKU","",25);
				
				$ph->print_input("Штрих код","code","CODE","",25);
				
				$ph->print_input("Алиас","alias","Alias","",25);
				
				$ph->print_input("Цена (грн)","price","Price",0,25);
								
				$ph->print_input("Доступно (шт)","quant","Quant",0,25);
				
				$ph->print_multiselect("Группа товаров","groups",$ph->groups,array());
				
				$ph->clear();
					
				$ph->print_area("Описание товара","details","Описание товара","");
				
				$ph->cat_group_chars();
				
				$ph->hr("Параметры публикации:");
				
				$ph->print_date("Начало публикации","date_start",$ph->curtime);
				
				$ph->print_date("Конец публикации","date_finish",$ph->fulltime);
				
				$ph->hr("Мета данные:");
				
				$ph->print_input("Title","title","SEO Title","Zen cosmetics",30);
				
				$ph->print_input("Description","desc","SEO Desc","Zen cosmetics",30);
				
				$ph->print_input("Keywords","keys","SEO Keys","Zen cosmetics",30);
				
				$ph->print_rotator("Индексация","index",1);
			
			?>
            
            <input type="submit" class="hidden" value="SAVE ME">
        </form>
       
       		<?php
	   			$ph->hr("Изображения:");
			
       			$ph->show_card_images();
	   		?>
        
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id	= <?php echo ADMIN_ID ?>;
	var wp_folder	= '<?php echo WP_FOLDER ?>';
	var card_table	= '<?php echo $ph->table ?>';
	var card_id		= 0;
	var app_id		= <?php echo $app_id ?>;
	var result_term = 'Объект успешно создан.';
	var form_name	= 'create-item-form';
</script>
<script type="text/javascript" language="javascript" src="<?php echo WP_FOLDER."js/helpCard.js" ?>"></script>

</html>