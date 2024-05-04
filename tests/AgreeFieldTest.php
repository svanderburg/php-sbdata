<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\AgreeField;

class AgreeFieldTest extends TestCase
{
	public function testEnabled(): void
	{
		$agreeField = new AgreeField("I agree");
		$agreeField->importValue("1");
		$this->assertTrue($agreeField->checkField("I agree"));
	}

	public function testDisabled(): void
	{
		$agreeField = new AgreeField("I agree");
		$agreeField->importValue("");
		$this->assertFalse($agreeField->checkField("I agree"));
	}

	public function testInvalid(): void
	{
		$agreeField = new AgreeField("I agree");
		$agreeField->importValue("invalid"); // Invalid value
		$this->assertFalse($agreeField->checkField("I agree"));
	}
}
?>
