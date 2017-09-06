<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content

	$cardItem = $zh->getTranslationsItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
				 
					 																							 
					 'Перевод (RU)'		=>	array( 'type'=>'input', 	'field'=>'text', 			'params'=>array( 'size'=>125, 'hold'=>'Translate' ) ),
					 //'Страница'			=>	array( 'type'=>'input', 	'field'=>'page', 			'params'=>array( 'size'=>100, 'hold'=>'Translate', 'disabled'=>true ) ),				 
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createLang", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания нового перевода</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>