<?php
namespace SBData\Model\Field;
use SBData\Model\Value\IntegerValue;

/**
 * Represents the structure of an individual data element that stores an integer
 * value and is kept hidden from the user but still propagates a parameter to a
 * form.
 */
class HiddenIntegerField extends GenericHiddenField
{
	/**
	 * Constructs a new HiddenIntegerField instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $minValue Specifies the minimum value that is allowed or null if there is no lower boundary (defaults to null)
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, $defaultValue = null, int $minValue = null, int $maxValue = null)
	{
		parent::__construct(new IntegerValue($mandatory, $maxlength, $defaultValue, $minValue, $maxValue));
	}
}
?>
