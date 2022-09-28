<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\ComboBoxField\DBComboBoxField;

class DBComboBoxFieldTest extends TestCase
{
	private static PDO $dbh;

	public static function setUpBeforeClass(): void
	{
		self::$dbh = new PDO("sqlite:./dbcombobox.sqlite");
		self::$dbh->query("create table numbers ( id string, value string, primary key(id) )");
		self::$dbh->query("insert into numbers values ('one', 'One')");
		self::$dbh->query("insert into numbers values ('two', 'Two')");
		self::$dbh->query("insert into numbers values ('three', 'Three')");
	}

	private static function queryIdValuePairs(): PDOStatement
	{
		return self::$dbh->query("select id, value from numbers order by id");
	}

	public function testSuccessOnEmpty(): void
	{
		$comboBoxField = new DBComboBoxField("Test", $this->queryIdValuePairs(), false);
		$comboBoxField->importValue("");
		$this->assertTrue($comboBoxField->checkField("Test"));
	}

	public function testFailureOnEmpty(): void
	{
		$comboBoxField = new DBComboBoxField("Test", $this->queryIdValuePairs(), true);
		$comboBoxField->importValue("");
		$this->assertFalse($comboBoxField->checkField("Test"));
	}
}
?>
