<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSiteCommentItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 //'Имя'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"" ) ),
					 'ID пользователя ('.$cardItem['user_email'].')'			=>	array( 'type'=>'input', 	'field'=>'user_id', 			'params'=>array( 'size'=>50, 'hold'=>'USER ID', 'onchange'=>"" ) ),
					 
					 'Clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Заголовок'		=>	array( 'type'=>'input', 		'field'=>'caption', 		'params'=>array( 'size'=>100, 'hold'=>'Caption' ) ),
					 
					 'Комментарий'		=>	array( 'type'=>'area', 		'field'=>'comment', 		'params'=>array( 'size'=>50, 'hold'=>'Comment' ) ),
					 
					 'Clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Рейтинг (1-5)'				=>	array( 'type'=>'input', 	'field'=>'rating', 			'params'=>array( 'size'=>15, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 'Публикация'				=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) )
					 
					//'Изображения'			=>	array( 'type'=>'header'),
					 
					//'Выбор изображений'		=>	array( 'type'=>'image_mult', 'field'=>'images', 		'params'=>array( 'path'=>"/webroot/img/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) )
					 
					// 'Заголовок'				=>	array( 'type'=>'input', 	'field'=>'caption', 		'params'=>array( 'size'=>75, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					
					 
					 //'ID статьи ('.$cardItem['prod_name'].')'				=>	array( 'type'=>'input', 	'field'=>'art_id', 			'params'=>array( 'size'=>50, 'hold'=>'ARTICLE ID', 'onchange'=>"" ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editSiteComment", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования отзыва о сайте#$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>