<?php 

require_once("_ajax_boot.php");

// Database connection
	
$db->db_access();

 // Стягиваем настройки сайта
	
	$siteSettings = $db->exec_query("SELECT * FROM [pre]total_config WHERE `id`=1 LIMIT 1",1);
	
	// Стягиваем настройки магазина
	
	$shopSettings = $db->exec_query("SELECT * FROM [pre]shop_settings WHERE `id`=1 LIMIT 1",1);
    
    define("USD_EX",$shopSettings['usd_ex']);
    define("EUR_EX",$shopSettings['eur_ex']);

// Проверяем user_id для зарегистрированных пользователей.
	
	$user_exist = false;
	$uid = 0;
	if(isset($_SESSION['uid']))
	{
		$curr_sess_id = (int)$_SESSION['uid'];
		if($curr_sess_id)
		{
			$user_data = $db->exec_query("SELECT * FROM [pre]users WHERE `id`='".$curr_sess_id."' AND `block`=0 LIMIT 1",1);
			if($user_data)
			{
				$user_exist = true;
				$profile = $user_data;
				define("UID",$profile['id']);
			}
		}
	}
	if(!$user_exist)
	{
		$uid = (isset($_SESSION['uid']) ? $_SESSION['uid'] : time()+rand(111,9999));
		define("UID",$uid);
		define("ONLINE",false);
	}else
	{
		define("ONLINE",true);
	}
	
	$_SESSION['uid'] = UID;
	$uid = UID;
	
	// конец проверки ID пользователя

// Prepare Response Array

$data = array('status'=>'failed', 'mf_list'=>array(), 'resultHtml'=>'<div class="alert alert-info">По Вашему запросу товаров не найдено. Пожалуйста, скорректируйте свой фильтр.</div>', 'filter_chars'=>array());


//====================================================================================================
// Include models

require_once("../model/mod.shop.php");

$shopObj = new Shop($db);

//====================================================================================================
// POST PARAMS

$filters = ""; // Фильтры к запросу в БД

$cat_id = (int)$_POST['cat_id'];


$_SESSION['mf_filter'] = array();
$_SESSION['prods_filter'] = array();
$_SESSION['prods_filter'][$cat_id] = array();

$curr_link = strip_tags(trim($_POST['curr_link']));

$price_range 	= $_POST['range_3'];

$price_min  = 0;
$price_max  = 100000;

$price_range_arr = explode(";",$price_range);

if(count($price_range_arr)==2)
{
	$price_min = (int)$price_range_arr[0];
	$price_max = (int)$price_range_arr[1];

	if($price_max > $price_min)
	{
		$filters .= " AND (M.price >= $price_min AND M.price <= $price_max) ";

		$_SESSION['prods_filter'][$cat_id]['price'] = array('min'=>$price_min, 'max'=>$price_max);
	}
}

