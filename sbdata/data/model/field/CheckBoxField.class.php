<?php
require_once("Field.class.php");

/**
 * Represents the structure of an individual data element containg a checked or unchecked state.
 */
class CheckBoxField extends Field
{
	/** Value that will be set if the checkbox has been checked */
	public $checkedValue;

	/**
	 * Constructs a new CheckBoxField instance
	 * 
	 * @param string $title Title of the field
	 * @param bool Indicates whether the field should be initially checked or not
	 * @param string $checkedValue Value that will be set if the checkbox has been checked
	 */
	public function __construct($title, $checked = false, $checkedValue = "1")
	{
		parent::__construct($title, true);
		
		if($checked)
			$this->value = $checkedValue;
		
		$this->checkedValue = $checkedValue;
	}
	
	/**
	 * @see Field::checkField()
	 */
	public function checkField($name)
	{
		$this->value = trim($this->value); // Trim whitespace that comes in front and after the input
		return($this->value == "" || $this->value == $this->checkedValue); // Value should be empty or the "checked value"
	}
}
?>
