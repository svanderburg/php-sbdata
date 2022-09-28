<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that is kept hidden
 * from the user but still propagates a parameter to a form.
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
