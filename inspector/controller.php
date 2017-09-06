<?php

class Controller
{
	public function __construct()
	{}
	
	// Метод удаляет директорию и все ее содержимое
	public function mtvc_RemoveDir($path)
	{
		if(file_exists($path) && is_dir($path))
	{
		$dirHandle = opendir($path);
		while (false !== ($file = readdir($dirHandle))) 
		{
			if ($file!='.' && $file!='..') // исключаем папки с названием '.' и '..' 
			{
				$tmpPath=$path.'/'.$file;
				//chmod($tmpPath, 0777);
				
				if (is_dir($tmpPath))
	  			{  // если папка
					$this->mtvc_RemoveDir($tmpPath);
			   	} 
	  			else 
	  			{ 
	  				if(file_exists($tmpPath))
					{
						// удаляем файл 
	  					unlink($tmpPath);
					}
	  			}
			}
		}
		closedir($dirHandle);
		
		// удаляем текущую папку
		if(file_exists($path))
		{
			rmdir($path);
		}
	}
	else
	{
		//echo "Удаляемой папки не существует или это файл!";
	}
	}
	
	// Метод рекурсивно считывает содержимое каталога и копирует его по указанному пути
	public function mtvc_Read_and_Copy_data_from_dir($path2dir,$copypath)
	{
		try
		{
			$d = dir ($path2dir); 
 
    		while (false !== ($entry = $d->read()))
			{ 
 				//echo '<br>ENTRY = '.$entry.'<br>';
        		if ($entry!='.' && $entry!='..' && $entry!='' )
				{
            		$all_path = $path2dir.$entry;
					$all_copypath = $copypath.$entry;
					if(!is_file($all_path)){
											mkdir($all_copypath,0777);
											}
            		$new_path_arr = $this->mtvc_Read_and_Copy_data_helper($all_path, $all_copypath, is_file($all_path));
			
					$new_path = $new_path_arr[0];
					$new_copypath = $new_path_arr[1];
 
            		if (!is_file($all_path))
					{
                		//echo "<br>NEW path = ".$new_path."<br>";
						if (!$this->mtvc_Read_and_Copy_data_from_dir($new_path,$new_copypath))
						{
                    		return false;
                		}
            		}
        		}
    		} // end while 
 
    		return true;
			
		}catch(Exception $e){
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}
	
	// Метод являеться вспомагательным для метода mtvc_Read_and_Copy_data_from_dir (копирует файлы и обновляет пути)
	public function mtvc_Read_and_Copy_data_helper($path2file, $copypath, $is_file = true)
	{
		try
		{
			if ($is_file)
			{ 
        		# выполняем операцию над файлом
        		//echo "FILE = ".$path2file."<br>"; 
				//chmod($path2file,0777);
				copy($path2file,$copypath);
				}else{ 
        				# выполняем операцию над папкой
        				$path2file = $path2file.'/';
						$copypath = $copypath."/"; 
						
        				//echo "<br>FOLDER = ".$path2file."<br>"; 
        				//chmod($path2dir,0777);
						}
				
				return array($path2file,$copypath);
		
		}catch(Exception $e){
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}
}