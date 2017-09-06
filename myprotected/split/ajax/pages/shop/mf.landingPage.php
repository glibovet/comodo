<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getLandingHeader($headParams);
	
	// Get page items
	
	$itemsList = $zh->getShopMf($params);

	$totalItems = $zh->getShopMf($params,true);
	
	$catalogList = $zh->getCatalogParents();
	
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
	
	// Prepare arrays for filter

	$filter1_options = array( 'По ID'=>'M.id', 'По названию'=>'M.name' );
	
	$filter2_options = array( 
							'Публикация' => array( 'fieldName'=>'M.block', 'params' => array('Да'=>'0', 'Нет'=>'1') ),
							'Категория' => array( 'fieldName'=>'M.cat_id', 'params' => $catalogList, 'type'=>'allCatalog', 'top_include'=>true )
							);
							
	$filter3_options = array( 
							'sort' => array( 'ID'=>'id', 'Название'=>'name', 'Категория'=>'cat_id' ),
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
						  'Название'				=>	array('type'=>'text',		'field'=>'name'),
						  'Страна'				=>	array('type'=>'text',		'field'=>'country'),
						  //'Категория'			=>	array('type'=>'text',		'field'=>'cat_name', 'params'=>array( 'replace'=>array(''=>'Верхняя категория') )),
						  'Публикация'			=>	array('type'=>'block',		'field'=>'block'),
						  'Просмотр'			=>	array('type'=>'cardView',	'field'=>'Смотреть'),
						  'Редактирование'		=>	array('type'=>'cardEdit',	'field'=>'Редактировать')
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