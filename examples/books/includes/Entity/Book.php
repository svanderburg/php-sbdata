<?php
namespace Examples\Books\Entity;
use Exception;
use PDO;
use PDOStatement;

class Book
{
	public static function queryOverview(PDO $dbh): PDOStatement
	{
		$stmt = $dbh->prepare("select book.BOOK_ID, book.Title, book.Subtitle, book.PUBLISHER_ID, publisher.Name as PublisherName ".
			"from book ".
			"inner join publisher on book.PUBLISHER_ID = publisher.PUBLISHER_ID ".
			"order by BOOK_ID");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function queryAll(PDO $dbh): PDOStatement
	{
		$stmt = $dbh->prepare("select * from book order by BOOK_ID");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function queryOne(PDO $dbh, $BOOK_ID): PDOStatement
	{
		$stmt = $dbh->prepare("select * from book where BOOK_ID = ?");
		if(!$stmt->execute(array($BOOK_ID)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function queryOnePublisher(PDO $dbh, $BOOK_ID): PDOStatement
	{
		$stmt = $dbh->prepare("select publisher.name ".
			"from book ".
			"inner join publisher on book.PUBLISHER_ID = publisher.PUBLISHER_ID ".
			"where book.BOOK_ID = ?");
		if(!$stmt->execute(array($BOOK_ID)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function insert(PDO $dbh, array $book): int
	{
		$dbh->beginTransaction();

		$stmt = $dbh->prepare("select max(BOOK_ID) from book");

		if($stmt->execute() && $row = $stmt->fetch())
		{
			$BOOK_ID = $row[0] + 1;

			$stmt = $dbh->prepare("insert into book values (?, ?, ?, ?)");
			if(!$stmt->execute(array($BOOK_ID, $book['Title'], $book['Subtitle'], $book['PUBLISHER_ID'])))
			{
				$dbh->rollBack();
				throw new Exception($stmt->errorInfo()[2]);
			}

			$dbh->commit();

			return $BOOK_ID;
		}
		else
		{
			$dbh->rollBack();
			throw new Exception("Cannot determine the next BOOK_ID");
		}
	}

	public static function update(PDO $dbh, array $book): void
	{
		$stmt = $dbh->prepare("update book set ".
			"title = ?, ".
			"subTitle = ?, ".
			"PUBLISHER_ID = ? ".
			"where BOOK_ID = ?");
		
		if(!$stmt->execute(array($book['Title'], $book['Subtitle'], $book['PUBLISHER_ID'], $book['BOOK_ID'])))
			throw new Exception($stmt->errorInfo()[2]);
	}

	public static function delete(PDO $dbh, $BOOK_ID): void
	{
		$stmt = $dbh->prepare("delete from book where BOOK_ID = ?");
		if(!$stmt->execute(array($BOOK_ID)))
			throw new Exception($stmt->errorInfo()[2]);
	}
}
?>
