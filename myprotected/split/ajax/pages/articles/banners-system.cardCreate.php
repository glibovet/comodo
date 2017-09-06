<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getBannerItem($item_id);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get categories List
	
	$catsList = $zh->getCatsList();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название (RU)'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),					 
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 
					 'Ссылка'				=>	array( 'type'=>'input', 	'field'=>'link', 			'params'=>array( 'size'=>75, 'hold'=>'Link' ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Позиция'				=>	array( 'type'=>'select', 	'field'=>'pos_id', 			'params'=>array( 'list'=>$sitePositions, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['pos_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'No select', 'id'=>0 ) 
																														 ) ),
																														 
					 'Порядковый номер'		=>	array( 'type'=>'input', 	'field'=>'order_id', 		'params'=>array( 'size'=>20, 'hold'=>'№' ) ),
																														 
					 //'Начало публикации'		=>	array( 'type'=>'date', 		'field'=>'startPublish', 	'params'=>array(  ) ),
					 
					 //'Завершение публикации'=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array(  ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'В новом окне?'		=>	array( 'type'=>'block', 	'field'=>'target', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Содержание (RU)'		=>	array( 'type'=>'redactor', 	'field'=>'data', 			'params'=>array(  ) ),
					 
					 'Изображение'			=>	array( 'type'=>'header'),
					 
					 'Изображение баннера'=>	array( 'type'=>'image_mono','field'=>'file', 			'params'=>array( 'path'=>"/webroot/img/split/files/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 
					 /*'Изображение материала (MOB: min: 1366x768px)'=>	array( 'type'=>'image_mono','field'=>'file_sm', 		'params'=>array( 'path'=>"/webroot/img/split/files/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"file" ) )*/
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createBanner", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания баннера</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>