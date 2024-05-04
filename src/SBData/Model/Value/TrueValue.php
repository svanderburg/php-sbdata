<?php
namespace SBData\Model\Value;

/**
 * A boolean value that is only valid when it is true
 */
class TrueValue extends BooleanValue
{
	/**
	 * Constructs a new TrueValue instance.
	 *
	 * @param $checkedValue The string value that corresponds to: true
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string $checkedValue = "1", int $maxlength = null)
	{
		parent::__construct($checkedValue, $maxlength, false);
	}

	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		return $this->value == $this->checkedValue;
	}
}
?>
