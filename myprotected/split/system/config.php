<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2015		*/
	/*	***************************	*/
	
	// Config file
	
class Config
{
    public $configs;
    function __construct(){
    $this->configs = array(
            
			
			"sitename" => "COMODO | STORE",
			
			//LOCAL
			/*"db" => array(
            	"host" => "localhost",
				"name" => "comodo",
            	"user" => "root",
				"pass" => "",
				"encode" => "utf8",
				),
            "admin" => array(
				"login" => "admin",
            	"pass" => "root"
			),*/
			
			
			//ONLINE
			"db" => array(
            	"host" => "localhost",
				"name" => "comodoki_kamstudio",
            	"user" => "comodoki_kamstud",
				"pass" => "qmEU1P6W",
				"encode" => "utf8",
				),
            "admin" => array(
				"login" => "admin",
            	"pass" => "root"
			),
			
			"copyright" => "&copy; 2016 Developed by kaminskiy-design.com.ua"
        );
    }
    function __destruct(){}
}