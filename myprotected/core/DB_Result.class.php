<?php
// DB Result - делегирует все задачи специфические для конкретных платформ объекту DB_Statement, из которого он был создан

interface DB_Delegation
{
	public function First();
	public function Last();
	public function Next();
	public function Prev();
}

class DB_Result implements DB_Delegation 
{
	protected $stmt;
	protected $result = array();
	private $rowIndex = 0;
	private $currIndex = 0;
	private $done = false;
	
	public function __construct(DB_MysqlStatement $stmt)
	{
		$this->stmt = $stmt;
	}
	
	public function First()
	{
		if(!$this->result)
		{
			$this->result[$this->rowIndex++] = $this->stmt->fetchAssoc();
		}
		$this->currIndex = 0;
		return $this;
	}
	
	public function Last()
	{
		if(!$this->done)
		{
			array_push($this->result,$this->stmt->fetchAssoc());
		}
		$this->done = true;
	}
	
	public function Next()
	{
		if($this->done)
		{
			return false;
		}
		$offset = $this->currIndex + 1;
		if(!$this->result[$offset])
		{
			$row = $this->stmt->fetchAssoc();
			if(!$row)
			{
				$this->done = true;
				return false;
			}
			$this->result[$offset] = $row;
			++$this->rowIndex;
			++$this->currIndex;
			return $this;
		}
		else
		{
			++$this->currIndex;
			return $this;
		}
	}
	
	public function Prev()
	{
		if($this->currIndex == 0)
		{
			return false;
		}
		--$this->currIndex;
		return $this;
	}
	
	public function __get($varname)
	{
		if(array_key_exists($varname,$this->result[$this->currIndex]))
		{
			return $this->result[$this->currIndex][$varname];
		}
		else
		{
			print("Magic GET Error: DB_Result object.\n");
		}
	}
}