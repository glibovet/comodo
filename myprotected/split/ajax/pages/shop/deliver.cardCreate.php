<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getShopDeliverDetails($item_id);
	
	$catalogParents = $zh->getCatalogParents();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 'На русском'			=>	array( 'type'=>'input', 	'field'=>'rus_name', 		'params'=>array( 'size'=>25, 'hold'=>'Russian name' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					'Категория'				=>	array( 'type'=>'select', 	'field'=>'cat_id', 			'params'=>array( 'list'=>$catalogParents, 
					 																									 'type'=>'allCatalog', 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['cat_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'-- Корневая категория --', 'id'=>0 ) 
																														 ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createShopDeliverItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания поставщика</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>