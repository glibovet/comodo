<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Имя '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'name', 		'params'=>array() ),
					 'Фамилия '.$lpx		=>	array( 'type'=>'text', 		'field'=>$pref.'fname', 	'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Изображение'			=>	array( 'type'=>'image',		'field'=>'avatar',			'params'=>array( 'path'=>'/webroot/img/split/files/users/' ) ),
					 'Email'				=>	array( 'type'=>'text', 		'field'=>'login', 			'params'=>array() ),
					 'Телефон'				=>	array( 'type'=>'text', 		'field'=>'phone', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Состояние'			=>	array( 'type'=>'text', 		'field'=>'active', 			'params'=>array( 'replace'=>array('0'=>'Не активен', '1'=>'Активен') ) ),
					 'Сотрудник компании'	=>	array( 'type'=>'block', 	'field'=>'worker', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Пол'					=>	array( 'type'=>'text', 		'field'=>'male', 			'params'=>array( 'replace'=>array('М'=>'Мужской', 'Ж'=>'Женский') ) ),
					 //'Дочерние элементы'	=>	array( 'type'=>'arr_mult',	'field'=>'childs', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Группа пользователей'	=>	array( 'type'=>'arr_mono', 	'field'=>'typeInfo', 		'params'=>array( 'field'=>'name' ) ),
					 'Дата рождения'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'Номер дисконтной карты'	=>	array( 'type'=>'text', 		'field'=>'sale_card_id', 			'params'=>array() ),
					 'Штрихкод'					=>	array( 'type'=>'text', 		'field'=>'sale_barcode', 			'params'=>array() ),
					 'Размер скидки (%)'		=>	array( 'type'=>'text', 		'field'=>'sale_percent', 			'params'=>array() ),
					 
					 'Дополнительные данные'=>	array( 'type'=>'usersExtraFields', 'field'=>'ef_groups','params'=>array( 'data'=>$cardItem['ef_groups'] ) ),
					 
					 'Дата регистрации'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array( ) ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр карточки пользователя</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>