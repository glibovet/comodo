<?php
$response = array('title'=>'Загрузка продукции с эксель файла и обновление информации', 'status'=>'error', 'message'=>'Error');
	
require_once "../../require.base.php";
	
require_once "../library/AjaxHelp.php";
	
$ah = new ajaxHelp($dbh);

$fileName1 = $_FILES['import_file_1']['name'];

$fileName2 = $_FILES['import_file_2']['name'];

if($ah->getExt($fileName1)=="xls" && $ah->getExt($fileName2)=="xls")
{
		$file_name1 = $ah->mtvc_add_files_file(array(
					'path'			=>"workabox-import/",
					'name'			=>"4",
					'pre'			=>"workabox_1",
					'size'			=>200,
					'rule'			=>0,
					'max_w'			=>25000,
					'max_h'			=>25000,
					'files'			=>"import_file_1",
					'resize_path'	=>"0",
					'resize_w'		=>0,
					'resize_h'		=>0,
					'resize_path_2'	=>"0",
					'resize_w_2'	=>0,
					'resize_h_2'	=>0
				  ));
				  
		$file_name2 = $ah->mtvc_add_files_file(array(
					'path'			=>"workabox-import/",
					'name'			=>"4",
					'pre'			=>"workabox_2",
					'size'			=>200,
					'rule'			=>0,
					'max_w'			=>25000,
					'max_h'			=>25000,
					'files'			=>"import_file_2",
					'resize_path'	=>"0",
					'resize_w'		=>0,
					'resize_h'		=>0,
					'resize_path_2'	=>"0",
					'resize_w_2'	=>0,
					'resize_h_2'	=>0
				  ));
	
	if($file_name1 && $file_name2)
	{
	
		chmod("workabox-import/".$file_name1,0777);
		chmod("workabox-import/".$file_name2,0777);
	
		error_reporting(E_ALL ^ E_NOTICE);
		require_once 'excel_reader2.php';
		
		$data1 = new Spreadsheet_Excel_Reader("workabox-import/$file_name1");
		$data2 = new Spreadsheet_Excel_Reader("workabox-import/$file_name2");
	
		//echo '<pre>'; print_r($data); echo '</pre>';
		//echo '<pre>'; print_r($sheets[0]['cells']); echo '</pre>';
		
		//echo $data->dump(true,true); 
	
	
	
		$data = array(); // New array
		
		// Read Articles
		
		$sheets1 = $data1->sheets;
		$cnt1 = 0;
		foreach($sheets1[0]['cells'] as $sheet1)
		{
			$cnt1++;
			
			$wid = strip_tags(str_replace("'","\'",$sheet1[1]));
			$art = strip_tags(str_replace("'","\'",$sheet1[10]));
					
			$data[$wid]				= array('art'=>0,'price'=>0);
			$data[$wid]['art'] 	= $art; 
		}
		
		// Read Prices
		
		$sheets2 = $data2->sheets;
		$cnt2 = 0;
		foreach($sheets2[0]['cells'] as $sheet2)
		{
			$cnt2++;
			
			$wid	= strip_tags(str_replace("'","\'",$sheet2[4]));
			$price	= strip_tags(str_replace("'","\'",$sheet2[3]));
					
			if(isset($data[$wid]))
			{
				$data[$wid]['price'] = $price;
			}
		}
	
		$result = "<table><tr><th> Article </th><th> Price </th></tr>";
		
		$rows_cnt = 0;
	
		$failed_rows = 1;
	
		foreach($data as $prod)
		{
			$rows_cnt++;
			
			//if($rows_cnt==1) continue;
			
			$item = array();
			
			$cnt = 0;
			
			$row_cells = "<td style='border-top:1px solid #ccc; border-right:1px solid #ccc;'>".str_replace('"',"\'",$prod['art'])."</td>";
			$row_cells .= "<td style='border-top:1px solid #ccc; border-right:1px solid #ccc;'>".str_replace('"',"\'",$prod['price'])." UAH</td>";
			
				$product_id_search = $ah->rs("SELECT id FROM [pre]shop_products WHERE `sku`='".$prod['art']."' LIMIT 1");
				if($product_id_search)
				{
					$product_id = $product_id_search[0]['id'];
					
					$query = "UPDATE [pre]shop_products SET 	
																`price`='".$prod['price']."' 
								WHERE `id`=$product_id LIMIT 1";
					
					$ah->rs($query);
				}else
				{
					$failed_rows++;
					$result .= "<tr>".$row_cells."</tr>";
				}
		}
		
		$result .= "</table>";
	
	}else
	{
		$result = "<p>Не удалось загрузить файл.</p>";
	}
	
	
		$result = "<br><p>Товары, которых не нашлось в Базе Данных (".$failed_rows.") :</p>".$result;
	
		
	$response['status'] = "success";
	$response['message'] = "<p>Импорт обновлений по товарам (".(count($data)-$failed_rows).") Workabox успешно завершился.</p>".($failed_rows > 1 ? $result : "");
}else{
	$response['status'] = "failed";
	$response['message'] = "<p>Импорт файлы должен быть в формате .xls</p>";
	}
	
echo json_encode($response);