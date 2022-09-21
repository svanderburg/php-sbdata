<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\DateField;

class DateFieldTest extends TestCase
{
	public function testValidDate(): void
	{
		$dateField = new DateField("Test", false);
		$dateField->value = "2010-01-01";
		$this->assertTrue($dateField->checkField("Test"));
	}

	public function testInvalidDate(): void
	{
		$dateField = new DateField("Test", false);
		$dateField->value = "invalid";
		$this->assertFalse($dateField->checkField("Test"));
	}
}
?>
