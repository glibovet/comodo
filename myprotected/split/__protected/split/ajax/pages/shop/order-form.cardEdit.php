<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getShopOrderDetails($item_id);
	
	// Get order statuses
	
	$orderStatuses = $zh->getOrderStatuses();
	
	
	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 
					 'Клиент ID'			=>	array( 'type'=>'input', 		'field'=>'user_id', 				'params'=>array( 'size'=>25, 'hold'=>'USER ID' ) ),
					 
					 'Клиент'				=>	array( 'type'=>'autocomplete', 	'field'=>'user_select', 			'params'=>array( 'size'=>25, 'hold'=>'Client', 'value'=>$cardItem['order_user']['name']." ".$cardItem['order_user']['fname'] ) ),
					 
					 'Имя'					=>	array( 'type'=>'input', 		'field'=>'client_name', 			'params'=>array( 'size'=>25, 'hold'=>'Name' ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 		'field'=>'client_fname', 			'params'=>array( 'size'=>25, 'hold'=>'Last name' ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 		'field'=>'client_phone', 			'params'=>array( 'size'=>25, 'hold'=>'Client phone' ) ),
					 
					 'Email'				=>	array( 'type'=>'input', 		'field'=>'client_email', 			'params'=>array( 'size'=>25, 'hold'=>'Client email' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					'Статус заказа'			=>	array( 'type'=>'select', 		'field'=>'status', 			'params'=>array( 'list'=>$orderStatuses, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['status'], 
																														 'onChange'=>"" 
																														 ) ),
					 'clear-1'				=>	array( 'type'=>'clear' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editShopOrder", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Заказ с интернет магазина #".($item_id+5000)."</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>