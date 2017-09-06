<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getStockItem($item_id);

	$rootPath = "../../../../..";
	
	// Get Stocks List
	
	$stocksList		= $zh->getStocksList();
	
	$fullnessStatuses = array(
								array('id'=>'0','name'=>'Пустая'),
								array('id'=>'1','name'=>'Не полная'),
								array('id'=>'2','name'=>'Полная')
							);
	
	$cardTmp = array(
					 'Код ячейки'			=>	array( 'type'=>'input', 	'field'=>'code', 			'params'=>array( 'size'=>25, 'hold'=>'Code' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Склад'				=>	array( 'type'=>'select', 	'field'=>'stock_id', 		'params'=>array( 'list'=>$stocksList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['stock_id'], 
																														 'onChange'=>"",
																														 'first'=>array( 'name'=>'Не определен', 'id'=>0 ) 
																														 ) ),
					 
					 'Наполненность'		=>	array( 'type'=>'select', 	'field'=>'fullness', 		'params'=>array( 'list'=>$fullnessStatuses, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>0, 
																														 'onChange'=>"" 
																														 // ,'first'=>array( 'name'=>'Node', 'id'=>0 ) 
																														 ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createStockCellItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания новой ячейки на складе</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>