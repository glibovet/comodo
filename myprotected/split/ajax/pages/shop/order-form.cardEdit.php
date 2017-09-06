<?php 
	$cardItem = $zh->getShopOrderDetails($item_id);
	
	// Start header content
	
	$headOrderParams = array('confirm'=>false,'cancel'=>false);
	
	if($cardItem['status']==1) $headOrderParams['confirm'] = true;
	
	if($cardItem['status']!=5) $headOrderParams['cancel'] = true;
	
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'shopOrder', 'params'=>$headOrderParams );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	
	// Start body content
	
	
	// Get order statuses
	
	$orderStatuses		= $zh->getOrderStatuses();
	
	$deliveryMethods 	= $zh->getDeliveryMethods();
	
	$paymentMethods 	= $zh->getPaymentMethods();
	
	$cartProducts = ($cardItem['products'] != "" ? unserialize($cardItem['products']) : array() );
	
	$nodeList 			= $zh->getCatalogParents(); // get Brands
	
	$paidStatuses = array( array('id'=>'Оплачен','name'=>'Оплачен'), array('id'=>'Не оплачен','name'=>'Не оплачен'));
	
	$orderNotes = array('Создан:'=>$cardItem['dateCreate'],'Автор:'=>"WebPlat ItFurLine",'№ заказа:'=>($item_id+5000),'ID:'=>$item_id);
	
	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 
					 'Клиент ID'			=>	array( 'type'=>'hidden', 		'field'=>'user_id' ),
					 
					 'Старый статус заказа'	=>	array( 'type'=>'hidden', 		'field'=>'old_order_status', 		'value'=>$cardItem['status'] ),
					 
					 'Клиент'				=>	array( 'type'=>'autocomplete', 	'field'=>'user_select', 			'params'=>array( 'size'=>50, 'hold'=>'Client', 
					 																										'value'=>$cardItem['order_user']['name']." ".$cardItem['order_user']['fname'] ) ),
					 
					 'Имя'					=>	array( 'type'=>'input', 		'field'=>'client_name', 			'params'=>array( 'size'=>25, 'hold'=>'Name' ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 		'field'=>'client_fname', 			'params'=>array( 'size'=>25, 'hold'=>'Last name' ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 		'field'=>'client_phone', 			'params'=>array( 'size'=>25, 'hold'=>'Client phone' ) ),
					 
					 'Email'				=>	array( 'type'=>'input', 		'field'=>'client_email', 			'params'=>array( 'size'=>25, 'hold'=>'Client email' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					'Статус заказа'			=>	array( 'type'=>'select', 		'field'=>'status', 					'params'=>array( 'list'=>$orderStatuses, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['status'], 
																														 'onChange'=>"" 
																														 ) ),
																														 
					'Статус оплаты'			=>	array( 'type'=>'select', 		'field'=>'paid_status', 			'params'=>array( 'list'=>$paidStatuses, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['paid_status'], 
																														 'onChange'=>"" 
																														 ) ),
																														 
					'Способ оплаты'			=>	array( 'type'=>'select', 		'field'=>'pay_method', 				'params'=>array( 'list'=>$paymentMethods, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['pay_method'], 
																														 'onChange'=>"" 
																														 ) ),
					 'Доставка'				=>	array( 'type'=>'header'),
					 
					 'Способ доставки'		=>	array( 'type'=>'select', 		'field'=>'delivery_method', 		'params'=>array( 'list'=>$deliveryMethods, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['delivery_method'], 
																														 'onChange'=>"" 
																														 ) ),
																														 
					 'Адрес доставки'		=>	array( 'type'=>'input', 		'field'=>'delivery_address', 		'params'=>array( 'size'=>100, 'hold'=>'Address' ) ),
					 																									 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Дата доставки'		=>	array( 'type'=>'date', 			'field'=>'delivery_date', 			'params'=>array( ) ),
					 
					 'Время доставки'		=>	array( 'type'=>'input', 		'field'=>'delivery_time', 			'params'=>array( 'size'=>25, 'hold'=>'Time' ) ),
					 
					 'Товары'				=>	array( 'type'=>'header'),
					 
					 'ProductsJs'			=>	array( 'type'=>'hidden', 		'field'=>'productsJsData' ),
					 
					 'Список товаров'		=>	array( 'type'=>'cartProducts',	'field'=>'products',				'params'=>array( 'items'=>$cartProducts, 'node_list'=>$nodeList, 'delivery_price'=>$cardItem['delivery']['price'], 'type'=>'edit' )),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),
					 
					 'Комментарий к заказу'	=>	array( 'type'=>'area', 			'field'=>'details', 				'params'=>array( 'size'=>50, 'hold'=>'Comments' ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 'Удаление заказа'		=>	array( 'type'=>'header'),
					 
					 'Удалить заказ'		=>	array( 'type'=>'deleteOrder'),
					 
					 'Сведенья'				=>	array( 'type'=>'notes',			'field'=>'order_notes',				'params'=>array('notes'=>$orderNotes))
					 
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