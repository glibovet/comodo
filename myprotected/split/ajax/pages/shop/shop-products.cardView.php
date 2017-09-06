<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProductsItemDetails($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(					 
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Название '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'Категория'				=>	array( 'type'=>'arr_mono',	'field'=>'category', 		'params'=>array( 'fields' => array('brand_name','name') ) ),
					 'Производитель'			=>	array( 'type'=>'text',		'field'=>'mf_name', 		'params'=>array(  ) ),
					 'Коллекция'				=>	array( 'type'=>'text',		'field'=>'collection_name', 'params'=>array(  ) ),
					 'Предмет'				=>	array( 'type'=>'text',		'field'=>'obj_name', 		'params'=>array(  ) ),
					 'Артикул'				=>	array( 'type'=>'text', 		'field'=>'sku', 			'params'=>array() ),
					 //'Штрих-код'			=>	array( 'type'=>'text', 		'field'=>'code', 			'params'=>array() ),
					 'Алиас'				=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Цена (грн)'			=>	array( 'type'=>'text', 		'field'=>'price', 			'params'=>array() ),
		  			 //'Поставщик'			=>	array( 'type'=>'text',		'field'=>'deliver_name', 	'params'=>array(  ) ),
					 //'На складе (шт)'		=>	array( 'type'=>'text', 		'field'=>'quant', 			'params'=>array() ),
					 //'В продаже (шт)'		=>	array( 'type'=>'text', 		'field'=>'in_stock', 		'params'=>array() ),
					 
					 'Длина (см)'			=>	array( 'type'=>'text', 		'field'=>'width', 			'params'=>array() ),
					 'Глубина (см)'			=>	array( 'type'=>'text', 		'field'=>'depth', 			'params'=>array() ),
					 'Высота (см)'			=>	array( 'type'=>'text', 		'field'=>'height', 			'params'=>array() ),
					 'Диаметр (см)'			=>	array( 'type'=>'text', 		'field'=>'diameter', 		'params'=>array() ),
					 
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Группы товаров'		=>	array( 'type'=>'arr_mult',	'field'=>'productGroups', 	'params'=>array( 'field'=>'name' ) ),
					 'Группа свойств'		=>	array( 'type'=>'arr_mono',	'field'=>'charsGroup', 		'params'=>array( 'field'=>'name' ) ),
					 'Свойства'				=>	array( 'type'=>'arr_mult',	'field'=>'chars', 			'params'=>array( 'type'=>'chars', 'fields'=>array('header'=>'name','val'=>'value','m'=>'measure') ) ),
					 
					 'Описание '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'details', 		'params'=>array() ),
					 
					 'Изображения'			=>	array( 'type'=>'images',	'field'=>'images',			'params'=>array( 'path'=>'/webroot/img/split/files/shop/products/', 'field'=>'file' ) ),

					 //'Начало публикации'	=>	array( 'type'=>'date', 		'field'=>'date_start',		'params'=>array() ),
					 //'Конец публикации'		=>	array( 'type'=>'date', 		'field'=>'date_finish', 	'params'=>array() ),
					 'Meta title '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'title', 			'params'=>array() ),
					 'Meta keywords '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'keys', 			'params'=>array() ),
					 'Meta description '.$lpx	=>	array( 'type'=>'text', 		'field'=>$pref.'desc', 			'params'=>array() ),
					 'Индексация'			=>	array( 'type'=>'text', 		'field'=>'index', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),

					 'Дата создания'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array() ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array() )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
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