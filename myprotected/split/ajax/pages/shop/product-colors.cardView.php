<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProdColDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Название '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'Значение'				=>	array( 'type'=>'text', 		'field'=>'value', 			'params'=>array() ),
					 'Позиция'				=>	array( 'type'=>'text', 		'field'=>'order_id', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs  );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр цвета продукта #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>