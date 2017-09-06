<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../../require.base.php";
	
	require_once "../../../library/BasicHelp.php";
	
	class CardHelp extends BasicHelp
	{
		public $cat_id;
		public $groups;
		public $admin;
		public $product_groups;
		public $stock;
		public $shelfs;
		public $on_stock;
		public $on_sold;
		public $on_access;
		
		public function set_values($table,$id)
		{
			try
			{
			$this->table	= $table;
			$this->id 		= $id;
			}catch(Exception $e)
			{
				throw new Exception("Exc-1: "+$e->getMessage());
			}
			
			try
			{
			$query = "SELECT * FROM [pre]".$this->table." 
						WHERE `id`=".$this->id." 
						ORDER BY id LIMIT 1";
			$items = $this->rs($query);
			$this->item = $items[0];
			}catch(Exception $e)
			{
				throw new Exception("Exc-2: "+$e->getMessage());
			}
			
			try
			{
			$query = "SELECT cat_id FROM [pre]shop_cat_prod_ref 
						WHERE `prod_id`=".$this->id." 
						ORDER BY id LIMIT 1";
			$refs = $this->rs($query);
			$this->cat_id = ($refs ? $refs[0]['cat_id'] : 0);
			}catch(Exception $e)
			{
				throw new Exception("Exc-3: "+$e->getMessage());
			}
		
			try
			{
			$query = "SELECT * FROM [pre]shop_products_groups 
						WHERE 1 
						ORDER BY id LIMIT 1000";
			$items = $this->rs($query);
			$this->groups = ($items ? $items : array());
			}catch(Exception $e)
			{
				throw new Exception("Exc-4: "+$e->getMessage());
			}
			
			try
			{
			$query = "SELECT * FROM [pre]users 
						WHERE `id`=".$this->item['adminMod']." 
						ORDER BY id LIMIT 1";
			$items = $this->rs($query);
			$this->admin = ($items ? $items[0] : array());
			}catch(Exception $e)
			{
				throw new Exception("Exc-5: "+$e->getMessage());
			}
	
			try
			{
			$query = "SELECT G.id as id,G.name as name FROM [pre]shop_products_groups as G
						LEFT JOIN [pre]shop_prod_group_ref as REF on REF.group_id = G.id
						WHERE REF.prod_id = ".$this->id."
						ORDER BY G.name 
						LIMIT 1000";
			$items = $this->rs($query);
			$this->product_groups = ($items ? $items : array());
			}catch(Exception $e)
			{
				throw new Exception("Exc-6: "+$e->getMessage());
			}
			
			try
			{
			$query = "SELECT * FROM [pre]shop_products_shelf_ref as REF
						LEFT JOIN [pre]stock_fields as SF on REF.shelf_id = SF.id 
						LEFT JOIN [pre]stocks as S on SF.stock_id = S.id
						WHERE REF.product_code = '".$this->item['code']."'
						LIMIT 1";
				
			$items = $this->rs($query);
			$this->stock = ($items ? $items[0] : array());
			}catch(Exception $e)
			{
				throw new Exception("Exc-7: "+$e->getMessage());
			}
			
			try
			{
			$query = "SELECT * FROM [pre]shop_products_shelf_ref as REF
						LEFT JOIN [pre]stock_fields as SF on REF.shelf_id = SF.id
						WHERE REF.product_code = '".$this->item['code']."'
						LIMIT 100";
						
			$this->shelfs = $this->rs($query);
			}catch(Exception $e)
			{
				throw new Exception("Exc-8: "+$e->getMessage());
			}
			
			$this->on_stock = 0;
			$this->on_sold = 0;
			$this->on_access = 0;
			
			foreach($this->shelfs as $sh)
			{
				$this->on_stock += $sh['quant'];
				$this->on_sold += $sh['sold_quant'];
			}
			
			$this->on_access = ($this->on_stock - $this->on_sold);
		}
		
		public function cat_group_chars()
		{
			echo '<div id="wp-form-extra-fields-wrap">';
			if($this->cat_id)
			{
				$query = "SELECT specs_group_id FROM [pre]shop_catalog 
							WHERE `id`='".$this->cat_id."' 
							ORDER BY id LIMIT 1";
				$items = $this->rs($query);
				$group_id = $items[0]['specs_group_id'];
			
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
	
	$ph->set_values("shop_products",(int)$_POST['id']);
	
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
				'path'		=>	'shop_products/editProductGroups.php'
			 ),
		array(
				'type'		=>	'require',
				'path'		=>	'shop_products/editProductChars.php'
			 )
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load EDIT CARD OBJECT</title>
</head>

<body>
	<div class="ipad-20" id="order_conteinter">
    	<form name="save-item-form" action="<?php echo WP_FOLDER ?>ajax/edit/edit-object.php" method="POST" target="_blank">
            
            <input type="hidden" name="table" value='<?php echo $ph->table ?>'>
            <input type="hidden" name="id" value='<?php echo $ph->id ?>'>
            <input type="hidden" name="card_data" value='<?php echo serialize($card_data) ?>'>
            
           	<?php
            
				$ph->print_input("Название","name","Название товара",$ph->item['name'],25);
			
				$ph->print_select_tree("Категория","cat_id","Не выбрана",$ph->cat_id,"reload_extra_fields($(this).val());","shop_catalog");
				
				$ph->print_rotator("Публикация","block",$ph->item['block'],true);
				
				$ph->print_input("Артикул","sku","SKU",$ph->item['sku'],25);
				
				$ph->print_input("Штрих код","code","CODE",$ph->item['code'],25);
				
				$ph->print_input("Алиас","alias","Alias",$ph->item['alias'],25);
				
				$ph->print_input("Цена (грн)","price","Price",$ph->item['price'],25);
								
				$ph->print_input("Доступно (шт)","quant","Quant",$ph->item['quant'],25);
				
				$ph->print_multiselect("Группа товаров","groups",$ph->groups,$ph->product_groups);
				
				$ph->clear();
					
				$ph->print_area("Описание товара","details","Описание товара",$ph->item['details']);
				
				$ph->cat_group_chars();
				
				$ph->hr("Параметры публикации:");
				
				$ph->print_date("Начало публикации","date_start",$ph->item['date_start']);
				
				$ph->print_date("Конец публикации","date_finish",$ph->item['date_finish']);
				
				$ph->hr("Мета данные:");
				
				$ph->print_input("Title","title","SEO Title",$ph->item['title'],30);
				
				$ph->print_input("Description","desc","SEO Desc",$ph->item['desc'],30);
				
				$ph->print_input("Keywords","keys","SEO Keys",$ph->item['keys'],30);
				
				$ph->print_rotator("Индексация","index",$ph->item['index']);
			
			?>
            
            <input type="submit" class="hidden" value="SAVE ME">
        </form>
       
       		<?php
	   			$ph->hr("Изображения:");
			
       			$ph->show_card_images();
	   		?>
            
            <br><br>
            <h4>Информация:</h4>
            
            <table>
            	<tr>
                	<td>Автор:</td>
                    <td><?php echo $ph->admin['name']." ".$ph->admin['fname'] ?></td>
                </tr>
                <tr>
                	<td>Создан:</td>
                    <td><?php echo $ph->item['dateCreate'] ?></td>
                </tr>
                <tr>
                	<td>На складе:</td>
                    <td><?php echo $ph->on_stock ?></td>
                </tr>
                <tr>
                	<td>Доступно:</td>
                    <td><?php echo $ph->on_access ?></td>
                </tr>
                <tr>
                	<td>Склад:</td>
                    <td><?php echo $ph->stock['name'] ?></td>
                </tr>
                <tr>
                	<td>Ячейки:</td>
                    <td><?php 
						foreach($ph->shelfs as $i => $sh)
						{		
							echo ($i > 0 ? ", " : "");
							echo $sh['zona']."-".$sh['rack']."-".$sh['section']."-".$sh['shelf'];
						}
					 ?></td>
                </tr>
                <tr>
                	<td>ID товара:</td>
                    <td><?php echo $ph->id ?></td>
                </tr>
            </table>
        
        <div class="clear"></div>
        <div class="ajax" id="ajax-getter"></div>
        
    </div>
</body>
<script type="text/javascript" language="javascript">
	var admin_id	= <?php echo ADMIN_ID ?>;
	var wp_folder	= '<?php echo WP_FOLDER ?>';
	var card_table	= '<?php echo $ph->table ?>';
	var card_id		= '<?php echo $ph->id ?>';
	var app_id		= <?php echo $app_id ?>;
	var form_name	= 'save-item-form';
	var result_term = 'Объект успешно редактирован.';
</script>
<script type="text/javascript" language="javascript" src="<?php echo WP_FOLDER."js/helpCard.js" ?>"></script>

</html>