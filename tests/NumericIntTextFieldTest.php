<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\Field;
use SBData\Model\Field\NumericIntTextField;
use SBData\Model\Field\HiddenNumericField;
use SBData\Model\Field\NumericIntKeyLinkField;

class NumericIntTextFieldTest extends TestCase
{
	public function classesProvider(): array
	{
		return [
			["SBData\\Model\\Field\\NumericIntTextField"],
			["SBData\\Model\\Field\\HiddenNumericIntField"],
			["SBData\\Model\\Field\\NumericIntKeyLinkField"]
		];
	}

	private function constructField(string $className, bool $mandatory): Field
	{
		if(str_contains($className, "Hidden"))
			return new $className($mandatory);
		else if(str_contains($className, "KeyLink"))
			return new $className("Test", "displayLink", $mandatory);
		else
			return new $className("Test", $mandatory);
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testNumericValue(string $className): void
	{
		$numericField = $this->constructField($className, false);
		$numericField->importValue("123");
		$this->assertTrue($numericField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testNonNumericValue(string $className): void
	{
		$numericField = $this->constructField($className, true);
		$numericField->importValue("invalid");
		$this->assertFalse($numericField->checkField("Test"));
	}
}
?>
