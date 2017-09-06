<?php 
	//********************
	//** WEB INSPECTOR | TAMPLATE | CONTENT LOAD
	//********************
	
	require_once "../../../../require.base.php";
	
	$app_id = (int)$_POST['app_id'];
	
	$card_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/card.load.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="split/css/jquery.tzSelect.css" rel="stylesheet" />

<title>Load USERS List</title>
</head>

<?php
	$filter_on  = false;
	
	if(isset($_POST['f_fields']) && sizeof($_POST['f_fields']) > 0)
	{
		$filter_on = true;
		
		$filter_data = array();
		
		$filter_arr = array();
		
		foreach($_POST['f_fields'] as $f_num => $f_field)
		{
			$filter_data[$f_field] = $_POST['f_values'][$f_num];
			
			$ff = explode("filtr[",$f_field);
				
			if(sizeof($ff) > 1)
			{
				$ff = str_replace("]","",$ff[1]);
				$filter_arr[$ff] = $_POST['f_values'][$f_num];
			}
		}
	}

	$on_page = $_POST['on_page'];;
	$start_page = $_POST['start_page'];
	$pages = 1;
	
	$filtr_table = trim(strip_tags($_POST['filtr_table']));
	
	$tables = unserialize($_POST['tables']);
	$fields = unserialize($_POST['fields']);
	
	//***********************************************************************************************************************
	
	$names_alias_str = "";
	
	$names_cnt = 0;
	foreach($tables as $qtable)
	{
		foreach($qtable['fields'] as $qfield)
		{
			$names_cnt++;
			$point = ", ";
			if($names_cnt == 1) $point = " ";
			$names_alias_str .= $point.$qtable['or_name'].".".$qfield['field']." as ".$qfield['alias'];
		}
	}
	
	// FILTER
	
	$where_sql = " WHERE 1 ";
	
	if($filter_on)
	{
		$sort_page 	= $filter_data['sort_filtr'];
		
		$order_page = $filter_data['order_filtr'];
		
		$on_page 	= $filter_data['quant_filtr'];
		
		if(trim($filter_data['filtr_search_key']) != "")
		{
			$where_sql .= " AND ".$tables[0]['or_name'].".".$filter_data['filtr_search_field']." LIKE '%".$filter_data['filtr_search_key']."%' ";
		}
		
		foreach($filter_arr as $ff_field => $ff_value)
		{
			if($ff_value == -1) continue;
			$where_sql .= " AND ".$tables[0]['or_name'].".".$ff_field." = '".$ff_value."' ";
		}
	}else{
		$sort_page = "id";
		}
		
	$order_sql = " ORDER BY ".$tables[0]['or_name'].".".$sort_page." ";
	$order_sql .= $order_page;
	
	$quant_tmp_query = "SELECT COUNT(*) FROM [pre]".$filtr_table." as ".$tables[0]['or_name'];
	$fact_tmp_query = "SELECT ".$names_alias_str." FROM [pre]".$filtr_table." as ".$tables[0]['or_name'];
	
	$tmp_query = "";
	if(sizeof($tables) > 1)
	{
		$tb_cnt = 0;
		foreach($tables as $qtable)
		{
			$tb_cnt++;
			if($tb_cnt > 1)
			{
				$tmp_query .= " LEFT JOIN [pre]".$qtable['name']." as ".$qtable['or_name']." ON ";
				$tmp_query .= $qtable['ref_table'].".".$qtable['ref_on']." = ".$qtable['or_name'].".".$qtable['ref_field'];
			}
		}
	}else
	{
	}
	
	$tmp_query .= $where_sql;
	
	$pages = ceil($users[0]['COUNT(*)']/$on_page);
	
	$tmp_query .= $order_sql;
	
	$fact_limit.= " LIMIT ".($start_page-1)*$on_page.",".$on_page;
	$quant_limit = " LIMIT 100000";
	
	$fact_tmp_query = $fact_tmp_query.$tmp_query.$fact_limit;
	
	$quant_tmp_query = $quant_tmp_query.$tmp_query.$quant_limit;
	
	//echo $tmp_query; die();
	
	$tmp_stmt = $dbh->prepare($fact_tmp_query);
	$tmp_arr  = $tmp_stmt->execute();
	
	$tmp_data = $tmp_arr->fetchallAssoc();
	
	//***********************************************************************************************************************
	
	//$query = "SELECT COUNT(*) FROM [pre]users WHERE 1 ORDER BY id";
			
			$users_stmt = $dbh->prepare($quant_tmp_query);
			$users_arr = $users_stmt->execute();
			$users = $users_arr->fetchallAssoc();
			
	$pages = ceil($users[0]['COUNT(*)']/$on_page);
			
	
	$monthes = array('','января','февряля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	
	$cnt = 0;
?>

<body>
	<?php  
		//echo $tmp_query;
		 //echo '<pre>'; print_r($_POST); echo '</pre>'; 
		
		//if($filter_on) echo '<pre>'; print_r($filter_arr); echo '</pre>';
		/*
		Array
(
    [filtr_table] => users
    [filtr_search_key] => цукцук
    [filtr_search_field] => name
    [filtr[block]] => 0
    [filtr[active]] => 1
    [sort_filtr] => name
    [order_filtr] => 
    [quant_filtr] => 15
)
		*/
	?>
    
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
                    <?php
                    foreach($fields as $field)
					{
						?>
						<th class="main-t-th" style=""><?php echo $field['title'] ?></th>
						<?php
					}
					?>
                    </div>
                	<tbody>
				<?php
                	foreach($tmp_data as $row)
					{
						$cnt++;
		
						//				Устанавливаем зебру в строках
						if($cnt%2 == 1)
						{
							$row['row_class']  = 'trcolor';
						}else
						{
							$row['row_class']  = '';
						}
				?>
                    <tr class="<?php echo $row['row_class'] ?>" id="<?php echo $row['id'] ?>">
                        <td class="check-col">
                        	<input	type="checkbox" 
                            		name="checker<?php	echo $row['id'] ?>" 
                                    class="table-checkbox" 
                                    id="check<?php 		echo $row['id'] ?>"
                                    value="<?php 		echo $row['id'] ?>"
                                    onchange="scan_active_checked();">
                            <label	class="tab-check-lab" 
                            		for="check<?php 	echo $row['id'] ?>">&nbsp;&nbsp;</label>
                        </td>
                 	<?php
                  	foreach($fields as $field)
				  	{
						switch($field['type'])
						{
							case 'text':
							{
								?>
								<td><?php echo $row[$field['value']]; ?></td>
								<?php
								break;
							}
							case 'date':
							{
								// Форматирование вывод Даты
								if(strtotime($row[$field['value']]) > strtotime(date("d.m.Y",time())." 00:00:00"))
								{
									$row[$field['value']] = "Сегодня, ".date("H:i",strtotime($row[$field['value']]));
		
								}elseif(strtotime($row[$field['value']]) < strtotime(date("d.m.Y",time())." 00:00:00") &&
										strtotime($data[$item_num]['dateCreate']) > (strtotime(date("d.m.Y",time())." 00:00:00")-86400))
									{
										$row[$field['value']] = "Вчера, ".date("H:i",strtotime($data[$item_num]['dateCreate']));
									}
								else
									{
										$row[$field['value']] = date("d",strtotime($row[$field['value']]))." ".
																	$monthes[(int)date("m",strtotime($row[$field['value']]))]." ".
																	date("Y",strtotime($row[$field['value']])).", ".
																	date("H:i",strtotime($row[$field['value']]));
		}
								?>
								<td><?php echo $row[$field['value']]; ?></td>
								<?php
								break;
							}
							case 'block':
							{
								//				Указываем состояния для колонки Опубликовано
								if($row[$field['value']] == "0")
								{
									$row['publish_class'] = "published";
									$row[$field['value']] = "Да";
								}else
								{
									$row['publish_class'] = "not-published";
									$row[$field['value']] = "Нет";
								}
								?>
								<td class="publication">
                        			<div class="<?php echo $row['publish_class'] ?>"></div>
                            		<span><?php echo $row[$field['value']] ?></span>
                        		</td>
								<?php
								break;
							}
							case 'active':
							{
								//				Указываем состояния для колонки Активен
								if($row[$field['value']] == "0")
								{
									$row[$field['value']] = "Не активен";
								}else
								{
									$row[$field['value']] = "Активен";
								}
								?>
								<td><?php echo $row[$field['value']] ?></td>
								<?php
								break;
							}
							case 'conc':
							{
								?><td>&nbsp;</td><?php
								break;
							}
							case 'link':
							{
								?><td>&nbsp;</td><?php
								break;
							}
							case 'conc_link':
							{
								$link_name = "";
								foreach($field['value'] as $fname)
								{
									$link_name .= " ".$row[$fname];
								}
								$link_name = trim($link_name);
								?>
								<td class="main-t-td-name">
                        			<div>
                                    	<a  href="javascript:void(0);" 
                                        	onclick="
                                            		<?php
                                                    foreach($field['actions'] as $action)
													{
														echo " ".$action['func']."(";
														$param_cnt = 0;
														foreach($action['params'] as $param)
														{
															$param_cnt++;
															$point = ", ";
															if($param_cnt == 1) $point = "";
															switch($param['type'])
															{
																case 1:
																{
																	echo $point.$param['value'];
																	break;
																}
																case 2:
																{
																	echo $point.$row[$param['value']];
																	break;
																}
																default: break;
															}
														}
														echo ");";
													}
													?>
                                                    change_head(3); 
                                            load_card(card_path,<?php echo $row['id'] ?>);"
                                        ><?php echo $link_name ?></a>
                                    </div>
                        		</td>
								<?php
								break;
							}
							case 'self_link':
							{
								?><td>&nbsp;</td><?php
								break;
							}
							case 'operation':
							{
								?><td>&nbsp;</td><?php
								break;
							}
							default:
							{
								?><td>&nbsp;</td><?php
								break;
							}
						}
					}
				  	?>
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
                	<button id="leap-back" class="page-nav-step" type="button" onclick="reload_content(<?php echo $frst_page ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"> << </button>
                    <button id="step-back" class="page-nav-step" type="button" onclick="reload_content(<?php echo $prev_page ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"> < </button>
                    
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
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"><?php echo $i ?></a></li>
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
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"><?php echo $i ?></a></li>
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
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"><?php echo $i ?></a></li>
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
                        <li class="<?php if($i == $start_page) echo 'active' ?>"><a href="#" onclick="reload_content(<?php echo $i ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"><?php echo $i ?></a></li>
						<?php
						}
					?>
                    </ul><!-- page-nav-left-items -->
					<?php
						}
					?>
                    
                    <button id="step-forward" class="page-nav-step" type="button" onclick="reload_content(<?php echo $next_page ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"> > </button>
                    <button id="leap-forward" class="page-nav-step" type="button" onclick="reload_content(<?php echo $last_page ?>,<?php echo $on_page ?>,cook_orderpage,cook_sortpage);"> >> </button>
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
    <script type="text/javascript" language="javascript">
        $('select#r-z-c-f-sort-amount').tzSelect('r-z-c-f-sort-amount');
		$('select#r-z-c-f-sort-order').tzSelect('r-z-c-f-sort-order');
		$('select#r-z-c-f-sort-by').tzSelect('r-z-c-f-sort-by');
	</script>
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
	
	var cook_onpage = $.cookie('on_page_<?php echo $app_id ?>');
	var cook_orderpage = $.cookie('order_page_<?php echo $app_id ?>');
	var cook_sortpage = $.cookie('sort_page_<?php echo $app_id ?>');
	
	function reload_content(start_page,on_page,order_page,sort_page)
	{
		filtr_sem = true;
		global_start_page = start_page;
		filtr_content();
		
		/*
		var data = {
					filtr_table:'<?php echo $filtr_table ?>',
					tables:'<?php echo serialize($tables) ?>',
					fields:'<?php echo serialize($fields) ?>',
						
					app_id	:<?php echo $app_id ?>,
					ajaxpath:'<?php echo $_POST['ajaxpath'] ?>',
					start_page:start_page,
					on_page:on_page,
					order_page:order_page,
					sort_page:sort_page
					}
		$('#inajax-1').load(data.ajaxpath,data);
		*/
	}
	
	function change_onpage(on_page)
	{
		$.cookie('on_page_<?php echo $app_id ?>',on_page);
		reload_content(1,on_page,cook_orderpage,cook_sortpage);
	}
	
	function change_orderpage(order)
	{
		$.cookie('order_page_<?php echo $app_id ?>',order);
		reload_content(1,cook_onpage,order,cook_sortpage);
	}
	
	function change_sortpage(sorter)
	{
		$.cookie('sort_page_<?php echo $app_id ?>',sorter);
		reload_content(1,cook_onpage,cook_orderpage,sorter);
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
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-new]').attr('title','Копировать');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-save]').attr('title','Опубликовать');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-close]').attr('title','Снять с публикации');
			$('.r-z-h-saving button.first-actives[class=r-z-h-s-delete]').attr('title','Удалить');
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
			global_ajaxFile = '<?php echo $_POST['ajaxpath'] ?>';
			global_app_id = '<?php echo $_POST['app_id'] ?>';
			
			<?php
			if(!isset($_POST['order_page']) && isset($_POST['first_load']) && $_POST['first_load'] != 'false')
			{
				?>
				//alert('<?php echo $_POST['first_load'] ?>');
				$('#close-filter').click();
				<?php
			}
			?>
			
			if(cook_onpage == null || cook_onpage == 'null')
			{
				cook_onpage = 15;
			}
			if(cook_orderpage == null || cook_orderpage == 'null')
			{
				cook_orderpage = "";
			}
			if(cook_sortpage == null || cook_sortpage == 'null')
			{
				cook_sortpage = "id";
			}
		});
</script>

</html>