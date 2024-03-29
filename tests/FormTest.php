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

	public function testValues(): void
	{
		$form = new Form(array(
			"name" => new TextField("Name", true),
			"email" => new EmailField("Email", true),
			"comment" => new TextField("Comment", true, 20, null, "Test case")
		));
		$form->importValues(array(
			"name" => "John Doe",
			"email" => "john@example.com"
		));

		$this->assertTrue($form->fields["name"]->exportValue() === "John Doe");
		$this->assertTrue($form->fields["email"]->exportValue() === "john@example.com");
		$this->assertTrue($form->fields["comment"]->exportValue() === "Test case");

		$form->clearValues();
		$this->assertTrue($form->fields["name"]->exportValue() === null);
		$this->assertTrue($form->fields["email"]->exportValue() === null);
		$this->assertTrue($form->fields["comment"]->exportValue() === "Test case");
	}
}
?>
