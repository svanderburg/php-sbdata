<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Field\IPAddressField;

class IPAddressFieldTest extends TestCase
{
	public function testValidIPv4Address(): void
	{
		$ipField = new IPAddressField("Test");
		$ipField->importValue("127.0.0.1");
		$this->assertTrue($ipField->checkField("Test"));
	}

	public function testValidIPv6Address(): void
	{
		$ipField = new IPAddressField("Test");
		$ipField->importValue("::1");
		$this->assertTrue($ipField->checkField("Test"));
	}

	public function testInvalidIPv4Address(): void
	{
		$ipField = new IPAddressField("Test");
		$ipField->importValue("256.0.0.1"); // First byte is too high
		$this->assertFalse($ipField->checkField("Test"));
	}
}
?>
