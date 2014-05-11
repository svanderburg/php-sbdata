<?php
class Book
{
	public $BOOK_ID;
	
	public $title;
	
	public $subTitle;
	
	public $PUBLISHER_ID;

	public static function queryAll(PDO $dbh)
	{
		$stmt = $dbh->prepare("select * from book order by BOOK_ID");
		$stmt->execute();
		return $stmt;
	}
	
	public static function queryOne(PDO $dbh, $BOOK_ID)
	{
		$stmt = $dbh->prepare("select * from book where BOOK_ID = ?");
		if($stmt->execute(array($BOOK_ID)) && $row = $stmt->fetch())
		{
			$book = new Book();
			$book->BOOK_ID = $row["BOOK_ID"];
			$book->title = $row["title"];
			$book->subTitle = $row["subTitle"];
			$book->PUBLISHER_ID = $row["PUBLISHER_ID"];
			
			return $book;
		}
		else
			throw new Exception("Cannot select book with id: ".$BOOK_ID);
	}
	
	public static function queryOnePublisher(PDO $dbh, $BOOK_ID)
	{
		$stmt = $dbh->prepare("select publisher.name from book inner join publisher on book.PUBLISHER_ID = publisher.PUBLISHER_ID where book.BOOK_ID = ?");
		$stmt->execute(array($BOOK_ID));
		return $stmt;
	}
	
	public function insert(PDO $dbh)
	{
		$dbh->beginTransaction();
		
		$stmt = $dbh->prepare("select max(BOOK_ID) from book");
		
		if($stmt->execute() && $row = $stmt->fetch())
		{
			$this->BOOK_ID = $row[0] + 1;
			
			$stmt = $dbh->prepare("insert into book values (?, ?, ?, ?)");
			$stmt->execute(array($this->BOOK_ID, $this->title, $this->subTitle, $this->PUBLISHER_ID));
			
			$dbh->commit();
		}
		else
			$dbh->rollBack();
	}
	
	public function update(PDO $dbh)
	{
		$stmt = $dbh->prepare("update book set ".
		    "title = ?, ".
		    "subTitle = ?, ".
			"PUBLISHER_ID = ? ".
			"where BOOK_ID = ?");
		
		$stmt->execute(array($this->title, $this->subTitle, $this->PUBLISHER_ID, $this->BOOK_ID));
	}
	
	public function delete(PDO $dbh)
	{
		$stmt = $dbh->prepare("delete from book where BOOK_ID = ?");
		$stmt->execute(array($this->BOOK_ID));
	}
}
?>
