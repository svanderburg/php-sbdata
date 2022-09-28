<?php
namespace SBData\Model;
use SBData\Model\Field\FileField;

/**
 * A form represents a collection of fields that together represent one object.
 */
class Form
{
	/** An associative array mapping field names to fields that should be checked and displayed */
	public array $fields;

	/** Action URL where the user gets redirected to (defaults to same page if null) */
	public ?string $actionURL;

	/**
	 * Constructs a new Form instance.
	 *
	 * @param $fields An associative array mapping field names to fields that should be checked and displayed
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 */
	public function __construct(array $fields, string $actionURL = null)
	{
		$this->fields = $fields;
		$this->actionURL = $actionURL;
	}
	
	/**
	 * Imports an array of values into the form fields.
	 *
	 * @param $values An associative array in which every key corresponds to a field and every value to a field value.
	 */
	public function importValues(array $values): void
	{
		foreach($this->fields as $name => $field)
		{
			if(array_key_exists($name, $values))
				$field->importValue($values[$name]);
		}
	}
	
	/**
	 * Clears the values in the form fields.
	 */
	public function clearValues(): void
	{
		foreach($this->fields as $name => $field)
			$field->value = NULL;
	}
	
	/**
	 * Exports the field values to an associative array having the same keys.
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
			$field->valid = $field->checkField($name);
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
			if(!$field->valid)
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
