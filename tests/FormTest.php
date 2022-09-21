<?php
require_once(dirname(__FILE__)."/../vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use SBData\Model\Form;
use SBData\Model\Field\TextField;
use SBData\Model\Field\EmailField;

class FormTest extends TestCase
{
	public function testValidForm(): void
	{
		$form = new Form(array(
			"name" => new TextField("Name", true),
			"email" => new EmailField("Email", true)
		));
		$form->importValues(array(
			"name" => "John Doe",
			"email" => "john@example.com"
		));
		$form->checkFields();
		$this->assertTrue($form->checkValid());
	}

	public function testInvalidForm(): void
	{
		$form = new Form(array(
			"name" => new TextField("Name", true),
			"email" => new EmailField("Email", true)
		));
		$form->importValues(array(
			"name" => "John Doe",
			"email" => "invalid" // This is an invalid email address
		));
		$form->checkFields();
		$this->assertFalse($form->checkValid());
	}
}
?>
