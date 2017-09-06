<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getLandingHeader($headParams);
	
	// Get page items
	
	$itemsList = $zh->getStocksCells($params);

	$totalItems = $zh->getStocksCells($params,true);

	// Pagination operations
	
	$on_page = (isset($_COOKIE['global_on_page']) ? $_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
	
	$pages = ceil($totalItems/$on_page);
	
	$start_page = (isset($params['start']) ? $params['start'] : 1);
	
	$frst_page = 1;
	$prev_page = 1;
	$next_page = $pages;
	$last_page = $pages;
				
	if($start_page < $pages) $next_page = $start_page+1;
	if($start_page > 1) $prev_page = $start_page-1;
	
	// Filter JS open
	
	if(isset($_COOKIE['filter-1']) && $_COOKIE['filter-1']) $data['filter']['f1'] = 1;
	if(isset($_COOKIE['filter-2']) && $_COOKIE['filter-2']) $data['filter']['f2'] = 1;
	if(isset($_COOKIE['filter-3']) && $_COOKIE['filter-3']) $data['filter']['f3'] = 1;
	
	
	// Get Stocks List
	
	$stocksList		= $zh->getStocksList();
	
	// Prepare arrays for filter
	
	$stocksListFilter = array();
	foreach($stocksList as $stockItem)
	{
		$stocksListFilter[$stockItem['name']]=$stockItem['id'];
	}
	
	// Filter arrays

	$filter1_options = array( 'По ID'=>'M.id', 'По Складам'=>'M.stock_id' );
	
	// , 'По Зонам'=>'M.zona', 'По Стелажам'=>'M.rack', 'По Секциям'=>'M.section', 'По Полкам'=>'M.shelf'
	
	$filter2_options = array( 
							'Publish' => array( 'fieldName'=>'M.block', 'params' => array('Yes'=>'0', 'No'=>'1') ),
							'Склад'   => array( 'fieldName'=>'M.stock_id', 'params' => $stocksListFilter ) 
							);
							
	$filter3_options = array( 
							'sort' => array( 'ID'=>'M.id', 'По Складам'=>'M.stock_id'),
							'order' => array( 'По возрастанию'=>'', 'По убыванию'=>' DESC' ) 
							);
	// Start data content
	
	$filterFormParams = array(	'params'=>$params, 
								'headParams'=>$headParams, 
								'filter1_options'=>$filter1_options, 
								'filter2_options'=>$filter2_options, 
								'filter3_options'=>$filter3_options, 
								'on_page'=>$on_page 
							  );
	
	$filterFormStr = $zh->getLandingFilterForm($filterFormParams);
	
	// Table structure
	
	$tableColumns = array(
						  'Checkbox'			=>	array('type'=>'checkbox',	'field'=>''),
						  'ID'					=>	array('type'=>'text',		'field'=>'id'),
						  'Код ячейки'			=>	array('type'=>'text',		'field'=>'code'),
						  'Склад'				=>	array('type'=>'text',		'field'=>'stock_name'),
						  //'Зона'					=>	array('type'=>'text',		'field'=>'zona'),
						  //'Стеллаж'				=>	array('type'=>'text',		'field'=>'rack'),
						  //'Секция'				=>	array('type'=>'text',		'field'=>'section'),
						  //'Полка'					=>	array('type'=>'text',		'field'=>'shelf'),
						  'Наполненность'		=>	array('type'=>'text',		'field'=>'fullness', 'params'=>array('replace'=>array('0'=>'Пустая','1'=>'Не полная','2'=>'Полная')) ),
						  'Кол-во товаров'		=>	array('type'=>'text',		'field'=>'products_count'),
						  'Публикация'			=>	array('type'=>'block',		'field'=>'block'),
						  'Просмотр'			=>	array('type'=>'cardView',	'field'=>'Смотреть'),
						  'Управление'			=>	array('type'=>'cardEdit',	'field'=>'Изменить')
						  );
	
	$tableParams = array( 'itemsList'=>$itemsList, 'tableColumns'=>$tableColumns, 'headParams'=>$headParams );
	
	$tableStr = $zh->getItemsTable($tableParams);
	
	// START PAGINATION
	
	$pagiParams = array( 'headParams'=>$headParams, 'start_page'=>$start_page, 'pages'=>$pages, 'on_page'=>$on_page );
	
	$pagiStr = $zh->getLandingPagination($pagiParams);
	
	// Join Content
	
	$data['bodyContent'] = $filterFormStr;
	
	$data['bodyContent'] .= $tableStr;
	
	$data['bodyContent'] .= $pagiStr;

?>