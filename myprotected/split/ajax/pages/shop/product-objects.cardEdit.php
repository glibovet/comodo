<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProdObjecDetails($item_id);

	$catalogList = $zh->getCatalogParents();

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Название '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"" ) ),
					 
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

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editProdMaterial", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования предмета мебели <b>&laquo;".($cardItem['name'])."&raquo;</b></h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>