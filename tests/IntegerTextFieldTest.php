<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\Field;
use SBData\Model\Field\IntegerTextField;
use SBData\Model\Field\HiddenIntegerField;
use SBData\Model\Field\IntegerKeyLinkField;

class IntegerTextFieldTest extends TestCase
{
	public function classesProvider(): array
	{
		return [
			["SBData\\Model\\Field\\IntegerTextField"],
			["SBData\\Model\\Field\\HiddenIntegerField"],
			["SBData\\Model\\Field\\IntegerKeyLinkField"]
		];
	}

	private function constructField(string $className, bool $mandatory, int $minValue = null, int $maxValue = null): Field
	{
		if(str_contains($className, "Hidden"))
			return new $className($mandatory, null, null, $minValue, $maxValue);
		else if(str_contains($className, "KeyLink"))
			return new $className("Test", "displayLink", $mandatory, null, null, $minValue, $maxValue);
		else
			return new $className("Test", $mandatory, 20, null, null, $minValue, $maxValue);
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

	/**
	 * @dataProvider classesProvider
	 */
	public function testValidRange(string $className): void
	{
		$numericField = $this->constructField($className, true, 2, 10);
		$numericField->importValue("5");
		$this->assertTrue($numericField->checkField("Test"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testInvalidRange(string $className): void
	{
		$numericField = $this->constructField($className, true, 2, 10);
		$numericField->importValue("15"); // Outside the range
		$this->assertFalse($numericField->checkField("Test"));
	}
}
?>
