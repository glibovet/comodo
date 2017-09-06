<?php
	include_once("../../system/config.php");
	$Config_obj = new Config();
	include_once("../../system/db.php");
	$Db_obj = new Db($Config_obj->configs['db']['host'],
					 $Config_obj->configs['db']['name'],
					 $Config_obj->configs['db']['user'],
					 $Config_obj->configs['db']['pass'],
					 $Config_obj->configs['db']['encode']);
	$Db_obj->db_access();
	include_once("../../system/mtvc_lib.php");
	$mtvc_obj = new MTVC_Lib();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Выгрузка в эксель историю активности пользователей</title>
</head>

<body>
<?php
	$data_arr = array();
	$load_folder = "all";
	
	//$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	//$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
	//$nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);
	
	$yesterday		= date("Y-m-d H:i:s" , time()-86400*1);
	$last_week		= date("Y-m-d H:i:s" , time()-86400*7);
	$last_month 	= date("Y-m-d H:i:s" , time()-86400*30);
	$last_quartal	= date("Y-m-d H:i:s" , time()-86400*120);
	$last_year		= date("Y-m-d H:i:s" , time()-86400*365);
	
	switch($_GET['id'])
	{
		case 1: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","`date_register` > '".$yesterday."'","id DESC","no");	$load_folder = "day"; break;
		case 2: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","`date_register` > '".$last_week."'","id DESC","no");	$load_folder = "week"; break;
		case 3: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","`date_register` > '".$last_month."'","id DESC","no");	$load_folder = "month"; break;
		case 4: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","`date_register` > '".$last_quartal."'","id DESC","no");	$load_folder = "quartal"; break;
		case 5: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","`date_register` > '".$last_year."'","id DESC","no");	$load_folder = "year"; break;
		case 6: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","no","id DESC","no");	$load_folder = "all"; break;
		
		default: $data_arr = $mtvc_obj->mtvc_get_table_data("*","users","no","id DESC","no");	$load_folder = "all"; break;
	}
	
	include("excelwriter.inc.php");
	$cur_date = date("Y-m-d H-i");
	$fileName = "users-history/".$load_folder."/users-".$cur_date.".xls";
	$excel = new ExcelWriter($fileName);
	
	if( $excel == false )
	{
		echo $excel->error;
		die;
	}
	
	$myArr = array(
					"<strong> ID </strong>",
					"<strong> VIP </strong>",
					"<strong> Имя </strong>",
					"<strong> Фамилия </strong>",
					"<strong> WebSite </strong>",
					"<strong> Email </strong>",
					"<strong> Город </strong>",
					"<strong> Facebook </strong>",
					"<strong> Vkontakte </strong>",
					"<strong> Баланс </strong>",
					"<strong> Бонус </strong>",
					"<strong> Дата регистрации </strong>",
					"<strong> Дата последней активности </strong>");
	$excel->writeLine($myArr, array('text-align'=>'center', 'color'=> 'blue', 'border-bottom' => '1px solid black'));

	foreach($data_arr as $data)
	{
		$excel->writeRow(); //создаем пустую строку
		
		foreach($data as $data_header => $data_value)
		{
			if(	$data_header == 'id'			||
				$data_header == 'vip'			||
				$data_header == 'name'			||
				$data_header == 'last_name' 	||
				$data_header == 'email'			||
				$data_header == 'website'		||
				$data_header == 'adress'		||
				$data_header == 'fb'			||
				$data_header == 'vk'			||
				$data_header == 'balans'		||
				$data_header == 'bonus'			||
				$data_header == 'date_register' ||
				$data_header == 'last_activity' 
				)
			{
				
			$vallue = $data_value;
			if($data_header == "website")
			{
				if(trim($vallue) != "") $vallue = "<a href='".$vallue."'>".$vallue."</a>";
			}
			if($data_header == "email")
			{
				if(trim($vallue) != "") $vallue = "<a href='mailto:".$vallue."'>".$vallue."</a>";
			}
				
			// Записываем столбци
			$excel->writeCol($vallue, array(
			'text-align' => 'left',
			'color' => 'black',
			'font-size' => '14px',
			'line-height'	=> '25px',
			'border-right' => '1px solid black')
			);
			}
		}
	}

	$excel->close();

?>
<a href="excel/users-history/<?php echo $load_folder ?>/users-<?php echo $cur_date ?>.xls">Открыть сформированный Excel файл</a>
</body>
</html>