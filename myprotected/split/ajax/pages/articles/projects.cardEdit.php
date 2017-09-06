<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams, $lpx);
	
	// Start body content
	
	$cardItem = $zh->getProjectItem($item_id);
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get formats List
	
	$menuFormats = $zh->getMenuFormats();
	
	// Get USERS
	
	$usersList = $zh->getUserList();


	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'					=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Название '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"$nameChange" ) ),
					 
					 'Алиас'				=>	array( 'type'=>"$aliasType", 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Дата публикации'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array(  ) ),
					 
					 'Позиция'				=>	array( 'type'=>'input', 	'field'=>'pos_id', 			'params'=>array( 'size'=>25, 'hold'=>'#Position' ) ),					  
					  
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					
					 'Архитектор'	=>	array( 'type'=>'select', 	'field'=>'user_id', 		'params'=>array( 'list'=>$usersList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'fname', 
																														 'currValue'=>$cardItem['user_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'fname'=>'No select', 'id'=>0 ) 
																														 ) ),
					
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Содержание '.$lpx		=>	array( 'type'=>'redactor', 	'field'=>$pref.'content', 	'params'=>array(  ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),
					 
					 
					'Изображения Проекта'			=>	array( 'type'=>'header'),
					 
					'Выбор изображений (min: 1200x900px)'		=>	array( 'type'=>'image_mult',  'field'=>'images', 		'params'=>array( 'path'=>"/webroot/img/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) ),
					
					 
					 'Мета теги'					=>	array( 'type'=>'header'),
					 
					'Title '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Keywords '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					 'Description '.$lpx		=>	array( 'type'=>'area', 		'field'=>$pref.'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					 'clear-4'					=>	array( 'type'=>'clear' ),					 
					 
					 'Динамичные фильтры'			=>	array( 'type'=>'header'),
					
					 'ID динамичного свойства'		=>	array( 'type'=>'hidden', 	'field'=>'charsD_ID', 		'params'=>array( 'size'=>25, 'hold'=>'Dinamical char ID' ) ),
			
					 'Свойства проекта (dinamic)' 	=> array( 'type'=>'projectDinamicChars', 'field'=>'charD', 'params'=>array('chars'=>$cardItem['charsD']) ),

					 'Фильтры'				=>	array( 'type'=>'header'),
					
					 'Свойства проекта'		=> array( 'type'=>'projectChars', 'field'=>'char', 'params'=>array('chars'=>$cardItem['chars']) ),
					 
					 'clear-5'				=>	array( 'type'=>'clear' ),
					 
					 'clear-6'				=>	array( 'type'=>'clear' ),
					 
					 'clear-7'				=>	array( 'type'=>'clear' )		
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editProject", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования материала #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>