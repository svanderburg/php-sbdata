<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing a natural number value that can be displayed
 * as text, but cannot be edited
 */
class ReadOnlyNaturalNumberTextField extends NaturalNumberTextField
{
	/**
	 * @see NaturalNumberTextField::__construct()
	 */
	public function __construct(string $title, bool $mandatory, int $size = 20, int $maxlength = null, $defaultValue = null, int $maxValue = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength, $defaultValue, $maxValue);
	}
}
