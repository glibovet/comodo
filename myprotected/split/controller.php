<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Controller file
	
class Controller extends Library
{
	function __contruct(){}
	
	// Метод вызывает работу приложения по номеру ID
	public function callApp($app_id, DB_Mysql $dbh)
	{
		try
		{
			if(file_exists(WP_FOLDER.APPS_DIR."app-".$app_id."/module.php"))
			{
				$smarty = new Smarty();
			
				// указываем, где находятся Smarty-директории
			
				$smarty->template_dir = WP_FOLDER.APPS_DIR."app-".$app_id."/smarty/templates/";
				$smarty->compile_dir = WP_FOLDER.APPS_DIR."app-".$app_id."/smarty/templates_c/";
				$smarty->config_dir = WP_FOLDER.APPS_DIR."app-".$app_id."/smarty/configs/";
				$smarty->cache_dir = WP_FOLDER.APPS_DIR."app-".$app_id."/smarty/cache/";
			
				require_once(APPS_DIR."app-".$app_id."/module.php");
			}else
			{
				return false;
			}
		}catch(Exception $e){
			$ext_value = EXT_SEM ? "LIB Error^ (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage() : "";
			echo $ext_value;
			}
	}
	
	// Метод вызывает подключения шапки приложения по номеру ID
	public function callAppHead($app_id,$rules)
	{
		try
		{
			if(file_exists(WP_FOLDER.APPS_DIR."app-".$app_id."/module.php"))
			{
				$head_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/head.load.php";
				
				$rules = $rules;
				
				require_once($head_path);
			}else
			{
				return false;
			}
		}catch(Exception $e){
			$ext_value = EXT_SEM ? "Head Error^ (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage() : "";
			echo $ext_value;
			}
	}
	
	// Метод рекурсивно выводит Applications Group
	public function callAppsGroup($apps_group_id,$apps_group)
	{
		try
		{
			if(true)
			{
				foreach($apps_group as $cur_step)
				{
					if($cur_step['type'] == 'tag')
					{
						$tag_val = '
						<'.$cur_step['data']['name'];
						foreach($cur_step['data']['attr'] as $attr_name => $attr_value)
						{
							$tag_val .= ' '.$attr_name.'="'.$attr_value.'"';
						}
						$tag_val .= '>';
						
						echo $tag_val;
						
						$this->callAppsGroup(1,$cur_step['data']['inside']);
						
						echo '</'.$cur_step['data']['name'].'>
						';
					}
					elseif($cur_step['type'] == 'app')
					{
						$this->callApp($cur_step['data']);
					}
				}
			}else
			{
				return false;
			}
		}catch(Exception $e){
			$ext_value = EXT_SEM ? "LIB Error^ (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage() : "";
			echo $ext_value;
			}
	}
	
	function __destruct(){}
}