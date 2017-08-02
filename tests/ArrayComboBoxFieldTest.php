<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\ComboBoxField\ArrayComboBoxField;

class ArrayComboBoxFieldTest extends TestCase
{
	public function testSuccessOnEmpty()
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), false);
		$comboBoxField->value = "";
		$this->assertTrue($comboBoxField->checkField("Test"));
	}

	public function testFailureOnEmpty()
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), true);
		$comboBoxField->value = "";
		$this->assertFalse($comboBoxField->checkField("Test"));
	}

	public function testValidOption()
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), true);
		$comboBoxField->value = "two";
		$this->assertTrue($comboBoxField->checkField("Test"));
	}

	public function testInvalidOption()
	{
		$comboBoxField = new ArrayComboBoxField("Test", array("one" => "One", "two" => "Two", "three" => "Three"), true);
		$comboBoxField->value = "nonexistent";
		$this->assertFalse($comboBoxField->checkField("Test"));
	}
}
?>
