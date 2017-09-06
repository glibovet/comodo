<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProductsGroupItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 //'Заголовок'			=>	array( 'type'=>'text', 		'field'=>'title', 			'params'=>array() ),
					 //'Подпись'				=>	array( 'type'=>'text', 		'field'=>'signature', 		'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Количество товаров'	=>	array( 'type'=>'text', 		'field'=>'products_quant', 	'params'=>array() ),
					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр группы товаров</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>