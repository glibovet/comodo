<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProductsItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Название'				=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'Категория'			=>	array( 'type'=>'arr_mono',	'field'=>'category', 		'params'=>array( 'fields' => array('brand_name','name') ) ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Артикул'				=>	array( 'type'=>'text', 		'field'=>'sku', 			'params'=>array() ),
					 'Штрих-код'			=>	array( 'type'=>'text', 		'field'=>'code', 			'params'=>array() ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Цена (грн)'			=>	array( 'type'=>'text', 		'field'=>'price', 			'params'=>array() ),
					 'Доступно (шт)'		=>	array( 'type'=>'text', 		'field'=>'quant', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Группы товаров'		=>	array( 'type'=>'arr_mult',	'field'=>'productGroups', 	'params'=>array( 'field'=>'name' ) ),
					 'Группа свойств'		=>	array( 'type'=>'arr_mono',	'field'=>'charsGroup', 		'params'=>array( 'field'=>'name' ) ),
					 'Свойства'				=>	array( 'type'=>'arr_mult',	'field'=>'chars', 			'params'=>array( 'type'=>'chars', 'fields'=>array('header'=>'name','val'=>'value','m'=>'measure') ) ),
					 
					 'Описание'				=>	array( 'type'=>'text', 		'field'=>'details', 		'params'=>array() ),
					 
					 'Изображения'			=>	array( 'type'=>'images',	'field'=>'images',			'params'=>array( 'path'=>'/split/files/shop/products/', 'field'=>'file' ) ),

					 'Начало публикации'	=>	array( 'type'=>'date', 		'field'=>'date_start',		'params'=>array() ),
					 'Конец публикации'		=>	array( 'type'=>'date', 		'field'=>'date_finish', 	'params'=>array() ),
					 'Meta title'			=>	array( 'type'=>'text', 		'field'=>'title', 			'params'=>array() ),
					 'Meta keywords'		=>	array( 'type'=>'text', 		'field'=>'keys', 			'params'=>array() ),
					 'Meta description'		=>	array( 'type'=>'text', 		'field'=>'desc', 			'params'=>array() ),
					 'Индексация'			=>	array( 'type'=>'text', 		'field'=>'index', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),

					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр карточки товара</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>