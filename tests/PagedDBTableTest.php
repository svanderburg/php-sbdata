<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\ParameterMap;
use SBData\Model\Value\IntegerValue;
use SBData\Model\Form;
use SBData\Model\Field\HiddenNumericIntField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\PagedDBTable;

class PagedDBTableTest extends TestCase
{
	private static PDO $dbh;

	public static function setUpBeforeClass(): void
	{
		self::$dbh = new PDO("sqlite:./pageddbtable.sqlite");
		self::$dbh->query("create table characters ( id integer, character string, primary key(id) )");
		self::$dbh->query("insert into characters values (1, 'A')");
		self::$dbh->query("insert into characters values (2, 'B')");
		self::$dbh->query("insert into characters values (3, 'C')");
		self::$dbh->query("insert into characters values (4, 'D')");
		self::$dbh->query("insert into characters values (5, 'E')");
		self::$dbh->query("insert into characters values (6, 'F')");
		self::$dbh->query("insert into characters values (7, 'G')");
		self::$dbh->query("insert into characters values (8, 'H')");
		self::$dbh->query("insert into characters values (9, 'I')");
		self::$dbh->query("insert into characters values (10, 'J')");
		self::$dbh->query("insert into characters values (11, 'K')");
		self::$dbh->query("insert into characters values (12, 'L')");
		self::$dbh->query("insert into characters values (13, 'M')");
		self::$dbh->query("insert into characters values (14, 'N')");
	}

	private static function queryNumOfItems(PDO $dbh, int $pageSize): int
	{
		$stmt = $dbh->prepare("select COUNT(*) from characters");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		if(($row = $stmt->fetch()) === false)
			return 0;
		else
			return (int)($row[0]);
	}

	public function testPagedDBTable(): void
	{
		/* Define a page param (page 1) */
		$requestMap = new ParameterMap(array(
			"page" => new IntegerValue(false, null, 0)
		));

		$requestMap->importValues(array(
			"page" => 1
		));

		/* Create a paged database table */
		$pageSize = 3;

		function queryNumOfPages(PDO $dbh, int $pageSize): int
		{
			return ceil(queryNumOfItems($dbh) / $pageSize);
		}

		$table = new PagedDBTable(array(
			"id" => new HiddenNumericIntField("id", true),
			"character" => new TextField("Character", true),
		), self::$dbh, $pageSize, "queryNumOfPages", $requestMap);

		/* Query the data and attach the statement to the table */
		$page = $requestMap->values["page"]->value;
		$offset = (int)($page * $pageSize);

		$stmt = self::$dbh->prepare("select * from characters order by id limit ?, ?");
		$stmt->bindParam(1, $offset, PDO::PARAM_INT);
		$stmt->bindParam(2, $pageSize, PDO::PARAM_INT);

		$stmt->execute();

		$table->stmt = $stmt;

		/* Check if the values are from the second page */
		$form = $table->nextForm();
		$this->assertInstanceOf(Form::class, $form);
		$this->assertTrue($form->fields["character"]->exportValue() == "D");

		$form = $table->nextForm();
		$this->assertInstanceOf(Form::class, $form);
		$this->assertTrue($form->fields["character"]->exportValue() == "E");

		$form = $table->nextForm();
		$this->assertInstanceOf(Form::class, $form);
		$this->assertTrue($form->fields["character"]->exportValue() == "F");

		/* Check if we have reached the end of the page */
		$form = $table->nextForm();
		$this->assertNull($form);
	}
}
