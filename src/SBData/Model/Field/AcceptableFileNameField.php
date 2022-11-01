<?php
namespace SBData\Model\Field;
use SBData\Model\Value\AcceptableFileNameValue;

/**
 * Represents the structure of a data element that should contain an acceptable filename that can be safely used on a certain system.
 */
class AcceptableFileNameField extends GenericTextField
{
	/**
	 * Constructs a new AcceptableFileNameField instance.
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $flags Flags that specify which filename properties to check
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, int $maxlength = null, int $flags = AcceptableFileNameValue::FLAG_ALL, $defaultValue = null)
	{
		parent::__construct($title, new AcceptableFileNameValue($mandatory, $maxlength, $flags, $defaultValue), $size);
	}
}
?>
