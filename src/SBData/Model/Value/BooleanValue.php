<?php
namespace SBData\Model\Value;

/**
 * Stores a boolean value checks whether it has been specified correctly.
 * true corresponds to a predefined string, false to an empty string.
 */
class BooleanValue extends SaneStringValue
{
	/** Value that will be set if the boolean value is true */
	public string $checkedValue;

	/**
	 * Constructs a new BooleanValue instance.
	 *
	 * @param $checkedValue The string value that corresponds to: true
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string $checkedValue = "1", int $maxlength = null)
	{
		parent::__construct(false, $maxlength);
		$this->checkedValue = $checkedValue;
	}

	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		if(!parent::checkValue($name))
			return false;

		return($this->value == "" || $this->value == $this->checkedValue);
	}
}
?>
