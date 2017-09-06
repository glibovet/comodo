<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getCatalogItemDetails($item_id);

	$catalogParents = $zh->getCatalogParents();
	
	$charsGroups = $zh->getCharsGroups();

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Название '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"$nameChange" ) ),
					 
					 'Алиас'				=>	array( 'type'=>"$aliasType", 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Родитель'				=>	array( 'type'=>'select', 	'field'=>'parent', 			'params'=>array( 'list'=>$catalogParents, 
					 																									 'type'=>'allCatalog',
																														 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['parent']['id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'-- Корневая категория --', 'id'=>0 ) 
																														 ) ),
					'Группа характеристик'	=>	array( 'type'=>'select', 	'field'=>'charsGroup', 		'params'=>array( 'list'=>$charsGroups, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['charsGroup']['id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'No select', 'id'=>0 ) 
																														 ) ),
					 
					 'clear-2'					=>	array( 'type'=>'clear' ),
					 
					 'Публикация'				=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Индексация'				=>	array( 'type'=>'block', 	'field'=>'index', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-3'					=>	array( 'type'=>'clear' ),
					 
					 'Описание категории '.$lpx	=>	array( 'type'=>'redactor', 	'field'=>$pref.'details', 		'params'=>array(  ) ),
					 
					 //'Параметры публикации'		=>	array( 'type'=>'header'),
					 
					 //'Начало публикации'			=>	array( 'type'=>'date', 		'field'=>'startPublish', 	'params'=>array( ) ),
					 
					 //'Завершение публикации'	=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array( ) ),
					 
					 'Мета теги'					=>	array( 'type'=>'header'),
					 
					 'Title '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Keywords '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					 'Description '.$lpx		=>	array( 'type'=>'area', 		'field'=>$pref.'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Изображение категории (500x375px)'=>	array( 'type'=>'image_mono','field'=>'filename', 		'params'=>array( 'path'=>"/webroot/img/split/files/shop/categories/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editShopCatalogItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования карточки каталога #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>