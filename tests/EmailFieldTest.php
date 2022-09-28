<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\EmailField;

class EmailFieldTest extends TestCase
{
	public function testValidEmail(): void
	{
		$emailField = new EmailField("Test", false);
		$emailField->importValue("foo@example.com");
		$this->assertTrue($emailField->checkField("Test"));
	}

	public function testInvalidEmail(): void
	{
		$emailField = new EmailField("Test", false);
		$emailField->importValue("invalid");
		$this->assertFalse($emailField->checkField("Test"));
	}
}
?>
