<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSiteMessageItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 			'params'=>array() ),
					 'ID Пользователя'		=>	array( 'type'=>'text', 		'field'=>'user_id', 	'params'=>array() ),
					 'Пользователь'			=>	array( 'type'=>'text', 		'field'=>'email', 		'params'=>array() ),
					 'Имя'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
					 'Сообщение'			=>	array( 'type'=>'text', 		'field'=>'message', 	'params'=>array() ),
					 
					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр сообщения</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>