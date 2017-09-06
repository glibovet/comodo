<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProdObjecDetails($item_id);

	$catalogList = $zh->getCatalogParents();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название (RU)'			=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>100, 'hold'=>'Название' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
										 
					
					'Категория товаров'			=>	array( 'type'=>'multiselect', 'field'=>'cat_groups', 			'params'=>array( 
																														 'list'=>$catalogList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['catGroups'], 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Позиция'			=>	array( 'type'=>'input', 	'field'=>'order_id', 	'params'=>array( 'size'=>20, 'hold'=>'1' ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createProdMaterial", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания предмета мебели</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>