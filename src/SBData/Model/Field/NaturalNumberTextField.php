<?php
namespace SBData\Model\Field;
use SBData\Model\Value\NaturalNumberValue;

/**
 * Represents the structure of an individual data element containing natural number values that should be displayed as a text field.
 */
class NaturalNumberTextField extends GenericTextField
{
	/**
	 * Constructs a new NaturalNumberTextField instance.
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, int $maxlength = null, $defaultValue = null, int $maxValue = null)
	{
		parent::__construct($title, new NaturalNumberValue($mandatory, $maxlength, $defaultValue, $maxValue), $size);
	}
}
