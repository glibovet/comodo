<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getStockItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>40, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Адресс'				=>	array( 'type'=>'input', 	'field'=>'adress', 			'params'=>array( 'size'=>100, 'hold'=>'Address' ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'GPS широта'			=>	array( 'type'=>'input', 	'field'=>'gps_w', 			'params'=>array( 'size'=>25, 'hold'=>'GPS w' ) ),
					 
					 'GPS долгота'			=>	array( 'type'=>'input', 	'field'=>'gps_h', 			'params'=>array( 'size'=>25, 'hold'=>'GPS h' ) )
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editStockItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования информации о складе #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>