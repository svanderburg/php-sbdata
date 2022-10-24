<?php
namespace SBData\Model\Field;
use SBData\Model\Value\IntegerValue;

/**
 * Represents the structure of an individual data element containing  numeric values that should be displayed as a text field.
 */
class NumericIntTextField extends GenericTextField
{
	/**
	 * Constructs a new NumericIntTextField instance.
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $minValue Specifies the minimum value that is allowed or null if there is no lower boundary (defaults to null)
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, int $maxlength = null, $defaultValue = null, int $minValue = null, int $maxValue = null)
	{
		parent::__construct($title, new IntegerValue($mandatory, $maxlength, $defaultValue, $minValue, $maxValue), $size);
	}
}
