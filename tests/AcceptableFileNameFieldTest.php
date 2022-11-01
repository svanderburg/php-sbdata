<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use SBData\Model\Field\AcceptableFileNameField;
use PHPUnit\Framework\TestCase;

class AcceptableFileNameFieldTest extends TestCase
{
	public function testValidFileName(): void
	{
		$field = new AcceptableFileNameField("filename", true, 20, 255);
		$field->importValue("validfile.txt");
		$this->assertTrue($field->checkField("filename"));
	}

	public function testInvalidUNIXFileName(): void
	{
		$field = new AcceptableFileNameField("filename", true, 20, 255);
		$field->importValue("/etc/sensitivefile.txt"); // Contains a /
		$this->assertFalse($field->checkField("filename"));
	}

	public function testInvalidWindowsFileName(): void
	{
		$field = new AcceptableFileNameField("filename", true, 20, 255);
		$field->importValue("my disallowed\nfile"); // Contains control character (linefeed) that is not allowed
		$this->assertFalse($field->checkField("filename"));
	}

	public function testInvalidWindowsFileName2(): void
	{
		$field = new AcceptableFileNameField("filename", true, 20, 255);
		$field->importValue("my disallowed>file"); // Contains special character > that is not allowed
		$this->assertFalse($field->checkField("filename"));
	}

	public function testInvalidWindowsFileName3(): void
	{
		$field = new AcceptableFileNameField("filename", true, 20, 255);
		$field->importValue("prn"); // Refers to the PRN special file
		$this->assertFalse($field->checkField("filename"));
	}

	public function testParentDirectory(): void
	{
		$field = new AcceptableFileNameField("filename", true, 20, 255);
		$field->importValue(".."); // Refers to the parent directory
		$this->assertFalse($field->checkField("filename"));
	}
}
?>
