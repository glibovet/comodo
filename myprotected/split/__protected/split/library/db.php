<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
class Db
{
	protected $db_connect;
	protected $host;
	protected $db_name;
	protected $user;
	protected $pass;
	protected $encode;
    function __construct($_host,$_db_name,$_user,$_pass,$_encode){
		$this->host = $_host;
		$this->db_name = $_db_name;
		$this->user = $_user;
		$this->pass = $_pass;
		$this->encode = $_encode;
    }
	public function db_access()
	{
		try{
			$this->db_connect = mysql_connect($this->host,$this->user,$this->pass);
			mysql_select_db($this->db_name,$this->db_connect);
			mysql_set_charset($this->encode,$this->db_connect);
		}
		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}
	public function db_destroy()
	{
		try
		{
			mysql_close($this->db_connect);
		}
		catch(Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}
    function __destruct(){}
}