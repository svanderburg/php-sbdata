<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\DutchZipCodeField;

class DutchZipCodeFieldTest extends TestCase
{
	public function testValidZipCode(): void
	{
		$zipCodeField = new DutchZipCodeField("Test", false);
		$zipCodeField->importValue("1221ZA");
		$this->assertTrue($zipCodeField->checkField("Test"));
	}

	public function testInvalidZipCode(): void
	{
		$zipCodeField = new DutchZipCodeField("Test", false);
		$zipCodeField->importValue("P1234A");
		$this->assertFalse($zipCodeField->checkField("Test"));
	}
}
?>
