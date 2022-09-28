<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
* Represents the structure of an individual data element that is not being displayed and configurable.
*/
class HiddenField extends GenericHiddenField
{
	/**
	 * Constructs a new HiddenField instance
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null)
	{
		parent::__construct(new Value($mandatory, $maxlength));
	}
}
?>
