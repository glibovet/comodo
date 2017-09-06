<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	--------------------------	*/
	
	if(WP_CHPU)
	{
	
		$alias = trim(strip_tags($_SERVER['REQUEST_URI'])); // Стягиваем адресную строку с GET параметрами

		$split_alias = mb_split("/",$alias);
			if(sizeof($split_alias) > 2)
			{
				$pre_global_path = "";
				for($i = 2; $i < (sizeof($split_alias)-1); $i++)
				{
					$pre_global_path .= "../";
				}
				define ("GLOBAL_PATH",$pre_global_path,TRUE);
			}else
			{
				define ("GLOBAL_PATH","",TRUE);
			} // Define GLOBAL_PATH

		if($alias == "" || $alias == "/")
		{
			$first_alias = "main";
		}else
		{
			$alias_quant = sizeof($split_alias);
			$first_alias = $split_alias[1];
		}
		$_GET['first_alias'] = $first_alias;
		$_GET['split_alias'] = $split_alias;
		$_GET['sizeof_split_alias'] = sizeof($split_alias)-1;
	
	} // end if WP_CHPU
	else
	{
		if(isset($_GET['data']) && $_GET['data'] != null)
		{
			$split_alias = unserialize(trim(strip_tags($_GET['data'])));
			
			if(sizeof($split_alias) > 2)
			{
				$pre_global_path = "";
				for($i = 1; $i < (sizeof($split_alias)-1); $i++)
				{
					$pre_global_path .= "../";
				}
				define ("GLOBAL_PATH",$pre_global_path,TRUE);
			}else
			{
				define ("GLOBAL_PATH","",TRUE);
			}
			
			$alias_quant = sizeof($split_alias);
			$first_alias = $split_alias[0];
			
			$_GET['first_alias'] = $first_alias;
			$_GET['split_alias'] = $split_alias;
			$_GET['sizeof_split_alias'] = sizeof($split_alias);
			
		}else
		{
			$first_alias = "main";
			//include_once("/404.html");
			//die("<p class='wp_chpu_error'>WP EXTENTION: CHPU ERROR.</p>");
		}		
	}