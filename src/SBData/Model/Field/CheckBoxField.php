<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containg a checked or unchecked state.
 */
class CheckBoxField extends Field
{
	/** Value that will be set if the checkbox has been checked */
	public $checkedValue;

	/** Indicates whether the field should be initially checked or not */
	public $initiallyChecked;

	/**
	 * Constructs a new CheckBoxField instance
	 *
	 * @param string $title Title of the field
	 * @param bool $initialltyChecked Indicates whether the field should be initially checked or not
	 * @param string $checkedValue Value that will be set if the checkbox has been checked
	 */
	public function __construct($title, $initiallyChecked = false, $checkedValue = "1")
	{
		parent::__construct($title, true);
		$this->initiallyChecked = $initiallyChecked;
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
