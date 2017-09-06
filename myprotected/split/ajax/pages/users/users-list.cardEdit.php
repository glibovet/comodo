<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);
	
	$usersTypes = $zh->getUsersTypes();
	
	$efGroups = $zh->getExtraFieldsGroups();

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'					=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Имя '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"$nameChange" ) ),
					 
					 'Фамилия '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'fname', 		'params'=>array( 'size'=>25, 'hold'=>'Фамилия' ) ),
					
					 'Алиас'				=>	array( 'type'=>$aliasType, 	'field'=>'alias', 				'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'E-mail'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'E-mail' ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'Телефон' ) ),
					 
					 'День Рождения'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Ггрупа пользователей'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type'], 
																														 'onChange'=>"reload_users_extra_fields($(this).val(),$item_id);" 
																														 ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Сотрудник компании'	=>	array( 'type'=>'block', 	'field'=>'worker', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Активность'			=>	array( 'type'=>'block', 	'field'=>'active', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Пол'					=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"М", 'no'=>"Ж", 'replace'=>array('0'=>'М', '1'=>'Ж') ) ),
					 
					 
					 
					 /*'Дисконтная карта'		=>	array( 'type'=>'header'),
					 
					 'Номер карты'			=>	array( 'type'=>'input', 	'field'=>'sale_card_id', 	'params'=>array( 'size'=>25, 'hold'=>'Discount card number', 'disabled'=>true ) ),
					 
					 'Штрихкод'				=>	array( 'type'=>'input', 	'field'=>'sale_barcode', 	'params'=>array( 'size'=>25, 'hold'=>'Barcode', 'disabled'=>true ) ),
					 
					 'Размер скидки (%)'	=>	array( 'type'=>'input', 	'field'=>'sale_percent', 	'params'=>array( 'size'=>25, 'hold'=>'Sale', 'disabled'=>true ) ),
					 
					 
					 
					 'Экстра поля'			=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),*/
					 
					 'Адрес'		=>	array( 'type'=>'header'),
					 
					 'Адрес доставки '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'delivery_address', 	'params'=>array( 'size'=>75, 'hold'=>'Киев, ул...') ),			
					 
					 
					 'Изображения'				=>	array( 'type'=>'header'),
					 
					 'Аватар пользователя'		=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/webroot/img/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Смена пароля'				=>	array( 'type'=>'header'),
					 
					 'Старый пароль'			=>	array( 'type'=>'input', 	'field'=>'old-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Старый пароль', 'type'=>'password' ) ),
					 
					 'Новый пароль'				=>	array( 'type'=>'input', 	'field'=>'new-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Новый пароль', 'type'=>'password' ) ),
					 
					 'Повторить новый пароль'	=>	array( 'type'=>'input', 	'field'=>'new-pass-r', 			'params'=>array( 'size'=>25, 'hold'=>'Повторить новый пароль', 'type'=>'password' ) ),
					 					 
					 
					 'Доп инфо о сотруднике'		=>	array( 'type'=>'header'),						 
					 
					 'Должность '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'position', 		'params'=>array( 'size'=>25, 'hold'=>'Должность' ) ),	
					 
					 'Позиция в списке'			=>	array( 'type'=>'input', 	'field'=>'order_id', 			'params'=>array( 'size'=>20, 'hold'=>'№' ) ),				 
					 
					 'clear-4'					=>	array( 'type'=>'clear' ),
					 
					 'Навыки (через",") '.$lpx	=>	array( 'type'=>'input', 	'field'=>$pref.'skills', 		'params'=>array( 'size'=>100, 'hold'=>'Навыки' ) ),
					 
					 'clear-5'					=>	array( 'type'=>'clear' ),
					 
					 'Кредо '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'credo', 		'params'=>array( 'size'=>100, 'hold'=>'Кредо' ) ),
					 
					 'clear-6'					=>	array( 'type'=>'clear' ),
					 
					 'О сотруднике '.$lpx		=>	array( 'type'=>'redactor', 	'field'=>$pref.'details', 		'params'=>array(  ) ),
					 
					 'clear-7'					=>	array( 'type'=>'clear' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editUserCard", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования карточки пользователя #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>