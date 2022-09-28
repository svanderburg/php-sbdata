<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element containing arbitrary unformatted text.
 */
class RawTextField extends GenericTextField
{
	/**
	 * Constructs a new RawTextField instance
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, new Value($mandatory, $maxlength), $size);
	}
}
?>
