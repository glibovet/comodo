<?php
$response = array('title'=>'Загрузка продукции с эксель файла и обновление информации', 'status'=>'error', 'message'=>'Error');
	
require_once "../../require.base.php";
	
require_once "../library/AjaxHelp.php";
	
$ah = new ajaxHelp($dbh);

$fileName = $_FILES['import_file']['name'];

if($ah->getExt($fileName)=="xls")
{
		$file_name = $ah->mtvc_add_files_file(array(
					'path'			=>"products-import/",
					'name'			=>"4",
					'pre'			=>"import_products",
					'size'			=>200,
					'rule'			=>0,
					'max_w'			=>25000,
					'max_h'			=>25000,
					'files'			=>"import_file",
					'resize_path'	=>"0",
					'resize_w'		=>0,
					'resize_h'		=>0,
					'resize_path_2'	=>"0",
					'resize_w_2'	=>0,
					'resize_h_2'	=>0
				  ));
	
	if($file_name)
	{
	
		chmod("products-import/".$file_name,0777);
	
		error_reporting(E_ALL ^ E_NOTICE);
		require_once 'excel_reader2.php';
		$data = new Spreadsheet_Excel_Reader("products-import/$file_name");
	
		//echo '<pre>'; print_r($data); echo '</pre>';
		//echo '<pre>'; print_r($sheets[0]['cells']); echo '</pre>';
		
		//echo $data->dump(true,true); 
	
		$result = "<table>";
		
		$rows_cnt = 0;
	
		$failed_rows = 0;
	
		$sheets = $data->sheets;
		foreach($sheets[0]['cells'] as $sheet)
		{
			$rows_cnt++;
			
			//if($rows_cnt==1) continue;
			
			$item = array();
			
			$cnt = 0;
			
			$row_cells = "";
			
				foreach($sheet as $cell)
				{
					$cnt++;
					
					$cell = strip_tags(str_replace("'","\'",$cell));
					
					switch($cnt)
					{
						case 1: $item['id'] 			= (int)$cell; break;
						case 2: $item['name'] 			= str_replace("'","\'",$cell); break;
						case 3: $item['sku'] 			= str_replace("'","\'",$cell); break;
						case 4: $item['quant'] 			= (int)$cell; break;
						case 5: $item['price'] 			= (float)$cell; break;
						case 6: $item['mf_name'] 		= str_replace("'","\'",$cell); break;
						case 7: $item['deliver_name']	= str_replace("'","\'",$cell); break;
						
						default: break;
					}
					
					$row_cells .= "<td>".str_replace('"',"\'",$cell)."</td>";
				}
				
				$product_id_search = $ah->rs("SELECT id FROM [pre]shop_products WHERE `id`='".$item['id']."' LIMIT 1");
				if($product_id_search)
				{
					$product_id = $product_id_search[0]['id'];
					
					$query = "UPDATE [pre]shop_products SET 	`name`='".$item['name']."',
																`sku`='".$item['sku']."',
																`quant`='".$item['quant']."',
																`price`='".$item['price']."' 
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
	
	
		$result = "<br><p>Товары, которых не нашлось в Базе Данных:</p>".$result;
	
		
	$response['status'] = "success";
	$response['message'] = "<p>Импорт обновлений по товарам успешно завершился.</p>".($failed_rows > 1 ? $result : "");
}else{
	$response['status'] = "failed";
	$response['message'] = "<p>Импорт файл должен быть в формате .xls</p>";
	}
	
echo json_encode($response);