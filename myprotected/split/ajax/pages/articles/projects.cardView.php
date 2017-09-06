<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProjectItem($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Архитектор'			=>	array( 'type'=>'text', 		'field'=>'user_name', 		'params'=>array() ),
					 'Изображения'			=>	array( 'type'=>'images',	'field'=>'images',			'params'=>array( 'path'=>'/webroot/img/split/files/projects/', 'field'=>'file' ) ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Содержание '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'content', 	'params'=>array() ),
					 'Дата создания'			=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр материала #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>