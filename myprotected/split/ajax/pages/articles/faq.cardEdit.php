<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getFaqItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'ВОПРОС (RU)'				=>	array( 'type'=>'area', 		'field'=>'question', 		'params'=>array( 'size'=>100, 'hold'=>'ВОПРОС' ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'ПИТАННЯ (UA)'				=>	array( 'type'=>'area', 		'field'=>'ua_question', 		'params'=>array( 'size'=>100, 'hold'=>'ПИТАННЯ' ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'QUESTION (EN)'				=>	array( 'type'=>'area', 		'field'=>'en_question', 		'params'=>array( 'size'=>100, 'hold'=>'QUESTION' ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),
					 
					 'Ответ (RU)'				=>	array( 'type'=>'redactor', 	'field'=>'answer', 			'params'=>array( 'size'=>100, 'hold'=>'Ответ' ) ),
					  
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 'Відповідь (UA)'				=>	array( 'type'=>'redactor', 	'field'=>'ua_answer', 			'params'=>array( 'size'=>100, 'hold'=>'Відповідь' ) ),
					  
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 'Answer (EN)'				=>	array( 'type'=>'redactor', 	'field'=>'en_answer', 			'params'=>array( 'size'=>100, 'hold'=>'Answer' ) ),
					  
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 																							 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Порядковый номер'		=>	array( 'type'=>'number', 	'field'=>'order_id' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editFAQ", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования FAQ #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>