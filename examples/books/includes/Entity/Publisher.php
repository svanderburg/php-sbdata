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
}
?>
