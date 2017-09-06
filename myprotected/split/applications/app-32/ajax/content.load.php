<?php 
	//********************
	//** WEB INSPECTOR
	//******************** Application 32 : Складские ячейки
	
	require_once "../../../../require.base.php";
	
	$app_id = (int)$_POST['app_id'];
	
	$card_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/card.load.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load STOCK FIELDS</title>
</head>

<?php
	$on_page = $_POST['on_page'];;
	$start_page = $_POST['start_page'];
	$pages = 1;
	
	$query = "SELECT COUNT(*) FROM [pre]stock_fields WHERE `rack`!= :1 AND `section`!= :2 AND `shelf`!= :3 ORDER BY id";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute(-1,-1,-1);
			$users = $users_arr->fetchallAssoc();
			
	$pages = ceil($users[0]['COUNT(*)']/$on_page);
			
	$query = "SELECT * FROM [pre]stock_fields WHERE `rack`!= :1 AND `section`!= :2 AND `shelf`!= :3 ORDER BY stock_id LIMIT ".($start_page-1)*$on_page.",".$on_page;
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute(-1,-1,-1);
		
			$users = $users_arr->fetchallAssoc();
			//echo '<pre>'; print_r($users); echo '</pre>';
	
	$data = $users;
	
	$cnt = 0;
	foreach($data as $item_num => $item_val)
	{
		$cnt++;
		
		//				Устанавливаем зебру в строках
		if($cnt%2 == 1)
		{
			$data[$item_num]['row_class']  = 'trcolor';
		}else
		{
			$data[$item_num]['row_class']  = '';
		}
		
		//				Указываем состояния для колонки Опубликовано
		if($item_val['block'] == "0")
		{
			$data[$item_num]['publish_class'] = "published";
			$data[$item_num]['block'] = "Да";
		}else
		{
			$data[$item_num]['publish_class'] = "not-published";
			$data[$item_num]['block'] = "Нет";
		}
		
		switch($item_val['fullness'])
		{
			case 0: $data[$item_num]['fullness'] = "Пустая"; break;
			case 1:  $data[$item_num]['fullness'] = "Не полная"; break;
			case 2:  $data[$item_num]['fullness'] = "Полная"; break;
			
			default:  $data[$item_num]['fullness'] = "Неизвестно"; break;
		}
		
	}
?>

