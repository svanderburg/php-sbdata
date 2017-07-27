<?php
namespace Examples\Books\Entity;
use Exception;
use PDO;

class Book
{
	public static function queryAll(PDO $dbh)
	{
		$stmt = $dbh->prepare("select * from book order by BOOK_ID");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
	
	public static function queryOne(PDO $dbh, $BOOK_ID)
	{
		$stmt = $dbh->prepare("select * from book where BOOK_ID = ?");
		if(!$stmt->execute(array($BOOK_ID)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
	
	public static function queryOnePublisher(PDO $dbh, $BOOK_ID)
	{
		$stmt = $dbh->prepare("select publisher.name from book inner join publisher on book.PUBLISHER_ID = publisher.PUBLISHER_ID where book.BOOK_ID = ?");
		if(!$stmt->execute(array($BOOK_ID)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
	
	public static function insert(PDO $dbh, array $book)
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
		}
		else
			$dbh->rollBack();
	}
	
	public static function update(PDO $dbh, array $book)
	{
		$stmt = $dbh->prepare("update book set ".
			"title = ?, ".
			"subTitle = ?, ".
			"PUBLISHER_ID = ? ".
			"where BOOK_ID = ?");
		
		if(!$stmt->execute(array($book['Title'], $book['Subtitle'], $book['PUBLISHER_ID'], $book['BOOK_ID'])))
			throw new Exception($stmt->errorInfo()[2]);
	}
	
	public static function delete(PDO $dbh, $BOOK_ID)
	{
		$stmt = $dbh->prepare("delete from book where BOOK_ID = ?");
		if(!$stmt->execute(array($BOOK_ID)))
			throw new Exception($stmt->errorInfo()[2]);
	}
}
?>
