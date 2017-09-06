<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProductsItemDetails($item_id);

	$catalogList = $zh->getCatalogList();
	
	$charsGroups = $zh->getCharsGroups();
	
	$productsGroups = $zh->getProductsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Артикул'				=>	array( 'type'=>'input', 	'field'=>'sku', 			'params'=>array( 'size'=>25, 'hold'=>'Article' ) ),
					 
					 'Штрих-код'			=>	array( 'type'=>'input', 	'field'=>'code', 			'params'=>array( 'size'=>25, 'hold'=>'Code' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Индексация'			=>	array( 'type'=>'block', 	'field'=>'index', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 
					 'Категория'			=>	array( 'type'=>'select', 	'field'=>'cat_id', 			'params'=>array( 'type'=>'brandTree',
					 																									 'list'=>$catalogList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['category']['id'], 
					'onChange'=>"updateProductCharsForm(0,".json_encode($cardItem['charsGroup']).",".json_encode($cardItem['chars']).",$(this).val());", 
																														 'first'=>array( 'name'=>'Node', 'id'=>0 ) 
																														 ) ),
																														 
					'Цена (грн)'			=>	array( 'type'=>'number', 	'field'=>'price', 			'params'=>array( 'size'=>25, 'hold'=>'Price' ) ),
					
					'Доступно (шт)'			=>	array( 'type'=>'number', 	'field'=>'quant', 			'params'=>array( 'size'=>25, 'hold'=>'Quant' ) ),
					
					'Групы товаров'			=>	array( 'type'=>'multiselect', 'field'=>'product_groups', 			'params'=>array( 
																														 'list'=>$productsGroups, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['productGroups'], 
																														 'onChange'=>"" 
																														 ) ),
					'Свойства товара'		=>	array( 'type'=>'header'),
					
					'Текущая категория'		=>	array( 'type'=>'hidden',	'field'=>'prevent_cat_id', 	'params'=>array( 'field'=>"category", 'arr_field'=>'id' ) ),
					
					$cardItem['charsGroup']['name'] => array( 'type'=>'shopProductChars', 'field'=>'char', 'params'=>array('chars'=>$cardItem['chars']) ),
					 
					'clear-2'				=>	array( 'type'=>'clear' ),
					 
					'Описание товара'		=>	array( 'type'=>'redactor', 	'field'=>'details', 		'params'=>array(  ) ),
					 
					'Параметры публикации'	=>	array( 'type'=>'header'),
					 
					'Начало публикации'		=>	array( 'type'=>'date', 		'field'=>'date_start', 		'params'=>array( ) ),
					 
					'Завершение публикации'	=>	array( 'type'=>'date', 		'field'=>'date_finish', 	'params'=>array( ) ),
					 
					'Мета теги'				=>	array( 'type'=>'header'),
					 
					'Title'					=>	array( 'type'=>'input', 	'field'=>'title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					'Keywords'				=>	array( 'type'=>'input', 	'field'=>'keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					'Description'			=>	array( 'type'=>'area', 		'field'=>'desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					'Изображения'			=>	array( 'type'=>'header'),
					 
					'Выбор файлов'			=>	array( 'type'=>'image_mult','field'=>'images', 		'params'=>array( 'path'=>"/split/files/shop/products/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) )
					
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createShopProductsItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания карточки товара ".((isset($params['copyItem']) && $params['copyItem'] > 0) ? "(Дубликат карточки #".$params['copyItem'].")" : "")."</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>