// FILTER PARAMS
  
	$f_pag_lim = 36; // Количество товаров на странице

	$f_pag_size = 5; // Максимальное количество отображаемых страниц в пагинации

	$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации

	$f_sort = (isset($_POST['sort']) ? strip_tags($_POST['sort']) : "id"); // Колонка, по которой делаем сортировку

	if(isset($_POST['desc']) && $_POST['desc']=="desc") $f_sort .= " DESC "; // Направление сортировки: убывающая/возрастающая


	$mf_filter = (isset($_POST['mf']) ? $_POST['mf'] :  array());
    
    $and_mf_filter = "";
    
    if($mf_filter)
    {
        $_SESSION['mf_filter'][$cat_id] = $mf_filter;
        
        $and_mf_filter = " AND ( ";
        foreach($mf_filter as $mf_i => $mf_id)
        {
            $and_mf_filter .= ($mf_i ? " OR " : "") . " M.mf_id=$mf_id ";
        }
        $and_mf_filter .= " ) ";
    }
    
    $post_filter = (isset($_POST['filter']) ? $_POST['filter'] :  array());

	$filter_joins = "";


	function filters_calc_query($post_filter, $group_char_id=0, $cat_id=0)
	{
		$r = array('filter_joins'=>"",'filters'=>"");

		foreach($post_filter as $char_id => $char_values)
		{
			if($char_id == $group_char_id) continue;

			if($char_values)
			{
				if(!$group_char_id) $_SESSION['prods_filter'][$cat_id][$char_id] = $char_values;

				$r['filter_joins'] .= " INNER JOIN [pre]shop_chars_prod_ref as CPR".$char_id." ON CPR".$char_id.".prod_id=M.id ";

				$r['filters'] .= " AND CPR".$char_id.".char_id=$char_id AND (";

					$v_cnt = 0;

					 foreach($char_values as $value)
					{
						$v_cnt++;
						if($v_cnt > 1) 
							{
								$r['filters'] .= " OR ";
							}

						$_v = str_replace("'","\'",$value);
						$r['filters'] .= " CPR".$char_id.".value='$_v' ";
					} 
					$r['filters'] .= ") ";
			}
		}

		return $r;
	}

	$filter_result = filters_calc_query($post_filter, 0, $cat_id);
	$filter_joins_1 = $filter_joins	. $filter_result['filter_joins'];
	$filters_1 		= $filters 		. $filter_result['filters'];
    
    ob_start();

	//$filters = "";
	//$filter_joins = "";
	$prodListResult = $shopObj->getCategoryProductsById($cat_id, $f_page_num, $f_pag_lim, $filters_1.$and_mf_filter, $filter_joins_1); // Список товаров на странице

	$prodList = $prodListResult['items'];
	
	if(!$prodList && $f_page_num>1)
	{
		$f_page_num=1;
		
		$prodListResult = $shopObj->getCategoryProductsById($cat_id, $f_page_num, $f_pag_lim, $filters_1.$and_mf_filter, $filter_joins_1); // Список товаров на странице

		$prodList = $prodListResult['items'];
	}

	$rows = $prodListResult['rows']; // Запрос на глобальное количество товаров в категории
	  
	$f_total_rows = $rows['rows']; // сохраняем общее количество товаров в категории

	$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации

	//=========================================================================================================================

	// COUNT CHARS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	$filter_group_id = (int)$_POST['filter_group_id'];

	$charsList = $shopObj->getCategoryFilterChars($filter_group_id);

	foreach($charsList as &$overFilterChar)
	{
		$char_id = $overFilterChar['id'];

		$filter_result = filters_calc_query($post_filter, $char_id, $cat_id);

		$filters_2 		= $filters 			. $filter_result['filters'];
		$filter_joins_2 = $filter_joins		. $filter_result['filter_joins'];

		$overFilterChar['values_count'] = $shopObj->countFilterValues($cat_id, $char_id, $filters_2.$and_mf_filter, $filter_joins_2);  // Количество товаров в фильтрах

		foreach($overFilterChar['values_count'] as &$j_item)
		{
			$j_item['ref_md5'] = md5( $char_id . trim(mb_strtolower($j_item['value'])) );
		}
	}

	$data['filter_chars'] = $charsList;
    
    // MF
    
    //echo "<pre>MF FILTERS: " . $and_mf_filter . "</pre>";
    
    //echo "<pre>FILTERS: " . $filters_1 . "</pre>";
    //echo "<pre>FILTER_JOINS: " . $filter_joins_1 . "</pre>";
    
    $data['mf_list'] = $shopObj->getCategoryMf($cat_id, true, $filters_1, $filter_joins_1);

	//echo "<pre>"; print_r($data['filter_chars']); echo "</pre>";
	
	$data['resultHtml'] = ob_get_contents();

	ob_end_clean();
	
	ob_start();
	include("../templates/".TEMPLATE_NAME."/view/shop/shopCatProdPagination.php");
	$pagination_html = ob_get_contents();
	
	include("../templates/".TEMPLATE_NAME."/view/shop/shopCatProdList.php");
	echo $pagination_html;

	//echo "<pre>"; print_r($prodList); echo "</pre>";

	//echo "<pre>"; print_r($_SESSION); echo "</pre>";

	$data['resultHtml'] .= ob_get_contents();

	ob_end_clean();

	

//====================================================================================================
// Closes the connection with database

$db->db_destroy();

// Return Json Array

if($prodList) $data['status'] = 'success';


echo json_encode($data);