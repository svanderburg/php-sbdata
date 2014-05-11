<?php
/**
 * A form represents a collection of fields that together represent one object.
 */
class Form
{
	/** An associative array of fields that should be checked and displayed */ 
	public $fields;
	
	/**
	 * Constructs a new Form instance.
	 * 
	 * @param array $fields An associative array of fields that should be checked and displayed
	 */
	public function __construct(array $fields)
	{
		$this->fields = $fields;
	}
	
	/**
	 * Imports an array of values into the form fields.
	 * 
	 * @param array $values An associative array in which every key corresponds to a field and every value to a field value. 
	 */
	public function importValues(array $values)
	{
		foreach($this->fields as $name => $field)
		{
			if(array_key_exists($name, $values))
				$field->value = $values[$name];
		}
	}
	
	/**
	 * Clears the values in the form fields.
	 */
	public function clearValues()
	{
		foreach($this->fields as $name => $field)
			$field->value = NULL;
	}
	
	/**
	 * Checks whether the field values in the form are valid. 
	 */
	public function checkFields()
	{
		foreach($this->fields as $name => $field)
			$field->valid = $field->checkField($name);
	}
	
	/**
	 * Checks whether the form (including all its fields) are valid.
	 * This function should be called after Form::checkFields()
	 * 
	 * @return bool true if and only if all form values are valid
	 */
	public function checkValid()
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
	public function hasFileField()
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
