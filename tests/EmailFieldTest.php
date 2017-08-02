<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\EmailField;

class EmailFieldTest extends TestCase
{
	public function testValidEmail()
	{
		$emailField = new EmailField("Test", false);
		$emailField->value = "foo@example.com";
		$this->assertTrue($emailField->checkField("Test"));
	}

	public function testInvalidEmail()
	{
		$emailField = new EmailField("Test", false);
		$emailField->value = "invalid";
		$this->assertFalse($emailField->checkField("Test"));
	}
}
?>
