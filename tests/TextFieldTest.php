<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\TextField;

class TextFieldTest extends TestCase
{
	public function testSuccessOnEmpty()
	{
		$textField = new TextField("Test", false);
		$textField->value = "";
		$this->assertTrue($textField->checkField("Test"));
	}

	public function testFailOnEmpty()
	{
		$textField = new TextField("Test", true);
		$textField->value = "";
		$this->assertFalse($textField->checkField("Test"));
	}

	public function testMaxLength()
	{
		$textField = new TextField("Test", true, 5, 5);
		$textField->value = "abcde";
		$this->assertTrue($textField->checkField("Test"));
	}

	public function testExceedMaxLength()
	{
		$textField = new TextField("Test", true, 5, 5);
		$textField->value = "abcdef";
		$this->assertFalse($textField->checkField("Test"));
	}

	public function testTrim()
	{
		$textField = new TextField("Test", true);
		$textField->value = "  hello";
		$this->assertTrue($textField->checkField("Test"));
		$this->assertEquals($textField->value, "hello");
	}
}
?>
