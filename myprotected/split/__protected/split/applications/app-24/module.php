<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file
	
	$parents_query = "SELECT id FROM [pre]admin_menu WHERE `type`=1 AND `parent`=0";
			
			$parents_stmt = $dbh->prepare($parents_query);
			$parents_arr = $parents_stmt->execute();
		
			// VARIANT 1
			//$parents_result = new DB_Result($parents_stmt);
			// while($parents_result->Next()){ echo $parents_result->id; }
		
			// VARIANT 2
			//$parents = $parents_arr->fetchallAssoc();
			//echo '<pre>'; print_r($parents); echo '</pre>';
	
	echo "Группы приложений<hr>";
	
	$smarty->assign("Name","ZEN"); // присваиваем переменной
	$smarty->display("view.tpl"); // выводим обработанный