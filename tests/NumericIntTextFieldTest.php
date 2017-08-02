<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\NumericIntTextField;

class NumericIntTextFieldTest extends TestCase
{
	public function testNumericValue()
	{
		$numericField = new NumericIntTextField("Test", false);
		$numericField->value = "123";
		$this->assertTrue($numericField->checkField("Test"));
	}

	public function testNonNumericValue()
	{
		$numericField = new NumericIntTextField("Test", true);
		$numericField->value = "invalid";
		$this->assertFalse($numericField->checkField("Test"));
	}
}
?>
