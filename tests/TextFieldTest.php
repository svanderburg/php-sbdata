<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\TextField;
use SBData\Model\Field\PasswordField;
use SBData\Model\Field\TextAreaField;

class TextFieldTest extends TestCase
{
	public function classesProvider(): array
	{
		return [
			["SBData\\Model\\Field\\TextField"],
			["SBData\\Model\\Field\\PasswordField"],
			["SBData\\Model\\Field\\TextAreaField"]
		];
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testSuccessOnEmpty(string $className): void
	{
		$textField = new $className("Test", false);
		$textField->value = "";
		$this->assertTrue($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testFailOnEmpty(string $className): void
	{
		$textField = new TextField("Test", true);
		$textField->value = "";
		$this->assertFalse($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testMaxLength(string $className): void
	{
		$textField = new TextField("Test", true, 5, 5);
		$textField->value = "abcde";
		$this->assertTrue($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testExceedMaxLength(string $className): void
	{
		$textField = new TextField("Test", true, 5, 5);
		$textField->value = "abcdef";
		$this->assertFalse($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testTrim(string $className): void
	{
		$textField = new TextField("Test", true);
		$textField->value = "  hello";
		$this->assertTrue($textField->checkField("Test"));
		$this->assertEquals($textField->value, "hello");
	}
}
?>
