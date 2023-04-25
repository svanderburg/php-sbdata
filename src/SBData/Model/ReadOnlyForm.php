<?php
namespace SBData\Model;

/**
 * A read-only form represents a collection of fields that together represent one object.
 * A read-only form can be used to display data objects in a read-only manner.
 */
class ReadOnlyForm
{
	/** An associative array mapping field names to fields that should be checked and displayed */
	public array $fields;

	/**
	 * Constructs a new ReadOnlyForm instance.
	 *
	 * @param $fields An associative array mapping field names to fields that should be checked and displayed
	 */
	public function __construct(array $fields)
	{
		$this->fields = $fields;
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
}
?>
