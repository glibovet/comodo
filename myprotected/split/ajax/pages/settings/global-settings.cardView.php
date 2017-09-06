<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSiteConfigs($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название сайта'		=>	array( 'type'=>'text', 		'field'=>'sitename', 		'params'=>array() ),
					 'Телефон'				=>	array( 'type'=>'text', 		'field'=>'phone_number', 	'params'=>array() ),
					 'Email техподдержки'	=>	array( 'type'=>'text', 		'field'=>'support_email', 	'params'=>array() ),
					 'FB'					=>	array( 'type'=>'text', 		'field'=>'fb_url', 			'params'=>array() ),
					 'VK'					=>	array( 'type'=>'text', 		'field'=>'vk_url', 			'params'=>array() ),
					 'OK'					=>	array( 'type'=>'text', 		'field'=>'ok_url', 			'params'=>array() ),
					 'YouTube'				=>	array( 'type'=>'text', 		'field'=>'yt_url', 			'params'=>array() ),
					 'Instagram'			=>	array( 'type'=>'text', 		'field'=>'in_url', 			'params'=>array() ),
					 'Недавние статьи (к-во)'=>	array( 'type'=>'text', 		'field'=>'blog_qnt', 		'params'=>array() ),						 
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'active', 			'params'=>array( 'replace'=>array('0'=>'Закрыт', '1'=>'Открыт') ) ),
					 'Индексация'			=>	array( 'type'=>'text', 		'field'=>'index', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Meta title'			=>	array( 'type'=>'text', 		'field'=>'meta_title', 		'params'=>array() ),
					 'Meta keywords'		=>	array( 'type'=>'text', 		'field'=>'meta_keys', 		'params'=>array() ),
					 'Meta description'		=>	array( 'type'=>'text', 		'field'=>'meta_desc', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Глобальные настройки сайта (режим просмотра)</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>