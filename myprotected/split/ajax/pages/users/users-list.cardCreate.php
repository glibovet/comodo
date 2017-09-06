<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$item_id = 0;
	
	$cardItem = $zh->getUserInfo($item_id);
	
	$usersTypes = $zh->getUsersTypes();
	
	$efGroups = $zh->getExtraFieldsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Имя'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Имя' , 'onchange'=>"change_alias();") ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 	'field'=>'fname', 			'params'=>array( 'size'=>25, 'hold'=>'Фамилия' ) ),
					 
					 'Должность'			=>	array( 'type'=>'input', 	'field'=>'position', 		'params'=>array( 'size'=>25, 'hold'=>'Должность' ) ),
					
					 'Алиас'				=>	array( 'type'=>'input', 	'field'=>'alias', 				'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'E-mail'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'E-mail' ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'Телефон' ) ),
					 
					 'День Рождения'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Пароль'				=>	array( 'type'=>'input', 	'field'=>'new-password', 		'params'=>array( 'size'=>25, 'hold'=>'Новый пароль', 'type'=>'password' ) ),
					 
					 'Группа пользователей'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>9, 
																														 'onChange'=>"reload_users_extra_fields($(this).val(),$item_id);" 
																														 ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Сотрудник компании'	=>	array( 'type'=>'block', 	'field'=>'worker', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Активность'			=>	array( 'type'=>'block', 	'field'=>'active', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Пол'					=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"М", 'no'=>"Ж", 'replace'=>array('0'=>'М', '1'=>'Ж') ) ),
					 
					 
					  //'Экстра поля'			=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),
					 
					 
					 'Адрес'		=>	array( 'type'=>'header'),
					 
					 'Адрес доставки'			=>	array( 'type'=>'input', 	'field'=>'delivery_address', 	'params'=>array( 'size'=>75, 'hold'=>'Киев, ул...') ),	
					 
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Аватар пользователя'	=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/webroot/img/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),
					 
					 
					 
					 'Доп инфо о сотруднике'			=>	array( 'type'=>'header'),					 
					 
					 'Должность (RU)'			=>	array( 'type'=>'input', 	'field'=>'position', 		'params'=>array( 'size'=>25, 'hold'=>'Должность' ) ),
					 
					 'Позиция в списке'			=>	array( 'type'=>'input', 	'field'=>'order_id', 			'params'=>array( 'size'=>20, 'hold'=>'№' ) ),
					 
					 'clear-4'					=>	array( 'type'=>'clear' ),
					 
					 'Навыки (через",") (RU)'			=>	array( 'type'=>'input', 	'field'=>'skills', 			'params'=>array( 'size'=>100, 'hold'=>'Навыки' ) ),
					 
					 'clear-5'					=>	array( 'type'=>'clear' ),
					 
					 'Кредо (RU)'					=>	array( 'type'=>'input', 	'field'=>'credo', 			'params'=>array( 'size'=>100, 'hold'=>'Кредо' ) ),
					 
					 'clear-6'					=>	array( 'type'=>'clear' ),
					 
					 'О сотруднике (RU)'				=>	array( 'type'=>'redactor', 	'field'=>'details', 		'params'=>array(  ) ),
					 
					 'clear-7'					=>	array( 'type'=>'clear' )
					 
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createUserCard", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания карточки пользователя ".((isset($params['copyItem']) && $params['copyItem'] > 0) ? "(Дубликат карточки #".$params['copyItem'].")" : "")."</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>