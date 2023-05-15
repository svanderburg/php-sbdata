<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\ReadOnlyForm;
use SBData\Model\Field\HiddenIntegerField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\ArrayTable;

class ArrayTableTest extends TestCase
{
	public function testArrayTable(): void
	{
		$table = new ArrayTable(array(
			"id" => new HiddenIntegerField("id", true),
			"firstname" => new TextField("First name", true),
			"lastname" => new TextField("Last name", true),
		));

		$table->setRows(array(
			array("id" => 1, "firstname" => "Sander", "lastname" => "van der Burg"),
			array("id" => 2, "firstname" => "John", "lastname" => "Doe")
		));

		// Check if we can iterate over two rows
		$table->iterator->rewind();

		$this->assertTrue($table->iterator->valid());
		$form = $table->iterator->current();
		$this->assertInstanceOf(ReadOnlyForm::class, $form);
		$table->iterator->next();

		$this->assertTrue($table->iterator->valid());
		$form = $table->iterator->current();
		$this->assertInstanceOf(ReadOnlyForm::class, $form);
		$table->iterator->next();

		$this->assertFalse($table->iterator->valid());
	}
}
