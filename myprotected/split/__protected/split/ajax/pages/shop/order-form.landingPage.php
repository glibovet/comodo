<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getLandingHeader($headParams);
	
	// Get page items
	
	$itemsList = $zh->getShopOrders($params);

	$totalItems = $zh->getShopOrders($params,true);
	
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
	
	// Filter arrays

	$filter1_options = array( 'By ID'=>'M.id' );
	
	$filter2_options = array( 
							'Статус оплаты' => array( 'fieldName'=>'M.paid_status', 'params' => array('Не оплачен'=>'Не оплачен', 'Оплачен'=>'Оплачен') ) 
							);
							
	$filter3_options = array( 
							'sort' => array( 'ID'=>'id', 'Статус оплаты'=>'paid_status'),
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
						  'Номер'				=>	array('type'=>'text',		'field'=>'id', 'params'=>array('math'=>"+",'value'=>5000) ),
						  'Источник'			=>	array('type'=>'text',		'field'=>'author_name', 'params'=> array('secondField'=>'author_fname', 'separate'=>" ") ),
						  'Заказчик'			=>	array('type'=>'text',		'field'=>'client_name', 'params'=> array('secondField'=>'client_fname', 'separate'=>" ") ),
						  'Статус'				=>	array('type'=>'text',		'field'=>'status_name'),
						  'Оплата'				=>	array('type'=>'text',		'field'=>'payment_name'),
						  'Доставка'			=>	array('type'=>'text',		'field'=>'delivery_name'),
						  'Статус оплаты'		=>	array('type'=>'text',		'field'=>'paid_status'),
						  'Товаров'				=>	array('type'=>'text',		'field'=>'products_quant'),
						  'На сумму(грн)'		=>	array('type'=>'text',		'field'=>'sum'),
						  'Дата'				=>	array('type'=>'date',		'field'=>'dateCreate', 'params'=>array('format'=>'d-m-Y') ),
						  'Просмотр'			=>	array('type'=>'cardView',	'field'=>'Смотреть'),
						  'Управление'			=>	array('type'=>'cardEdit',	'field'=>'Изменить'),
						  'ID'					=>	array('type'=>'text',		'field'=>'id')
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