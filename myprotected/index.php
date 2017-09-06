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

	<title>ADMIN COMODO</title>

    <link rel="stylesheet" type="text/css" href="split/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="split/css/style.css" />
        
    <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="split/css/styleIE.css" />
    <![endif]-->
	
    <?php 
		/* 
			<script type="text/javascript" language="javascript" src="../bootstrap/js/jquery.js" ></script>
			<script type="text/javascript" language="javascript" src="split/js/jquery.min.js" ></script> 
			
			<script type="text/javascript" src="split/js/jquery.mockjax.js"></script>
			
			// jQuery.noConflict()
    	*/
	?>
    
    <script type="text/javascript" language="javascript" src="split/js/jquery.min.js" ></script>
    <!-- <script type="text/javascript" src="split/js/jquery.mockjax.js"></script> -->
    
    <script type="text/javascript" src="split/js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="split/js/jquery.inputmask.js"></script>
    
    <script type="text/javascript" language="javascript" src="split/js/jquery.easing.1.3.js" ></script>
    <script type="text/javascript" language="javascript" src="split/js/jquery.form.js" ></script>
    <script type="text/javascript" language="javascript" src="split/js/jquery.cookie.js" ></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    
	<link type="text/css" rel="stylesheet" href="redactor/redactor/redactor.css" />
	<script type="text/javascript" language="javascript" src="redactor/redactor/redactor.min.js"></script>
    
</head>

<body>
	<?php
    	require_once(WP_FOLDER."view.php");
	?>
    <div class="ajax" id="ajax-getter">&nbsp;</div>
</body>

<script src="split/js/js.js" type="text/javascript"></script>
<script src="split/js/helpCard.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript" src="split/js/script_after_body.js" ></script>

			<link href="/bootstrap/css/global-style.css" rel="stylesheet" type="text/css" media="screen">
            
			<script type="text/javascript" src="/bootstrap/assets/bootstrap/js/bootstrap.min.js"></script>

			<!--[if lt IE 9]>
    			<script src="../bootstrap/js/html5shiv.js"></script>
    			<script src="../bootstrap/js/respond.min.js"></script>
			<![endif]-->

			<script type="text/javascript" src="/bootstrap/assets/mixitup/jquery.mixitup.js"></script>
			<script type="text/javascript" src="/bootstrap/assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
			<script type="text/javascript" src="/bootstrap/js/jquery.wp.custom.js"></script>

</html>