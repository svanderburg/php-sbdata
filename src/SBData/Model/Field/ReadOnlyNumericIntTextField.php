<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing a numeric value that can be displayed
 * as text, but cannot be edited
 */
class ReadOnlyNumericIntTextField extends NumericIntTextField
{
	/**
	 * @see NumericIntTextField::__construct()
	 */
	public function __construct(string $title, bool $mandatory, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
	}
}
