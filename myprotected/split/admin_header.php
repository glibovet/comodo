<?php 
	$empty = true;
	if(isset($_GET['control']) && isset($_GET['item']))
	{
		$empty = false;
		$item_id = $_GET['item'];
		
		$rules = array(
					  'head-1'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 0,
										  
										  'filtr-1' => 1,
										  'filtr-2' => 1,
										  'filtr-3' => 1,
										  
										  'copy'		=> 1,
										  'activate'	=> 1,
										  'disactivate'	=> 1,
										  'delete'		=> 1,
										  
										  'create' => 1
										  ),
						'head-2'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 1,
										  
										  'back' => 1,
										  
										  'new'		=> 1,
										  'save'	=> 1,
										  'close'	=> 1,
										  
										  'create' => 1
										  ),
						'head-3'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 1,
										  
										  'back' => 1,
										  
										  'new'		=> 1,
										  'save'	=> 1,
										  'close'	=> 1,
										  
										  'create' => 1
										  ),
						'create'	=> 'Создать'
					  );
		
		switch($item_id)
		{
			///////////////////    Пользователь
			case 28:	$controller->callAppHead(6,$rules);	 break; // Задания
			case 29: {
						 $rules = array(
					  	'head-1'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 0,	'filtr-1'	=> 1,'filtr-2'		=> 1,'filtr-3'	=> 1,
										  'copy' => 0,		'activate'	=> 0,'disactivate'	=> 0,'delete'	=> 1,'create' => 1
										  ),
						'head-2'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 1,'back' => 1,
										  'new'		=> 0,'save'	=> 0,'close'	=> 0,'create' => 1,
										  ),
						'head-3'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 1,'back' => 1,
										  'new'		=> 0,'save'	=> 0,'close'	=> 0,'create' => 0
										  ),
						'create'	=> 'Отправить'
					  );
						$controller->callAppHead(0,$rules);	 break;	// Сообщения <7>
					 }
			case 7: {
					  $rules = array(
					  	'head-1'	=>	array(
					  					  'publish' => 0,
										  'hidden'	=> 1,	'filtr-1'	=> 1,'filtr-2'		=> 1,'filtr-3'	=> 1,
										  'copy' => 1,		'activate'	=> 1,'disactivate'	=> 1,'delete'	=> 1,'create' => 1
										  ),
						'head-2'	=>	array(
					  					  'publish' => 0,
										  'hidden'	=> 1,'back' => 1,
										  'new'		=> 1,'save'	=> 1,'close'	=> 1,'create' => 1
										  ),
						'head-3'	=>	array(
					  					  'publish' => 1,
										  'hidden'	=> 0,'back' => 0,
										  'new'		=> 0,'save'	=> 0,'close'	=> 0,'create' => 1
										  )
					  );
						$controller->callAppHead(0,$rules);	 break; // Профиль <8>
					}
			///////////////////    Пользователи
			case 8:		$controller->callAppHead(0,$rules);	 	 break; // Все пользователи <9>
			case 10:	$controller->callAppHead(0,$rules); 	 break;	// Группы пользователй <10>
			//case 11:	$controller->callApp('11',$dbh); break; // Добавить новую группу
			//case 31:	$controller->callApp('12',$dbh); break; // Рассылка пользователям
			
			///////////////////    Материалы
			case 12:	$controller->callAppHead(0,$rules);	 	 break; // Менеджер материалов <13>
			case 13:	$controller->callAppHead(0,$rules); 	 break; // Категории материалов <14>
			case 14:	$controller->callAppHead(0,$rules); 	 break; // Баннерная система <15>
			case 15:	$controller->callAppHead(0,$rules); 	 break; // Контент блоки <16>
			case 16:	$controller->callAppHead(0,$rules); 	 break; // Вопрос-ответ <17>
			case 30:	$controller->callAppHead(0,$rules); 	 break; // Менеджер меню <18>
			
			///////////////////    Магазин
			case 17:	$controller->callAppHead(0,$rules);	 	 break; // Категории товаров <19>
			case 18:	$controller->callAppHead(20,$rules);	 break;	// Управление товарами
			case 19:	$controller->callAppHead(0,$rules); 	 break; // Характеристики товаров <21>
			case 34:	$controller->callAppHead(0,$rules); 	 break; // Категории Характеристик товаров <30>
			//case 32:	$controller->callApp('29',$dbh); break; // Группы товаров
			case 33:	$controller->callAppHead(31,$rules);	 break; // Склады
			case 35:	$controller->callAppHead(32,$rules);	 break; // Складские ячейки
			case 20:	$controller->callAppHead(22,$rules);	 break; // Заказы
			case 36:	$controller->callAppHead(33,$rules); 	 break; // Прием товаров
			
			///////////////////    Настройки
			//case 22:	$controller->callApp('23',$dbh); break; // Управление приложениями
			//case 23:	$controller->callApp('24',$dbh); break;	// Группы приложений
			case 24:	$controller->callAppHead(25,$rules); 	 break; // Глобальные настройки
			//case 25:	$controller->callApp('26',$dbh); break; // SEO Настройки
			
			///////////////////    Помощь
			//case 26:	$controller->callApp('27',$dbh); break; // Звдать вопрос
			//case 27:	$controller->callApp('28',$dbh); break;	// Частые вопросы
			
			default:	$empty = true;	break;
		}
	}
	
	if($empty)
	{
			?>
            <br>
            <div style="color:#FFF;">
            <center>Меню событий на WEB PLATFORM &laquo;ZEN&raquo;.</center>
            </div>
			<?php
	}