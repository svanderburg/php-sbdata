<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing a integer value that can be displayed
 * as text, but cannot be edited
 */
class ReadOnlyIntegerTextField extends IntegerTextField
{
	/**
	 * @see IntegerTextField::__construct()
	 */
	public function __construct(string $title, bool $mandatory, int $size = 20, int $maxlength = null, $defaultValue = null, int $minValue = null, int $maxValue = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength, $defaultValue, $minValue, $maxValue);
	}
}
