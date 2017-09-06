<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	--------------------------	*/
	
	require_once "require.base.php";
	
	require_once("set_define_values.php");
	
	require_once(WP_FOLDER."library/core.php");
	
	$lib_obj = new Library();
	
	require_once(WP_FOLDER.SMARTY_DIR."libs/Smarty.class.php");
	
	require_once(WP_FOLDER."controller.php");
	$controller = new Controller(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"	/>
    <meta content="WebMiracle" 							name="author"	/>
    <meta content="noindex,nofollow" 					name="robots"	/>

	<link href="favicon.png" rel="shortcut icon">

	<title>ZEN ADMIN</title>

    <link rel="stylesheet" type="text/css" href="split/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="split/css/style.css" />
        
    <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="split/css/styleIE.css" />
    <![endif]-->
	
    <script type="text/javascript" language="javascript" src="split/js/jquery.min.js" ></script>
    <script type="text/javascript" language="javascript" src="split/js/jquery.easing.1.3.js" ></script>
    <script type="text/javascript" language="javascript" src="js/jquery.form.js" ></script>
    <script type="text/javascript" language="javascript" src="js/jquery.cookie.js" ></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    
	<link type="text/css" rel="stylesheet" href="redactor/redactor/redactor.css" />
	<script type="text/javascript" language="javascript" src="redactor/redactor/redactor.min.js"></script>
</head>

<body>
	<?php
    	require_once(WP_FOLDER."view.php");
	?>
</body>

<script type="text/javascript" language="javascript" src="split/js/script_after_body.js" ></script>

</html>