<body>
			<div class="r-z-c-table">
                <table class="maintable" id="main-table">
                    <div class="head-tr">
                    	<th class="main-t-th check-col" style="line-height:37px; padding-left:4px;">
                        	<input	type="checkbox" 
                            		name="checkerAll" 
                                    class="table-checkbox" 
                                    id="checkAll"
                                    value="null" 
                                    onclick="select_all_checked();">
                             <label	class="tab-check-lab" 
                            		for="checkAll">&nbsp;&nbsp;</label>
                        </th>
                        <th class="main-t-th" style=""># Ячейки</th>
                        <th class="main-t-th" style="">Склад, id</th>
                        <th class="main-t-th" style="">Зона</th>
                        <th class="main-t-th" style="">Степлаж</th>
                        <th class="main-t-th" style="">Секция</th>
                        <th class="main-t-th" style="">Полка</th>
                        <th class="main-t-th" style="">Публикация</th>
                        <th class="main-t-th" style="">Заполненность</th>
                        <th class="main-t-th" style="">Кол-во товаров</th>
                    </div>
                	<tbody>
				<?php
                	foreach($data as $row)
					{
						
						$products_query = "SELECT * FROM [pre]shop_products_shelf_ref WHERE `shelf_id`= :1 ORDER BY dateCreate DESC LIMIT 1000";		
							
							$products_stmt = $dbh->prepare($products_query);
							$products_arr = $products_stmt->execute($row['id']);
		
							$products = $products_arr->fetchallAssoc();
							
							$shelf_quant = 0;
							
							foreach($products as $shelf_products)
							{
								//$shelf_quant += $shelf_products['quant'];
							}
						
				?><tr class="<?php echo $row['row_class'] ?>" id="<?php echo $row['id'] ?>">
                        <td class="check-col">
                        	<input	type="checkbox" 
                            		name="checker<?php	echo $row['id'] ?>" 
                                    class="table-checkbox" 
                                    id="check<?php 		echo $row['id'] ?>"
                                    value="<?php 		echo $row['id'] ?>"
                                    onchange="scan_active_checked();" >
                            <label	class="tab-check-lab" 
                            		for="check<?php 	echo $row['id'] ?>">&nbsp;&nbsp;</label>
                        </td>
                         <td class="main-t-td-name">
                        	<div><a href="javascript:void(0);" onclick="change_head(3); load_card(card_path,<?php echo $row['id'] ?>);"><?php echo $row['id'] ?></a></div>
                        </td>
                        <td><?php echo $row['stock_id'] ?></td>
                        <td><?php echo $row['zona'] ?></td>
                        <td class="main-t-td-name">
                        	<div><a href="javascript:void(0);" onclick=""><?php echo $row['rack'] ?></a></div>
                        </td>
                        <td><?php echo $row['section'] ?></td>
                        <td><?php echo $row['shelf'] ?></td>
                        <td class="publication">
                        	<div class="<?php echo $row['publish_class'] ?>"></div>
                            <span><?php echo $row['block'] ?></span>
                        </td>
                        <td><?php echo $row['fullness'] ?></td>
                        <td><?php echo $shelf_quant ?></td>
                        </tr>
                <?php
					}
				?>     
                	</tbody>
                </table>
            </div><!-- r-z-c-table -->
            
            <div class="manage-pages">
           	<?php
            	$frst_page = 1;
				$prev_page = 1;
				$next_page = $pages;
				$last_page = $pages;
				
				if($start_page < $pages) $next_page = $start_page+1;
				if($start_page > 1) $prev_page = $start_page-1;
			?>
                <div class="page-navigation">
                	<button id="leap-back" class="page-nav-step" type="button" onclick="reload_content(<?php echo $frst_page ?>,<?php echo $on_page ?>);"> << </button>
                    <button id="step-back" class="page-nav-step" type="button" onclick="reload_content(<?php echo $prev_page ?>,<?php echo $on_page ?>);"> < </button>
                    
                    <?php
                    	if($pages > 7)
						{
							if($start_page > ($pages-6))
							{
							?>
					<ul id="page-nav-left-items" class="page-nav-items">
                    <?php
                    	for($i = $pages-6; $i <= $pages-4; $i++)
						{
						?>
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>);"><?php echo $i ?></a></li>
						<?php
						}
					?>
                    </ul><!-- page-nav-left-items -->
							<?php
							}else
							{
							?>
                   <ul id="page-nav-left-items" class="page-nav-items">
                    <?php
                    	for($i = $start_page; $i <= $start_page+2; $i++)
						{
						?>
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>);"><?php echo $i ?></a></li>
						<?php
						}
					?>
                    </ul><!-- page-nav-left-items -->
							<?php
							}
					?>
                    
                    <div class="page-nav-ellipsis">...</div>
                    
                    <ul id="page-nav-right-items" class="page-nav-items">
                    <?php
                    	for($i = $pages-2; $i <= $pages; $i++)
						{
						?>
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>);"><?php echo $i ?></a></li>
						<?php
						}
					?>
                    </ul><!-- page-nav-right-items -->
                    
                    <?php
						}else
						{
					?>
					<ul id="page-nav-left-items" class="page-nav-items">
                    <?php
                    	for($i = 1; $i <= $pages; $i++)
						{
						?>
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>);"><?php echo $i ?></a></li>
						<?php
						}
					?>
                    </ul><!-- page-nav-left-items -->
					<?php
						}
					?>
                    
                    <button id="step-forward" class="page-nav-step" type="button" onclick="reload_content(<?php echo $next_page ?>,<?php echo $on_page ?>);"> > </button>
                    <button id="leap-forward" class="page-nav-step" type="button" onclick="reload_content(<?php echo $last_page ?>,<?php echo $on_page ?>);"> >> </button>
                </div><!-- page-navigation -->
                
                <div class="number-of-items">
                	<label for="numb-of-items">Элементов на странице:</label>
                    <div class="styled-select styled-select-sm">
                        <select class="" id="numb-of-items" onchange="change_onpage($(this).val());">
                            <option <?php if($on_page == 10) echo 'selected="selected" data-skip="1"' ?> value="10">10</option>
                            <option <?php if($on_page == 15) echo 'selected="selected" data-skip="1"' ?> value="15">15</option>
                            <option <?php if($on_page == 30) echo 'selected="selected" data-skip="1"' ?> value="30">30</option>
                            <option <?php if($on_page == 45) echo 'selected="selected" data-skip="1"' ?> value="45">45</option>
                            <option <?php if($on_page == 60) echo 'selected="selected" data-skip="1"' ?> value="60">60</option>
                            <option <?php if($on_page == 75) echo 'selected="selected" data-skip="1"' ?> value="75">75</option>
                        </select>
                    </div>
                </div><!-- number-of-items -->
            </div><!-- manage-pages -->
            
            <div id="messageArea"></div>
            <div id="dndArea"></div>
