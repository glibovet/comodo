<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCharsItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Группа характеристик'	=>	array( 'type'=>'arr_mono', 	'field'=>'charsGroup', 		'params'=>array( 'field'=>'name','link'=>array('parent'=>'shop',
					 																																   'alias'=>'category-svoistv-tovarov',
																																					   'id'=>34,
																																					   'item_id'=>1,
																																					   'params'=>'{}') ) ),
					 'Значение по умолчанию'=>	array( 'type'=>'text', 		'field'=>'default', 		'params'=>array() ),
					 'Еденица измерения'	=>	array( 'type'=>'text', 		'field'=>'measure',			'params'=>array() ),
					 'Подсказка'			=>	array( 'type'=>'text', 		'field'=>'title',			'params'=>array() ),
					 'Публикация на сайте'	=>	array( 'type'=>'text', 		'field'=>'show_site', 		'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Публикация в админ'	=>	array( 'type'=>'text', 		'field'=>'show_admin', 		'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр свойства #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>