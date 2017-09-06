<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Excel READER</title>
<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("products.xls");
?>

</head>

<body>
<table>
<?php 
	//echo '<pre>'; print_r($data); echo '</pre>';
	//echo '<pre>'; print_r($sheets[0]['cells']); echo '</pre>';
	
	//echo $data->dump(true,true); 

	$sheets = $data->sheets;
	foreach($sheets[0]['cells'] as $sheet)
	{
		?>
		<tr>
        	<?php
            foreach($sheet as $cell)
			{
				?>
				<td><?php echo $cell ?></td>
				<?php
			}
			?>
        </tr>
		<?php
	}
?>
</table>
</body>
</html>