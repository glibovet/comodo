<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getContactItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Город (RU)'		=>	array( 'type'=>'input', 	'field'=>'city',  'params'=>array( 'size'=>35, 'hold'=>'Город', 'onchange'=>"change_alias();" ) ),				 
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Номера телефонов (через ";")'	=>	array( 'type'=>'input', 	'field'=>'phone_number', 		'params'=>array( 'size'=>35, 'hold'=>'044 000-00-00;' ) ),
					 
					 'Email'				=>	array( 'type'=>'input', 	'field'=>'email', 		'params'=>array( 'size'=>35, 'hold'=>'SupportEmail' ) ),					 
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Адрес (RU)'			=>	array( 'type'=>'input', 	'field'=>'adress', 	'params'=>array( 'size'=>50, 'hold'=>'Адрес' ) ),
					 
					 'Ссылка на карту'		=>	array( 'type'=>'input', 	'field'=>'map_frame', 			'params'=>array( 'size'=>75, 'hold'=>'map url' ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),	
					 
					 'Время Пн-Пт (RU)'		=>	array( 'type'=>'input', 	'field'=>'work_time', 	'params'=>array( 'size'=>25, 'hold'=>'Время Пн-Пт' ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),	
					 
					 'Время Сб (RU)'		=>	array( 'type'=>'input', 	'field'=>'sat_time', 	'params'=>array( 'size'=>25, 'hold'=>'Время Сб' ) ),
					 
					 'clear-5'				=>	array( 'type'=>'clear' ),	
					 
					 'Время Вс (RU)'		=>	array( 'type'=>'input', 	'field'=>'sun_time', 	'params'=>array( 'size'=>25, 'hold'=>'Время Вс' ) ),	
					 
					 'clear-6'				=>	array( 'type'=>'clear' ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 				'params'=>array( 'reverse'=>true ) ),
					 
					 'clear-7'					=>	array( 'type'=>'clear' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createContactItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания контакта</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>