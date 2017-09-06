<?php
	//==================================================
	// Shop controller
	//==================================================
	
	// $currPage ini from switcher
	
	$cat_id = $category['id'];

	$categoryBreadcrumbs = $menuObj->rec_cat_tree( array(), $cat_id );


	$catsList = $shopObj->getChildsByID($cat_id);


	// Pagination

	$filters = ""; // Фильтры к запросу в БД
  
	$f_pag_lim = 9; // Количество товаров на странице

	$f_pag_size = 5; // Максимальное количество отображаемых страниц в пагинации

	$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации

	$f_sort = (isset($_GET['sort']) ? strip_tags($_GET['sort']) : "id"); // Колонка, по которой делаем сортировку

	if(isset($_GET['desc']) && $_GET['desc']=="desc") $f_sort .= " DESC "; // Направление сортировки: убывающая/возрастающая


	// Если в сессиях ранее сохранились значения фильтров для данной категории - применяем их к запросу

	// FILTER PARAMS

	$filters = "";

	$filter_joins = "";

	$price_filter = false;

	if(isset($_SESSION['prods_filter']) && isset($_SESSION['prods_filter'][$cat_id]) && isset($_GET['page']))
	{

		if(isset($_SESSION['prods_filter'][$cat_id]['price']))
		{
			$price_filter = true;

			$min_price = $_SESSION['prods_filter'][$cat_id]['price']['min'];
			$max_price = $_SESSION['prods_filter'][$cat_id]['price']['max'];

			$filters .= " AND (M.price >= $min_price AND M.price <= $max_price) ";
		}

		$post_filter = $_SESSION['prods_filter'][$cat_id];

		foreach($post_filter as $char_id => $char_values)
		{
			if($char_values && $char_id>0)
			{
				$filter_joins .= " LEFT JOIN [pre]shop_chars_prod_ref as CPR".$char_id." ON CPR".$char_id.".prod_id=M.id ";

				$filters .= " AND CPR".$char_id.".char_id=$char_id AND (";
					$v_cnt = 0;
					 foreach($char_values as $value)
					{
						$v_cnt++;
						if($v_cnt > 1) $filters .= " OR ";

						$_v = str_replace("'","\'",$value);
						$filters .= " CPR".$char_id.".value='$_v' ";
					} 
				$filters .= ") ";
			}
		}

	}else{
		$_SESSION['prods_filter'] = array();
	}

	$prodList = $shopObj->getCategoryProductsById($cat_id, $f_page_num, $f_pag_lim, $filters, $filter_joins); // Список товаров на странице


	// HACK

	if(!$prodList && $f_page_num>1) header("Location: ".SELF_LINK."?page=1");

	
	$rows = $db->exec_query('SELECT FOUND_ROWS() AS rows',1); // Запрос на глобальное количество товаров в категории
	  
	$f_total_rows = $rows['rows']; // сохраняем общее количество товаров в категории

	$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации

	
	// FILTERS QUERY

	//$size_chars_list = $shopObj->getSizeChars($cat_id);

	$filter_chars_list = array(); // По умолчанию в категории нет фильтров по товарам

	$filter_group_id = $category['specs_group_id'];

	if($filter_group_id)
	{
		$filter_chars_list = $shopObj->getCategoryFilterChars($filter_group_id);

		foreach($filter_chars_list as $i => $char)
		{
			$filter_chars_list[$i]['values'] = $shopObj->getCategoryFilterCharValues( $cat_id, $char['id'] );

		}
	}

	$max_min_price = $shopObj->getCategoryMaxMinPrice($cat_id);


	//echo "<pre>"; print_r($char['id']); echo "</pre>"; exit();
	//echo "<pre>"; print_r($height_values); echo "</pre>"; exit();
	//echo "<pre>"; print_r($depth_values); echo "</pre>"; exit();

	//echo "<pre>"; print_r($filter_chars_list); echo "</pre>"; exit();


	//echo "<pre>$cat_id"; print_r($categoryBreadcrumbs); echo "</pre>"; exit();

	//echo "<pre>$cat_id"; print_r($catsList); echo "</pre>"; exit();