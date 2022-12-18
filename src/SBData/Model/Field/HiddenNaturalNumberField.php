<?php
namespace SBData\Model\Field;
use SBData\Model\Value\NaturalNumberValue;

/**
 * Represents the structure of an individual data element that stores a natural
 * number value and is kept hidden from the user but still propagates a
 * parameter to a form.
 */
class HiddenNaturalNumberField extends GenericHiddenField
{
	/**
	 * Constructs a new HiddenNaturalNumberField instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, $defaultValue = null, int $maxValue = null)
	{
		parent::__construct(new NaturalNumberValue($mandatory, $maxlength, $defaultValue, $maxValue));
	}
}
?>
