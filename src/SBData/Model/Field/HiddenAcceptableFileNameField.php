<?php
namespace SBData\Model\Field;
use SBData\Model\Value\AcceptableFileNameValue;

/**
 * Represents the structure of an individual data element that stores text,
 * is checked for valid UNIX/Windows path names and
 * is kept hidden from the user but still propagates a parameter to a form.
 */
class HiddenAcceptableFileNameField extends GenericHiddenField
{
	/**
	 * Constructs a new HiddenAcceptableFileNameField instance
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $flags Flags that specify which filename properties to check
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, int $flags = AcceptableFileNameValue::FLAG_ALL, $defaultValue = null)
	{
		parent::__construct(new AcceptableFileNameValue($mandatory, $maxlength, $flags, $defaultValue));
	}
}
?>
