<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\HiddenNumericIntField;

class HiddenNumericIntFieldTest extends TestCase
{
	public function testNumericValue(): void
	{
		$numericField = new HiddenNumericIntField(false);
		$numericField->importValue("123");
		$this->assertTrue($numericField->checkField("Test"));
	}

	public function testNonNumericValue(): void
	{
		$numericField = new HiddenNumericIntField(true);
		$numericField->importValue("invalid");
		$this->assertFalse($numericField->checkField("Test"));
	}
}
?>
