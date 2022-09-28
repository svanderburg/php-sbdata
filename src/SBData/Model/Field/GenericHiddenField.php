<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
* Represents the structure of an individual data element that is not displayed or configurable.
*/
class GenericHiddenField extends Field
{
	/**
	 * Constructs a new GenericHiddenField instance
	 *
	 * @param $value An object that stores and checks the value of the field
	 */
	public function __construct(Value $value)
	{
		parent::__construct("", $value);
	}
}
?>
