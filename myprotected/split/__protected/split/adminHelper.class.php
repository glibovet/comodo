<?php
	class adminHelper
	{
		function __construct()
		{
		}
		function deformat_date($val)
		{
			$result = "";
			$monthes = array('','янв.','фев.','мар.','апр.','мая','июня','июля','авг.','сен.','окт.','нбр.','дек.');
			
			if(strtotime($val) > strtotime(date("d.m.Y",time())." 00:00:00"))
								{
									$result = "Сегодня, ".date("H:i",strtotime($val));
		
								}elseif(strtotime($val) < strtotime(date("d.m.Y",time())." 00:00:00") &&
										strtotime($data[$item_num]['dateCreate']) > (strtotime(date("d.m.Y",time())." 00:00:00")-86400))
									{
										$result = "Вчера, ".date("H:i",strtotime($val));
									}
								else
									{
										$result = date("d",strtotime($val))." ".$monthes[(int)date("m",strtotime($val))]." ".
																	", ".
																	date("H:i",strtotime($val));
									}
			return $result;
		}
	
		function next_sub_str($str,$len)
		{
			return implode(array_slice(explode('<br>',wordwrap($str,$len,'<br>',false)),0,1));
		}
	}
	