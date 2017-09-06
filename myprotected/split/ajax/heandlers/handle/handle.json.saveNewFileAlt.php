<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$field	= (isset($_POST['field']) ? $_POST['field'] : 'images');
	
	if($field == 'docs'){
			$appTable = "docs_ref";
		}elseif($field == 'finishes'){
				$appTable = "finishes_ref";
			}else{
				$appTable = "files_ref";
				}
	
	$id	= (int)$_POST['id'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));
	
	
	$query = "UPDATE [pre]$appTable SET `title`='$val' WHERE `id`=$id LIMIT 1";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "ALT файла успешно сохранен.";