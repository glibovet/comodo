<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProdColDetails($item_id);

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'					=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Название '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
					 'Значение'				=>	array( 'type'=>'color', 	'field'=>'value', 		'params'=>array( 'size'=>25, 'hold'=>'#000000' ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'Позиция'			=>	array( 'type'=>'input', 	'field'=>'order_id', 	'params'=>array( 'size'=>20, 'hold'=>'1' ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editProdColor", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования цвета продукта <b>&laquo;".($cardItem['name'])."&raquo;</b></h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>