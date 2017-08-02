<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\URLField;

class URLFieldTest extends TestCase
{
	public function testValidURL()
	{
		$urlField = new URLField("Test", false);
		$urlField->value = "http://example.com";
		$this->assertTrue($urlField->checkField("Test"));
	}

	public function testInvalidURL()
	{
		$urlField = new URLField("Test", false);
		$urlField->value = "invalid";
		$this->assertFalse($urlField->checkField("Test"));
	}
}
?>
