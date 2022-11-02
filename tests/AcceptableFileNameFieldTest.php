<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use SBData\Model\Field\Field;
use SBData\Model\Field\AcceptableFileNameField;
use SBData\Model\Field\HiddenAcceptableFileNameField;
use PHPUnit\Framework\TestCase;

class AcceptableFileNameFieldTest extends TestCase
{
	public function classesProvider(): array
	{
		return [
			["SBData\\Model\\Field\\AcceptableFileNameField"],
			["SBData\\Model\\Field\\HiddenAcceptableFileNameField"]
		];
	}

	private function constructField(string $className, bool $mandatory, int $maxlength): Field
	{
		if(str_contains($className, "Hidden"))
			return new $className($mandatory, $maxlength);
		else
			return new $className("filename", $mandatory, 20, $maxlength);
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testValidFileName(string $className): void
	{
		$field = $this->constructField($className, true, 255);
		$field->importValue("validfile.txt");
		$this->assertTrue($field->checkField("filename"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testInvalidUNIXFileName(string $className): void
	{
		$field = $this->constructField($className, true, 255);
		$field->importValue("/etc/sensitivefile.txt"); // Contains a /
		$this->assertFalse($field->checkField("filename"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testInvalidWindowsFileName(string $className): void
	{
		$field = $this->constructField($className, true, 255);
		$field->importValue("my disallowed\nfile"); // Contains a control character (linefeed) that is not allowed
		$this->assertFalse($field->checkField("filename"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testInvalidWindowsFileName2(string $className): void
	{
		$field = $this->constructField($className, true, 255);
		$field->importValue("my disallowed>file"); // Contains a special character > that is not allowed
		$this->assertFalse($field->checkField("filename"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testInvalidWindowsFileName3(string $className): void
	{
		$field = $this->constructField($className, true, 255);
		$field->importValue("prn"); // Refers to the PRN special file
		$this->assertFalse($field->checkField("filename"));
	}

	/**
	 * @dataProvider classesProvider
	 */
	public function testParentDirectory(string $className): void
	{
		$field = $this->constructField($className, true, 255);
		$field->importValue(".."); // Refers to the parent directory
		$this->assertFalse($field->checkField("filename"));
	}
}
?>
