<?php
// DB Mysql class

interface DB_Connection
{
	public function execute($query);	// Выполняет запрос в БД
	public function prepare($query);	// Подготовка к выполнению запроса
}

class DB_Mysql implements DB_Connection
{
	public		$pre;
	protected 	$user;
	protected 	$pass;
	protected 	$dbhost;
	protected 	$dbname;
	protected 	$dbh;		// Дескриптор подключения к Базе Данных
	protected 	$encode;
	
	public function __construct($user,$pass,$dbhost,$dbname,$encode,$pre)
	{
		$this->user		= $user;
		$this->pass		= $pass;
		$this->dbhost	= $dbhost;
		$this->dbname	= $dbname;
		$this->encode	= $encode;
		$this->pre		= $pre;
	}
	
	protected function connect()
	{
		$this->dbh = mysql_pconnect($this->dbhost,$this->user,$this->pass);
		if(!is_resource($this->dbh))
		{
			throw new Exception;
		}
		if(!mysql_select_db($this->dbname,$this->dbh))
		{
			throw new Exception;
		}
		mysql_set_charset($this->encode,$this->dbh);
	}
	
	public function execute($query)
	{
		if(!$this->dbh)
		{
			$this->connect();
		}
		$ret = mysql_query($query,$this->dbh);
		if(!$ret)
		{
			throw new Exception;
		}
			elseif(!is_resource($ret))
			{
				return TRUE;
			}
				else
				{
					$stmt = new DB_MysqlStatement($this->dbh,$query);
					$stmt->result = $ret;
					return $stmt;
				}
	}
	
	public function prepare($query)
	{
		if(!$this->dbh)
		{
			$this->connect();
		}
		$query = str_replace("[pre]",$this->pre,$query);
		return new DB_MysqlStatement($this->dbh,$query);
	}
}