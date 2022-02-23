<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element that can be displayed
 * as text, but cannot be edited
 */
class ReadOnlyNumericIntTextField extends NumericIntTextField
{
	/**
	 * @see TextField::__construct()
	 */
	public function __construct(string $title, bool $mandatory, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField(string $name): bool
	{
		return parent::checkField($name);
	}
}
