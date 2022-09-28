<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\ComboBoxField\ArrayComboBoxField;

class ArrayComboBoxFieldTest extends TestCase
{
	public function testSuccessOnEmpty(): void
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), false);
		$comboBoxField->importValue("");
		$this->assertTrue($comboBoxField->checkField("Test"));
	}

	public function testFailureOnEmpty(): void
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), true);
		$comboBoxField->importValue("");
		$this->assertFalse($comboBoxField->checkField("Test"));
	}

	public function testValidOption(): void
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), true);
		$comboBoxField->importValue("two");
		$this->assertTrue($comboBoxField->checkField("Test"));
	}

	public function testInvalidOption(): void
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), true);
		$comboBoxField->importValue("nonexistent");
		$this->assertFalse($comboBoxField->checkField("Test"));
	}
}
?>
