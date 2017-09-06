<?php
// DB Mysql Statement class - оболочка класса DB Mysql

class DB_MysqlStatement
{
	public $result;
	public $binds;
	public $query;
	public $dbh;
	
	public function __construct($dbh,$query)
	{
		$this->query	= $query;
		$this->dbh		= $dbh;
		if(!is_resource($dbh))
		{
			throw new Exception("Некорректное соединение с Базой Данных.");
		}
	}
	
	public function fetchRow()
	{
		if(!$this->result)
		{
			throw new Exception("Запрос не выполнен.");
		}
		return mysql_fetch_row($this->result);
	}
	
	public function fetchAssoc()
	{
		if(!$this->result)
		{
			throw new Exception("Запрос не выполнен.");
		}
		return mysql_fetch_assoc($this->result);
	}
	
	public function fetchallAssoc()
	{
		$result = array();
		while($row = $this->fetchAssoc())
		{
			$result[] = $row;
		}
		return $result;
	}
	
	public function execute($show_query = FALSE)
	{
		$binds = func_get_args();
		foreach($binds as $index => $name)
		{
			$this->binds[$index+1] = $name;
		}
		$cnt = count($binds);
		$query = $this->query;
		if($cnt)
		{
		foreach($this->binds as $ph => $pv)
		{
				if(is_array($pv))
				{
					foreach($pv as $pv_h => $pv_v)
					{
						$ph_inc = $pv_h+1;
						$query = str_replace(":$ph_inc", "'".mysql_escape_string($pv_v)."'",$query);
					}
				}else
				{
					$query = str_replace(":$ph", "'".mysql_escape_string($pv)."'",$query);
				}
			}
		}
		//echo "<div class='query-secret'>Query = ".$query.'</div>';
		
		$this->result = mysql_query($query,$this->dbh);
		if(!$this->result)
		{
			throw new Exception("execute Error.");
		}
		return $this;
	}
}