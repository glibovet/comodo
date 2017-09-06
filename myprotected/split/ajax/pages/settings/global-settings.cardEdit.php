<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSiteConfigs($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название сайта'		=>	array( 'type'=>'input', 	'field'=>'sitename', 			'params'=>array( 'size'=>35, 'hold'=>'Sitename', 'onchange'=>"change_alias();" ) ),
					 
					 'Номер телефона'		=>	array( 'type'=>'input', 	'field'=>'phone_number', 		'params'=>array( 'size'=>35, 'hold'=>'044-000-00-00' ) ),
					 
					 'Email техподдержки'	=>	array( 'type'=>'input', 	'field'=>'support_email', 		'params'=>array( 'size'=>35, 'hold'=>'SupportEmail' ) ),					 
					 
					 'clear-1'					=>	array( 'type'=>'clear' ),					 
					 
					 'FB ссылка'			=>	array( 'type'=>'input', 	'field'=>'fb_url', 		'params'=>array( 'size'=>50, 'hold'=>'FB url' ) ),
					 
					 'VK ссылка'			=>	array( 'type'=>'input', 	'field'=>'vk_url', 		'params'=>array( 'size'=>50, 'hold'=>'VK url' ) ),
					 
					 'G+ ссылка'			=>	array( 'type'=>'input', 	'field'=>'gp_url', 		'params'=>array( 'size'=>50, 'hold'=>'G+ url' ) ),					 
					 
					 'clear-2'					=>	array( 'type'=>'clear' ),
					 
					 'YouTube ссылка'	=>	array( 'type'=>'input', 	'field'=>'yt_url', 		'params'=>array( 'size'=>50, 'hold'=>'YouTube url' ) ),
					 
					 'Instagram ссылка'	=>	array( 'type'=>'input', 	'field'=>'in_url', 		'params'=>array( 'size'=>50, 'hold'=>'Instagram url' ) ),
					  
					 'clear-3'				=>	array( 'type'=>'clear' ),	
					 
					 'Copyright'			=>	array( 'type'=>'input', 	'field'=>'copyright', 		'params'=>array( 'size'=>50, 'hold'=>'Copyright' ) ),
					 
					 /*'Адрес компании (RU)'		=>	array( 'type'=>'input', 	'field'=>'shop_adress', 	'params'=>array( 'size'=>50, 'hold'=>'Адрес' ) ),
					 
					 'Адрес компании (UA)'	=>	array( 'type'=>'input', 	'field'=>'ua_shop_adress', 	'params'=>array( 'size'=>50, 'hold'=>'Адреса' ) ),
					 
					 'Адрес компании (EN)'		=>	array( 'type'=>'input', 	'field'=>'en_shop_adress', 	'params'=>array( 'size'=>50, 'hold'=>'Address' ) ),
					 
					 'Ссылка на карту'		=>	array( 'type'=>'input', 	'field'=>'map_frame', 			'params'=>array( 'size'=>75, 'hold'=>'map url' ) ),*/
					 
					 'clear-4'					=>	array( 'type'=>'clear' ),					 
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'active', 				'params'=>array( 'reverse'=>false ) ),
					 	
					 'Индексация'			=>	array( 'type'=>'block', 	'field'=>'index', 				'params'=>array( 'reverse'=>false ) ),					 
					 
					 'Недавние статьи (к-во)'=>	array( 'type'=>'input', 	'field'=>'blog_qnt', 			'params'=>array( 'size'=>15, 'hold'=>'8' ) ),
					 
					 'Мета теги на главной'	=>	array( 'type'=>'header'),
					 
					 'Title (RU)'				=>	array( 'type'=>'input', 	'field'=>'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
					 
					 'Keywords (RU)'				=>	array( 'type'=>'input', 	'field'=>'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords' ) ),
					 
					 'Description (RU)'			=>	array( 'type'=>'area', 		'field'=>'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					 'clear-5'					=>	array( 'type'=>'clear' ),
					 
					 'Title (UA)'				=>	array( 'type'=>'input', 	'field'=>'ua_meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
					 
					 'Keywords (UA)'				=>	array( 'type'=>'input', 	'field'=>'ua_meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords' ) ),
					 
					 'Description (UA)'			=>	array( 'type'=>'area', 		'field'=>'ua_meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),					 
					 
					 'clear-6'					=>	array( 'type'=>'clear' ),
					 
					 'Title (EN)'				=>	array( 'type'=>'input', 	'field'=>'en_meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title' ) ),
					 
					 'Keywords (EN)'				=>	array( 'type'=>'input', 	'field'=>'en_meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords' ) ),
					 
					 'Description (EN)'			=>	array( 'type'=>'area', 		'field'=>'en_meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) )					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editSiteConfig", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Глобальные настройки сайта (режим редактирования)</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>