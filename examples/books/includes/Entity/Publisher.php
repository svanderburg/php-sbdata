<?php
namespace Examples\Books\Entity;
use Exception;
use PDO;

class Publisher
{
	public static function queryAll(PDO $dbh)
	{
		$stmt = $dbh->prepare("select * from publisher order by PUBLISHER_ID");
		$stmt->execute();
		return $stmt;
	}
}
?>
