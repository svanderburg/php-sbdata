<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that stores text and
 * is kept hidden from the user but still propagates a parameter to a form.
 */
class HiddenField extends GenericHiddenField
{
	/**
	 * Constructs a new HiddenField instance
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, $defaultValue = null)
	{
		parent::__construct(new Value($mandatory, $maxlength, $defaultValue));
	}
}
?>
