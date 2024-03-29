<?php
namespace SBData\Model;
use SBData\Model\Field\FileField;
use SBData\Model\Label\Label;
use SBData\Model\Label\TextLabel;

/**
 * A form represents a collection of fields that together represent one object.
 * A form can be used to check and display data objects in read and write mode.
 */
class Form extends ReadOnlyForm
{
	/** Action URL where the user gets redirected to (defaults to same page if null) */
	public ?string $actionURL;

	/** Label to be displayed on the submit button */
	public Label $submitLabel;

	/** Error message displayed on form level when a field is invalid */
	public string $validationErrorMessage;

	/** Error message displayed for an invalid field */
	public string $fieldErrorMessage;

	/**
	 * Constructs a new Form instance.
	 *
	 * @param $fields An associative array mapping field names to fields that should be checked and displayed
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $submitLabel Label to be displayed on the submit button
	 * @param $validationErrorMessage Error message displayed on form level when a field is invalid
	 * @param $fieldErrorMessage Error message displayed for an invalid field
	 */
	public function __construct(array $fields, string $actionURL = null, Label $submitLabel = null, string $validationErrorMessage = "One or more fields are invalid and marked with a red color", string $fieldErrorMessage = "This value is incorrect!")
	{
		parent::__construct($fields);
		$this->actionURL = $actionURL;

		if($submitLabel === null)
			$this->submitLabel = new TextLabel("Submit");
		else
			$this->submitLabel = $submitLabel;

		$this->validationErrorMessage = $validationErrorMessage;
		$this->fieldErrorMessage = $fieldErrorMessage;
	}

	/**
	 * Clears the values in the form fields.
	 */
	public function clearValues(): void
	{
		foreach($this->fields as $name => $field)
			$field->clearValue();
	}
	
	/**
	 * Exports the field values to an associative array having the same keys.
	 *
	 * @return An associative array with values
	 */
	public function exportValues(): array
	{
		$values = array();

		foreach($this->fields as $key => $field)
			$values[$key] = $field->exportValue();

		return $values;
	}
	
	/**
	 * Checks whether the field values in the form are valid.
	 */
	public function checkFields(): void
	{
		foreach($this->fields as $name => $field)
			$field->value->valid = $field->checkField($name);
	}
	
	/**
	 * Checks whether the form (including all its fields) are valid.
	 * This function should be called after Form::checkFields()
	 *
	 * @return true if and only if all form values are valid
	 */
	public function checkValid(): bool
	{
		foreach($this->fields as $name => $field)
		{
			if(!$field->isValid())
				return false;
		}
		
		return true;
	}
	
	/**
	 * Returns true if and only if the form has a FileField.
	 *
	 * @return true if and only if the form has a FileField
	 */
	public function hasFileField(): bool
	{
		$hasFileField = false;
	
		foreach($this->fields as $name => $field)
		{
			if($field instanceof FileField)
			{
				$hasFileField = true;
				break;
			}
		}
	
		return $hasFileField;
	}
}
?>
