<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getGalleryItem($item_id);
	
	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название в Админпанели'	=>	array( 'type'=>'input', 	'field'=>'name', 		'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 //'Заголовок на сайте'		=>	array( 'type'=>'input', 	'field'=>'caption', 	'params'=>array( 'size'=>50, 'hold'=>'CAption' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 //'Описание'				=>	array( 'type'=>'redactor', 	'field'=>'data', 			'params'=>array(  ) ),
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Выбор изображений (min: 1200x900px)'	=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>"/webroot/img/split/files/content/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editGallery", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования Галлереи #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>