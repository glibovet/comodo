<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCharsItemDetails($item_id);
	
	$charsGroups = $zh->getCharsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Публикация на сайте'	=>	array( 'type'=>'block', 	'field'=>'show_site', 		'params'=>array( 'reverse'=>false ) ),
					 
					 'Публикация в админ'	=>	array( 'type'=>'block', 	'field'=>'show_admin', 		'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					'Ггрупа характеристик'	=>	array( 'type'=>'select', 	'field'=>'group_id', 		'params'=>array( 'list'=>$charsGroups, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['group_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'No select', 'id'=>0 ) 
																														 ) ),
					 
					 
					 'Значение по умолчанию'=>	array( 'type'=>'input', 	'field'=>'default', 		'params'=>array( 'size'=>25, 'hold'=>'Default', 'onchange'=>"" ) ),
					 
					 'Еденица измерения'	=>	array( 'type'=>'input', 	'field'=>'measure', 		'params'=>array( 'size'=>25, 'hold'=>'Measure', 'onchange'=>"" ) ),
					 
					 'Подсказка'			=>	array( 'type'=>'input', 	'field'=>'title', 			'params'=>array( 'size'=>25, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editShopCharsItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования товарного свойства #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>