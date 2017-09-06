<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Core system
	
class Library extends Config
{
    function __construct(){}
	
	public function preloadStarting()
	{
		require_once(WP_FOLDER."html/wp_preload.html");
	}
	public function readHttpLink()
	{
	}
	public function setPageType()
	{
	}
	public function includeCssFiles()
	{
		?>
        <link rel="stylesheet" type="text/css" href="<?php echo GLOBAL_PATH.WP_FOLDER."css/reset.css" ?>" />
        <?php
        	if(isset($_GET['control']) && $_GET['control'] != null && trim($_GET['control']) != "")
			{
		?>
        <link rel="stylesheet" type="text/css" href="<?php echo GLOBAL_PATH.WP_FOLDER."css/style.css" ?>" />
        <?php
			}
		?>
        <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="<?php echo GLOBAL_PATH.WP_FOLDER."css/styleIE.css" ?>" />
        <![endif]-->
        <?php
	}
	public function printGoogleAnaliticsScript()
	{
	}
	public function loadScriptsBeforeBody()
	{
		?>
		<script type="text/javascript" language="javascript" src="<?php echo GLOBAL_PATH.WP_FOLDER."js/jquery.min.js" ?>" ></script>
        <script type="text/javascript" language="javascript" src="<?php echo GLOBAL_PATH.WP_FOLDER."js/jquery.easing.1.3.js" ?>" ></script>
        <script type="text/javascript" language="javascript" src="<?php echo GLOBAL_PATH.WP_FOLDER."js/jquery.form.js" ?>" ></script>
        <script type="text/javascript" language="javascript" src="<?php echo GLOBAL_PATH.WP_FOLDER."js/jquery.cookie.js" ?>" ></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<?php
	}
	public function loadScriptsAfterBody()
	{
		?>
		<script type="text/javascript" language="javascript" src="<?php echo GLOBAL_PATH.WP_FOLDER."js/script_after_body.js" ?>" ></script>
		<?php
	}
	// Функция правильной урезки строки по количеству символов
	public function cropStr($str, $size)
	{ 
  		return mb_substr($str,0,mb_strrpos(mb_substr($str,0,$size,'utf-8'),' ','utf-8'),'utf-8');
	}
	
    function __destruct(){}
}