</body>
<?php
	if(isset($_POST['first_load']) && $_POST['first_load'] == 1)
	{
?>
	<script src="split/js/jquery.tablednd.js" type="text/javascript"></script>
	<script src="split/js/datepicker.js" type="text/javascript"></script>
	<script src="split/js/js.js" type="text/javascript"></script>
	<script src="split/js/jquery.tzSelect.js" type="text/javascript"></script>
    <script src="split/js/tz-script.js" type="text/javascript"></script>
<?php
	}else
	{
	?>
	<script type="text/javascript" language="javascript">
        $('select#numb-of-items').tzSelect('numb-of-items');
	</script>
	<?php
	}
?>
	<script src="split/js/my-tablednd.js" type="text/javascript"></script>
    
<script type="text/javascript" language="javascript">
	var card_path = '<?php echo $card_path ?>';
	var checkSem = false;
	
	function reload_content(start_page,on_page)
	{
		var data = {
					ajaxpath:'<?php echo $_POST['ajaxpath'] ?>',
					start_page:start_page,
					on_page:on_page
					}
		$('#inajax-1').load(data.ajaxpath,data);
	}
	function change_onpage(on_page)
	{
		$.cookie('on_page_9',on_page);
		reload_content(1,on_page);
	}
	function select_all_checked()
	{
		if(checkSem)
		{
			$('input.table-checkbox').removeAttr('checked');
			checkSem = false;
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').addClass('nonactive');
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').attr('title','Опция не активна, для активации необходимо отметить елементы из списка.');
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').css('cursor','auto');
		}else
		{
			$('input.table-checkbox').attr('checked','checked');
			checkSem = true;
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').removeClass('nonactive');
			
			$('#activate-checked-button').attr('title','Опубликовать');
			$('#disactivate-checked-button').attr('title','Снять с публикации');
			$('#delete-checked-button').attr('title','Удалить');
			
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').css('cursor','pointer');
		}
	}
	function scan_active_checked()
	{
		var cur_users = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_user_id = $(this).val();
				if(cur_user_id != 'null')
				{
					cur_users.push(cur_user_id);
				}
			});
		if(cur_users.length > 0)
		{
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').removeClass('nonactive');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-new]').attr('title','Копировать');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-save]').attr('title','Опубликовать');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-close]').attr('title','Снять с публикации');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-delete]').attr('title','Удалить');
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').css('cursor','pointer');
		}else
		{
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').addClass('nonactive');
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').attr('title','Опция не активна, для активации необходимо отметить елементы из списка.');
			$('.r-z-h-saving button.first-actives[class!=r-z-h-s-create]').css('cursor','auto');
		}
	}
	$(function(){
			$('#close-filter').click();
		});
</script>

</html>