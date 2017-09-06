<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file of Application << 7 >>
	
	$app_id = 0; // TEMPLATE APPLICATION
	
	$data = array();
	
	$data['loadsrc'] = "/".ADMIN_PATH.WP_FOLDER."/img/pulse.gif";
	$data['ajaxpath'] = "/".ADMIN_PATH.WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/content.load.php";
	
	$data['start_page'] = 1;
	$data['on_page'] = 10;
	
	if(isset($_COOKIE['on_page_'.$app_id]) && $_COOKIE['on_page_'.$app_id] != null && $_COOKIE['on_page_'.$app_id] > 5)
	{
		$data['on_page'] = $_COOKIE['on_page_'.$app_id];
	}
	
	$filtr_table = "users_dialogs";
	
	$filtr_1 = array(
					'search'	=> 'Поиск сообщениям',
					'options'	=> array(
										 array(
										 	  'title'=>'Содержанию',
											  'value'=>'name'
											  ),
										 array(
											  'title'=>'ID',
											  'value'=>'id'
											  )
										 )
					);
	$filtr_2 = array(
					array(
						'select_title'	=> 'Прочитано',
						'select_name'	=> 'filtr[status]',
						'options'	=> array(
											array(
												'title'=>'Нет',
												'value'=>'0'
												),
											array(
												'title'=>'Да',
												'value'=>'1'
												)
											)
						)
					);
	$filtr_3 = array(
					array(
						 'title'	=>	'Содержание',
						 'value'	=>	'message',
						 ),
					array(
						 'title'	=>	'Статус',
						 'value'	=>	'status',
						 ),
					array(
						 'title'	=>	'Дата создания',
						 'value'	=>	'dateCreate',
						 ),
					array(
						 'title'	=>	'ID',
						 'value'	=>	'id',
						 ),
					
					);
	
	$tables = array(
					array(
						  'name'		=> 'users_dialogs',
						  'or_name'		=> 'UD',
						  'ref_table'	=> '',
						  'ref_field'	=> '',
						  'ref_on'		=> '',
						  'where'		=> ' (UD.from_id='.ADMIN_ID.' OR UD.to_id='.ADMIN_ID.') AND UD.last=1 ',
						  'fields'		=> array(
						  						array(
													 'field'=>'id',
													 'alias'=>'id'
													 ),
												array(
													 'field'=>'message',
													 'alias'=>'message'
													 ),
												array(
													 'field'=>'status',
													 'alias'=>'status'
													 ),
												array(
													 'field'=>'from_id',
													 'alias'=>'from_id'
													 ),
												array(
													 'field'=>'to_id',
													 'alias'=>'to_id'
													 )
												,
												array(
													 'field'=>'dateCreate',
													 'alias'=>'dateCreate'
													 )
												)
						 ),
					array(
						  'name'		=> 'users',
						  'or_name'		=> 'US',
						  'ref_table'	=> 'UD',
						  'ref_field'	=> 'id',
						  'ref_on'		=> 'from_id',
						  'fields'		=> array(
						  						array(
													 'field'=>'name',
													 'alias'=>'name'
													 ),
												array(
													 'field'=>'fname',
													 'alias'=>'fname'
													 )
												)
						 )
					);
	$fields = array(
					array(
						 'title'	=> 'Диалог',
						 'type'		=> 'conc_link',
						 'value'	=> array('name','fname'),
						 'actions'	=> array(
						 					array(
						 						'func'		=>	'change_head',
												'params'	=>	array(
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 3
												 					 		)
																	  )
												 ),
											array(
						 						'func'		=>	'load_app_card',
												'params'	=>	array(
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 'card_path'
												 					 		),
																	  array(
																	 		'type' 	=> 2,
																	 		'value'	=> 'id'
												 					 		),
																	  array(
																	 		'type' 	=> 1,
																	 		'value'	=> 'card_data'
												 					 		)
																	  )
												 )
											)
						 ),
					array(
						 'title'	=> 'Сообщение',
						 'type'		=> 'sub_text',
						 'value'	=> 'message',
						 'size'		=>	50
						 ),
					array(
						 'title'	=> 'Время',
						 'type'		=> 'date',
						 'value'	=> 'dateCreate'
						 )
					);
					
	
	$card_data = array(
					  'table'	=> 'users_dialogs',
					  'type'	=> 'dialog'			
					  );
	
	$smarty->assign("filtr_table",$filtr_table);
	$smarty->assign("filtr_1",$filtr_1);
	$smarty->assign("filtr_2",$filtr_2);
	$smarty->assign("filtr_3",$filtr_3);
	
	$smarty->assign("tables",$filtr_3);
	$smarty->assign("fields",$filtr_3);
	
	$smarty->assign("data",$data); // присваиваем переменной
	$smarty->display("view.tpl"); // выводим обработанный
	
?>

	<script type="text/javascript" language="javascript">
		$(function(){
			$('form[name=wp-filtr-form]').ajaxForm();
			var data = {
						filtr_table:'<?php echo $filtr_table ?>',
						tables:'<?php echo serialize($tables) ?>',
						fields:'<?php echo serialize($fields) ?>',
						card_data:'<?php echo serialize($card_data) ?>',
						
						app_id	:<?php echo $app_id ?>,
						ajaxpath:'<?php echo $data['ajaxpath'] ?>',
						start_page:<?php echo $data['start_page'] ?>,
						on_page:<?php echo $data['on_page'] ?>,
						first_load:1,
						}
			
				$('#inajax-1').load(data.ajaxpath,data,function(){
					<?php
						if(isset($_GET['id']) && $_GET['id'] > 0)
						{
							?>
							change_head(3); 
							load_app_card(card_path, <?php echo (int)$_GET['id'] ?>, card_data);
							$('#mess_loop_<?php echo (int)$_GET['id'] ?>').hide(400);
						<?php
						}
					?>
					});
			
			global_table_filtr = data.filtr_table;
			global_tables = data.tables;
			global_fields = data.fields;
		});
	</script>
    