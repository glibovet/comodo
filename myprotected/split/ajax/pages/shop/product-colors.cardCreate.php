<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProdColDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название (RU)'			=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>100, 'hold'=>'Название' ) ),
					 'Значение'				=>	array( 'type'=>'color', 	'field'=>'value', 		'params'=>array( 'size'=>25, 'hold'=>'#000000' ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'Позиция'			=>	array( 'type'=>'input', 	'field'=>'order_id', 	'params'=>array( 'size'=>20, 'hold'=>'1' ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createProdColor", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания цвета продукта</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>