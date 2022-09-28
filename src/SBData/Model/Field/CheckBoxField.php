<?php
namespace SBData\Model\Field;
use SBData\Model\Value\BooleanValue;

/**
 * Represents the structure of an individual data element containg a checked or unchecked state.
 */
class CheckBoxField extends Field
{
	/** Indicates whether the field should be initially checked or not */
	public bool $initiallyChecked;

	/**
	 * Constructs a new CheckBoxField instance
	 *
	 * @param $title Title of the field
	 * @param $initiallyChecked Indicates whether the field should be initially checked or not
	 * @param $checkedValue Value that will be set if the checkbox has been checked
	 */
	public function __construct(string $title, bool $initiallyChecked = false, string $checkedValue = "1")
	{
		parent::__construct($title, new BooleanValue($checkedValue));
		$this->initiallyChecked = $initiallyChecked;
	}
}
?>
