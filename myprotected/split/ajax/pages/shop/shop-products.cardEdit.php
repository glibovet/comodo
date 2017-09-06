<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProductsItemDetails($item_id);

	$catalogList = $zh->getCatalogParents();
	
	$charsGroups = $zh->getCharsGroups();
	
	$productsGroups = $zh->getProductsGroups();

	//$mf_list = $zh->getCategoryMf($cardItem['category']['id']);
	
	$mf_list = $zh->getAllMf();
	
	$collections_list = $zh->getMfCollections($cardItem['mf_id']);

	$delivers_list = $zh->getAllDelivers();

	$access_list = $zh->getProdAccessuares($item_id);
	
	$complect_list = $zh->getProdComplect($item_id);
	
	$size_list = $zh->getProdSizes($item_id);
	
	$colors = $zh->getColors();
	
	$objects = $zh->getCatObjects($cardItem['cat_id']);
	
	$objectGroups = $zh->getObjectGroups($cardItem['collection_id'], $item_id);

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	
	//echo "<pre>"; print_r($objectGroups); echo "</pre>";  exit();
	
	$tmp = array();
	
	$cardTmp = array(
					 'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Название '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"$nameChange" ) ),
					 
					 'Алиас'				=>	array( 'type'=>"$aliasType", 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'Артикул'				=>	array( 'type'=>'input', 	'field'=>'sku', 			'params'=>array( 'size'=>25, 'hold'=>'Article' ) ),
					 
					 //'Штрих-код'			=>	array( 'type'=>'hidden', 	'field'=>'code', 			'params'=>array( 'size'=>25, 'hold'=>'Code' ) ),
					 
					  //'Цена (грн)'			=>	array( 'type'=>'input', 	'field'=>'price', 			'params'=>array( 'size'=>25, 'hold'=>'UAH Price' ) ),
					 
					 'Цена (EUR)'				=>	array( 'type'=>'input', 	'field'=>'eur_price', 		'params'=>array( 'size'=>25, 'hold'=>'EUR Price' ) ),
					 
					 //'Старая Цена ($)'		=>	array( 'type'=>'input', 	'field'=>'usd_sale_price', 		'params'=>array( 'size'=>25, 'hold'=>'SALE Price' ) ),
					 
					 //'Скидка % (без знака "-")'		=>	array( 'type'=>'input', 	'field'=>'sale_per', 		'params'=>array( 'size'=>25, 'hold'=>$cardItem['sale']) ),
					 
					 //'Скидка %'		=>	array( 'type'=>'hidden', 	'field'=>'sale', 		'params'=>array( 'size'=>25, 'hold'=>'Текущая скидка') ),
					 
					 
					 'Категория'			=>	array( 'type'=>'select', 	'field'=>'cat_id', 			'params'=>array( 'list'=>$catalogList, 
					 																									 'type'=>'allCatalog', 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['cat_id'], 
					'onChange'=>"updateProductCharsForm(0,".json_encode($cardItem['charsGroup']).",".json_encode($cardItem['chars']).",$(this).val());", 
																														 'first'=>array( 'name'=>'-- Без категории --', 'id'=>0 ) 
																														 ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 
					 /*'Производитель'		=>	array( 'type'=>'autocomplete', 	'field'=>'mf_name', 	'params'=>array( 'size'=>50, 'hold'=>'Начните вводить название', 
					 																										'value'=>"" ) ),*/
					 
					'Производитель'		=>	array( 'type'=>'select', 	'field'=>'mf_id', 		'params'=>array( 'list'=>$mf_list, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['mf_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'-- Без производителя --', 'id'=>0 )  
																														 ) ),
																															
					 'Коллекция'		=>	array( 'type'=>'select', 	'field'=>'collection_id', 		'params'=>array( 'list'=>$collections_list, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['collection_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'-- Без коллекции --', 'id'=>0 ) 
																														 ) ),	
																														 
					 'Другие предметы'			=>	array( 'type'=>'multiselect', 'field'=>'object_groups', 			'params'=>array( 
																														 'list'=>$objectGroups, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['objectGroups'], 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
																														 
					 'Предмет мебели'					=>	array( 'type'=>'select', 	'field'=>'obj_id', 		'params'=>array( 'list'=>$objects, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['obj_id'],  
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Без предмета', 'id'=>NULL ) 
																														 ) ),
					 
					'Цвет (фильтр)'					=>	array( 'type'=>'select', 	'field'=>'color_id', 		'params'=>array( 'list'=>$colors, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['color_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Выберите цвет', 'id'=>0 ) 
																														 ) ),
																														 
					 'Цвет (карточка)'			=>	array( 'type'=>'multiselect', 'field'=>'color_groups', 			'params'=>array( 
																														 'list'=>$colors, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['colorGroups'], 
																														 'onChange'=>"" 
																														 ) ),
					 				 					 
					 
					 //'Модель'				=>	array( 'type'=>'input', 	'field'=>'model', 			'params'=>array( 'size'=>25, 'hold'=>'Model Name' ) ),	
					 
					'clear-3'				=>	array( 'type'=>'clear' ),
																														 
					'На складе (шт)'		=>	array( 'type'=>'input', 	'field'=>'quant', 			'params'=>array( 'size'=>25, 'hold'=>'Quant' ) ),
					
					'В продаже (шт)'		=>	array( 'type'=>'hidden', 	'field'=>'in_stock', 		'params'=>array( 'size'=>25, 'hold'=>'In stock' ) ),
					
					'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					'Индексация'			=>	array( 'type'=>'block', 	'field'=>'index', 			'params'=>array( 'reverse'=>false ) ),
					
					'Групы товаров'			=>	array( 'type'=>'multiselect', 'field'=>'product_groups', 			'params'=>array( 
																														 'list'=>$productsGroups, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['productGroups'], 
																														 'onChange'=>"" 
																														 ) ),
					
					'clear-4'				=>	array( 'type'=>'clear' ),								
					 
					//'Сопровождающий текст'	=>	array( 'type'=>'input', 	'field'=>'dop_text', 		'params'=>array( 'size'=>100, 'hold'=>'Text about price...') ),	
					
					'Описание товара '.$lpx	=>	array( 'type'=>'redactor', 	'field'=>$pref.'details', 		'params'=>array(  ) ),
					
					
					//'Видео товара'	=>	array( 'type'=>'input', 	'field'=>'video', 		'params'=>array( 'size'=>100, 'hold'=>'src=...') ),
					

					'Динамичные свойства товара'		=>	array( 'type'=>'header'),
			
					'Наличие динамичного свойства'		=>	array( 'type'=>'hidden', 	'field'=>'has_charsD', 		'params'=>array( 'size'=>25, 'hold'=>'Has dinamical chars?' ) ),
					
					'ID динамичного свойства'			=>	array( 'type'=>'hidden', 	'field'=>'charsD_ID', 		'params'=>array( 'size'=>25, 'hold'=>'Dinamical char ID' ) ),
			
					$cardItem['charsGroup']['name']." (dinamic)" => array( 'type'=>'shopProductDinamicChars', 'field'=>'charD', 'params'=>array('chars'=>$cardItem['charsD'],'has_chars'=>$cardItem['has_charsD'],'charsGroupID'=>$cardItem['charsGroup']['id']) ),

					'Свойства товара'		=>	array( 'type'=>'header'),
					
					'Текущая категория'		=>	array( 'type'=>'hidden',	'field'=>'prevent_cat_id', 	'params'=>array( 'field'=>"category", 'arr_field'=>'id' ) ),
					
					'Наличие свойств'		=>	array( 'type'=>'hidden', 	'field'=>'has_chars', 		'params'=>array( 'size'=>25, 'hold'=>'Has chars?' ) ),
					
					$cardItem['charsGroup']['name'] => array( 'type'=>'shopProductChars', 'field'=>'char', 'params'=>array('chars'=>$cardItem['chars'],'has_chars'=>$cardItem['has_chars']) ),
					
					 
					'Габариты товара'	=>	array( 'type'=>'header'),					
					
					'Длина (см)'			=>	array( 'type'=>'input', 	'field'=>'width', 			'params'=>array( 'size'=>15, 'hold'=>'Width' ) ),
					
					'Глубина (см)'			=>	array( 'type'=>'input', 	'field'=>'depth', 			'params'=>array( 'size'=>15, 'hold'=>'Depth' ) ),
					
					'Высота (см)'			=>	array( 'type'=>'input', 	'field'=>'height', 			'params'=>array( 'size'=>15, 'hold'=>'Height' ) ),
					
					'Диаметр (см)'			=>	array( 'type'=>'input', 	'field'=>'diameter', 		'params'=>array( 'size'=>15, 'hold'=>'Diameter' ) ),
					
					//'Вес (г)'				=>	array( 'type'=>'input', 	'field'=>'weight', 			'params'=>array( 'size'=>15, 'hold'=>'Weight' ) ),
					
					//'Параметры публикации'	=>	array( 'type'=>'header'),
					 
					'Начало публикации'		=>	array( 'type'=>'hidden', 		'field'=>'date_start', 		'params'=>array( ) ),
					 
					'Завершение публикации'	=>	array( 'type'=>'hidden', 		'field'=>'date_finish', 	'params'=>array( ) ),
					
					 
					'Мета теги'				=>	array( 'type'=>'header'),
					 
					'Title '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					'Keywords '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					'Description '.$lpx		=>	array( 'type'=>'area', 		'field'=>$pref.'desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					
					 
					'Изображения Товара'		=>	array( 'type'=>'header'),
					 
					'Выбор изображений (min: 400x300px)'		=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>"/webroot/img/split/files/shop/products/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
					
					 
					'Варианты отделки'		=>	array( 'type'=>'header'),
					 
					'Изображение (min: 400x300px)'		=>	array( 'type'=>'image_mult', 'field'=>'finishes', 		'params'=>array( 'path'=>"/webroot/img/split/files/shop/finishes/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) )
					
					/*'Видео'				=>	array( 'type'=>'header'),
					 
					'Выбор видеофайла'		=>	array( 'type'=>'image_mono', 'field'=>'video', 		'params'=>array( 'path'=>"/webroot/img/split/files/shop/products/video/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) )
					
					'Аксессуары'			=>	array( 'type'=>'header'),
					
					'Список аксессуаров'	=>	array( 'type'=>'prod_access_script', 'access_list'=>$access_list),
					
					'Похожие товары'	=>	array( 'type'=>'header'),
					
					'Список товаров'	=>	array( 'type'=>'prod_complect_script', 'access_list'=>$complect_list)*/
					
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editShopProductsItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Next/Prev product links
	
	$prev_link = "";
	$next_link = "";
	
	if($cardItem['prev_prod'])
	{
		$prev_link = "<a style='float:left; color:green;' href='javascript:void(0);' title='".stripslashes($cardItem['prev_prod']['name'])."' onclick=\"loadPage('shop','shop-products',18,".$cardItem['prev_prod']['id'].",'cardEdit',{});\">&lsaquo; Предыдущий товар</a>";
	}
	
	if($cardItem['next_prod'])
	{
		$next_link = "<a style='float:right; color:green;' href='javascript:void(0);' title='".stripslashes($cardItem['next_prod']['name'])."' onclick=\"loadPage('shop','shop-products',18,".$cardItem['next_prod']['id'].",'cardEdit',{});\">Следующий товар &rsaquo;</a>";
	}
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<div class='new-line' style='text-align:center; min-height:20px;'>$prev_link Форма редактирования карточки товара #$item_id $next_link</div>
			<div class='clear'></div>
			";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>