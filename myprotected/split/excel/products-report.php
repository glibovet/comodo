<?php
	$response = array('title'=>'Выгрузка в эксель Продукции по фильтру', 'status'=>'error', 'message'=>'Error');
	
	require_once "../../require.base.php";
	
	require_once "../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$data_arr = array();
	
	include("excelwriter.inc.php");
	$cur_date = date("Y-m-d H-i-s");
	$fileName = "products-report/products-".$cur_date.".xls";
	$excel = new ExcelWriter($fileName);
	
	if( $excel == false )
	{
		echo $excel->error;
		die;
	}
	
	$myArr = array(
					"<strong> ID </strong>",
					"<strong> Название </strong>",
					"<strong> Артикул </strong>",
					"<strong> На складе </strong>",
					"<strong> Цена (грн) </strong>",
					"<strong> Производитель </strong>",
					"<strong> Поставщик </strong>"
				   	);
	$excel->writeLine($myArr, array('text-align'=>'center', 'color'=> 'blue', 'border-bottom' => '1px solid black'));

	///////////////////////////////////////////////////////////////

	$params = array();
	
	$params['filtr'] = $_POST['filtr'];
	
	if($params['filtr'])
		{
			parse_str($params['filtr'],$prmFiltr);
		}else
		{
			$prmFiltr = array();
		}
	$params['filtr'] = $prmFiltr;
	
	$appTable = "shop_products"; // Main table

	$data_arr = $ah->getAllShopProducts($params);
	
	///////////////////////////////////////////////////////////////

	$col_params = array(
			'text-align' => 'left',
			'color' => 'black',
			'font-size' => '14px',
			'line-height'	=> '25px',
			'border-right' => '1px solid black');

	foreach($data_arr as $data)
	{
		$excel->writeRow(); //создаем пустую строку
		
		// Записываем столбци
		$excel->writeCol($data['id'], $col_params);
		$excel->writeCol($data['name'], $col_params);
		$excel->writeCol($data['sku'], $col_params);
		//$excel->writeCol($data['cat_name'], $col_params);
		//$excel->writeCol($data['code'], $col_params);
		$excel->writeCol($data['quant'], $col_params);
		//$excel->writeCol($data['in_stock'], $col_params);
		$excel->writeCol($data['price'], $col_params);
		$excel->writeCol($data['mf_name'], $col_params);
		$excel->writeCol($data['deliver_name'], $col_params);
	}

	$excel->close();

	$response['status'] = "success";
	$response['message'] = "<p><a href='split/excel/products-report/products-".$cur_date.".xls' target='_blank'>Открыть сформированный Excel файл</a></p>";
	
	echo json_encode($response);