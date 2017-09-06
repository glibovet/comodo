<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getArticleItem($item_id, $pref);
	
	$cardItem['old_alias'] = $cardItem['alias']; // !!! OLD ALIAS HACK STEP 1
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get formats List
	
	$menuFormats = $zh->getMenuFormats();
	
	// Get Menu Categories
	
	$catsList = $zh->getCatsList();

	// Get Galleries List
	
	$galleriesList = $zh->getGalleriesList();

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Название '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'name', 			'params'=>array( 'size'=>125, 'hold'=>'Name', 'onchange'=>"$nameChange" ) ),
					 'Алиас'				=>	array( 'type'=>"$aliasType", 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 'OLD Алиас'			=>	array( 'type'=>"hidden", 	'field'=>'old_alias', 			'params'=>array() ), 
					 // !!! OLD ALIAS HACK STEP 2
					 
					 'Изображение материала'=>	array( 'type'=>'image_mono',	'field'=>'filename', 		'params'=>array( 'path'=>"/webroot/img/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) ),
					 
					 'clear-0'				=>	array( 'type'=>'clear' ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 'Дата публикации'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array(  ) ),
					 
					 'Позиция'				=>	array( 'type'=>'input', 	'field'=>'pos_id', 			'params'=>array( 'size'=>25, 'hold'=>'#Position' ) ),
					 
					  //'В новом окне?'		=>	array( 'type'=>'block', 	'field'=>'target', 			'params'=>array( 'reverse'=>false ) ),
					  
					  
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					
					 'Категория материалов'	=>	array( 'type'=>'select', 	'field'=>'cat_id', 		'params'=>array( 'list'=>$catsList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['cat_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'No select', 'id'=>0 ) 
																														 ) ),
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Содержание '.$lpx		=>	array( 'type'=>'redactor', 	'field'=>$pref.'content', 	'params'=>array(  ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),
					 
					 'Галлерея'				=>	array( 'type'=>'select', 'field'=>'gallery_id', 'params'=>array( 'list'=>$galleriesList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['gallery_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Без галлереи', 'id'=>0 ) 
																														 ) ),
																														 
					 
					 'Видеоматериал'			=>	array(  'type'=>'input', 	'field'=>'video', 			'params'=>array( 'size'=>125, 'hold'=>'YouTube src=...' ) ),
					 
					 'Мета теги'					=>	array( 'type'=>'header'),
					 
					 'Title '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Keywords '.$lpx			=>	array( 'type'=>'input', 	'field'=>$pref.'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					 'Description '.$lpx		=>	array( 'type'=>'area', 		'field'=>$pref.'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 //'Дополнительный модуль из (/split/view_parts/pages/modules/)'	=>	array( 'type'=>'input', 	'field'=>'script_name', 'params'=>array( 'size'=>50, 'hold'=>'Script name [.php]' ) ),
					 
					 //'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 //'Позиция текста из Редактора'		=>	array( 'type'=>'input', 	'field'=>'text_pos', 			'params'=>array( 'size'=>25, 'hold'=>'#Text' ) ),
					 
					 //'Позиция Галлереи'					=>	array( 'type'=>'input', 	'field'=>'gallery_pos', 		'params'=>array( 'size'=>25, 'hold'=>'#Gallery' ) ),
					 
					 //'Позиция доп. Модуля'	=>	array( 'type'=>'input', 	'field'=>'script_pos', 						'params'=>array( 'size'=>25, 'hold'=>'#Script' ) ),
					 
					 //'Изображения'			=>	array( 'type'=>'header'),
					 
					 
					 //'Документы'			=>	array( 'type'=>'header'),
					 
					 //'Выбор файлов'			=>	array( 'type'=>'image_mult', 'field'=>'docs', 			'params'=>array( 'path'=>"/webroot/img/split/files/documents/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editArticleItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
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