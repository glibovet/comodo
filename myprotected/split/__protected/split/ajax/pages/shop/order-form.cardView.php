<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'shopOrder' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getShopOrderDetails($item_id);

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