<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Form;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\ArrayTable;

class ArrayTableTest extends TestCase
{
	public function testArrayTable()
	{
		$table = new ArrayTable(array(
			"id" => new HiddenField("id", true),
			"firstname" => new TextField("First name", true),
			"lastname" => new TextField("Last name", true),
		));

		$table->setRows(array(
			array("id" => 1, "firstname" => "Sander", "lastname" => "van der Burg"),
			array("id" => 2, "firstname" => "John", "lastname" => "Doe")
		));

		// Check if we can iterate over two rows
		$form = $table->fetchForm();
		$this->assertInstanceOf(Form::class, $form);

		$form = $table->fetchForm();
		$this->assertInstanceOf(Form::class, $form);

		$form = $table->fetchForm();
		$this->assertNull($form);
	}
}
