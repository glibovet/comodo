<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getCatalogItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Изображение'			=>	array( 'type'=>'image',		'field'=>'filename',		'params'=>array( 'path'=>'/webroot/img/split/files/shop/categories/' ) ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Родитель'				=>	array( 'type'=>'arr_mono',	'field'=>'parent', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Дочерние элементы'	=>	array( 'type'=>'arr_mult',	'field'=>'childs', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Группа характеристик'	=>	array( 'type'=>'arr_mono', 	'field'=>'charsGroup', 		'params'=>array( 'field'=>'name','link'=>array('parent'=>'shop',
					 																																   'alias'=>'category-svoistv-tovarov',
																																					   'id'=>34,
																																					   'item_id'=>1,
																																					   'params'=>'{}') ) ),
					 'Описание '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'details', 		'params'=>array() ),
					 //'Начало публикации'		=>	array( 'type'=>'date', 		'field'=>'startPublish',	'params'=>array() ),
					 //'Конец публикации'		=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array() ),
					 
					 'Meta title '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'meta_title', 		'params'=>array() ),
					 'Meta keywords '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'meta_keys', 		'params'=>array() ),
					 'Meta description '.$lpx	=>	array( 'type'=>'text', 		'field'=>$pref.'meta_desc', 		'params'=>array() ),
					 'Индексация'				=>	array( 'type'=>'text', 		'field'=>'index', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Дата создания'				=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'		=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр категории каталога</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>