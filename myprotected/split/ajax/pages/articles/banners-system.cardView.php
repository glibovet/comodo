<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getBannerItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Позиция'					=>	array( 'type'=>'text', 		'field'=>'pos_name', 		'params'=>array() ),
					 'Изображение'				=>	array( 'type'=>'image',		'field'=>'file',			'params'=>array( 'path'=>'/webroot/img/split/files/content/' ) ),
					 'Публикация'				=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Содержание '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'data', 		'params'=>array() ),
					 'Алиас'					=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 //'Начало публикации'		=>	array( 'type'=>'date', 		'field'=>'startPublish', 	'params'=>array() ),
					 //'Завершение публикации'	=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array() ),
					 'Ссылка'					=>	array( 'type'=>'text', 		'field'=>'link', 			'params'=>array() ),
					 'Открывать в новом окне?'	=>	array( 'type'=>'text', 		'field'=>'target', 			'params'=>array( 'replace'=>array('0'=>'Нет', '1'=>'Да') ) ),
					 'Дата создания'			=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр баннера #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>