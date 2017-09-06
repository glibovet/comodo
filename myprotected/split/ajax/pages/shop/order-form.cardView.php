<?php 
	$cardItem = $zh->getShopOrderDetails($item_id);
	
	// Start header content

	$backTask = (isset($params['backTask']) ? true : false);

	$headOrderParams = array('confirm'=>false,'cancel'=>false, 'backTask'=>$backTask);
	
	if($cardItem['status']==1) $headOrderParams['confirm'] = true;
	
	if($cardItem['status']!=5) $headOrderParams['cancel'] = true;
	
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'shopOrder', 'params'=>$headOrderParams );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content

	$rootPath = "../../../../..";
	
	
	// Get str of Order view
	
	$viewParams = array();
	
	$shopOrderViewStr = $zh->getShopOrderView($cardItem,$viewParams);
	
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Заказ с интернет магазина #".($item_id+5000)."</h3>";
	
	$data['bodyContent'] .= $shopOrderViewStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>