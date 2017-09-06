<?php
// Tmp Class

class Tmp
{
	public $userid;
	public $username;
	public $firstname;
	public $lastname;
	public $salutation;
	public $countrycode;
	
	public function __construct($userid = false, $username = false, $firstname = false, $lastname = false, $salutation = false, $countrycode = false)
	{
		$this->userid = $userid;
		$this->username = $username;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->salutation = $salutation;
		$this->countrycode = $countrycode;
	}
}

class TmpMapper implements ObjectInterface
{	
	public static function findById($id,DB_Mysql $dbh)
	{
		$query = "SELECT * FROM users WHERE userid = :1";
		
		$data_stmt = $dbh->prepare($query);
		$data_result = $data_stmt->execute($id);
		$data = $data_result->fetchAssoc();
		
		if(!$data)
		{
			return false;
		}
		return new Tmp($data['userid'], $data['username'], $data['firstname'], $data['lastname'], $data['salutation'], $data['countrycode']);
	}
	
	public static function findByQuery($query,$params,DB_Mysql $dbh)
	{
		$data_stmt = $dbh->prepare($query);
		$data_result = $data_stmt->execute($params);
		$data = $data_result->fetchallAssoc();
		
		if(!$data)
		{
			return false;
		}
		return $data;
	}
	
	public static function insert(Tmp $tmp,DB_Mysql $dbh)
	{
		if($tmp->userid)
		{
			throw new Exception("Object TMP имеет идентификатор userid, вставка невозможна.");
		}
		$query = "INSERT INTO users (username, firstname, lastname, salutation, countrycode) VALUES (:1, :2, :3, :4, :5)";
		$data_stmt = $dbh->prepare($query);
		$data_result = $data_stmt->execute($tmp->username, $tmp->firstname, $tmp->lastname, $tmp->salutation, $tmp->countrycode);
		
		list($tmp->userid) = $dbh->prepare("select last_insert_id()")->execute()->fetchRow();
	}
	
	public static function update(Tmp $tmp, DB_Mysql $dbh)
	{
		if(!$tmp->userid)
		{
			throw new Exception("Для вызова метода update() необходим идентификатор userid.");
		}
		$query = "UPDATE users SET username = :1, firstname = :2, lastname = :3, salutation = :4, countrycode = :5 WHERE userid =  :6";
		$dbh->prepare($query)->execute($tmp->username,$tmp->firstname,$tmp->lastname,$tmp->salutation,$tmp->countrycode,$tmp->userid);
	}
	
	public static function delete(Tmp $tmp, DB_Mysql $dbh)
	{
		if(!$tmp->userid)
		{
			throw new Exception("Object TMP не имеет идентификатора userid, удаление невозможно.");
		}
		$query = "DELETE FROM users WHERE userid = :1";
		$dbh->prepare($query)->execute($tmp->userid);
	}
}