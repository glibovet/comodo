<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCharsItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название (RU)'				=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Публикация на сайте'	=>	array( 'type'=>'block', 	'field'=>'show_site', 		'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					
					 'Участие в фильтрах'	=>	array( 'type'=>'block', 	'field'=>'show_admin', 		'params'=>array( 'reverse'=>false ) ),

					 'Тип динамичный?'		=>	array( 'type'=>'block', 	'field'=>'is_dinamic', 		'params'=>array( 'reverse'=>false ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' )				 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createProjectCharsItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания фильтра проекта</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>