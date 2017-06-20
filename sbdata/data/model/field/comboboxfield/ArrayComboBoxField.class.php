<?php
require_once(dirname(__FILE__)."/../TextField.class.php");

/**
 * Represents the structure of an individual data element that should be displayed as a combo box
 * which data is retrieved from an array of objects.
 */
class ArrayComboBoxField extends TextField
{
	/** An associative array which key represents to the option value and the value to the text being displayed */ 
	public $values;
	
	/**
	 * Constructs a new ArrayComboBoxField instance.
	 * 
	 * @param string $title Title of the field
	 * @param array $values An array in which the keys correspond to the input names and values to their descriptions
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct($title, array $values, $mandatory = false)
	{
		parent::__construct($title, $mandatory);
		$this->values = $values;
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField($name)
	{
		return array_key_exists($this->value, $this->values);
	}
}
?>
