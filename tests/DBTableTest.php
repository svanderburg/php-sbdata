<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Form;
use SBData\Model\Field\HiddenIntegerField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\DBTable;

class DBTableTest extends TestCase
{
	private static PDO $dbh;

	public static function setUpBeforeClass(): void
	{
		self::$dbh = new PDO("sqlite:./dbtable.sqlite");
		self::$dbh->query("create table persons ( id integer, firstname string, lastname string, primary key(id) )");
		self::$dbh->query("insert into persons values (1, 'Sander', 'van der Burg')");
		self::$dbh->query("insert into persons values (2, 'John', 'Doe')");
	}

	public function testDBTable(): void
	{
		$table = new DBTable(array(
			"id" => new HiddenIntegerField("id", true),
			"firstname" => new TextField("First name", true),
			"lastname" => new TextField("Last name", true),
		));

		$table->stmt = self::$dbh->query("select * from persons");

		// Check if we can iterate over two rows
		$form = $table->nextForm();
		$this->assertInstanceOf(Form::class, $form);

		$form = $table->nextForm();
		$this->assertInstanceOf(Form::class, $form);

		$form = $table->nextForm();
		$this->assertNull($form);
	}
}
