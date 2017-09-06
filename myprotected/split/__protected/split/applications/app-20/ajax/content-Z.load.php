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

<title>Load USERS List</title>
</head>

<?php
	$app_id = 20;
	
	$on_page = $_POST['on_page'];;
	$start_page = $_POST['start_page'];
	$pages = 1;
		
	$query = "SELECT COUNT(*) FROM [pre]shop_products WHERE 1 ORDER BY id";
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
			$users = $users_arr->fetchallAssoc();
			
	$pages = ceil($users[0]['COUNT(*)']/$on_page);
			
	$query = "SELECT * FROM [pre]shop_products WHERE 1 ORDER BY order_id LIMIT ".($start_page-1)*$on_page.",".$on_page;
			
			$users_stmt = $dbh->prepare($query);
			$users_arr = $users_stmt->execute();
		
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
			$data[$item_num]['block'] = "Включена";
		}else
		{
			$data[$item_num]['publish_class'] = "not-published";
			$data[$item_num]['block'] = "Выключена";
		}
		
	}
?>

<body>
			<div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                    	<th class="main-t-th check-col" style=""></th>
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Артикул</th>
                        <th class="main-t-th" style="">Штрих-код</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">Состояние</th>
                        <th class="main-t-th" style="">Кол-во</th>
                        <th class="main-t-th" style="">Группа</th>
                        <th class="main-t-th" style="">ID</th>
                    </div>
                	<tbody>
				<?php
                	foreach($data as $row)
					{
						
						$query = "	SELECT * FROM [pre]shop_cat_prod_ref as REF
									LEFT JOIN [pre]shop_catalog as CAT ON CAT.id=REF.cat_id
									WHERE REF.prod_id=".$row['id']." 
									ORDER BY REF.cat_id
									LIMIT 1";
			
						$cat_stmt = $dbh->prepare($query);
						$cat_arr = $cat_stmt->execute();
						$cat = $cat_arr->fetchallAssoc();
						
						$query = "	SELECT * FROM [pre]shop_prod_group_ref as REF
									LEFT JOIN [pre]shop_products_groups as GRR ON GRR.id=REF.group_id
									WHERE REF.prod_id=".$row['id']." 
									ORDER BY REF.group_id
									LIMIT 20";
			
						$group_stmt = $dbh->prepare($query);
						
						$group_arr = $group_stmt->execute();
						$groups = $group_arr->fetchallAssoc();
						
						$groups_list = "";
						$g_cnt = 0;
						foreach($groups as $group)
						{
							$g_cnt++;
							if($g_cnt == 1)
							{
								$groups_list .= $group['name'];
							}else
							{
								$groups_list .= ', '.$group['name'];
							}
						}
				?>
                    <tr class="<?php echo $row['row_class'] ?>" id="<?php echo $row['id'] ?>">
                        <td class="check-col">
                        	<input	type="checkbox" 
                            		name="checker<?php	echo $row['id'] ?>" 
                                    class="table-checkbox" 
                                    id="check<?php 		echo $row['id'] ?>"
                                    value="<?php 		echo $row['id'] ?>">
                            <label	class="tab-check-lab" 
                            		for="check<?php 	echo $row['id'] ?>">&nbsp;&nbsp;</label>
                        </td>
                        <td class="main-t-td-name">
                        	<div><a href="javascript:void(0);"><?php echo $row['name'] ?></a></div>
                        </td>
                        <td><?php echo $row['sku'] ?></td>
                        <td><?php echo $row['code'] ?></td>
                        <td><?php echo $cat[0]['name'] ?></td>
                        <td class="publication">
                        	<div class="<?php echo $row['publish_class'] ?>"></div>
                            <span><?php echo $row['block'] ?></span>
                        </td>
                        <td><?php echo $row['quant'] ?></td>
                        <td><?php echo $groups_list ?></td>
                        <td><?php echo $row['id'] ?></td>
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

	<script src="split/js/jquery.tablednd.js" type="text/javascript"></script>
	<script src="split/js/datepicker.js" type="text/javascript"></script>
	<script src="split/js/my-tablednd.js" type="text/javascript"></script>
	<script src="split/js/js.js" type="text/javascript"></script>
	<script src="split/js/jquery.tzSelect.js" type="text/javascript"></script>
	<script src="split/js/tz-script.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript">
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
		$.cookie('on_page_<?php echo $app_id ?>',on_page);
		reload_content(1,on_page);
	}
	$(function(){
			$('#close-filter').click();
		});
</script>

</html>