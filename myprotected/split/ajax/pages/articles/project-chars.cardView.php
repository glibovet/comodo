<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getCharsItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Тип'					=>	array( 'type'=>'text', 		'field'=>'is_dinamic', 		'params'=>array( 'replace'=>array('0'=>'Обычный', '1'=>'<b>Динамичный</b>') ) ),
					 'Публикация на сайте'	=>	array( 'type'=>'text', 		'field'=>'show_site', 		'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Публикация в админ'	=>	array( 'type'=>'text', 		'field'=>'show_admin', 		'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр фильтра #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>