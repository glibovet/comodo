<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AppHelper extends Helper {
		
	// Корректная подрезка строки
	function next_sub_str($str,$len)
	{
		return implode(array_slice(explode('<br>',wordwrap($str,$len,'<br>',false)),0,1));
	}
	
	// Метод предназначен для создания превью файла
	public function mtvc_ChangeImageSize($filename, $savepath, $ext, $neww, $newh)
  	{
		try{
	 		$idata=getimagesize($filename);
     		$oldw=$idata[0];
     		$oldh=$idata[1];
     		$ext = strtolower($ext);
     		if($ext=='jpg' or $ext=='jpeg')
    		{ 
				$im=@imagecreatefromjpeg($filename);
      			if($im)
      			{
					if($oldw>$oldh) (double)$ratio=(double)$oldw/ (double)$neww;
        			else(double)$ratio=(double)$oldh/ (double)$newh;
        			$dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
        			$white = ImageColorAllocate($dest, 255,255,255);
        			imagefill($dest, 1, 1, $white);
        			imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
					imageJPeG($dest,$savepath);
        			imageDestroy($im);
        			imageDestroy($dest);
        			return true;
      			}
			}elseif($ext=='gif')
    		{
				$im=imagecreatefromgif($filename);
      			if($oldw>$oldh) (double)$ratio=(double)$oldw/ (double)$neww;
      			else(double)$ratio=(double)$oldh/ (double)$newh;
      			$dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
      			$white = ImageColorAllocate($dest, 255,255,255);
      			imagefill($dest, 1, 1, $white);
      			imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
      			imagegif($dest,$savepath);
      			imageDestroy($im);
      			imageDestroy($dest);
      			return true;
			}elseif($ext=='png')
    		{
				$im=imagecreatefrompng($filename);
      			if($oldw>$oldh) (double)$ratio=(double)$oldw/ (double)$neww;
      			else (double)$ratio=(double)$oldh/ (double)$newh;
      			$dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
      			$white = ImageColorAllocate($dest, 255,255,255);
      			imagefill($dest, 1, 1, $white);
      			imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
      			imagepng($dest,$savepath);
      			imageDestroy($im);
      			imageDestroy($dest);
      			return true;
			}
			return false;
		}catch(Exception $e){
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
  	}

	// Метод возвращает название разширения файла
	public function mtvc_get_file_ext($filename)
	{
		try{
			$test = $filename;
			$result = "";
			$cnt = 0;
			while($cnt < strlen($test))
			{
				if($test[strlen($test)-$cnt] == '.'){break;}
				$result .= $test[strlen($test)-$cnt];
				$cnt++;
			}
			$result = strrev($result);
			return $result;
		}catch(Exception $e){
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}
	
	// Метод MULTI-приема картинки через массив $_FILES[multiple]
	public function mtvc_add_files_file_miltiple($arr)
	{
		$result_arr = array();
		foreach($_FILES[$arr['files']]['name'] as $multi_cnt => $multi_cur_name)
		{
		/* 1  */ $path			= $arr['path'];				// путь к каталогу
		/* 2  */ $name			= $arr['name'];				// имя картинки: ->
									// 1 - оставить
									// 2 - сгенерировать используя текущую дату и время + то что было
									// 3 - сгенерировать используя текущую дату и время
									// 4 - использовать приставку (пункт 4)
									// 5 - приставка из п.4 + сгенерированное имя из даты и времени
								
		/* 3  */ $pre			= $arr['pre'];				// приставка имени файла
		/* 4  */ $size			= $arr['size'];				// допустимый размер файла в Mb
		/* 5  */ $rule			= $arr['rule'];				// Тип правила проверки на правильность расзмерности файла: ->
									// 0 - без проверки
									// 1 - учитывать пункт 6 и 7
									// 2 - строго квадрат
									// 3 - строго учитывать равность пункта 6 и 7
								
		/* 6  */ $max_w				= $arr['max_w'];			// максимальная ширина
		/* 7  */ $max_h				= $arr['max_h'];			// максимальная высота
		/* 8  */ $files				= $arr['files'];			// имя $_FILES
		/* 9  */ $resize_path 		= $arr['resize_path'];		// путь к папке превью mid | 0
		/* 10 */ $resize_w			= $arr['resize_w'];			// ширина mid фалйа | 0
		/* 11 */ $resize_h			= $arr['resize_h'];			// высота mid фалйа | 0
		/* 12 */ $resize_path_2		= $arr['resize_path_2'];	// путь к папке превью min | 0
		/* 13 */ $resize_w_2		= $arr['resize_w_2'];		// ширина min фалйа | 0
		/* 14 */ $resize_h_2		= $arr['resize_h_2'];		// высота mid фалйа | 0
		
	if($name < 1 || $name > 5){$name = 1;}
	if($rule < 0 || $rule > 3){$rule = 0;}
	
	$filepath = $path;
	
	//echo '<pre>files == '; print_r($_FILES[$files]); echo '</pre>';
	
	$filename = $_FILES[$files]['name'][$multi_cnt];
	
	$file_extension = $this->mtvc_get_file_ext($filename);
	
	if($name == 1){$filename = $_FILES[$files]['name'][$multi_cnt];}
	if($name == 2){$filename = date('YmdHis').rand(100,1000)."_".$_FILES[$files]['name'][$multi_cnt];}
	if($name == 3){$filename = date('YmdHis').rand(100,1000).'.'.$file_extension;}
	if($name == 4){$filename = $pre.'-'.rand(1,1000).'.'.$file_extension;}
	if($name == 5){$filename = $pre.date('YmdHis').rand(100,1000).'.'.$file_extension;}
	
	$filepath =  $path.$filename;
	
	//echo '<br>MULTI PATH: '.$filepath.'<br>';
	
	if($resize_path != "0"){$resize_path .= $resize_w."x".$resize_h."_".$filename;}
	if($resize_path_2 != "0"){$resize_path_2 .= $resize_w_2."x".$resize_h_2."_".$filename;}
	
	if($_FILES[$files]['size'][$multi_cnt] != 0 && $_FILES[$files]['size'][$multi_cnt]<=1024000*$size)
	{
		if(move_uploaded_file($_FILES[$files]['tmp_name'][$multi_cnt], $filepath))
		{
			$size = getimagesize($filepath);
			if($rule == 0)
			{
				if($resize_path != "0"){
					$this->mtvc_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
				if($resize_path_2 != "0"){
					$this->mtvc_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
				array_push($result_arr,$filename);
			}
			if($rule == 1)
			{
				if($size[0] <= $max_w && $size[1] <= $max_h)
				{
					if($resize_path != "0"){
						$this->mtvc_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						$this->mtvc_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					array_push($result_arr,$filename);
				}else
				{
					echo("<p class='fail'>Файл превышает допустимый размер: ".$max_w."x".$max_h." px.</p>");
					unlink($filepath);
					array_push($result_arr,'fail');
				}
			}
			if($rule == 2)
			{
				if($size[0] == $size[1])
				{
					if($resize_path != "0"){
						$this->mtvc_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						$this->mtvc_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					array_push($result_arr,$filename);
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет правилу: ширина должна быть ровна высоте.</p>");
					unlink($filepath);
					array_push($result_arr,'fail');
				}
			}
			if($rule == 3)
			{
				if($size[0] == $max_w && $size[1] == $max_h)
				{
					if($resize_path != "0"){
						$this->mtvc_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						$this->mtvc_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					array_push($result_arr,$filename);
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет заданым параметрам: ".$max_w."x".$max_h." px.</p>");
					unlink($filepath);
					array_push($result_arr,'fail');
				}
			}
		}else
		{
			echo("<p class='fail'>Файл не может быть сохранён по пути: ".$filepath.". Укажите другой путь или проверьте права доступа директории на запись.</p>");
			array_push($result_arr,'fail');
		}
	}else
	{
		echo("<p class='fail'>Файл превышает допустимый размер: ".$size." Mb.</p>");
		array_push($result_arr,'fail');
	}
	
	} // end foreach multi name
	return $result_arr;
	}
 
}
?>