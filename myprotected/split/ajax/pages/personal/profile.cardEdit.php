<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'profile' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);
	
	$usersTypes = $zh->getUsersTypes();
	
	$efGroups = $zh->getExtraFieldsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Имя'					=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Фамилия'				=>	array( 'type'=>'input', 	'field'=>'fname', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Логин'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'Телефон'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'Alias' ) ),
					 
					 'День Рождения'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Група пользователей'	=>	array( 'type'=>'hidden', 	'field'=>'type' ),
					 
					 /*
					 'Група пользователей'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type'], 
																														 'onChange'=>"reload_users_extra_fields($(this).val(),$item_id);" 
																														 ) ),
					 */
					 'Публикация'			=>	array( 'type'=>'hidden', 	'field'=>'block' ), // 'params'=>array( 'reverse'=>true )
					 
					 'Активность'			=>	array( 'type'=>'hidden', 	'field'=>'active' ), // 'params'=>array( 'reverse'=>false )
					 
					 'Пол'					=>	array( 'type'=>'block', 	'field'=>'male', 			'params'=>array( 'reverse'=>true, 'yes'=>"М", 'no'=>"Ж", 'replace'=>array('0'=>'М', '1'=>'Ж') ) ),
					 
					 
					 'Экстра поля'			=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),
					 
					 
					 'Изображения'			=>	array( 'type'=>'header'),
					 
					 'Аватар пользователя'	=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Смена пароля'				=>	array( 'type'=>'header'),
					 
					 'Старый пароль'			=>	array( 'type'=>'input', 	'field'=>'old-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Старый пароль', 'type'=>'password' ) ),
					 
					 'Новый пароль'				=>	array( 'type'=>'input', 	'field'=>'new-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Новый пароль', 'type'=>'password' ) ),
					 
					 'Повторить новый пароль'	=>	array( 'type'=>'input', 	'field'=>'new-pass-r', 			'params'=>array( 'size'=>25, 'hold'=>'Повторить новый пароль', 'type'=>'password' ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editUserCard", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования профиля</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>