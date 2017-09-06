<?php
// Object Interface

interface ObjectInterface
{
	public static function findById($id,DB_Mysql $dbh);
	public static function findByQuery($query,$params,DB_Mysql $dbh);
}

