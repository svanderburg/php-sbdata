<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use SBData\Model\Field\Field;
use SBData\Model\Field\NaturalNumberTextField;
use SBData\Model\Field\HiddenNaturalNumberField;
use SBData\Model\Field\NaturalNumberKeyLinkField;

class NaturalNumberTextFieldTest extends TestCase
{
	public static function classesProvider(): array
	{
		return [
			["SBData\\Model\\Field\\NaturalNumberTextField"],
			["SBData\\Model\\Field\\HiddenNaturalNumberField"],
			["SBData\\Model\\Field\\NaturalNumberKeyLinkField"]
		];
	}

	private function constructField(string $className, bool $mandatory): Field
	{
		if(str_contains($className, "Hidden"))
			return new $className($mandatory);
		else if(str_contains($className, "KeyLink"))
			return new $className("Test", "displayLink", $mandatory);
		else
			return new $className("Test", $mandatory, 20);
	}

	#[DataProvider('classesProvider')]
	public function testNumericValue(string $className): void
	{
		$numericField = $this->constructField($className, false);
		$numericField->importValue("123");
		$this->assertTrue($numericField->checkField("Test"));
	}

	#[DataProvider('classesProvider')]
	public function testInvalidNumericValue(string $className): void
	{
		$numericField = $this->constructField($className, false);
		$numericField->importValue("-123"); // A negative number is not a natural number
		$this->assertFalse($numericField->checkField("Test"));
	}

	#[DataProvider('classesProvider')]
	public function testNonNumericValue(string $className): void
	{
		$numericField = $this->constructField($className, true);
		$numericField->importValue("invalid");
		$this->assertFalse($numericField->checkField("Test"));
	}
}
?>
