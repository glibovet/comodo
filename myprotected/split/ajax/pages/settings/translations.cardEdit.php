<?php 
	// Start header content

	//$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'translate_edit' );
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getTranslationsItem($item_id);

	$rootPath = "../../../../..";
	$disabled = ($lpx ? false : true);
	
	$cardTmp = array(
					 'LPX'					=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Перевод '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'text', 			'params'=>array( 'size'=>125, 'hold'=>'Translate '.$lpx, 'disabled'=>$disabled ) ),
					 //'Страница'			=>	array( 'type'=>'input', 	'field'=>'page', 			'params'=>array( 'size'=>100, 'hold'=>'Translate', 'disabled'=>true ) ),
					 'clear-1'				=>	array( 'type'=>'clear' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editTranslate", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования перевода #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>