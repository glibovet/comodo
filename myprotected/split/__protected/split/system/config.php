<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Config file
	
class Config
{
    public $configs;
    function __construct(){
    $this->configs = array(
            "sitename" => "MIRACLE WEB TECHNOLOGIES - Професcиональная разработка сайтов",
			"db" => array(
            	"host" => "localhost",
				"name" => "zencosmet",
            	"user" => "zencosmusr",
				"pass" => "kTpcgY5q",
				"encode" => "utf8",
				),
            "admin" => array(
				"login" => "admin",
            	"pass" => "root"
			),
			"copyright" => "&copy; 2013 MIRACLE WEB TECHNOLOGIES"
        );
    }
    function __destruct(){}
}