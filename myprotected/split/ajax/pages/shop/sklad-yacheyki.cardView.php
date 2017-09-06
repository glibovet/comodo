<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getStockCellItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 //'Склад'				=>	array( 'type'=>'text', 		'field'=>'stock_name', 		'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Код ячейки'			=>	array( 'type'=>'text', 		'field'=>'code', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Наполненность'		=>	array( 'type'=>'text', 		'field'=>'fullness', 		'params'=>array('replace'=>array('0'=>'Пустая','1'=>'Не полная','2'=>'Полная')) ),
					 'Количество товаров'	=>	array( 'type'=>'text', 		'field'=>'products_count', 	'params'=>array() ),
					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр ячейки на складе '".$cardItem['stock_name']."'</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>