<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Module file of Application << 10 >>
	
	$app_id = 22;
	
	$data = array();
	
	$data['loadsrc'] = "/".ADMIN_PATH.WP_FOLDER."/img/pulse.gif";
	$data['ajaxpath'] = "/".ADMIN_PATH.WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/content.load.php";
	
	$data['start_page'] = 1;
	$data['on_page'] = 10;
	
	if(isset($_COOKIE['on_page_'.$app_id]) && $_COOKIE['on_page_'.$app_id] != null && $_COOKIE['on_page_'.$app_id] > 5)
	{
		$data['on_page'] = $_COOKIE['on_page_'.$app_id];
	}
	
	$smarty->assign("data",$data); // присваиваем переменной
	$smarty->display("view.tpl"); // выводим обработанный
	
?>

	<script type="text/javascript" language="javascript">
		$(function(){
			var data = {
						ajaxpath:'<?php echo $data['ajaxpath'] ?>',
						start_page:<?php echo $data['start_page'] ?>,
						on_page:<?php echo $data['on_page'] ?>
						}
			$('#inajax-1').load(data.ajaxpath,data);
		});
	</script>
    