<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	// COPY: CREATE TABLE new_tbl LIKE org_tbl
	
	/*
		CREATE TABLE IF NOT EXISTS `schema`.`Employee` (
		`idEmployee` VARCHAR(45) NOT NULL ,
		`Name` VARCHAR(255) NULL ,
		`idAddresses` VARCHAR(45) NULL ,
		PRIMARY KEY (`idEmployee`) ,
		CONSTRAINT `fkEmployee_Addresses`
		FOREIGN KEY `fkEmployee_Addresses` (`idAddresses`)
		REFERENCES `schema`.`Addresses` (`idAddresses`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
		ENGINE = InnoDB	
		DEFAULT CHARACTER SET = utf8
		COLLATE = utf8_bin
	*/
	
	require_once "../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Table INSERT FIELD</title>
</head>

<?php
	$table	= trim($_POST['table']);
	
	$query = "
			 CREATE TABLE IF NOT EXISTS `".$table."` 
			 	(
				`id` INT(11)  PRIMARY KEY AUTO_INCREMENT
				)
			ENGINE = InnoDB	
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			 ";
?>
<body>
	<?php
		echo $query;
		
    	$create_row_stmt = $dbh->prepare($query);
		$create_row_stmt->execute();
	?>
</body>
</html>