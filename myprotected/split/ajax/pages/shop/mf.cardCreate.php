<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getShopMfDetails($item_id);
	
	$catalogParents = $zh->getCatalogParents();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название (RU)'			=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>"input", 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'Страна (RU)'			=>	array( 'type'=>'input', 	'field'=>'country', 		'params'=>array( 'size'=>50, 'hold'=>'country' ) ),
					 
					 'Сайт'					=>	array( 'type'=>'input', 	'field'=>'site', 			'params'=>array( 'size'=>50, 'reverse'=>true ) ),						 
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					  'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'LOGO'					=>	array( 'type'=>'image_mono',	'field'=>'filename', 		'params'=>array( 'path'=>"/webroot/img/split/files/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 //'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Содержание (RU)'		=>	array( 'type'=>'redactor', 	'field'=>'details', 	'params'=>array(  ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),																														 
					 
					 'Видеоматериал'			=>	array(  'type'=>'input', 	'field'=>'video', 			'params'=>array( 'size'=>125, 'hold'=>'YouTube src=...' ) ),
					 
					 'Мета теги'				=>	array( 'type'=>'header'),
					 
					 'Title (RU)'			=>	array( 'type'=>'input', 	'field'=>'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Keywords (RU)'		=>	array( 'type'=>'input', 	'field'=>'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					 'Description (RU)'		=>	array( 'type'=>'area', 		'field'=>'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' )
					 
					 /*'Категория'				=>	array( 'type'=>'select', 	'field'=>'cat_id', 			'params'=>array( 'list'=>$catalogParents, 
					 																									 'type'=>'allCatalog', 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['cat_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'-- Корневая категория --', 'id'=>0 ) 
																														 ) )*/
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createShopMfItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания производителя</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>