<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getContactItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Город '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'city', 		'params'=>array() ),
					 'Телефон'				=>	array( 'type'=>'text', 		'field'=>'phone_number', 	'params'=>array() ),
					 'Email'				=>	array( 'type'=>'text', 		'field'=>'email', 			'params'=>array() ),	 
					 'Адрес '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'adress', 	'params'=>array() ),	 
					 'Время Пн-Пт '.$lpx	=>	array( 'type'=>'text', 		'field'=>$pref.'work_time', 'params'=>array() ),	 
					 'Время Сб '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'sat_time', 	'params'=>array() ),	 	 
					 'Время Вс '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'sun_time', 	'params'=>array() ),	
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Открыт', '1'=>'Закрыт') ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Контакты сайта (режим просмотра)</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>