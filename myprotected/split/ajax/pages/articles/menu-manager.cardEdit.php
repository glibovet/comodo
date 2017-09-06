<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getMenuItem($item_id, $pref);
	
	$itemsList = $zh->getMenu();
	
	// Get positions List
	
	$sitePositions = $zh->getPositions();
	
	// Get formats List
	
	$menuFormats = $zh->getMenuFormats();
	
	// Get Menu Categories
	
	$menuCategories = $zh->getCatsList();

	// Get Galleries List
	
	$galleriesList = $zh->getGalleriesList();
	
	$currRelations = (strlen($cardItem['relation']) > 3 ? unserialize($cardItem['relation']) : array());
	
	$hiddenRel_2 = true;
	$hiddenRel_3 = true;
	
	if($cardItem['type']==2) $hiddenRel_2 = false;
	if($cardItem['type']==3) $hiddenRel_3 = false;
	

	$rootPath = "../../../../..";
	
	$aliasType = ($lpx ? "hidden" : "input");
	$nameChange = ($lpx ? "" : "change_alias();");
	
	$cardTmp = array(
					 'LPX'		=>	array( 'type'=>'hidden',	'field'=>'lpx', 'value'=>$lpx ),
					 
					 'Заголовок '.$lpx		=>	array( 'type'=>'input', 	'field'=>$pref.'name', 		'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"$nameChange" ) ),
					 
					 'Алиас'				=>	array( 'type'=>"$aliasType", 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					 //'Подпись'				=>	array( 'type'=>'input', 	'field'=>'link', 			'params'=>array( 'size'=>75, 'hold'=>'Link' ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'Родитель'				=>	array( 'type'=>'select',  	'field'=>'parent', 			'params'=>array( 'list'=>$itemsList, 
																														 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['parent'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Не выбрана', 'id'=>0 ) 
																														 ) ),
																														 
					 'Формат'				=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$menuFormats, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Не выбран', 'id'=>0 ),
																														 'onChange'=>"make_visible_relation($(this).val());" 
																														 ) ),
																														 
																													 
																														 
					 'Категория материалов'	=>	array( 'type'=>'select', 'hidden'=>$hiddenRel_2 , 'field'=>'relation-2', 'params'=>array( 'list'=>$menuCategories, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['relation'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Не выбрана', 'id'=>0 ) 
																														 ) ),
					 
					 'Список категорий материалов'	=>	array( 'type'=>'multiselect', 'hidden'=>$hiddenRel_3, 'field'=>'relation-3', 'params'=>array( 
																														 'list'=>$menuCategories, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$currRelations, 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Позиция'				=>	array( 'type'=>'input', 	'field'=>'pos_id', 			'params'=>array( 'size'=>25, 'hold'=>'#Position' ) ),
					 
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 
					 //'Отображать в шапке?'	=>	array( 'type'=>'block', 	'field'=>'top_view', 		'params'=>array( 'reverse'=>false ) ),
					 
					 //'В новом окне?'		=>	array( 'type'=>'block', 	'field'=>'target', 			'params'=>array( 'reverse'=>false ) ),
					 
					 'Содержание '.$lpx		=>	array( 'type'=>'redactor', 	'field'=>$pref.'details', 		'params'=>array(  ) ),
					 
					'clear-3'				=>	array( 'type'=>'clear' ),
					 
					'Галлерея'				=>	array( 'type'=>'select', 'field'=>'gallery_id', 'params'=>array( 'list'=>$galleriesList, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['gallery_id'], 
																														 'onChange'=>"", 
																														 'first'=>array( 'name'=>'Без галлереи', 'id'=>0 ) 
																														 ) ),
					 
					 
					 'Мета теги'			=>	array( 'type'=>'header'),
					 
					 'Title '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'meta_title', 			'params'=>array( 'size'=>50, 'hold'=>'Title', 'onchange'=>"" ) ),
					 
					 'Keywords '.$lpx				=>	array( 'type'=>'input', 	'field'=>$pref.'meta_keys', 			'params'=>array( 'size'=>50, 'hold'=>'Keywords', 'onchange'=>"" ) ),
					 
					 'Description '.$lpx			=>	array( 'type'=>'area', 		'field'=>$pref.'meta_desc', 			'params'=>array( 'size'=>100, 'hold'=>'Description' ) )
					 
					// 'Дополнительный модуль из (/split/view_parts/pages/modules/)'	=>	array( 'type'=>'input', 	'field'=>'script_name', 'params'=>array( 'size'=>50, 'hold'=>'Script name [.php]' ) ),
					 
					// 'clear-4'				=>	array( 'type'=>'clear' ),
					 
					 //'Позиция текста из Редактора'		=>	array( 'type'=>'input', 	'field'=>'text_pos', 			'params'=>array( 'size'=>25, 'hold'=>'#Text' ) ),
					 
					 //'Позиция Галлереи'					=>	array( 'type'=>'input', 	'field'=>'gallery_pos', 		'params'=>array( 'size'=>25, 'hold'=>'#Gallery' ) ),
					 
					// 'Позиция доп. Модуля'	=>	array( 'type'=>'input', 	'field'=>'script_pos', 						'params'=>array( 'size'=>25, 'hold'=>'#Script' ) ),
					 
					 //'Изображения'			=>	array( 'type'=>'header'),
					 
					 //'Изображение пункта меню' =>	array( 'type'=>'image_mono','field'=>'filename', 	'params'=>array( 'path'=>"/split/files/content/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 //'Имя изображения'		=>	array( 'type'=>'hidden',	'field'=>'curr_filename', 	'params'=>array( 'field'=>"filename" ) ),
					 
					 //'Документы'			=>	array( 'type'=>'header'),
					 
					 //'Выбор файлов'			=>	array( 'type'=>'image_mult', 'field'=>'docs', 			'params'=>array( 'path'=>"/split/files/documents/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'file' ) )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editMenuItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs  );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования пункта меню #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>