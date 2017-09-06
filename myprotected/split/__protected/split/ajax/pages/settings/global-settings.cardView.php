<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCatalogItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Изображение'			=>	array( 'type'=>'image',		'field'=>'filename',		'params'=>array( 'path'=>'/split/files/shop/categories/' ) ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Родитель'				=>	array( 'type'=>'arr_mono',	'field'=>'parent', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Дочерние элементы'	=>	array( 'type'=>'arr_mult',	'field'=>'childs', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Группа характеристик'	=>	array( 'type'=>'arr_mono', 	'field'=>'charsGroup', 		'params'=>array( 'field'=>'name','link'=>array('parent'=>'shop',
					 																																   'alias'=>'category-svoistv-tovarov',
																																					   'id'=>34,
																																					   'item_id'=>1,
																																					   'params'=>'{}') ) ),
					 'Описание'				=>	array( 'type'=>'text', 		'field'=>'details', 		'params'=>array() ),
					 'Начало публикации'	=>	array( 'type'=>'date', 		'field'=>'startPublish',	'params'=>array() ),
					 'Конец публикации'		=>	array( 'type'=>'date', 		'field'=>'finishPublish', 	'params'=>array() ),
					 'Meta title'			=>	array( 'type'=>'text', 		'field'=>'meta_title', 		'params'=>array() ),
					 'Meta keywords'		=>	array( 'type'=>'text', 		'field'=>'meta_keys', 		'params'=>array() ),
					 'Meta description'		=>	array( 'type'=>'text', 		'field'=>'meta_desc', 		'params'=>array() ),
					 'Индексация'			=>	array( 'type'=>'text', 		'field'=>'index', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>