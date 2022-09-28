<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\CheckBoxField;

class CheckBoxFieldTest extends TestCase
{
	public function testEnabled(): void
	{
		$checkBoxField = new CheckBoxField("Administrator rights", true, "admin");
		$checkBoxField->importValue("admin");
		$this->assertTrue($checkBoxField->checkField("Administrator"));
	}

	public function testDisabled(): void
	{
		$checkBoxField = new CheckBoxField("Administrator rights", true, "admin");
		$checkBoxField->importValue("");
		$this->assertTrue($checkBoxField->checkField("Administrator"));
	}

	public function testInvalid(): void
	{
		$checkBoxField = new CheckBoxField("Administrator rights", true, "admin");
		$checkBoxField->importValue("invalid"); // Invalid value
		$this->assertFalse($checkBoxField->checkField("Administrator"));
	}
}
?>
