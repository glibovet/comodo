<?php
	require_once "../../require.base.php";
	
	require_once "../library/AjaxHelp.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Выгрузка в эксель Продукции по фильтру</title>
</head>

<body>
<?php
	$data_arr = array();
	
	include("excelwriter.inc.php");
	$cur_date = date("Y-m-d H-i-s");
	$fileName = "products-history/products-".$cur_date.".xls";
	$excel = new ExcelWriter($fileName);
	
	if( $excel == false )
	{
		echo $excel->error;
		die;
	}
	
	$myArr = array(
					"<strong> ID </strong>",
					"<strong> CATEGORY </strong>",
					"<strong> ARTICLE </strong>",
					"<strong> CODE </strong>",
					"<strong> NAME </strong>",
					"<strong> PRICE (UAH) </strong>"
				   	);
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