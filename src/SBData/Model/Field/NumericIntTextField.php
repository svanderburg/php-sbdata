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
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, int $maxlength = null)
	{
		parent::__construct($title, new IntegerValue($mandatory, $maxlength), $size);
	}
}
