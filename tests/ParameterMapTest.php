<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\ParameterMap;
use SBData\Model\Value\EmailValue;
use SBData\Model\Value\SaneStringValue;

class ParameterMapTest extends TestCase
{
	public function testValidParameterMap(): void
	{
		$map = new ParameterMap(array(
			"name" => new SaneStringValue(true),
			"email" => new EmailValue(true)
		));
		$map->importValues(array(
			"name" => "John Doe",
			"email" => "john@example.com"
		));
		$map->checkValues();
		$this->assertTrue($map->checkValid());
	}

	public function testInvalidParameterMap(): void
	{
		$map = new ParameterMap(array(
			"name" => new SaneStringValue(true),
			"email" => new EmailValue(true)
		));
		$map->importValues(array(
			"name" => "John Doe",
			"email" => "invalid" // This is an invalid email address
		));
		$map->checkValues();
		$this->assertFalse($map->checkValid());
	}
}
?>
