<?php
namespace SBData\Model\Field;
use SBData\Model\Value\SaneStringValue;

/**
 * Represents the structure of a data element that should contains sanitized text and displayed as a text field.
 */
class TextField extends GenericTextField
{
	/**
	 * Constructs a new TextField instance
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, int $maxlength = null)
	{
		parent::__construct($title, new SaneStringValue($mandatory, $maxlength), $size);
	}
}
?>
