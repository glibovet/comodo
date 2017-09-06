<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getContactItem($item_id);

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'					=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Город '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'city', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Номера телефонов (через ";")'	=>	array( 'type'=>'input', 	'field'=>'phone_number', 		'params'=>array( 'size'=>35, 'hold'=>'044 000-00-00;' ) ),
					 
					 'Email'				=>	array( 'type'=>'input', 	'field'=>'email', 		'params'=>array( 'size'=>35, 'hold'=>'SupportEmail' ) ),					 
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Адрес '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'adress', 	'params'=>array( 'size'=>50, 'hold'=>'Адрес' ) ),
					 
					 'Ссылка на карту'		=>	array( 'type'=>'input', 	'field'=>'map_frame', 			'params'=>array( 'size'=>75, 'hold'=>'map url' ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),	
					 
					 'Время Пн-Пт '.$lpx	=>	array( 'type'=>'input', 	'field'=>$pref.'work_time', 	'params'=>array( 'size'=>25, 'hold'=>'Время Пн-Пт' ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),	
					 
					 'Время Сб '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'sat_time', 	'params'=>array( 'size'=>25, 'hold'=>'Время Сб' ) ),
					 
					 'clear-5'				=>	array( 'type'=>'clear' ),	
					 
					 'Время Вс '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'sun_time', 	'params'=>array( 'size'=>25, 'hold'=>'Время Вс' ) ),
					 
					 'clear-6'				=>	array( 'type'=>'clear' ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 				'params'=>array( 'reverse'=>true ) ),
					 
					 'clear-7'				=>	array( 'type'=>'clear' )					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editContactItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Контакты сайта (режим редактирования)</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>