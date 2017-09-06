<?php 
	$empty = true;
	if(isset($_GET['control']) && isset($_GET['item']))
	{
		$empty = false;
		$item_id = $_GET['item'];
		switch($item_id)
		{
			///////////////////    Пользователь
			case 28:	$controller->callApp('6',$dbh);	 break; // Задания
			case 29:	$controller->callApp('7',$dbh);	 break;	// Сообщения
			case 7:		$controller->callApp('8',$dbh);	 break; // Профиль
			
			///////////////////    Пользователи
			case 8:		$controller->callApp('9',$dbh);	 break; // Все пользователи
			case 10:	$controller->callApp('10',$dbh); break;	// Группы пользователй
			case 11:	$controller->callApp('11',$dbh); break; // Добавить новую группу
			case 31:	$controller->callApp('12',$dbh); break; // Рассылка пользователям
			
			///////////////////    Материалы
			case 12:	$controller->callApp('13',$dbh); break; // Менеджер материалов
			case 13:	$controller->callApp('14',$dbh); break;	// Категории материалов
			case 14:	$controller->callApp('15',$dbh); break; // Баннерная система
			case 15:	$controller->callApp('16',$dbh); break; // Контент блоки
			case 16:	$controller->callApp('17',$dbh); break; // Вопрос-ответ
			case 30:	$controller->callApp('18',$dbh); break; // Менеджер меню
			
			///////////////////    Магазин
			case 18:	$controller->callApp('20',$dbh); break;	// Управление товарами
			case 17:	$controller->callApp('19',$dbh); break; // Категории товаров
			case 19:	$controller->callApp('21',$dbh); break; // Характеристики товаров
			case 34:	$controller->callApp('30',$dbh); break; // Категории характеристик товаров
			case 32:	$controller->callApp('29',$dbh); break; // Группы товаров
			case 33:	$controller->callApp('31',$dbh); break; // Склады
			case 35:	$controller->callApp('32',$dbh); break; // Складские ячейки
			case 20:	$controller->callApp('22',$dbh); break; // Заказы
			case 36:	$controller->callApp('33',$dbh); break; // Прием товаров
			
			///////////////////    Настройки
			case 22:	$controller->callApp('23',$dbh); break; // Управление приложениями
			case 23:	$controller->callApp('24',$dbh); break;	// Группы приложений
			case 24:	$controller->callApp('25',$dbh); break; // Глобальные настройки
			case 25:	$controller->callApp('26',$dbh); break; // SEO Настройки
			
			///////////////////    Помощь
			case 26:	$controller->callApp('27',$dbh); break; // Звдать вопрос
			case 27:	$controller->callApp('28',$dbh); break;	// Частые вопросы
			
			default:	$empty = true;	break;
		}
	}
	
	if($empty)
	{
			// start app 
			?>
            
            <br>
            <center>Добро пожаловать в панель администратора WEB PLATFORM &laquo;ZEN&raquo;.</center>
            
            <?php // end app 
	}