<?php
namespace Examples\TodoList\Entity;
use Exception;
use PDO;
use PDOStatement;

class TodoItem
{
	public static function queryNumOfItems(PDO $dbh): int
	{
		$stmt = $dbh->prepare("select COUNT(*) from todoitem");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		if(($row = $stmt->fetch()) === false)
			return 0;
		else
			return (int)($row[0]);
	}

	public static function queryPage(PDO $dbh, int $page, int $pageSize): PDOStatement
	{
		$offset = (int)($page * $pageSize);

		$stmt = $dbh->prepare("select * from todoitem order by ITEM_ID limit ?, ?");
		$stmt->bindParam(1, $offset, PDO::PARAM_INT);
		$stmt->bindParam(2, $pageSize, PDO::PARAM_INT);

		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function queryOne(PDO $dbh, $ITEM_ID): PDOStatement
	{
		$stmt = $dbh->prepare("select * from todoitem where ITEM_ID = ?");
		if(!$stmt->execute(array($ITEM_ID)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function insert(PDO $dbh, array $item): int
	{
		$dbh->beginTransaction();

		$stmt = $dbh->prepare("select max(ITEM_ID) from todoitem");

		if($stmt->execute() && $row = $stmt->fetch())
		{
			$ITEM_ID = $row[0] + 1;

			$stmt = $dbh->prepare("insert into todoitem values (?, ?)");
			if(!$stmt->execute(array($ITEM_ID, $item['Description'])))
			{
				$dbh->rollBack();
				throw new Exception($stmt->errorInfo()[2]);
			}

			$dbh->commit();
			return $ITEM_ID;
		}
		else
		{
			$dbh->rollBack();
			throw new Exception("Cannot determine the next item id!");
		}
	}

	public static function update(PDO $dbh, array $item): void
	{
		$stmt = $dbh->prepare("update todoitem set ".
			"Description = ? ".
			"where ITEM_ID = ?");

		if(!$stmt->execute(array($item['Description'], $item['ITEM_ID'])))
			throw new Exception($stmt->errorInfo()[2]);
	}

	public static function delete(PDO $dbh, $ITEM_ID): void
	{
		$stmt = $dbh->prepare("delete from todoitem where ITEM_ID = ?");
		if(!$stmt->execute(array($ITEM_ID)))
			throw new Exception($stmt->errorInfo()[2]);
	}
}
?>
