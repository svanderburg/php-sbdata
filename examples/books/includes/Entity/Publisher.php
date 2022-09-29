<?php
namespace Examples\Books\Entity;
use Exception;
use PDO;
use PDOStatement;

class Publisher
{
	public static function queryAll(PDO $dbh): PDOStatement
	{
		$stmt = $dbh->prepare("select * from publisher order by PUBLISHER_ID");
		$stmt->execute();
		return $stmt;
	}

	public static function queryOne(PDO $dbh, $PUBLISHER_ID): PDOStatement
	{
		$stmt = $dbh->prepare("select * from publisher where PUBLISHER_ID = ?");
		if(!$stmt->execute(array($PUBLISHER_ID)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
}
?>
