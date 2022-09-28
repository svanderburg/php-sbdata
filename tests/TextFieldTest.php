<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\TextField;
use SBData\Model\Field\RawTextField;
use SBData\Model\Field\PasswordField;
use SBData\Model\Field\TextAreaField;
use SBData\Model\Field\RawTextAreaField;

class TextFieldTest extends TestCase
{
	public function classesProvider(): array
	{
		return [
			["SBData\\Model\\Field\\TextField"],
			["SBData\\Model\\Field\\RawTextField"],
			["SBData\\Model\\Field\\PasswordField"],
			["SBData\\Model\\Field\\TextAreaField"],
			["SBData\\Model\\Field\\RawTextAreaField"]
		];
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testSuccessOnEmpty(string $className): void
	{
		$textField = new $className("Test", false);
		$textField->importValue("");
		$this->assertTrue($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testFailOnEmpty(string $className): void
	{
		$textField = new $className("Test", true);
		$textField->importValue("");
		$this->assertFalse($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testMaxLength(string $className): void
	{
		if(str_contains($className, "TextArea"))
			$textField = new $className("Test", true, 20, 20, 5);
		else
			$textField = new $className("Test", true, 5, 5);
		$textField->importValue("abcde");
		$this->assertTrue($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testExceedMaxLength(string $className): void
	{
		if(str_contains($className, "TextArea"))
			$textField = new $className("Test", true, 20, 20, 5);
		else
			$textField = new $className("Test", true, 5, 5);

		$textField->importValue("abcdef");
		$this->assertFalse($textField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testTrim(string $className): void
	{
		$textField = new $className("Test", true);
		$textField->importValue("  hello");
		$this->assertTrue($textField->checkField("Test"));

		if(str_contains($className, "Raw") || str_contains($className, "PasswordField")) // In raw fields trailing white spaces must be preserved, but in regular fields they should not
			$this->assertEquals($textField->exportValue(), "  hello");
		else
			$this->assertEquals($textField->exportValue(), "hello");
	}
}
?>
